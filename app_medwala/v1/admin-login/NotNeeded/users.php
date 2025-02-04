<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$findcommentsssss = find("all", USER, '*', "", array());
	if(isset($_GET['userid']))
	{
		$id=$_GET['userid'];
		$table=USER;
		$set_value="status=:status";
		$where_clause="WHERE id=".$id;
		$execute=array(
		':status'=>$_GET['status'],
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			echo("<script>window.alert('Status Changed Successfully');</script>");
			echo("<script>window.location.href = 'users.php';</script>");
		}
		else
		{
			echo('error occured');
			exit;
		}
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
											<h6 class="text-uppercase mb-0">HERE ARE ALL USERS</h6>
												
												
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Name</th>
												  <th>Email</th>
												  <th>Status</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($findcommentsssss)
												{
													$sl=0;
													foreach($findcommentsssss as $admin)
													{
													$sl++;
											  ?>
												<tr>
												  <th scope="row"><?php echo $sl; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $admin['email']; ?></td>
												  <td>
													<select name="artistname" placeholder="Choose One Artist" data-allow-clear="1" onchange="location = this.value;">
														<option selected ><?php echo $admin['status'] ?> ( Current Status )</option>
														<option disabled >-----------</option>
															<option value="users.php?userid=<?php echo $admin['id']; ?>&status=inactive">inactive</option>
															<option value="users.php?userid=<?php echo $admin['id']; ?>&status=active">active</option>
													</select>
												  </td>
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