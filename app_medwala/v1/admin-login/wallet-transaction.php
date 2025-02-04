<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	$find_shop= find("first", SHOP, '*', "WHERE id = '".$_GET['shopid']."'", array());
    if($find_shop)
    {
        $find_wallet= find("all", WALLETTRANSACTION, '*', "WHERE shopid = '".$find_shop['id']."'ORDER BY ID DESC", array());
    }
if(isset($_POST['submit']))
	{
	     $find_shop['wallet']; 
	      $balance=$find_shop['wallet']+$_POST['stock'];
	     
	    $shopid=$_POST['shopid'];
	    
		date_default_timezone_set("Asia/Calcutta");
		//$date = date('Y-m-d H:i:s');
		 $date = date('Y-m-d');
		 $time=date('H:i:s');
		 $table=WALLETTRANSACTION;
		$fields="shopid,amount,balance,details,type,date,time";
		$values=":shopid,:amount,:balance,:details,:type,:date,:time";
		$execute=array(
			':amount'=>$_POST['stock'],
			':shopid'=>$shopid,
			':details'=>$_POST['details'],
			':balance'=>$balance,
			':type'=>'credit',
			':date'=> $date ,
			':time'=> $time,
			);
		$save_data = save($table, $fields, $values, $execute);	
		
		
		
		$table=SHOP;
		$set_value="wallet=:wallet";
		$where_clause="WHERE id='".$_POST['shopid']."'";
		$execute=array(
		':wallet'=>$balance,
		);
		$update=update($table, $set_value, $where_clause, $execute);
		
		if($save_data && $update)
		{
			header('location:wallet-transaction.php?shopid='.$shopid);
			exit;
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	if(isset($_POST['deductsubmit']))
	{
	     $find_shop['wallet'];
	      $balance=$find_shop['wallet']-$_POST['stock'];
	    $shopid=$_POST['shopid'];
	   
		date_default_timezone_set("Asia/Calcutta");
		//$date = date('Y-m-d H:i:s');
		 $date = date('Y-m-d');
		 $time=date('H:i:s');
		 $table=WALLETTRANSACTION;
		$fields="shopid,amount,balance,details,type,date,time";
		$values=":shopid,:amount,:balance,:details,:type,:date,:time";
		$execute=array(
			':amount'=>$_POST['stock'],
			':shopid'=>$shopid,
			':details'=>$_POST['details'],
			':balance'=>$balance,
			':type'=>'debit',
			':date'=> $date ,
			':time'=> $time,
			);
		$save_data = save($table, $fields, $values, $execute);	
		
		
		
		$table=SHOP;
		$set_value="wallet=:wallet";
		$where_clause="WHERE id='".$shopid."'";
		$execute=array(
		':wallet'=>$balance,
		);
		$update=update($table, $set_value, $where_clause, $execute);
		
		if($save_data && $update)
		{
			header('location:wallet-transaction.php?shopid='.$shopid);
			exit;
		}
		else
		{
			echo("error occured");exit;
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
					    <p>Wallet Balance : <?php echo $find_shop['wallet']; ?> </p>
						<p>Name : <?php echo $find_shop['name']; ?> </p>
						<div class="row">
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
										  	<div class="card-header">
											
											<h6 class="text-uppercase mb-0">WALLET OF <?php echo $find_shop['name'];?> - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add Money</button><br>
											<button type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-primary">Deduct Money</button></h6>
										<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Update Stock</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															<div class="form-group">       
																<label>Details</label>
																<textarea name="details" class="form-control" required></textarea>
															  </div>
															  <div class="form-group">       
																<label>Amount</label>
																<input name="stock" type="text" placeholder="Amount" class="form-control" required >
															  </div>
															  
															 <input type="hidden" name="shopid" value="<?php echo $find_shop['id'];?>">
															  
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
												<!-- Modal-->
													<div id="myModal3"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Deduct Stock</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															<div class="form-group">       
																<label>Details</label>
																<textarea name="details" class="form-control" required></textarea>
															  </div>
															  <div class="form-group">       
																<label>Amount</label>
																<input name="stock" type="text" placeholder="Amount" class="form-control" required >
															  </div>
															  
															 <input type="hidden" name="shopid" value="<?php echo $find_shop['id'];?>">
															  
															  <div class="form-group">       
																<button name="deductsubmit" type="submit" class="btn btn-primary">Submit</button>
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
											<!-- <h6 class="text-uppercase mb-0">HERE ARE ALL ACTIVE FACULTIES - <a href="add-product.php" class="btn btn-primary">Add New Product</a> -->
													
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table  class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  
												  <th>Date</th>
												  <th>Time</th>
												  <th>Details</th>
												  <th>Amount</th>
												  <th>Type</th>
												  <th>Balance</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_wallet)
												{
													$sl=0;
													foreach($find_wallet as $admin)
													{
													$sl++;
													
											  ?>
												<tr>
												  
												
												  <td><?php echo $admin['date'];  ?></td>
												  <td><?php echo $admin['time'];  ?></td>
												  <td><?php echo $admin['details'];?></td>
                                                  <td><?php echo $admin['amount'];?></td> 
                                                  <td><?php 
												  if($admin['type']=='credit')
												  {?>
												   <p style="color:green"><?php echo $admin['type']; ?></p>
												   <?php
												  }
												  else
												  {?>
												     <p style="color:red"><?php echo $admin['type']; ?></p>
												  <?php
												  }
												   ?></td>
												  <td><?php echo $admin['balance'];?></td> 
												 
												  
												 
												 
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