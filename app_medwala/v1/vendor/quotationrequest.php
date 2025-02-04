<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['vendorid'])) {
	header('Location: index.php');
	exit;
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
											<h6 class="text-uppercase mb-0"> 
											<ul class="nav nav-pills">
                                              <li class="nav-item">
                                                <a class="nav-link active" data-toggle="pill" href="#pending">Pending</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#ongoing">Ongoing</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#submitted">Submitted</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#cancelled">Cancelled</a>
                                              </li>
                                            </ul>
											</h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">  
										  <div class="tab-content">
										  <div class="tab-pane container active" id="pending">
										      <?php 
										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='pending' ORDER BY id desc", array());
										      if($find_quotationrequest)
										      {
										          foreach($find_quotationrequest as $quotationrequest)
										      {
										          
										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                  $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
										      ?>
										      <div class="row box1">
										          <div class="col-md-5">
										               <div class="input-field row">
															<label class="col-md-3 form-control-label">Quote Id:</label>
															<div class="col-md-9">
																<p>
																	<?php echo $quotationrequest['quoteid'];?>
																</p>
															</div>
														</div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Name:</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['name'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Email</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['email'];?></p>
										                </div>
										              </div>
										              <div class="input-field row" >
										                <label class="col-md-3 form-control-label">Phone</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['phone'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Address</label>
										                <div class="col-md-9">
										                <p><?php echo $find_useraddress['fulladdress'];?></p>
										                </div>
										              </div>
										             
										          </div>
										           <div class="col-md-5">
										               <div class="input-field row">
										                <label class="col-md-3 form-control-label">Photo</label>
										                <div class="col-md-9">
										                <p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p>
										                <br>
										                <span><?php echo count($allprescription);?> more</span>
										              <br>
										              <a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>" >Click To View</a>
										           
										                </div>
										              </div>  
										          </div>
										          <div class="col-md-2">
										               <div class="input-field row">
										                
										                	<!--<a  onclick="accept(<?php echo $quotationrequest['quoteid'];?>)" class="btn btn-success"style="margin-bottom:10px">Accept</a>-->
										                	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php echo $quotationrequest['quoteid'];?>">
                                                              Accept
                                                            </button>
										                	<br>
										                	<br>
										                	<a  onclick="reject(<?php echo $quotationrequest['quoteid'];?>)" class="btn btn-danger ">Reject</a>
										                	
										                	<!-- Button trigger modal -->
                                                            
                                                            
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal<?php echo $quotationrequest['quoteid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                              <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                   <form action="acceptstatuschange.php" method="post">
                                                                        <input type="hidden" id="quoteid" name="quoteid" value="<?php echo $quotationrequest['quoteid'];?>">
                                                                       <div class="input-field row">
                										                <label class="col-md-3 form-control-label">Date Time</label>
                										                <div class="col-md-9">
                										                <input type="datetime-local" id="birthdaytime" name="datetimeval">
                										                </div>
                										              </div>
                										              <input  type="submit" name="submit" class="btn btn-primary" value="Submit">
                                                                   </form>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
										              </div>
										              
										          </div>
										      </div>
										      
										      	<!-- Modal-->
													<div id="myModa<?php echo $quotationrequest['quoteid'];?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  
														  <div class="modal-body">
														  	<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															    <div class="line"></div>
															<div class="form-group">       
																<?php 
															    $finalprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
															    if($finalprescription)
															    {
															        foreach($finalprescription as $prescriptionpic)
															        {
															            ?>
															            <p><img src="<?php echo $prescriptionpic['image'];?>" width="100px" height="100px"></p>
															            <br>
															       <?php }
															    }
															    ?>
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
										      <?php } } ?>
										  </div>
                                            <div class="tab-pane container fade" id="ongoing">
                                                <?php 
										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='accepted' ORDER BY id desc", array());
										      if($find_quotationrequest)
										      {
										          foreach($find_quotationrequest as $quotationrequest)
										      {
										          
										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                  $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
										      ?>
										      <div class="row box1">
										          <div class="col-md-5">
										               <div class="input-field row">
															<label class="col-md-3 form-control-label">Quote Id:</label>
															<div class="col-md-9">
																<p>
																	<?php echo $quotationrequest['quoteid'];?>
																</p>
															</div>
														</div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Name:</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['name'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Email</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['email'];?></p>
										                </div>
										              </div>
										              <div class="input-field row" >
										                <label class="col-md-3 form-control-label">Phone</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['phone'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Address</label>
										                <div class="col-md-9">
										                <p><?php echo $find_useraddress['fulladdress'];?></p>
										                </div>
										              </div>
										              
										          </div>
										           <div class="col-md-5">
										               <div class="input-field row">
										                <label class="col-md-3 form-control-label">Photo</label>
										                <div class="col-md-9">
										                <p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p>
										                <br>
										                <span><?php echo count($allprescription);?> more</span>
										              <br>
										              <a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>" >Click To View</button>
										           
										                </div>
										              </div>  
										          </div>
										          <div class="col-md-2">
										               <div class="input-field row">
										                
										                	<a  href="viewquotation.php?quoteid=<?php echo $quotationrequest['quoteid'];?>" class="btn btn-success"style="margin-bottom:10px">View</a>
										                	<br>
										                	<br>
										                	<a  href="javascript:void(0)" class="btn btn-danger ">Call Support</a>
										              </div>
										              
										          </div>
										      </div>
										      
										      	
										      <?php } } ?>
                                            </div>
                                                <div class="tab-pane container fade" id="submitted">
                                                <?php 
										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='submitted' ORDER BY id desc", array());
										      if($find_quotationrequest)
										      {
										          foreach($find_quotationrequest as $quotationrequest)
										      {
										          
										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                  $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
										      ?>
										      <div class="row box1">
										          <div class="col-md-5">
										               <div class="input-field row">
															<label class="col-md-3 form-control-label">Quote Id:</label>
															<div class="col-md-9">
																<p>
																	<?php echo $quotationrequest['quoteid'];?>
																</p>
															</div>
														</div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Name:</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['name'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Email</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['email'];?></p>
										                </div>
										              </div>
										              <div class="input-field row" >
										                <label class="col-md-3 form-control-label">Phone</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['phone'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Address</label>
										                <div class="col-md-9">
										                <p><?php echo $find_useraddress['fulladdress'];?></p>
										                </div>
										              </div>
										              
										          </div>
										           <div class="col-md-5">
										               <div class="input-field row">
										                <label class="col-md-3 form-control-label">Photo</label>
										                <div class="col-md-9">
										                <p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p>
										                <br>
										                <span><?php echo count($allprescription);?> more</span>
										              <br>
										              <a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>" >Click To View</a>
										           
										                </div>
										              </div>  
										          </div>
										          
										      </div>
										      
										      	
										      <?php } } ?>
                                            </div>
                                             <div class="tab-pane container" id="cancelled">
										      <?php 
										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='cancel' ORDER BY id desc", array());
										      if($find_quotationrequest)
										      {
										          foreach($find_quotationrequest as $quotationrequest)
										      {
										          
										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                  $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
										      ?>
										      <div class="row box1">
										          <div class="col-md-5">
										               <div class="input-field row">
															<label class="col-md-3 form-control-label">Quote Id:</label>
															<div class="col-md-9">
																<p>
																	<?php echo $quotationrequest['quoteid'];?>
																</p>
															</div>
														</div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Name:</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['name'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Email</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['email'];?></p>
										                </div>
										              </div>
										              <div class="input-field row" >
										                <label class="col-md-3 form-control-label">Phone</label>
										                <div class="col-md-9">
										                <p><?php echo $find_user['phone'];?></p>
										                </div>
										              </div>
										              <div class="input-field row">
										                <label class="col-md-3 form-control-label">Address</label>
										                <div class="col-md-9">
										                <p><?php echo $find_useraddress['fulladdress'];?></p>
										                </div>
										              </div>
										             
										          </div>
										           <div class="col-md-5">
										               <div class="input-field row">
										                <label class="col-md-3 form-control-label">Photo</label>
										                <div class="col-md-9">
										                <p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p>
										                <br>
										                <span><?php echo count($allprescription);?> more</span>
										              <br>
										              <a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>" >Click To View</a>
										           
										                </div>
										              </div>  
										          </div>
										          
										      </div>
										      
										      	<!-- Modal-->
													<div id="myModa<?php echo $quotationrequest['quoteid'];?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  
														  <div class="modal-body">
														  	<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															    <div class="line"></div>
															<div class="form-group">       
																<?php 
															    $finalprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
															    if($finalprescription)
															    {
															        foreach($finalprescription as $prescriptionpic)
															        {
															            ?>
															            <p><img src="<?php echo $prescriptionpic['image'];?>" width="100px" height="100px"></p>
															            <br>
															       <?php }
															    }
															    ?>
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
										      <?php } } ?>
										  </div>
                                            </div>
											
										  </div>
										</div>
								 </div>
						</div>
					</section>
				</div>
				<?php require_once('includes/footer.php');?>
				 <script type="text/javascript">
                             function accept(id) {
                              //alert(id);
                              var ans=confirm('Do You Want To Accept The Quotation Request ?');
                             if(ans == true)
                              { 
                               $.ajax({  
                                   url:"<?php echo DOMAIN_NAME_PATH ?>vendor/acceptstatuschange.php", 
                                   method:"POST",  
                                   data:{ id:id},
                                   dataType:"text",
                                   cache: false,
                                   success:function(data)  
                                   {
                                       if(data == 'done'){
                                           alert("accepted successfully");  
                                           location.reload();
                                       }
                                       else{
                                           alert(data);
                                       }
                                          
                                   }  
                            }) 
                              }
                        }
                        
                          function reject(id) {
                              //alert(id);
                              var ans=confirm('Do You Want To Reject The Quotation Request ?');
                             if(ans == true)
                              { 
                               $.ajax({  
                                   url:"<?php echo DOMAIN_NAME_PATH ?>vendor/rejectstatuschange.php", 
                                   method:"POST",  
                                   data:{ id:id},
                                   dataType:"text",
                                   cache: false,
                                   success:function(data)  
                                   {
                                       if(data == 'done'){
                                           alert("Rejected successfully");  
                                           location.reload();
                                       }
                                       else{
                                           alert(data);
                                       }
                                          
                                   }  
                            }) 
                              }
                        }
                        </script>
			</div>
	</div>
  </body>
</html>