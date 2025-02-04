<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$leadsthisvendor = find("all", LEADS, '*', "WHERE rating != '' ORDER BY id DESC", array());
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
											<h6 class="text-uppercase mb-0">Latest Reviews</h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                  <tr>
                                                    <th scope="col">Customer Details</th>
                                                    <th scope="col">Vendor Details</th>
                                                    <th scope="col">Rating</th>
                                                    <th scope="col">Comment</th>
                                                    <th scope="col">Date</th>
                                                  </tr>
                                                </thead>
                                                <tbody class="list">
                                                <?php
                                                if($leadsthisvendor){
                                                    foreach($leadsthisvendor as $lead){
                                                        $userr = find("first", USER, '*', "WHERE email = '".$lead['user']."'", array());
                                                        $vendor = find("first", VENDOR, '*', "WHERE email = '".$lead['vendor']."'", array());
                                                ?>
                                                  <tr>
                                                    <th scope="row">
                                                      <div class="media align-items-center">
                                                        <div class="media-body">
                                                          <span class="name mb-0 text-sm"><?php echo $userr['name']; ?><br>
                                                          Phone : <?php echo $userr['phn']; ?><br>
                                                          Email : <?php echo $userr['email']; ?>
                                                          </span>
                                                        </div>
                                                      </div>
                                                    </th>
                                                    <td style="
                                                    font-size: 13px;
                                                    ">
                                                      <?php echo $vendor['name']; ?><br>
                                                      Phone : <?php echo $vendor['phn']; ?><br>
                                                      Email : <?php echo $vendor['email']; ?>
                                                    </td>
                                                    <td style="color:orange">
                                                        <?php echo $lead['rating']; ?> <i class="fa fa-star" aria-hidden="true"></i>
                                                    </td>
                                                    <td>
                                                        <?php echo $lead['comment']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date("d M Y", strtotime($lead['ratedate'])); ?>
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