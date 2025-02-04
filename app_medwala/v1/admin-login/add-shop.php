<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

$find_category = find("all", CATEGORY, '*', "ORDER BY id DESC", array());

	if(isset($_POST['submit']))
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');
			$time=date('h:i:s');
			$num = strtotime($date);
			 $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
			
			$url = strtolower(create_slug($_POST['name']))."-".uniqid();
			
			
			$ext1 = pathinfo($_FILES["trade_lisence"]["name"], PATHINFO_EXTENSION);
			$filename1=uniqid().uniqid().'.'.$ext1;
			$tempname1=$_FILES["trade_lisence"]["tmp_name"];
			$folder1="img/".$filename1;
			move_uploaded_file($tempname1,$folder1);
			
			
			$ext2 = pathinfo($_FILES["drug_lisence"]["name"], PATHINFO_EXTENSION);
			$filename2=uniqid().uniqid().'.'.$ext2;
			$tempname2=$_FILES["drug_lisence"]["tmp_name"];
			$folder2="img/".$filename2;
			move_uploaded_file($tempname2,$folder2);
			
			
			$ext3 = pathinfo($_FILES["shop_address_proof"]["name"], PATHINFO_EXTENSION);
			$filename3=uniqid().uniqid().'.'.$ext3;
			$tempname3=$_FILES["shop_address_proof"]["tmp_name"];
			$folder3="img/".$filename3;
			move_uploaded_file($tempname3,$folder3);
			
		 	$cat_id=implode(',',$_POST['categories']);
			
			
		    $a=[];
		    foreach($_POST['categories'] as $cat_ids)
		    {
		        $find_catname=find("first", CATEGORY, '*', "WHERE id='".$cat_ids."'", array());
		        if($find_catname)
		        {
		            array_push($a,$find_catname['name']);
		        }
		    }
		    $catfinalname=implode(', ',$a);
			//print_r($catfinalname);	
			
	   // exit();
			$table=SHOP;
			$fields="name,categories,categories_name,address,profile_image,joindate,jointime,url,name_of_owner,email_of_owner,phone_of_owner,trade_lisence,drug_lisence,shop_address_proof,lati,longi,contact_person_name,contact_person_email,contact_person_phone,description,discount_percentage,area,deliverydistance";
			$values=":name,:categories,:categories_name,:address,:profile_image,:joindate,:jointime,:url,:name_of_owner,:email_of_owner,:phone_of_owner,:trade_lisence,:drug_lisence,:shop_address_proof,:lati,:longi,:contact_person_name,:contact_person_email,:contact_person_phone,:description,:discount_percentage,:area,:deliverydistance";
			$execute=array(
				':name'=>$_POST['name'],
				':categories'=>implode(',',$_POST['categories']),
				'categories_name'=>$catfinalname,
				':address'=>$_POST['address'],
				':profile_image'=>DOMAIN_NAME_PATH_ADMIN.$folder,
				':joindate'=>$date,
				':jointime'=>$time,
				':url'=>$url,
				':lati'=>$_POST['latitude'],
				':longi'=>$_POST['longitude'],
				':name_of_owner'=>$_POST['name_of_owner'],
				':email_of_owner'=>$_POST['email_of_owner'],
				':phone_of_owner'=>$_POST['phone_of_owner'],
				':contact_person_name'=>$_POST['contact_person_name'],
				':contact_person_email'=>$_POST['contact_person_email'],
				':contact_person_phone'=>$_POST['contact_person_phone'],
				':trade_lisence'=>DOMAIN_NAME_PATH_ADMIN.$folder1,
				':drug_lisence'=>DOMAIN_NAME_PATH_ADMIN.$folder2,
				':shop_address_proof'=>DOMAIN_NAME_PATH_ADMIN.$folder3,
				':description'=>$_POST['description'],
				':discount_percentage'=>$_POST['discount_percentage'],
				':area'=>$_POST['area'],
				':deliverydistance'=>$_POST['deliverydistance'],
				);
			
			$save_data = save($table, $fields, $values, $execute);
			if($save_data)
			{
			
				
				$findshop = find("first", SHOP, '*', "WHERE url = '$url' ", array());
				$folders=array();
				$extension=array("jpeg","jpg","png","gif");
				if(isset($_FILES["galfiles"]))
				{
					foreach($_FILES["galfiles"]["tmp_name"] as $key=>$tmp_name) {
						$file_name=$_FILES["galfiles"]["name"][$key];
						$file_tmp=$_FILES["galfiles"]["tmp_name"][$key];
						$ext=pathinfo($file_name,PATHINFO_EXTENSION);

						if(in_array($ext,$extension)) {
							$filename=basename($file_name,$ext);
							$newFileName=uniqid().uniqid().".".$ext;
							$folders[$key]=$newFileName;
							
							move_uploaded_file($file_tmp,"img/".$newFileName);
						}
						else {
							array_push($error,"$file_name, ");
						}
					}

				}
				if($folders)
				{
					foreach($folders as $fold)
					{
				$table=GALLERY;
				$fields="name,shop_id,url";
				$values=":name,:shop_id,:url";
				$execute=array(
					':name'=>DOMAIN_NAME_PATH_ADMIN."img/".$fold,
					':shop_id'=>$findshop['id'],
					':url'=>$url,
					);
				$save_data = save($table, $fields, $values, $execute);
					}
				}
				header('location:all-shop.php');
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
									<h3 class="h6 text-uppercase mb-0">Add New Shop</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									    <h4>Normal Details</h4>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label"> Select Category</label>
										<div class="col-md-9">
										  <select name="categories[]" id="categories" class="form-control" required  multiple>
										<option value="">Select Category</option>
										<?php if($find_category){
											foreach($find_category as $category){?>
										<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
										<?Php }} ?>
									</select> 
									  </div>
									  	</div>
									  	
									   
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Profile Photo</label>
										<div class="col-md-9">
										  <input name="uploadfile" id="uploadfile" type="file" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Gallery Photos</label>
										<div class="col-md-9">
										  <input name="galfiles[]" type="file" class="form-control" multiple required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Address </label>
										<div class="col-md-9">
										  <input name="address" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Area </label>
										<div class="col-md-9">
										  <input name="area" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Latitude </label>
										<div class="col-md-9">
										  <input name="latitude" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Longitude </label>
										<div class="col-md-9">
										  <input name="longitude" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <h4>Ownership Details</h4>
									  
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Name Of Owner</label>
										<div class="col-md-9">
										  <input name="name_of_owner" type="text" class="form-control" required>
										</div>
									  </div>
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Email Of Owner</label>
										<div class="col-md-9">
										  <input name="email_of_owner" type="email" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone Of Owner</label>
										<div class="col-md-9">
										  <input name="phone_of_owner" type="text" class="form-control" required pattern="[6-9]{1}[0-9]{9}" title="Only 10 digits phone number allowed">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <h4>Contact Person </h4>
									  
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Name Of Contact Person</label>
										<div class="col-md-9">
										  <input name="contact_person_name" type="text" class="form-control" required>
										</div>
									  </div>
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Email Of Contact Person (Optional)</label>
										<div class="col-md-9">
										  <input name="contact_person_email" type="email" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone Of Contact Person</label>
										<div class="col-md-9">
										  <input name="contact_person_phone" type="text" class="form-control" required >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <h4>Documents </h4>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Trade Lisence</label>
										<div class="col-md-9">
										  <input name="trade_lisence" id="trade_lisence" type="file" class="form-control" required>
										</div>
									  </div>
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Drug Lisence</label>
										<div class="col-md-9">
										  <input name="drug_lisence" id="drug_lisence" type="file" class="form-control" required>
										</div>
									  </div>
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Shop Address Proof</label>
										<div class="col-md-9">
										  <input name="shop_address_proof" id="shop_address_proof" type="file" class="form-control" required>
										</div>
									  </div>
									  
									  <!--<div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Description</label>
										<div class="col-md-9">
										  <textarea name="description" class="form-control ckeditor" required ></textarea>
										</div>
									  </div>-->
									  
								    <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label"> Description</label>
										<div class="col-md-9">
										<textarea name="description" class="form-control ckeditor" required ></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label"> Discount percentage</label>
										<div class="col-md-9">
									     <input name="discount_percentage" type="text" class="form-control" required>
										</div>
									  </div>
									  
								    <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Delivery Distance(In km) </label>
										<div class="col-md-9">
										  <input name="deliverydistance" type="text" class="form-control" required>
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
	
<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
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
						  <button class="btn btn-success crop_image">Crop & Upload Image</button>
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
      width:255,
      height:190,
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
  </body>
</html>
