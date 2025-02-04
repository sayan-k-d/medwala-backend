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
		$shop = find("first", SHOP, '*', "WHERE id = '$id' ", array());
		$url = $shop['url'];
		
	}
	else
	{
		header("location:all-shop.php");exit;
	}
	
	if(isset($_POST['submit']))
	{
		
		if(!empty($_FILES['galfiles']['name'][0]))
		{ 
			
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
						$newFileName=$filename.time().".".$ext;
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
				':shop_id'=>$shop['id'],
				':url'=>$url,
				);
			$save_data = save($table, $fields, $values, $execute);
				}
			}
		}
		
		
		if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
		{
		
			
			$ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext1;
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$newfile_location="img/".$filename;
			$folder=DOMAIN_NAME_PATH_ADMIN."img/".$filename;
			move_uploaded_file($tempname,$newfile_location);
		}
		else
		{
			$folder=$shop['profile_image'];
		}
		
			if(isset($_FILES["trade_lisence"]["name"]) && $_FILES["trade_lisence"]["name"]!='' && $_FILES["trade_lisence"]["error"]==0)
		{
			
			$ext1 = pathinfo($_FILES["trade_lisence"]["name"], PATHINFO_EXTENSION);
			$filename1=uniqid().uniqid().'.'.$ext1;
			$tempname1=$_FILES["trade_lisence"]["tmp_name"];
			$newfile_location1="img/".$filename1;
			$folder1=DOMAIN_NAME_PATH_ADMIN."img/".$filename1;
			move_uploaded_file($tempname1,$newfile_location1);
		}
		else
		{
			$folder1=$shop['trade_lisence'];
		}
		
			if(isset($_FILES["drug_lisence"]["name"]) && $_FILES["drug_lisence"]["name"]!='' && $_FILES["drug_lisence"]["error"]==0)
		{
			$ext2 = pathinfo($_FILES["drug_lisence"]["name"], PATHINFO_EXTENSION);
			$filename2=uniqid().uniqid().'.'.$ext2;
			$tempname2=$_FILES["drug_lisence"]["tmp_name"];
			$newfile_location2="img/".$filename2;
			$folder2=DOMAIN_NAME_PATH_ADMIN."img/".$filename2;
			move_uploaded_file($tempname2,$newfile_location2);
		}
		else
		{
			$folder2=$shop['drug_lisence'];
		}
			if(isset($_FILES["shop_address_proof"]["name"]) && $_FILES["shop_address_proof"]["name"]!='' && $_FILES["shop_address_proof"]["error"]==0)
		{
			
			 $ext3 = pathinfo($_FILES["shop_address_proof"]["name"], PATHINFO_EXTENSION);
			$filename3=uniqid().uniqid().'.'.$ext3;
			$tempname3=$_FILES["shop_address_proof"]["tmp_name"];
			$newfile_location3="img/".$filename3;
			$folder3=DOMAIN_NAME_PATH_ADMIN."img/".$filename3;
			move_uploaded_file($tempname3,$newfile_location3);
		}
		else
		{
			$folder3=$shop['shop_address_proof'];
		}
		
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
		$table=SHOP;
		$set_value="name=:name,categories=:categories,categories_name=:categories_name,address=:address,profile_image=:profile_image,name_of_owner=:name_of_owner,
		email_of_owner=:email_of_owner,phone_of_owner=:phone_of_owner,contact_person_name=:contact_person_name,contact_person_email=:contact_person_email,
		contact_person_phone=:contact_person_phone,lati=:lati,longi=:longi,trade_lisence=:trade_lisence,drug_lisence=:drug_lisence,shop_address_proof=:shop_address_proof,
		description=:description,discount_percentage=:discount_percentage,area=:area,deliverydistance=:deliverydistance,badgetext=:badgetext,badgetextcolor=:badgetextcolor,
		badgebackgroundcolor=:badgebackgroundcolor";
		$where_clause="WHERE id=".$shop['id'];
		$execute=array(
		':name'=>$_POST['name'],
		':categories'=>implode(',',$_POST['categories']),
		':categories_name'=>$catfinalname,
		':address'=>$_POST['address'],
		':profile_image'=>$folder,
		':name_of_owner'=>$_POST['name_of_owner'],
		':email_of_owner'=>$_POST['email_of_owner'],
		':phone_of_owner'=>$_POST['phone_of_owner'],
		':contact_person_name'=>$_POST['contact_person_name'],
		':contact_person_email'=>$_POST['contact_person_email'],
		':contact_person_phone'=>$_POST['contact_person_phone'],
		':lati'=>$_POST['latitude'],
		':longi'=>$_POST['longitude'],
		':trade_lisence'=>$folder1,
		':drug_lisence'=>$folder2,
		':shop_address_proof'=>$folder3,
		':description'=>$_POST['description'],
		':discount_percentage'=>$_POST['discount_percentage'],
		':area'=>$_POST['area'],
		':deliverydistance'=>$_POST['deliverydistance'],
		':badgetext'=>$_POST['badgetext'],
		':badgetextcolor'=>$_POST['badgetextcolor'],
		':badgebackgroundcolor'=>$_POST['badgebackgroundcolor']
		);
		$update=update($table, $set_value, $where_clause, $execute);
		//print_r($update);exit;
		if($update)
		{
			header("location:all-shop.php");
			exit;
		}
		else
		{
			exit;
			echo('error occured');
		}
	
	}
	
	if(isset($_GET['pdid']))
	{
		
		$pdid=$_GET['pdid'];
		$table=GALLERY;
		$where_clause="WHERE id=".$pdid;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:edit-shop.php?id=".$id);
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
									<h3 class="h6 text-uppercase mb-0">EDIT SHOP</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									    <h4>Normal Details</h4>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" value="<?php echo $shop['name']; ?>" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Categories</label>
										<div class="col-md-9">
										  
										   <select name="categories[]" placeholder="Choose One Catagory" data-allow-clear="1" multiple id="categoriesedit" >
												   <?php
												   $find_cat = find("all", CATEGORY, '*', "", array());
												   $catagories = explode(',',$shop['categories']);
													if($find_cat)
													{
														$sl=0;
														foreach($find_cat as $cat)
														{
															if (in_array("".$cat['id']."", $catagories))
															{
																$select = "selected";
															}
															else
															{
																$select = "";
															}
															
															
												  ?>
														<option <?php echo $select; ?> value="<?php echo $cat['id']; ?>" ><?php echo $cat['name'] ?></option>
														<?php
														}
													}	
												  ?>
											</select>
										</div>
									  </div>
									  
									 
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Profile Photo</label>
										<div class="col-md-9">
										  <input name="uploadfile" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $shop['profile_image']; ?>" width="20%">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Gallery Photos</label>
										<div class="col-md-9">
										  <input name="galfiles[]" type="file" class="form-control" multiple>
										  <br><br>
										  <div class="row">
										  <?php
										  $gallery=find("all", GALLERY, '*', "WHERE shop_id= '".$shop['id']."' OR url = '".$shop['url']."' ", array());
													if($gallery)
													{
														$sl=0;
														foreach($gallery as $gal)
														{
												  ?>
											<div class="col-md-3"><img src="<?php echo $gal['name']; ?>" width="100%">
											<a href="edit-shop.php?id=<?php echo $id; ?>&pdid=<?php echo $gal['id']; ?>">Delete</a>
											</div>
											<?php
														}
													}	
												  ?>
										  </div>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Address </label>
										<div class="col-md-9">
										  <input name="address" type="text" class="form-control" required value="<?php echo $shop['address']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Area </label>
										<div class="col-md-9">
										  <input name="area" type="text" class="form-control" required value="<?php echo $shop['area']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Latitude </label>
										<div class="col-md-9">
										  <input name="latitude" type="text" class="form-control" required value="<?php echo $shop['lati']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Longitude </label>
										<div class="col-md-9">
										  <input name="longitude" type="text" class="form-control" required value="<?php echo $shop['longi']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <h4>Ownership Details</h4>
									  
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Name Of Owner</label>
										<div class="col-md-9">
										  <input name="name_of_owner" type="text" class="form-control" required value="<?php echo $shop['name_of_owner']; ?>" >
										</div>
									  </div>
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Email Of Owner</label>
										<div class="col-md-9">
										  <input name="email_of_owner" type="email" class="form-control" required value="<?php echo $shop['email_of_owner']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone Of Owner</label>
										<div class="col-md-9">
										  <input name="phone_of_owner" type="text" class="form-control" required pattern="[6-9]{1}[0-9]{9}" title="Only 10 digits phone number allowed" value="<?php echo $shop['phone_of_owner']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <h4>Contact Person </h4>
									  
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name Of Contact Person</label>
										<div class="col-md-9">
										  <input name="contact_person_name" type="text" class="form-control" required value="<?php echo $shop['contact_person_name']; ?>">
										</div>
									  </div>
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Email Of Contact Person (Optional)</label>
										<div class="col-md-9">
										  <input name="contact_person_email" type="email" class="form-control" value="<?php echo $shop['contact_person_email']; ?>">
										</div>
									  </div>
									  
									  <div class="line"></div>
									   <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone Of Contact Person</label>
										<div class="col-md-9">
										  <input name="contact_person_phone" type="text" class="form-control" required pattern="[6-9]{1}[0-9]{9}" title="Only 10 digits phone number allowed" value="<?php echo $shop['contact_person_phone']; ?>">
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <h4>Documents </h4>
									
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Trade Lisence</label>
										<div class="col-md-9">
										  <input name="trade_lisence" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $shop['trade_lisence']; ?>" width="20%">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Drug Lisence</label>
										<div class="col-md-9">
										  <input name="drug_lisence" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $shop['drug_lisence']; ?>" width="20%">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Shop Address Proof</label>
										<div class="col-md-9">
										  <input name="shop_address_proof" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $shop['shop_address_proof']; ?>" width="20%">
										</div>
									  </div>
									   
									   <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label"> Description</label>
										<div class="col-md-9">
										<textarea name="description" class="form-control ckeditor"  ><?php echo $shop['description']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label"> Discount percentage</label>
										<div class="col-md-9">
									    <input name="discount_percentage" type="text" class="form-control" required value="<?php echo $shop['discount_percentage']; ?>">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Delivery Distance(In km) </label>
										<div class="col-md-9">
										  <input name="deliverydistance" type="text" class="form-control" required value="<?php echo $shop['deliverydistance']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Badgetext </label>
										<div class="col-md-9">
										  <input name="badgetext" type="text" class="form-control" required value="<?php echo $shop['badgetext']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Badgetext Color </label>
										<div class="col-md-9">
										  <input name="badgetextcolor" type="text" class="form-control" required value="<?php echo $shop['badgetextcolor']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Badge Background Color </label>
										<div class="col-md-9">
										  <input name="badgebackgroundcolor" type="text" class="form-control" required value="<?php echo $shop['badgebackgroundcolor']; ?>" >
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