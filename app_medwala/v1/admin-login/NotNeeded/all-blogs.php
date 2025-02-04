<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$find_artists = find("all", BLOG, '*', "", array());
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=BLOG;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:all-blogs.php");
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
											<h6 class="text-uppercase mb-0">Here Are All Blogs <a href="add-blog.php"><button type="button" class="btn btn-primary">Add Blog</button></a></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Image</th>
												  <th>Name</th>
												  <th>Date</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_artists)
												{
													$sl=0;
													foreach($find_artists as $artists)
													{
													$sl++;

											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><img src="<?php echo $artists['pic']; ?>" style="max-height:60px;"></td>
												  <td><?php echo $artists['title']; ?></td>
												  <td><?php echo $artists['date']; ?></td>
												  <td><a href="edit-blog.php?id=<?php echo $artists['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="all-blogs.php?id=<?php echo $artists['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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