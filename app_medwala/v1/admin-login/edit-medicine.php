<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$medicine = find("first", MEDICINELIST, '*', "WHERE id = '$id' ", array());
		
	}
	else
	{
		header("location:all-medicine.php");exit;
	}
	if(isset($_POST['submit']))
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');
			$time=date('h:i:s');
			
			$table=MEDICINELIST;
			$set_value="name=:name,description=:description,mrp=:mrp";
	    	$where_clause="WHERE id=".$medicine['id'];
			$execute=array(
				':name'=>$_POST['name'],
				':description'=>$_POST['description'],
				':mrp'=>$_POST['mrp'],
				);
			
			$update=update($table, $set_value, $where_clause, $execute);
			if($update)
			{
			
			
				header('location:all-medicine.php');
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
						<div class="row">
							<div class="col-lg-12 mb-5">
								<div class="card">
								  <div class="card-header">
									<h3 class="h6 text-uppercase mb-0">Add New Medicine</h3>
								  </div>
								  <div class="card-body">
                                    <form method="post"  enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Name</label>
                                            <div class="col-md-9">
                                            <input name="name" type="text" class="form-control" required value="<?php echo $medicine['name'];?>">
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">MRP </label>
                                            <div class="col-md-9">
                                            <input name="mrp" type="text" class="form-control" required value="<?php echo $medicine['mrp'];?>">
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"> Description</label>
                                            <div class="col-md-9">
                                            <textarea name="description" class="form-control ckeditor" required ><?php echo $medicine['description'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-auto">
                                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                        <a href="admin-panel.php"><button type="submit" class="btn btn-secondary">Cancel</button></a>
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
