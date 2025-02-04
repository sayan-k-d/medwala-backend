<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$find_slider = find("all", GALLERY, '*', "WHERE pid = 'galleryphotos'", array());
	if(isset($_POST['submit']))
	{
		$folders=array();
		$extension=array("jpeg","jpg","png","gif");
		if(isset($_FILES["galfiles"]))
		{
			foreach($_FILES["galfiles"]["tmp_name"] as $key=>$tmp_name) {
				$file_name=$_FILES["galfiles"]["name"][$key];
				$file_tmp=$_FILES["galfiles"]["tmp_name"][$key];
				$ext=pathinfo($file_name,PATHINFO_EXTENSION);

				if(in_array($ext,$extension)) {
					$filename=basename($file_name,$ext);
					$newFileName=$filename.uniqid().".".$ext;
					$folders[$key]=$newFileName;
					move_uploaded_file($file_tmp,"img/".$newFileName);
				}
				else {
					array_push($error,"$file_name, ");
				}
			}

		}
		if($folders)
		{
			foreach($folders as $fold)
			{
			$table=GALLERY;
			$fields="name,pid,url";
			$values=":name,:pid,:url";
			$execute=array(
				':name'=>$fold,
				':pid'=>'galleryphotos',
				':url'=>'galleryphotos',
				);
				$save_data = save($table, $fields, $values, $execute);
			}
				
			header('location:gallery.php');
			exit;
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=GALLERY;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:gallery.php");
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
											<h6 class="text-uppercase mb-0">HERE ARE ALL ACTIVE GALLERY PHOTOS - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add Photos</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD Multiple Images</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>Add Gallery Images</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="line"></div>
																  <div class="form-group row">
																	<label class="col-md-3 form-control-label">Gallery Photos</label>
																	<div class="col-md-9">
																	  <input name="galfiles[]" type="file" class="form-control" multiple required>
																	</div>
																  </div>
																  
															  <div class="form-group">       
																<button name="submit" type="submit" class="btn btn-primary">Submit</button>
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
												  <th>#</th>
												  <th>Pic</th>
												  <th>DELETE</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_slider)
												{
													$sl=0;
													foreach($find_slider as $admin)
													{
													$sl++;

											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><img src="img/<?php echo $admin['name']; ?>" style="max-height:60px;"></td>
												  <td><a href="gallery.php?id=<?php echo $admin['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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
  </body>
</html>