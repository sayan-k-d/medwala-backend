<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
    //print_r($_SESSION);exit;
	$find_subaccount = find("all", SUBACCOUNT, '*', "WHERE shopid = '".$_SESSION['vendorid']."' ORDER BY id desc", array());
		

	 if(isset($_GET['userid']))
  {
    $id=$_GET['userid'];
    $table=SUBACCOUNT;
    $set_value="status=:status";
    $where_clause="WHERE id=".$id;
    $execute=array(
    ':status'=>$_GET['status'],
    );
    $update=update($table, $set_value, $where_clause, $execute);
    if($update)
    {
      echo("<script>window.alert('Status Changed Successfully');</script>");
      echo("<script>window.location.href = 'all-subaccount.php';</script>");
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
											<h6 class="text-uppercase mb-0">Here Are All Subaccount 
											<a href="add-subaccount.php" class="btn btn-primary">Add Subaccount</a></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Date</th>
												  <th>UserName</th>
												  <th>Status</th>
												  <th>EDIT</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_subaccount)
												{
													$sl=0;
													foreach($find_subaccount as $subaccount)
													{
													$sl++;
													
											  ?>
	                                 
												  
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $subaccount['date']; ?><br> <?php echo $subaccount['time']; ?></td>
												  <td><?php echo $subaccount['username']; ?></td>
												  <td>
											      <select name="artistname" placeholder="Choose One Status" data-allow-clear="1" onchange="location = this.value;">
                                                    <option selected ><?php echo $subaccount['status'] ?> ( Current Status )</option>
                                                    <option disabled >-----------</option>
                                                      <option value="all-subaccount.php?userid=<?php echo $subaccount['id']; ?>&status=inactive">inactive</option>
                                                      <option value="all-subaccount.php?userid=<?php echo $subaccount['id']; ?>&status=active">active</option>
                                                  </select>
                                                  </td>
												  <td><a href="edit-subaccount.php?id=<?php echo $subaccount['id']; ?>"><button name="edit" type="submit" class="btn btn-primary">Edit</button></a></td>
												  
												  
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