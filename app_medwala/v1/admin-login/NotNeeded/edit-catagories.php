<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();
// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$find_catagory = find("first", CATAGORY, '*', "WHERE id ='".$_GET['id']."' ", array());

	if(isset($_POST['submit']))
		{
			if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
			{
				$filename=uniqid().$_FILES["uploadfile"]["name"];
				$tempname=$_FILES["uploadfile"]["tmp_name"];
				$folder="img/".$filename;
				move_uploaded_file($tempname,$folder);
			}
			else
			{
				$folder=$find_catagory['pic'];
			}
			
			$table=CATAGORY;
			$set_value="name=:name, homepage=:homepage,pic=:pic, parent=:parent, position=:position, srtdescription=:srtdescription, seotitle=:seotitle, seodescription=:seodescription, seokeywords=:seokeywords,url=:url";
			$where_clause="WHERE id=".$find_catagory['id'];
			$execute=array(
			':name'=>$_POST['name'],
			':homepage'=>$_POST['homepage'],
			':parent'=>$_POST['parent'],
			':position'=>$_POST['position'],
			':srtdescription'=>$_POST['srtdescription'],
			':seotitle'=>$_POST['seotitle'],
			':seodescription'=>$_POST['seodescription'],
			':seokeywords'=>$_POST['seokeywords'],
	    	':url'=>$_POST['url'].'-'.substr($find_catagory['url'],-13),
			':pic'=>$folder,
			);
			$update=update($table, $set_value, $where_clause, $execute);
			if($update)
			{
				header("location: catagories.php");
				exit;
				
			}
			else
			{
				echo("error occured");exit;
			}
			
			
		}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('includes/admin_links.php');?>
		<script src="up/croppie.js"></script>
		<link rel="stylesheet" href="up/croppie.css" />
</head>

 <body>
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
									<h3 class="h6 text-uppercase mb-0">EDIT CATAGORY</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group">   
									  
										<label>CATAGORY NAME</label>
										<input value="<?php echo $find_catagory['name']; ?>" name="name" type="text" placeholder="CATAGORY NAME" class="form-control" required>
									  </div>
									  
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">URL</label>
										<div class="col-md-9">
										  <input name="url" type="text" class="form-control" value="<?php echo substr($find_catagory['url'],0,-14); ?>"  onkeypress="return AvoidSpace(event)" required>
										</div>
									  </div>
									  
									  
									  <div class="form-group"> 
										<label>Short Description</label>
										<input value="<?php echo $find_catagory['srtdescription']; ?>" name="srtdescription" type="text" placeholder="Short Description" class="form-control" required>
									  </div>
									  
									  
									  <?php $find_cat_parent = find("first", CATAGORY, '*', "WHERE id = '". $find_catagory['parent']."' ", array()); ?>
									  <div class="form-group">
										<label>Parent Catagory</label>
											<select id="" name="parent" placeholder="Parent Catagory" data-allow-clear="1" >
												<option value="<?php echo $find_catagory['parent']; ?>"  selected><?php echo $find_cat_parent['name']; ?></option>
												  <?php
												   $find_cat = find("all", CATAGORY, '*', "WHERE parent = ''", array());
													if($find_cat)
													{
														$sl=0;
														foreach($find_cat as $cat)
														{
												  ?>
														<option value="<?php echo $cat['id'] ?>" ><?php echo $cat['name'] ?></option>
														<?php
														}
													}	
												  ?>
											</select>
									  </div>
									  <?php 
									  if($find_catagory['parent'] != '')
									  {
									      $displayposi = 'style="display:none;"';
									  }
									  else
									  {
									      $displayposi = '';
									  }
									  ?>
									  
									  <div class="form-group" <?php echo $displayposi; ?>>
										<label>WANT TO PLACE IN HOME PAGE ?</label>
											<select id="" name="homepage" placeholder="WANT TO PLACE IN HOME PAGE ?" data-allow-clear="1" >
												<option selected><?php echo $find_catagory['homepage']; ?></option>
												<option disabled>----------------------------------</option>
												<option>No</option>
												<option>Yes</option>
											</select>
									  </div>
									  
									  
									  <div class="form-group" <?php echo $displayposi; ?> >   
									    <label>Position For Homepage</label>
										<input value="<?php echo $find_catagory['position']; ?>" name="position" type="text" placeholder="" class="form-control">
									  </div>
									  
									  <div class="form-group" >       
										<label>Display Picture</label>
										<input name="uploadfile" type="file" class="form-control">
										<br><br>
										 <img src="<?php echo $find_catagory['pic']; ?>" width="20%">
									  </div>
									  
									  
									  <div class="form-group">
										<label>SEO Title</label>
										<input value="<?php echo $find_catagory['seotitle']; ?>" name="seotitle" type="text" placeholder="SEO Title" class="form-control" >
									  </div>
									  
									  
									  <div class="form-group">
										<label>SEO Description</label>
										<input value="<?php echo $find_catagory['seodescription']; ?>" name="seodescription" type="text" placeholder="SEO Description" class="form-control" >
									  </div>
									  
									  <div class="form-group">  
										<label>SEO Keywords</label>
										<input value="<?php echo $find_catagory['seokeywords']; ?>" name="seokeywords" type="text" placeholder="SEO Keywords" class="form-control" >
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


<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Upload & Crop Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
  						<br />
  						<br />
  						<br/>
						  <button class="btn btn-success crop_image">Crop Image</button>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>


<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
      });
    })
  });

});  
</script>