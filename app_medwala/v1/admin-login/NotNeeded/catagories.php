<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}
	$find_artists = find("all", CATAGORY, '*', "", array());
	if(isset($_POST['submit']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$filename=uniqid().$_FILES["uploadfile"]["name"];
		$tempname=$_FILES["uploadfile"]["tmp_name"];
		$folder="img/".$filename;
		move_uploaded_file($tempname,$folder);
		$table=CATAGORY;
		$fields="name,srtdescription,pic,date,parent,url";
		$values=":name,:srtdescription,:pic,:date,:parent,:url";
		$execute=array(
			':name'=>$_POST['name'],
			':srtdescription'=>$_POST['srtdescription'],
			':parent'=>$_POST['parent'],
			':pic'=>$folder,
			':date'=>$date,
			':url'=>strtolower(create_slug($_POST['name']))."-".uniqid(),
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:catagories.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
	    $find_subfilters = find("all", SUBFILTER, '*', "WHERE subcat = '".$_GET['id']."' ", array());
	    if($find_subfilters){
	        
    	    foreach($find_subfilters as $subfils){
    		    $table=SUBFILTER;
        		$where_clause="WHERE id=".$subfils['id'];
        		$execute=array();
        		delete($table, $where_clause, $execute);
    		}
	    }
	    
		$find_filters = find("all", FILTER, '*', "WHERE subcategory = '".$_GET['id']."' ", array());
	    if($find_filters){
	        foreach($find_filters as $subfilsssd){
    		    $table=FILTER;
        		$where_clause="WHERE id=".$subfilsssd['id'];
        		$execute=array();
        		delete($table, $where_clause, $execute);
    		}
	    }
		
		
		
		$id=$_GET['id'];
		$table=CATAGORY;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:catagories.php");
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
											<h6 class="text-uppercase mb-0">HERE ARE ALL ACTIVE CATAGORIES - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Catagory</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD CATAGORY</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD CATAGORY DETAILS HERE</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>CATAGORY NAME</label>
																<input name="name" type="text" placeholder="CATAGORY NAME" class="form-control" required>
															  </div>
															  
															   <div class="form-group"> 
                        										<label>Short Description</label>
                        										<input value="<?php echo $find_catagory['srtdescription']; ?>" name="srtdescription" type="text" placeholder="Short Description" class="form-control" required>
                        									  </div>
                        									  
															  <div class="form-group">
																<label>Parent Catagory</label>
																	<select id="" name="parent" placeholder="Parent Catagory ?" data-allow-clear="1" >
																		<option selected></option>
																		  <?php
																		   $find_cat = find("all", CATAGORY, '*', "WHERE parent = '' ", array());
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
																<label>PICTURE</label>
																<input name="uploadfile" type="file" class="form-control" required>
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
												  <th>Name</th>
												  <th>Parent</th>
												  <th>Homepage</th>
												  <th>Position</th>
												  <th>FILTER</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
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
													$find_parent = find("first", CATAGORY, '*', "WHERE id = '".$admin['parent']."' ", array());

											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><img src="<?php echo $admin['pic']; ?>" style="max-height:60px;"></td>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $find_parent['name']; ?></td>
												  <td><?php echo $admin['homepage']; ?></td>
												  <td><?php echo $admin['position']; ?></td>
												  <?php
												  if($find_parent){
												     echo('
												     <td><a href="filter.php?subid='.$admin['id'].'"><button name="filter" type="submit" class="btn btn-primary">Filters</button></a></td>
												     '); 
												  }
												  else{
												      echo('
												     <td><button disabled name="filter" type="submit" class="btn btn-primary">Filters</button></td>
												     '); 
												  }
												  ?>
												  
												  <td><a href="edit-catagories.php?id=<?php echo $admin['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="catagories.php?id=<?php echo $admin['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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