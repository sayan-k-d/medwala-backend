<?php
session_start();
	require_once('loader.inc');
	// If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedinteacher'])) {
    	header('Location: index.php');
    	exit;
    }

    $find_transactions = find("all", TRANSACTIONS, '*', "WHERE teacherid = '".$_SESSION['teacherid']."' ORDER BY id DESC", array());
    $find_teacher = find("first", TEACHERS, '*', "WHERE id = '".$_SESSION['teacherid']."' ", array());
?>
<!DOCTYPE html>
<html>
  <head>
	<?php require_once('includes/admin_links.php');?>
  </head>
  <body>
    <!-- navbar-->
    <?php require_once('includes/header.php');?>
    <div class="d-flex align-items-stretch">
     <?php require_once('includes/sidebar.php');?> 
	 
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5 text-center">
		<section class="py-5">
						<div class="row">
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">All Transactions ( Wallet Balance : <?php echo $find_teacher['wallet']; ?> )</h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table  class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>Date</th>
												  <th>Details</th>
												  <th>Type</th>
												  <th>Amount</th>
												  <th>Balance</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_transactions)
												{
													foreach($find_transactions as $u)
													{
											  ?>
												<tr>
												  <td><?php echo $u['date']; ?></td>
												  <td><?php echo $u['details']; ?></td>
												  <td><?php echo $u['type']; ?></td>
												  <?php
												  if($u['type'] == 'credit'){
												      echo('
												      <td style="color:green;font-weight:800">'.$u['amount'].'</td>
												      ');
												  }
												  else{
												      echo('
												      <td style="color:red;font-weight:800">'.$u['amount'].'</td>
												      ');
												  }
												  ?>
												  <td><?php echo $u['balance']; ?></td>
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
		
		

		<footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">Your company &copy; 2018-2021</p>
              </div>
              <div class="col-md-6 text-center text-md-right text-gray-400">
                <p class="mb-0">Design by <a href="serveque.in" >Serveque</a></p>
              </div>
            </div>
          </div>
        </footer>
		
      </div>
	  
    </div>
    
  </body>
</html>