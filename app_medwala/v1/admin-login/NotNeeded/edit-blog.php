<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$artist = find("first", BLOG, '*', "WHERE id = '$id' ", array());
	}
	else
	{
		header("location:all-blogs.php");exit;
	}
	
	if(isset($_POST['submit']))
	{
		if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
		{
		    $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
		}
		else
		{
			$folder=$artist['pic'];
		}
		$table=BLOG;
		$set_value="title=:title,pic=:pic,description=:description,url=:url";
		$where_clause="WHERE id=".$id;
		$execute=array(
		':title'=>$_POST['title'],
		':description'=>$_POST['description'],
		':url'=>$_POST['url'].'-'.substr($artist['url'],-13),
		':pic'=>$folder,
		);
		$update=update($table, $set_value, $where_clause, $execute);
		//print_r($update);exit;
		if($update)
		{
			header("location:all-blogs.php");
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
									<h3 class="h6 text-uppercase mb-0">EDIT BLOG</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Title</label>
										<div class="col-md-9">
										  <input name="title" type="text" class="form-control" value="<?php echo $artist['title']; ?>" required>
										</div>
									  </div>
									  
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">URL</label>
										<div class="col-md-9">
										  <input name="url" type="text" class="form-control" value="<?php echo substr($artist['url'],0,-14); ?>"  onkeypress="return AvoidSpace(event)" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Description</label>
										<div class="col-md-9">
										  <textarea name="description" class="form-control ckeditor"><?php echo $artist['description']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Photo</label>
										<div class="col-md-9">
										  <input name="uploadfile" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $artist['pic']; ?>" width="20%">
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