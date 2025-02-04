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
		    $findexisting = find("first", VENDOR, '*', "WHERE email = '".$_POST['email']."' OR phn = '".$_POST['phn']."' ", array());
		    if($findexisting){
		        echo('Email Or Phone Registered Already');exit;
		    }
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d h:i:s');
			$filename=uniqid().$_FILES["uploadfile"]["name"];
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
			
			$filename2=uniqid().$_FILES["uploadfile2"]["name"];
			$tempname2=$_FILES["uploadfile2"]["tmp_name"];
			$folder2="img/".$filename2;
			move_uploaded_file($tempname2,$folder2);
			
			$catagory = implode('@||@',$_POST['catagory']);
			$url = strtolower(create_slug($_POST['name']))."-".uniqid();
			
			$table=VENDOR;
			$fields="name,phn,sndphn,address,email,password,logo,doc,education,date,url,catagory,description,exp,cost,pincode,lang,subcategory,workfrom,workto,gender,dob,yvc,subfilters,city,area,state,lon,lati,adharnumber,pannumber,mdt,skillsets,lastemployer,lecontact,refname,refcontact,status,visible";
			$values=":name,:phn,:sndphn,:address,:email,:password,:logo,:doc,:education,:date,:url,:catagory,:description,:exp,:cost,:pincode,:lang,:subcategory,:workfrom,:workto,:gender,:dob,:yvc,:subfilters,:city,:area,:state,:lon,:lati,:adharnumber,:pannumber,:mdt,:skillsets,:lastemployer,:lecontact,:refname,:refcontact,:status,:visible";
			$execute=array(
				':name'=>$_POST['name'],
				':phn'=>$_POST['phn'],
				':sndphn'=>$_POST['sndphn'],
				':address'=>$_POST['address'],
	        	':gender'=>$_POST['gender'],
				':email'=>$_POST['email'],
				':password'=>$_POST['password'],
	        	':dob'=>$_POST['dob'],
				':logo'=>$folder,
				':doc'=>$folder2,
				':education'=>$_POST['education'],
				':description'=>$_POST['description'],
	        	':yvc'=>$_POST['yvc'],
				':exp'=>$_POST['exp'],
        		':city'=>$_POST['city'],
        		':area'=>$_POST['area'],
        		':state'=>$_POST['state'],
        		':lati'=>$_POST['lati'],
        		':lon'=>$_POST['lon'],
				':catagory'=>$catagory,
				':url'=>$url,
				':date'=>$date,
				':cost'=>$_POST['cost'],
				':pincode'=>$_POST['pincode'],
				':lang'=>implode('@||@',$_POST['lang']),
				':subcategory'=>implode('@||@',$_POST['subcategories']),
				':workfrom'=>$_POST['workfrom'],
				':workto'=>$_POST['workto'],
				':subfilters'=> implode(',',$_POST['subfilters']),
        		':adharnumber'=>$_POST['adharnumber'],
        		':pannumber'=>$_POST['pannumber'],
        		':mdt'=>$_POST['mdt'],
        		':skillsets'=>implode(',',$_POST['skillsets']),
        		':lastemployer'=>$_POST['lastemployer'],
        		':lecontact'=>$_POST['lecontact'],
        		':refname'=>$_POST['refname'],
        		':refcontact'=>$_POST['refcontact'],
        		':status'=>'active',
        		':visible'=>'',
				);
			$save_data = save($table, $fields, $values, $execute);
			if($save_data)
			{
				$findproduct = find("first", VENDOR, '*', "WHERE url = '$url' ", array());
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
							$newFileName=$filename.uniqid().".".$ext;
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
					$fields="name,pid,url";
					$values=":name,:pid,:url";
					$execute=array(
						':name'=>$fold,
						':pid'=>$findproduct['id'],
						':url'=>$url,
						);
					$save_data = save($table, $fields, $values, $execute);
						}
					}
					if($_POST['attr'] == "Simple")
					{
						header('location:all-products.php');
					}
					else
					{
						header('location:selectattr.php?url='.$url);
					}
					header('location:vendor.php');
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
									<h3 class="h6 text-uppercase mb-0">Add New Vendor</h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone</label>
										<div class="col-md-9">
										  <input name="phn" type="number" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Whatsapp Number</label>
										<div class="col-md-9">
										  <input name="sndphn" type="number" class="form-control">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Address</label>
										<div class="col-md-9">
										  <input name="address" type="text" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">City</label>
										<div class="col-md-9">
										  <input name="city" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Area</label>
										<div class="col-md-9">
										  <input name="area" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">State</label>
										<div class="col-md-9">
										  <input name="state" type="text" class="form-control" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Latitute <a href="https://www.latlong.net/">Click Here To Get</a></label>
										<div class="col-md-9">
										  <input name="lati" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Longitute <a href="https://www.latlong.net/">Click Here To Get</a></label>
										<div class="col-md-9">
										  <input name="lon" type="text" class="form-control" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Description</label>
										<div class="col-md-9">
										  <textarea name="description" class="form-control ckeditor" required ></textarea>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Youtube Video Code</label>
										<div class="col-md-9">
										  <input name="yvc" type="text" class="form-control"  value="" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Catagory</label>
										<div class="col-md-9">
										  <select name="catagory[]" placeholder="Choose One Catagory" data-allow-clear="1" required multiple onchange="getsubcategories()" id="categories">
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
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Subcategories</label>
										<div class="col-md-9">
										    <select name="subcategories[]" placeholder="Select Subcategories" data-allow-clear="1" required multiple id="subcategories" onchange="findfilters()" >
												   
											</select>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Languages Known</label>
										<div class="col-md-9">
										    <select name="lang[]" placeholder="Choose Languages" data-allow-clear="1" required multiple>
										            <option value="" ></option>
												   <option value="Hindi" >Hindi</option>
												   <option value="English" >English</option>
												   <option value="Bengali" >Bengali</option>
											</select>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Gender</label>
										<div class="col-md-9">
										    <select name="gender" placeholder="Gender" data-allow-clear="1" required>
										        <?php
										        $langarraysdds = array('Male','Female','Others');
										        
										        foreach($langarraysdds as $gends){
										        ?>
												   <option value="<?php echo $gends; ?>"><?php echo $gends; ?></option>
												 <?php
												 
										        }
												 ?>
											</select>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Date Of Birth</label>
										<div class="col-md-9">
										  <input name="dob" type="date" class="form-control"  value="" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Gallery Photos</label>
										<div class="col-md-9">
										  <input name="galfiles[]" type="file" class="form-control" multiple >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Email</label>
										<div class="col-md-9">
										  <input name="email" type="email" class="form-control" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Adhar Number</label>
										<div class="col-md-9">
										  <input name="adharnumber" type="number" class="form-control" required>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Pan Number ( Optional )</label>
										<div class="col-md-9">
										  <input name="pannumber" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Max Distance Traven ( In KMS Optional )</label>
										<div class="col-md-9">
										  <input name="mdt" type="number" class="form-control" >
										</div>
									  </div>
									  
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Skill Sets</label>
										<div class="col-md-9">
										  <input name="skillsets" type="number" class="form-control" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Skill Sets</label>
										<div class="col-md-9">
										  <select name="skillsets[]" placeholder="Choose Multiple Skill Sets" data-allow-clear="1" required multiple>
												   <?php
												   $find_skills = find("all", SKILLSETS, '*', "", array());
													if($find_skills)
													{
														$sl=0;
														foreach($find_skills as $cat)
														{
												  ?>
														<option value="<?php echo $cat['id'] ?>" ><?php echo $cat['name'] ?></option>
														<?php
														}
													}	
												  ?>
													</select>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Last Employer Name ( Optional )</label>
										<div class="col-md-9">
										  <input name="lastemployer" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Last Employer Contact ( Optional )</label>
										<div class="col-md-9">
										  <input name="lecontact" type="number" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Reference Name ( Optional )</label>
										<div class="col-md-9">
										  <input name="refname" type="text" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Reference Contact ( Optional )</label>
										<div class="col-md-9">
										  <input name="refcontact" type="number" class="form-control" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Profile Picture</label>
										<div class="col-md-9">
										  <input name="uploadfile" id="uploadfile" type="file" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Document</label>
										<div class="col-md-9">
										  <input name="uploadfile2" type="file" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Password</label>
										<div class="col-md-9">
										  <input name="password" type="text" class="form-control" required>
										</div>
									  </div>
									  
									   <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Education</label>
										<div class="col-md-9">
										  <input name="education" type="text" class="form-control" required>
										</div>
									  </div>
									  
									   <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Experience in Years</label>
										<div class="col-md-9">
										  <input name="exp" type="number" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Cost Per Day</label>
										<div class="col-md-9">
										  <input name="cost" type="number" class="form-control" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Pincode</label>
										<div class="col-md-9">
										  <input name="pincode" type="number" class="form-control" required>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Work From (Leave Blank For 24 Hours)</label>
										<div class="col-md-9">
										  <input name="workfrom" type="time" class="form-control" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Work To (Leave Blank For 24 Hours)</label>
										<div class="col-md-9">
										  <input name="workto" type="time" class="form-control" >
										</div>
									  </div>
									  
									   <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Sub Filters</label>
										<div class="col-md-9">
										    <select name="subfilters[]" placeholder="Choose Sub Filters" data-allow-clear="1" required multiple id="subfilters">
										      
											</select>
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
