<?php
session_start();
	require_once('loader.inc');
	
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}



$about = find("first", ABOUT, '*', "WHERE id = '1' ", array());

	if(isset($_POST['submit']))
		{
			if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
			{
			    $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
				$filename=uniqid().'.'.$ext;
				$tempname=$_FILES["uploadfile"]["tmp_name"];
				$folder="img/".$filename;
				move_uploaded_file($tempname,$folder);
			}
			else
			{
				$folder=$about['headerlogo'];
			}
			
			if(isset($_FILES["homepagelastbanner"]["name"]) && $_FILES["homepagelastbanner"]["name"]!='' && $_FILES["homepagelastbanner"]["error"]==0)
			{
				$filenamehomepagelastbanner=uniqid().$_FILES["homepagelastbanner"]["name"];
				$tempnamehomepagelastbanner=$_FILES["homepagelastbanner"]["tmp_name"];
				$folderhomepagelastbanner="img/".$filenamehomepagelastbanner;
				move_uploaded_file($tempnamehomepagelastbanner,$folderhomepagelastbanner);
			}
			else
			{
				$folderhomepagelastbanner=$about['homepagelastbanner'];
			}
			
			if(isset($_FILES["uploadfile2"]["name"]) && $_FILES["uploadfile2"]["name"]!='' && $_FILES["uploadfile2"]["error"]==0)
			{
				$filename2=uniqid().$_FILES["uploadfile2"]["name"];
				$tempname=$_FILES["uploadfile2"]["tmp_name"];
				$folder2="img/".$filename2;
				move_uploaded_file($tempname,$folder2);
			}
			else
			{
				$folder2=$about['footerlogo'];
			}
			
			if(isset($_FILES["vdoimg"]["name"]) && $_FILES["vdoimg"]["name"]!='' && $_FILES["vdoimg"]["error"]==0)
			{
			    $path = $_FILES['vdoimg']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
				$filenamevdoimg=uniqid().'.'.$ext;
				$tempnamevdoimg=$_FILES["vdoimg"]["tmp_name"];
				$foldervdoimg="img/".$filenamevdoimg;
				move_uploaded_file($tempnamevdoimg,$foldervdoimg);
			}
			else
			{
				$foldervdoimg=$about['vdoimg'];
			}
			
			
			
			$table=ABOUT;
			$set_value="title=:title";
			$where_clause="WHERE id=1";
			$execute=array(
			':title'=>$_POST['title'],
		
			);
			$update=update($table, $set_value, $where_clause, $execute);
			if($update)
			{
				header("location:about.php");
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
									<h3 class="h6 text-uppercase mb-0">Add About Us Content</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Title</label>
										<div class="col-md-9">
										  <input value="<?php echo $about['title'];?>" name="title" type="text" class="form-control" required>
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