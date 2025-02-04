<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

	$find_shop = find("all", SHOP, '*', "ORDER BY id desc", array());
		
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$shop = find("first", SHOP, '*', "WHERE id = '$id' ", array());
		 $url = $shop['url']; 
		
		$table1=GALLERY;
		$where_clause1="WHERE url='".$url."' ";
		$execute1=array();
		delete($table1, $where_clause1, $execute1);
		
		
		$table=SHOP;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:all-shop.php");
	}
	
	 if(isset($_GET['userid']))
  {
    $id=$_GET['userid'];
    $table=SHOP;
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
											<h6 class="text-uppercase mb-0">Here Are All Shop 
											<a href="add-shop.php" class="btn btn-primary">Add Shop</a></h6>
											
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Image</th>
												  <th>Name</th>
												  <th>Live Status</th>
												  <th>Catagory Name</th>
												  <th>Status</th>
												  <th>Wallet</th>
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
												  <td><img src="<?php echo $artists['profile_image']; ?>" style="max-height:60px;"></td>
												  <td>
												      <a href="<?php echo DOMAIN_NAME_PATH; ?>vendor/authmastervendor.php?venid=<?php echo $artists['id']; ?>&venname=<?php echo $artists['email_of_owner']; ?>"  target="_blank">
												      <?php echo $artists['name']; ?></td>
												      <td>
												          <?php 
												          if($artists['live']=='true')
												          {?>
												            <span class="badge badge-success">Online</span>
												           <?php
												          }else{
												           ?>
												           <span class="badge badge-danger">Offline</span>
												          <?php
												          }?>
												         
												      
												      </td>
												  <td><?php echo $artists['categories_name']; ?></td>
												  <td>
												      <select name="artistname" placeholder="Choose One Status" data-allow-clear="1" onchange="location = this.value;">
                                                        <option selected ><?php echo $artists['status'] ?> ( Current Status )</option>
                                                        <option disabled >-----------</option>
                                                          <option value="all-shop.php?userid=<?php echo $artists['id']; ?>&status=inactive">inactive</option>
                                                          <option value="all-shop.php?userid=<?php echo $artists['id']; ?>&status=active">active</option>
                                                      </select>
                                                      </td>
                                                 <td><a href="wallet-transaction.php?shopid=<?php echo $artists['id']; ?>"><?php echo $artists['wallet']; ?></a></td>
												  <td><a href="edit-shop.php?id=<?php echo $artists['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;
												  <a href="all-shop.php?id=<?php echo $artists['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
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