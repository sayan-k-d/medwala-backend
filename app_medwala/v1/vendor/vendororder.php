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
                                                <a class="nav-link active" data-toggle="pill" href="#openorder">Open Orders</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#packed">Packed</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#outofdelivery">Out Of Delivery</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#delivered">Delivered</a>
                                              </li>
                                            </ul>
											</h6> </div>
											<div class="card-body" style="overflow: scroll">
												<div class="tab-content">
													<div class="tab-pane container active" id="openorder">
														<?php 
            										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND (status='Paid' OR status='COD') ORDER BY id desc", array());
            										      if($find_quotationrequest)
            										      {
            										          foreach($find_quotationrequest as $quotationrequest)
            										      {
            										          
            										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                            $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                            $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                              $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $firstquotephoto = find("first", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $findquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
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
																			<p>
																				<?php echo $find_user['name'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Email</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['email'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Phone</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['phone'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Address</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_useraddress['fulladdress'];?>
																			</p>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Photo</label>
																		<p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p> <span><?php echo count($allprescription);?> more</span> 
																		<a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>">Click To View</a> 
																		</div>
																</div>
																
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Quotation Photo</label>
																		<p><img src="<?php echo $firstquotephoto['image'];?>" width="100px" height="100px"></p> <span><?php echo count($findquotephoto);?> more</span> 
																		<a href="javascript:void(0)" data-toggle="modal" data-target="#quotephoto<?php echo $quotationrequest['quoteid'];?>">Click To View</a> 
																	</div>
																</div>
																<div class="col-md-1">
            										               <div class="input-field">
            										                <a  onclick="packed(<?php echo $quotationrequest['quoteid'];?>)" class="btn btn-success"style="margin-bottom:10px">Packed</a>
            										              </div>
            										          </div>
															</div>
															<!-- Modal-->
															<div id="quotephoto<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
																<div role="document" class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
																			<form method="post" enctype="multipart/form-data" class="form-horizontal">
																				<div class="line"></div>
																				<div class="form-group">
																					<?php 
                        															    $finalquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                        															    if($finalquotephoto)
                        															    {
                        															        foreach($finalquotephoto as $quotephoto)
                        															        {
                        															            ?>
            																						<p><img src="<?php echo $quotephoto['image'];?>" width="100px" height="100px"></p>
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
															<!-- Modal-->
															<div id="myModa<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
													<div class="tab-pane container fade" id="packed">
														<?php 
                										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='packed' ORDER BY id desc", array());
                										      if($find_quotationrequest)
                										      {
                										          foreach($find_quotationrequest as $quotationrequest)
                										      {
                										          
                										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                                $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                                $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                                  $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                                   $firstquotephoto = find("first", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                                   $findquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
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
																			<p>
																				<?php echo $find_user['name'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Email</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['email'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Phone</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['phone'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Address</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_useraddress['fulladdress'];?>
																			</p>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Photo</label>
																		<p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p> <span><?php echo count($allprescription);?> more</span> 
																		<a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>">Click To View</a>
																		</div>
																</div>
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Quotation Photo</label>
																		<p><img src="<?php echo $firstquotephoto['image'];?>" width="100px" height="100px"></p>
																		 <span><?php echo count($findquotephoto);?> more</span>
																		 <a href="javascript:void(0)" data-toggle="modal" data-target="#quotephoto<?php echo $quotationrequest['quoteid'];?>">Click To View</a>
																		 </div>
																</div>
																<div class="col-md-1">
																	<div class="input-field"> <a onclick="ship(<?php echo $quotationrequest['quoteid'];?>)" class="btn btn-success" style="margin-bottom:10px">Ship</a> </div>
																</div>
															</div>
															<!-- Modal-->
															<div id="quotephoto<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
																<div role="document" class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
																			<form method="post" enctype="multipart/form-data" class="form-horizontal">
																				<div class="line"></div>
																				<div class="form-group">
																					<?php 
                    															    $finalquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                    															    if($finalquotephoto)
                    															    {
                    															        foreach($finalquotephoto as $quotephoto)
                    															        {
                    															            ?>
																						<p><img src="<?php echo $quotephoto['image'];?>" width="100px" height="100px"></p>
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
															<!-- Modal-->
															<div id="myModa<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
													<div class="tab-pane container fade" id="outofdelivery">
														<?php 
            										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='shipped' ORDER BY id desc", array());
            										      if($find_quotationrequest)
            										      {
            										          foreach($find_quotationrequest as $quotationrequest)
            										      {
            										          
            										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                            $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                            $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                              $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $firstquotephoto = find("first", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $findquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
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
																			<p>
																				<?php echo $find_user['name'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Email</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['email'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Phone</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['phone'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Address</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_useraddress['fulladdress'];?>
																			</p>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Photo</label>
																		<p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p>
																		 <span><?php echo count($allprescription);?> more</span>
																		<a href="javascript:void(0)" data-toggle="modal" data-target="#myModa<?php echo $quotationrequest['quoteid'];?>">Click To View</a> </div>
																</div>
																<div class="col-md-2">
																	<div class="input-field">
																		<label class="form-control-label">Quotation Photo</label>
																		
																		<p><img src="<?php echo $firstquotephoto['image'];?>" width="100px" height="100px"></p>
																		 <span><?php echo count($findquotephoto);?> more</span>
																	 <a href="javascript:void(0)" data-toggle="modal" data-target="#quotephoto<?php echo $quotationrequest['quoteid'];?>">Click To View</a></div>
																</div>
																<div class="col-md-1">
																	<div class="input-field row"> 
																	<a  data-toggle="modal" data-target="#quotedeliver<?php echo $quotationrequest['quoteid'];?>" class="btn btn-success" style="margin-bottom:10px">Delivered</a> </div>
																</div>
															</div>
																<!-- Modal-->
															<div id="quotedeliver<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
																<div role="document" class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<h4 id="exampleModalLabel" class="modal-title">Delivery Details</h4>
																			<form method="post" enctype="multipart/form-data" class="form-horizontal">
																				<div class="line"></div>
																				<div class="form-group">
																				    <label>Delivery Otp</label>
								                                                    <input type="text" name="deliveryotp" id="deliveryotp<?php echo $quotationrequest['quoteid'];?>" class="form-control" required>
                        															    
																				</div>
																				<button onclick="delivered(<?php echo $quotationrequest['quoteid'];?>)" class="btn btn-success">Submit</button>
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
															<div id="quotephoto<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
																<div role="document" class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
																			<form method="post" enctype="multipart/form-data" class="form-horizontal">
																				<div class="line"></div>
																				<div class="form-group">
																					<?php 
                        															    $finalquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                        															    if($finalquotephoto)
                        															    {
                        															        foreach($finalquotephoto as $quotephoto)
                        															        {
                        															            ?>
        																						<p><img src="<?php echo $quotephoto['image'];?>" width="100px" height="100px"></p>
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
															<!-- Modal-->
															<div id="myModa<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
													<div class="tab-pane container fade" id="delivered">
														<?php 
            										      $find_quotationrequest = find("all", QUOTATIONREQUEST, '*', " WHERE shopid='".$_SESSION['vendorid']."' AND status='delivered' ORDER BY id desc", array());
            										      if($find_quotationrequest)
            										      {
            										          foreach($find_quotationrequest as $quotationrequest)
            										      {
            										         // echo $quotationrequest['userid'];
            										     	$find_useraddress = find("first", USERADDRESS, '*', " WHERE userid='".$quotationrequest['userid']."' ", array());
                                                            $find_user = find("first", USER, '*', " WHERE id='".$quotationrequest['userid']."' ", array());
                                                            $find_prescription = find("first", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                              $allprescription = find("all", PRESCRIPTIONS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $firstquotephoto = find("first", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                                                               $findquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
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
																			<p>
																				<?php echo $find_user['name'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Email</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['email'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Phone</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_user['phone'];?>
																			</p>
																		</div>
																	</div>
																	<div class="input-field row">
																		<label class="col-md-3 form-control-label">Address</label>
																		<div class="col-md-9">
																			<p>
																				<?php echo $find_useraddress['fulladdress'];?>
																			</p>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="input-field">
																		<label class="form-control-label">Photo</label>
																		<p><img src="<?php echo $find_prescription['image'];?>" width="100px" height="100px"></p> <span><?php echo count($allprescription);?> more</span> <a href="javascript:void(0)" data-toggle="modal" data-target="#myModa1<?php echo $quotationrequest['quoteid'];?>">Click To View </a> </div>
																</div>
																<div class="col-md-3">
																	<div class="input-field">
																		<label class="form-control-label">Quotation Photo</label>
																		<p><img src="<?php echo $firstquotephoto['image'];?>" width="100px" height="100px"></p> <span><?php echo count($findquotephoto);?> more</span> <a href="javascript:void(0)" data-toggle="modal" data-target="#quotephoto1<?php echo $quotationrequest['quoteid'];?>">Click To View</a> </div>
																</div>
															</div>
															<!-- Modal-->
															<div id="quotephoto1<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
																<div role="document" class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<h4 id="exampleModalLabel" class="modal-title">Prescription Photos</h4>
																			<form method="post" enctype="multipart/form-data" class="form-horizontal">
																				<div class="line"></div>
																				<div class="form-group">
																					<?php 
                    															    $finalquotephoto = find("all", QUOTEPHOTOS, '*', " WHERE quoteid='".$quotationrequest['quoteid']."' ", array());
                    															    if($finalquotephoto)
                    															    {
                    															        foreach($finalquotephoto as $quotephoto)
                    															        {
                    															            ?>
    																						<p><img src="<?php echo $quotephoto['image'];?>" width="100px" height="100px"></p>
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
															<!-- Modal-->
															<div id="myModa1<?php echo $quotationrequest['quoteid'];?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
							function delivered(id) {
								
								var deliveryotp=$('#deliveryotp'+id).val();
							
								if(deliveryotp=='')
								{
								    alert('Please Enter OTP');
								    return false;
								}
								var ans = confirm('Do You Want To Delivered The Order ?');
								if(ans == true) {
									$.ajax({
										url: "<?php echo DOMAIN_NAME_PATH ?>vendor/deliveredstatuschange.php",
										method: "POST",
										data: {
											id: id,deliveryotp:deliveryotp
										},
										dataType: "text",
										cache: false,
										success: function(data) {
										    
											if(data.trim() == 'done') {
												alert("Delivered successfully");
												location.reload();
											} 
											else if(data.trim() == 'not match') {
												alert("OTP Not Match");
												return false;
											}
											else {
												alert(data);
											}
										}
									})
								}
							}

							function ship(id) {
								//alert(id);
								var ans = confirm('Do You Want To Shiip The Order ?');
								if(ans == true) {
									$.ajax({
										url: "<?php echo DOMAIN_NAME_PATH ?>vendor/shipstatuschange.php",
										method: "POST",
										data: {
											id: id
										},
										dataType: "text",
										cache: false,
										success: function(data) {
											if(data == 'done') {
												alert("Shipped successfully");
												location.reload();
											} else {
												alert(data);
											}
										}
									})
								}
							}

							function packed(id) {
								//alert(id);
								var ans = confirm('Do You Want To Packed The Order ?');
								if(ans == true) {
									$.ajax({
										url: "<?php echo DOMAIN_NAME_PATH ?>vendor/packedstatuschange.php",
										method: "POST",
										data: {
											id: id
										},
										dataType: "text",
										cache: false,
										success: function(data) {
											if(data == 'done') {
												alert("Packed successfully");
												location.reload();
											} else {
												alert(data);
											}
										}
									})
								}
							}

							function reject(id) {
								//alert(id);
								var ans = confirm('Do You Want To Accept The Quotation Request ?');
								if(ans == true) {
									$.ajax({
										url: "<?php echo DOMAIN_NAME_PATH ?>vendor/rejectstatuschange.php",
										method: "POST",
										data: {
											id: id
										},
										dataType: "text",
										cache: false,
										success: function(data) {
											if(data == 'done') {
												alert("Rejected successfully");
												location.reload();
											} else {
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