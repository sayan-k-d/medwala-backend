<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
    $display = '';
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$category= find("first", CATEGORY, '*', "WHERE id = '$id' ", array());
	
		
	}
	else
	{
		header("location:all-shop.php");exit;
	}
	
	if(isset($_POST['submit']))
	{
		
	
		$table=CATEGORY;
		$set_value="name=:name";
		$where_clause="WHERE id=".$category['id'];
		$execute=array(
		':name'=>$_POST['name'],
		);
		$update=update($table, $set_value, $where_clause, $execute);
		//print_r($update);exit;
		if($update)
		{
			header("location:all-categories.php");
			exit;
		}
		else
		{
			exit;
			echo('error occured');
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
									<h3 class="h6 text-uppercase mb-0">EDIT CATEGORY</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									   
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" value="<?php echo $category['name']; ?>" required>
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
	<script>
	    function getrs(){
	        var mrp = $('#mrp').val();
	        var price = $('#price').val();
	        var val = mrp - price;
	        var tag = $('#tagtext').val('Rs. '+val+' OFF')
	    };
	    
	    function getpercentage(){
	        //alert('sk');
	        var mrps = $('#mrp').val();
	        var prices = $('#price').val();
	        var vals = mrps - prices;
	        var percent = vals / mrps * 100;
	        $('#tagtext').val(percent+'% OFF')
	    }
	</script>
  </body>
</html>