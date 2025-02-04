<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
    //print_r($_SESSION);exit;
	$find_wallet= find("all", WALLETTRANSACTION, '*', "WHERE shopid = '".$_SESSION['vendorid']."' ORDER BY id desc", array());
	$find_shop= find("first", SHOP, '*', "WHERE id = '".$_SESSION['vendorid']."' ORDER BY id desc", array());	

	 
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
						     <p>Wallet Balance: <?php echo $find_shop['wallet'];?></p>
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
										      
											<h6 class="text-uppercase mb-0">Here Are All Wallet Transaction </h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Date</th>
												  <th>Amount</th>
												  <th>Type</th>
												  <th>Details</th>
												  <th>Balance</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_wallet)
												{
													$sl=0;
													foreach($find_wallet as $wallet)
													{
													$sl++;
													
											  ?>
	                                 
												  
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $wallet['date']; ?><br> <?php echo $wallet['time']; ?></td>
												  <td><?php echo $wallet['amount']; ?></td>
												  <td><?php 
												  if($wallet['type']=='credit')
												  {?>
												   <p style="color:green"><?php echo $wallet['type']; ?></p>
												   <?php
												  }
												  else
												  {?>
												     <p style="color:red"><?php echo $wallet['type']; ?></p>
												  <?php
												  }
												   ?></td>
												  <td><?php echo $wallet['details']; ?></td>
												  <td><?php echo $wallet['balance']; ?></td>
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