<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

if (!isset($_GET['filterid'])) {
	header('Location: subcatagories.php');
	exit;
}

	$find_artists = find("all", SUBFILTER, '*', "WHERE filter = '".$_GET['filterid']."' ", array());
	$findfilter = find("first", FILTER, '*', "WHERE id = '".$_GET['filterid']."' ", array());
	$findsubcat = find("first", CATAGORY, '*', "WHERE id = '".$findfilter['subcategory']."' ", array());
	if(isset($_POST['submit']))
	{
		$table=SUBFILTER;
		$fields="name,filter,subcat";
		$values=":name,:filter,:subcat";
		$execute=array(
			':name'=>$_POST['name'],
			':filter'=>$_GET['filterid'],
			':subcat'=>$findsubcat['id'],
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:subfilters.php?filterid='.$_GET['filterid']);
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=SUBFILTER;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header('location:subfilters.php?filterid='.$_GET['filterid']);
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
											<h6 class="text-uppercase mb-0">SUB FILTERS FOR <?php echo $findfilter['name'];?> ( Subcat : <?php echo $findsubcat['name'];?> )- <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Sub Filter</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Add Sub Filter</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Sub Filter Name</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required>
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
												  <th>Name</th>
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

											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><a href="subfilters.php?id=<?php echo $admin['id']; ?>&filterid=<?php echo $_GET['filterid']; ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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