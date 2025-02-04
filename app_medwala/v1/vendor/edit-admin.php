<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedinrestaurant'])) {
	header('Location: index.php');
	exit;
}
$admin = find("first", RESTAURANT, '*', "WHERE id = '".$_SESSION['resid']."'", array());

?>
<!DOCTYPE html>
<html lang="en">

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
									<h3 class="h6 text-uppercase mb-0">EDIT ADMIN</h3>
								  </div>
								  <div class="card-body">
									<form method="post" enctype="multipart/form-data" class="form-horizontal">
										
										  <div class="form-group">       
											<label>Restaurant Name</label>
											<input  value="<?php echo $admin['name']; ?>"  name="name" type="text" placeholder="Teacher Name" class="form-control" required disabled>
										  </div>
										  
										   <div class="form-group">       
											<label>Restaurant Shortname</label>
											<input  value="<?php echo $admin['shortname']; ?>"  name="shortname" type="text" placeholder="Teacher Short Name" class="form-control" required disabled>
										  </div>
										  
										  <div class="form-group">       
											<label>Restaurant Address</label>
											<input value="<?php echo $admin['address']; ?>"  name="address" type="text" placeholder="Teacher Address" class="form-control" required disabled>
										  </div>
										  
										  <div class="form-group">       
											<label>Restaurant Phone</label>
											<input value="<?php echo $admin['phone']; ?>" name="phone" type="tel" title="Enter 10 Digit Phone Numbers" placeholder="Teacher Phone" disabled class="form-control" pattern="[6-9]{1}[0-9]{9}" required>
										  </div>
										  
										  <div class="form-group">       
											<label>Restaurant Email</label>
											<input value="<?php echo $admin['email']; ?>" name="email" type="email" placeholder="Teacher Email" class="form-control" required disabled>
										  </div>
    									  
										  <div class="form-group">
					                        <img src="<?php echo DOMAIN_NAME_PATH_ADMIN.$admin['pic']; ?>" width="40%">
										  </div>
										  
										  <div class="form-group">       
											To Update Profile Information Please Contact Admin
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