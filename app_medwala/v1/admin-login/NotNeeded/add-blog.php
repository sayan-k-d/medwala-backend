<?php
session_start();
	require_once('loader.inc');
	
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}

	if(isset($_POST['submit']))
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');
			$num = strtotime($date);
			$ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
			$table=BLOG;
			$fields="title,description,pic,date,url";
			$values=":title,:description,:pic,:date,:url";
			$execute=array(
				':title'=>$_POST['name'],
				':description'=>$_POST['description'],
				':pic'=>$folder,
				':date'=>$date,
				':url'=>strtolower(create_slug($_POST['name']))."-".uniqid(),
				);
			$save_data = save($table, $fields, $values, $execute);
			if($save_data)
			{
				header('location:all-blogs.php');
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
									<h3 class="h6 text-uppercase mb-0">Add New Blog</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Title</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" required pattern="[a-zA-Z0-9\s]+">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Description</label>
										<div class="col-md-9">
										  <textarea name="description" class="form-control ckeditor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Feature Photo</label>
										<div class="col-md-9">
										  <input name="uploadfile" type="file" class="form-control" >
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