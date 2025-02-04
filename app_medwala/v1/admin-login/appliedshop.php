<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

	$find_shop = find("all", APPLYVENDOR, '*', "ORDER BY id desc", array());
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$shop = find("first", APPLYVENDOR, '*', "WHERE id = '$id' ", array());
		 $url = $shop['url']; 
		
		
		
		$table=APPLYVENDOR;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:appliedshop.php");
	}
	
	 if(isset($_GET['userid']))
  {
    $id=$_GET['userid'];
    $table=APPLYVENDOR;
    $set_value="status=:status";
    $where_clause="WHERE id=".$id;
    $execute=array(
    ':status'=>$_GET['status'],
    );
    $update=update($table, $set_value, $where_clause, $execute);
    if($update)
    {
      echo("<script>window.alert('Status Changed Successfully');</script>");
      echo("<script>window.location.href = 'all-shop.php';</script>");
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
											<h6 class="text-uppercase mb-0">Here Are All Applied Shop </h6>
											
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Shop Name</th>
												  <th>Name</th>
												  <th>Email</th>
												  <th>Phone Number</th>
												  <th>Status</th>
												  <th>ACTION</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_shop)
												{
													$sl=0;
													foreach($find_shop as $artists)
													{
													$sl++;
													
											  ?>
	                                 
												  
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $artists['shopname']; ?></td>
												  <td><?php echo $artists['name']; ?></td>
												  <td><?php echo $artists['email']; ?></td>
												  <td><?php echo $artists['phone']; ?></td>
												  <td>
												      <?php
												      if($artists['status']=='pending')
												      {
												        echo('<p style="color:red">Pending</p>');
												      }
												      else if($artists['status']=='approved')
												      {
												        echo('<p style="color:green">Approved</p>');
												      }
												      else
												      {}
												      ?>
                                                  </td>
												  <td>
												    <?php
												    if($artists['status']=='pending')
													{?>
												   <a href="approved-shop.php?id=<?php echo $artists['id']; ?>" class="btn btn-success">Approved</a> &nbsp; <?php } ?>
												  <a href="appliedshop.php?id=<?php echo $artists['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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