<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

	$find_category = find("all", CATEGORY, '*', "ORDER BY id desc", array());
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		
		$table=CATEGORY;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:all-categories.php");
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
											<h6 class="text-uppercase mb-0">Here Are All Category 
											<a href="add-categories.php" class="btn btn-primary">Add Category</a></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Name</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_category)
												{
													$sl=0;
													foreach($find_category as $artists)
													{
													$sl++;
													
											  ?>
	                                 
												  
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td>
												      <?php echo $artists['name']; ?></td>
												  
												  <td><a href="edit-categories.php?id=<?php echo $artists['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="all-categories.php?id=<?php echo $artists['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
												  
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