<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

	$find_medicine = find("all", MEDICINELIST, '*', "ORDER BY id desc", array());
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$shop = find("first", MEDICINELIST, '*', "WHERE id = '$id' ", array());
		$table=MEDICINELIST;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:all-medicine.php");
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
											<h6 class="text-uppercase mb-0">Here Are All Medicine List 
											<a href="add-medicine.php" class="btn btn-primary">Add Medicine</a></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Date</th>
												  <th>Name</th>
												  <th>MRP</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_medicine)
												{
													$sl=0;
													foreach($find_medicine as $medicine)
													{
													$sl++;
													
											  ?>
	                                 
												  
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $medicine['date']; ?><br> <?php echo $medicine['time']; ?></td>
												  <td><?php echo $medicine['name']; ?></td>
												  <td><?php echo $medicine['mrp']; ?></td>
												  <td><a href="edit-medicine.php?id=<?php echo $medicine['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="all-medicine.php?id=<?php echo $medicine['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
												  
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