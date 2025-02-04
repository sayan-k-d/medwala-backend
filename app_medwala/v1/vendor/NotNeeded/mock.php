<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}


	$find_artists = find("all", MOCK, '*', "WHERE teacherid = '".$_SESSION['teacherid']."'", array());
	$findteacher = find("first", TEACHERS, '*', "WHERE id = '".$_SESSION['teacherid']."' ", array());
	
	if(isset($_POST['submit']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
		$ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
		$filename=uniqid().uniqid().'.'.$ext;
		$tempname=$_FILES["uploadfile"]["tmp_name"];
		$folder="img/".$filename;
		move_uploaded_file($tempname,$folder);
		
		$table=MOCK;
		$fields="name,teacherid,price,category,srtdescription,pic";
		$values=":name,:teacherid,:price,:category,:srtdescription,:pic";
		$execute=array(
			':name'=>$_POST['name'],
			':teacherid'=>$findteacher['id'],
			':price'=>$_POST['price'],
			':category'=>$_POST['category'],
			':srtdescription'=>$_POST['srtdescription'],
			':pic'=>$folder,
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:mock.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_POST['submitedit']))
	{
	    if(isset($_FILES["uploadfile2"]["name"]) && $_FILES["uploadfile2"]["name"]!='' && $_FILES["uploadfile2"]["error"]==0)
		{
		    $ext = pathinfo($_FILES["uploadfile2"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile2"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
		}
		else
		{
			$folder= $_POST['pic'];
		}
		$table=MOCK;
		$set_value="name=:name,price=:price,category=:category,srtdescription=:srtdescription,pic=:pic";
		$where_clause="WHERE id=".$_POST['id'];
		$execute=array(
		':name'=>$_POST['name'],
		':price'=>$_POST['price'],
		':category'=>$_POST['category'],
		':srtdescription'=>$_POST['srtdescription'],
		':pic'=>$folder,
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:mock.php');
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
		$table=MOCK;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		
		header('location:mock.php');
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
											<h6 class="text-uppercase mb-0">MOCKS OF <?php echo $findteacher['name'];?> - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Mock</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Add Mock</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Name</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required>
															  </div>
															  
															  
															  <div class="form-group">       
																<label>Picture</label>
																<input name="uploadfile" type="file" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Short Points ( Seperate By @||@ )</label>
																<textarea type="text" name="srtdescription" class="form-control" required></textarea>
															  </div>
															  
															  <div class="form-group">
																<label>Select Category</label>
																	<select id="" name="category" placeholder="Select Category" data-allow-clear="1" required>
																	    <option></option>
																		  <?php
																		   $find_cat = find("all", CATEGORY, '*', "WHERE teacherid = '".$_SESSION['teacherid']."' ", array());
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
																<label>Price</label>
																<input name="price" type="number" placeholder="Price" class="form-control" required>
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
												  <th>Mock ID</th>
												  <th>Name</th>
												  <th>Price</th>
												  <th>Category</th>
												  <th>Exams</th>
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
                                                    $find_category = find("first", CATEGORY, '*', "WHERE id = '".$admin['category']."'", array());
                                                    $find_exams = find("all", EXAM, '*', "WHERE mockid = '".$admin['id']."' AND (trash != '1' OR trash IS NULL ) ", array());
											  ?>
												<tr>
												  <th scope="row"><?php echo $admin['id']; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $admin['price']; ?></td>
												  <td><?php echo $find_category['name']; ?></td>
												  <td><a href="exam.php?mockid=<?php echo $admin['id']; ?>" class="btn btn-outline-info">Exams ( <?php echo count($find_exams); ?> )</a></td>
												  <td><a href="#" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp; <a onclick="return confirm('Are you sure you want to delete this item?');" href="mock.php?id=<?php echo $admin['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
												  	<!--Edit Modal-->
													<div id="editmodal_<?php echo $admin['id']; ?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Edit Batch</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Name</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required value="<?php echo $admin['name']; ?>">
															  </div>
															  
															  <div class="form-group">       
																<label>PICTURE</label>
																<input name="uploadfile2" type="file" class="form-control">
																<br><br>
										                        <img src="<?php echo $admin['pic']; ?>" width="20%">
										                        <input name="pic" type="hidden" placeholder="Name" class="form-control" required value="<?php echo $admin['pic']; ?>">
															  </div>
															  
															  
															  <div class="form-group">       
																<label>Short Points ( Seperate By @||@ )</label>
																<textarea type="text" name="srtdescription" class="form-control" required><?php echo $admin['srtdescription']; ?></textarea>
															  </div>
															  
															  <div class="form-group">       
																<label>Price</label>
																<input name="price" type="number" placeholder="Price" class="form-control" required value="<?php echo $admin['price']; ?>">
															  </div>
																
																<div class="form-group">
																<label>Select Category</label>
																	<select id="" name="category" placeholder="Select Category" data-allow-clear="1" required>
																	    <option></option>
																		  <?php
																		   $find_cat = find("all", CATEGORY, '*', "WHERE teacherid = '".$_SESSION['teacherid']."' ", array());
																			if($find_cat)
																			{
																				$sl=0;
																				foreach($find_cat as $cat)
																				{
																				    if ($cat['id'] == $admin['category'])
                            															{
                            																$select = "selected";
                            															}
                            															else
                            															{
                            																$select = "";
                            															}
																		  ?>
																				<option <?php echo $select; ?> value="<?php echo $cat['id'] ?>" ><?php echo $cat['name'] ?></option>
																				<?php
																				}
																			}	
																		  ?>
																	</select>
															  </div>
															  
															  <input type="hidden" value="<?php echo $admin['id']; ?>" name="id">
															  
															  <div class="form-group">       
																<button name="submitedit" type="submit" class="btn btn-primary">Submit</button>
															  </div>
															</form>
														  </div>
														  <div class="modal-footer">
															<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
														  </div>
														</div>
													  </div>
													</div>
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
  </body>
</html>