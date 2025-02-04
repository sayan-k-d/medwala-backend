<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$find_artists = find("all", VENDOR, '*', "WHERE status = 'active' ORDER BY id desc ", array());
	//print_r($find_artists);exit;
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=VENDOR;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:vendor.php");
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
											<h6 class="text-uppercase mb-0">Here Are All Vendors <a href="add-vendor.php"><button type="button" class="btn btn-primary">Add New Vendor</button></a></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>Vendor ID</th>
												  <th>Logo</th>
												  <th>Name</th>
												  <th>Phone</th>
												  <th>Address</th>
												  <th>Email</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_artists)
												{
													$sl=0;
													$now = new DateTime();
													foreach($find_artists as $artists)
													{
													$sl++;
											  ?>
												<tr>
												  <th scope="row"><?php echo $artists['id']; ?></th>
												  <td><img src="<?php echo $artists['logo']; ?>" style="max-height:60px;"></td>
												  <td><a href="<?php echo DOMAIN_NAME_PATH; ?>vendor/authmastervendor.php?venid=<?php echo $artists['id']; ?>&venname=<?php echo $artists['email']; ?>"  target="_blank"><?php echo $artists['name']; ?></a></td>
												   <td><?php echo $artists['phn']; ?></td>
												    <td><?php echo $artists['address']; ?></td>
												     <td><?php echo $artists['email']; ?></td>
												  <td><a href="edit-vendor.php?id=<?php echo $artists['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="vendor.php?id=<?php echo $artists['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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