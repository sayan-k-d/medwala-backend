<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
	$find_artists = find("all", STUDYMATERIALS, '*', "WHERE teacher = '".$_SESSION['teacherid']."'  ORDER BY id DESC", array());
	
	if(isset($_POST['submitstudent']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
		$ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
		$filename=uniqid().uniqid().'.'.$ext;
		$tempname=$_FILES["uploadfile"]["tmp_name"];
		$folder="img/".$filename;
		move_uploaded_file($tempname,$folder);
		
		$table=STUDYMATERIALS;
		$fields="name,file,mockid,teacher";
		$values=":name,:file,:mockid,:teacher";
		$execute=array(
			':name'=>$_POST['name'],
			':file'=>$folder,
			':mockid'=>implode(',',$_POST['mockid']),
			':teacher'=>$_SESSION['teacherid'],
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:studymaterials.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	
	if(isset($_POST['submitedit']))
	{
	    if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
		{
		    $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
		}
		else
		{
			$folder= $_POST['file'];
		}
		$table=STUDYMATERIALS;
		$set_value="name=:name,file=:file,mockid=:mockid,teacher=:teacher";
		$where_clause="WHERE id=".$_POST['studentid'];
		$execute=array(
			':name'=>$_POST['name'],
			':file'=>$folder,
			':mockid'=>implode(',',$_POST['mockid']),
			':teacher'=>$_SESSION['teacherid'],
			);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:studymaterials.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=STUDYMATERIALS;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:studymaterials.php");
	}
?>
<!DOCTYPE html>
<html>
  <head>

	<?php require_once('includes/header.php');?>


	<div class="d-flex align-items-stretch">
			<?php require_once('includes/sidebar.php');?> 
			<div class="page-holder w-100 d-flex flex-wrap">
				<div class="container-fluid px-xl-5">
					<section class="py-5">
						<div class="row">
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">ALL STUDY MATERIALS - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Material</button>  &nbsp;</h6>
					
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD EXAM</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD EXAM DETAILS HERE</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Title</label>
																<input name="name" type="text" placeholder="Title" class="form-control" required>
															  </div>
															  
															   <div class="form-group">       
																<label>File</label>
																<input name="uploadfile" type="file" class="form-control" required>
															  </div>
															  
															  <div class="form-group">
																<label>Select Batchs</label>
																	<select id="" name="mockid[]" placeholder="Select Mock" data-allow-clear="1" required multiple>
																		  <?php
																		   $find_cat = find("all", MOCK, '*', "WHERE teacherid = '".$_SESSION['teacherid']."' ", array());
																			if($find_cat)
																			{
																				$sl=0;
																				foreach($find_cat as $cat)
																				{
																		  ?>
																				<option value="<?php echo $cat['id'] ?>" ><?php echo $cat['name'] ?></option>
																				<?php
																				}
																			}	
																		  ?>
																	</select>
															  </div>
                        									  
															  <div class="form-group">       
																<button name="submitstudent" type="submit" class="btn btn-primary">Submit</button>
															  </div>
															</form>
														  </div>
														  <div class="modal-footer">
															<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
														  </div>
														</div>
													  </div>
													</div>
												<!-- Modal-->
													
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>Sl</th>
												  <th>Name</th>
												  <th>Mock</th>
												  <th>File</th>
												  <th>Actions</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_artists)
												{
													$sl=0;
													foreach($find_artists as $admin)
													{
													$sl++;
											  ?>
												<tr>
												  <th scope="row"><?php echo $sl; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td>
												      <?php
        												  $batch = explode(',',$admin['mockid']);
        												  foreach($batch as $b){
        												      $find_batch = find("first", MOCK, '*', "WHERE id = '".$b."' ", array());
        												      echo($find_batch['name'].',');
        												  }
                                                    ?>
												  </td>
												  <td><a href="<?php echo $admin['file']; ?>" download>Click To Download</a></td>
												  <td><a onclick="return confirm('Are you sure you want to delete this item?');" href="studymaterials.php?id=<?php echo $admin['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												<!--Edit Modal-->
												
												</tr>
											<?php
													}
												}
											?>
											  </tbody>
											</table>
										  </div>
										</div>
								 </div>
						</div>
						
					</section>
				</div>
				<?php require_once('includes/footer.php');?>
			</div>
	</div>
  
  
  
	<script>
	    function closemodal(id){
	        $('#myModal2').hide();
	    }
	</script>
	
	<script>
      function changeoftimertypeedit(id){
         var timerype = $('#timertype'+id).val();
         if(timerype != 'Fixed'){
             $('#timeforexam'+id).show();
         }
         else{
             $('#timeforexam'+id).hide();
         }
      }
  </script>
  </body>
</html>