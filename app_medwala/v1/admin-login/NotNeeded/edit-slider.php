<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();
// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$find_catagory = find("first", SLIDER, '*', "WHERE id ='".$_GET['id']."' ", array());

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
			
			$table=SLIDER;
			$set_value="link=:link, place=:place, pic=:pic, position=:position";
			$where_clause="WHERE id=".$find_catagory['id'];
			$execute=array(
			':link'=>$_POST['link'],
			':place'=>$_POST['place'],
			':position'=>$_POST['position'],
			':pic'=>$folder,
			);
			$update=update($table, $set_value, $where_clause, $execute);
			if($update)
			{
				header("location: slider.php");
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
										<label>Link</label>
										<input name="link" type="text" placeholder="Link" class="form-control" value="<?php echo $find_catagory['link']; ?>">
									  </div>
									  <div class="form-group">       
										<label>Position</label>
										<input name="position" type="number" placeholder="Position" class="form-control" value="<?php echo $find_catagory['position']; ?>">
									  </div>
									  <div class="form-group">       
										<label>Place</label>
										<select name="place" placeholder="place" data-allow-clear="1" required>
										<?php 
											if($find_catagory['place'] == 'banner'){
												echo('
												<option value="banner" selected>Homepage Top Slider</option>
												');
											}
										?>
										</select>
									  </div>
									  <div class="form-group">       
										<label>PICTURE</label>
										<input name="uploadfile" type="file" class="form-control" >
										<img src="<?php echo $find_catagory['pic']; ?>" width="20%">
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