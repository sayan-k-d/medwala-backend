<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$find_slider = find("all", SLIDER, '*', "", array());
	if(isset($_POST['submit']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$filename=uniqid().$_FILES["uploadfile"]["name"];
		$tempname=$_FILES["uploadfile"]["tmp_name"];
		$folder="img/".$filename;
		move_uploaded_file($tempname,$folder);
		$table=SLIDER;
		$fields="link,place,pic,position";
		$values=":link,:place,:pic,:position";
		$execute=array(
			':link'=>$_POST['link'],
			':place'=>$_POST['place'],
			':position'=>$_POST['position'],
			':pic'=>$folder,
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:slider.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=SLIDER;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:slider.php");
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
											<h6 class="text-uppercase mb-0">HERE ARE ALL ACTIVE SLIDERS - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Slider</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD Slider</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>Add Slider Image</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Link</label>
																<input name="link" type="text" placeholder="Link" class="form-control">
															  </div>
															  <div class="form-group">       
																<label>Position</label>
																<input name="position" type="number" placeholder="Position" class="form-control">
															  </div>
															  <div class="form-group">       
																<label>Place</label>
																<select name="place" placeholder="place" data-allow-clear="1" required>
                												   <option value="banner" >Homepage Top Slider</option>
                											    </select>
															  </div>
															  <div class="form-group">       
																<label>PICTURE</label>
																<input name="uploadfile" type="file" class="form-control" >
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
												  <th>Link</th>
												  <th>Place</th>
												  <th>Position</th>
												  <th>EDIT</th>
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
												  <td><img src="<?php echo $admin['pic']; ?>" style="max-height:60px;"></td>
												  <td><?php echo $admin['link']; ?></td>
												  <td><?php echo $admin['place']; ?></td>
												  <td><?php echo $admin['position']; ?></td>
												  <td><a href="edit-slider.php?id=<?php echo $admin['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="slider.php?id=<?php echo $admin['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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