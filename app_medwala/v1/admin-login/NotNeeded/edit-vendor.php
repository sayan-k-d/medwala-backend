<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
    $display = '';
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$product = find("first", VENDOR, '*', "WHERE id = '$id' ", array());
		$url = $product['url'];
	}
	else
	{
		header("location:vendor.php");exit;
	}
	
	if(isset($_POST['submit']))
	{
		$findexisting = find("first", VENDOR, '*', "WHERE email = '".$_POST['email']."' AND id != '$id' ", array());
	    if($findexisting){
	        echo('Email Registered Already');exit;
	    }
	    $findexistingphone = find("first", VENDOR, '*', "WHERE phn = '".$_POST['phn']."' AND id != '$id' ", array());
	    if($findexistingphone){
	        echo('Phone Registered Already');exit;
	    }
	    
	    
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
			$fields="name,pid,url";
			$values=":name,:pid,:url";
			$execute=array(
				':name'=>$fold,
				':pid'=>$product['id'],
				':url'=>$url,
				);
			$save_data = save($table, $fields, $values, $execute);
				}
			}
		}
		
		$catagory = implode('@||@',$_POST['catagory']);
		
		if(isset($_FILES["uploadfile"]["name"]) && $_FILES["uploadfile"]["name"]!='' && $_FILES["uploadfile"]["error"]==0)
		{
			$filename=uniqid().$_FILES["uploadfile"]["name"];
			$tempname=$_FILES["uploadfile"]["tmp_name"];
			$folder="img/".$filename;
			move_uploaded_file($tempname,$folder);
		}
		else
		{
			$folder=$product['logo'];
		}
		
		if(isset($_FILES["uploadfile2"]["name"]) && $_FILES["uploadfile2"]["name"]!='' && $_FILES["uploadfile2"]["error"]==0)
		{
			$filename2=uniqid().$_FILES["uploadfile2"]["name"];
			$tempname2=$_FILES["uploadfile2"]["tmp_name"];
			$folder2="img/".$filename2;
			move_uploaded_file($tempname2,$folder2);
		}
		else
		{
			$folder2=$product['doc'];
		}
		
		
		$table=VENDOR;
		$set_value="name=:name,phn=:phn,sndphn=:sndphn,gender=:gender,address=:address,email=:email,password=:password,logo=:logo,doc=:doc,education=:education,description=:description,exp=:exp,catagory=:catagory,
		cost=:cost,pincode=:pincode,lang=:lang,subcategory=:subcategory,workfrom=:workfrom,subfilters=:subfilters,workto=:workto,dob=:dob,yvc=:yvc,city=:city,area=:area,state=:state,lati=:lati
		,lon=:lon,refcontact=:refcontact,refname=:refname,lecontact=:lecontact,lastemployer=:lastemployer,skillsets=:skillsets,mdt=:mdt,pannumber=:pannumber,adharnumber=:adharnumber,visible=:visible
		,tagtext=:tagtext,tagcolor=:tagcolor, seotitle=:seotitle, seodescription=:seodescription, seokeywords=:seokeywords,url=:url";
		$where_clause="WHERE id=".$product['id'];
		$execute=array(
		':name'=>$_POST['name'],
		':phn'=>$_POST['phn'],
		':sndphn'=>$_POST['sndphn'],
		':address'=>$_POST['address'],
		':email'=>$_POST['email'],
		':gender'=>$_POST['gender'],
		':password'=>$_POST['password'],
		':logo'=>$folder,
		':doc'=>$folder2,
		':education'=>$_POST['education'],
		':description'=>$_POST['description'],
		':dob'=>$_POST['dob'],
		':exp'=>$_POST['exp'],
		':city'=>$_POST['city'],
		':area'=>$_POST['area'],
		':state'=>$_POST['state'],
		':lati'=>$_POST['lati'],
		':lon'=>$_POST['lon'],
		':catagory'=>$catagory,
		':cost'=>$_POST['cost'],
		':yvc'=>$_POST['yvc'],
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
		':visible'=>$_POST['visible'],
		':tagtext'=>$_POST['tagtext'],
		':tagcolor'=>$_POST['tagcolor'],
		':seotitle'=>$_POST['seotitle'],
		':seodescription'=>$_POST['seodescription'],
		':seokeywords'=>$_POST['seokeywords'],
		':url'=>$_POST['url'].'-'.substr($product['url'],-13),
		);
		$update=update($table, $set_value, $where_clause, $execute);
		//print_r($update);exit;
		if($update)
		{
			header("location:vendor.php");
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
		header("location:edit-vendor.php?id=".$id);
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
									<h3 class="h6 text-uppercase mb-0">EDIT VENDOR</h3>
								  </div>
								   <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Name</label>
										<div class="col-md-9">
										  <input name="name" type="text" class="form-control" required value="<?php echo $product['name']; ?>" >
										</div>
									  </div>
									  
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">URL</label>
										<div class="col-md-9">
										  <input name="url" type="text" class="form-control" value="<?php echo substr($product['url'],0,-14); ?>"  onkeypress="return AvoidSpace(event)" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Phone</label>
										<div class="col-md-9">
										  <input name="phn" type="number" class="form-control" required value="<?php echo $product['phn']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Whatsapp Number</label>
										<div class="col-md-9">
										  <input name="sndphn" type="number" class="form-control"  value="<?php echo $product['sndphn']; ?>" > 
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Address</label>
										<div class="col-md-9">
										  <input name="address" type="text" class="form-control" required value="<?php echo $product['address']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">City</label>
										<div class="col-md-9">
										  <input name="city" type="text" class="form-control" value="<?php echo $product['city']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Area</label>
										<div class="col-md-9">
										  <input name="area" type="text" class="form-control" value="<?php echo $product['area']; ?>"  >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">State</label>
										<div class="col-md-9">
										  <input name="state" type="text" class="form-control" value="<?php echo $product['state']; ?>"  >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Latitute <a href="https://www.latlong.net/">Click Here To Get</a></label>
										<div class="col-md-9">
										  <input name="lati" type="text" class="form-control" value="<?php echo $product['lati']; ?>"   >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Longitute <a href="https://www.latlong.net/">Click Here To Get</a></label>
										<div class="col-md-9">
										  <input name="lon" type="text" class="form-control" value="<?php echo $product['lon']; ?>"   >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Description</label>
										<div class="col-md-9">
										  <textarea name="description" class="form-control ckeditor" required ><?php echo $product['description']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Catagory</label>
										<div class="col-md-9">
										  <select name="catagory[]" placeholder="Choose One Catagory" data-allow-clear="1" multiple id="categoriesedit" onchange="getsubcategoriesedit()">
												   <?php
												   $find_cat = find("all", CATAGORY, '*', "WHERE parent = ''", array());
												   $catagories = explode('@||@',$product['catagory']);
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
										<label class="col-md-3 form-control-label">Select Subcategories</label>
										<div class="col-md-9">
										    <select name="subcategories[]" placeholder="Select Subcategories" data-allow-clear="1" required multiple id="subcategoriesedit" onchange="findfiltersedit()" >
												   <?php
												   $find_categories = find("all", CATAGORY, '*', "WHERE parent IN (".implode(',',$catagories).") ", array());
												   $subcats = explode('@||@',$product['subcategory']);
												   foreach($find_categories as $subcat){
												    if (in_array("".$subcat['id']."", $subcats))
															{
																$select = "selected";
															}
															else
															{
																$select = "";
															}
												   ?>
												   <option <?php echo $select; ?> value="<?php echo $subcat['id']; ?>" ><?php echo $subcat['name'] ?></option>
												   <?php
												                         }
												   ?>
											</select>
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
										  $gallery=find("all", GALLERY, '*', "WHERE pid= '".$product['id']."' OR url = '".$product['url']."' ", array());
													if($gallery)
													{
														$sl=0;
														foreach($gallery as $gal)
														{
												  ?>
											<div class="col-md-3"><img src="img/<?php echo $gal['name']; ?>" width="100%">
											<a href="edit-vendor.php?id=<?php echo $id; ?>&pdid=<?php echo $gal['id']; ?>">Delete</a>
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
										<label class="col-md-3 form-control-label">Select Languages Known</label>
										<div class="col-md-9">
										    <select name="lang[]" placeholder="Choose Languages" data-allow-clear="1" required multiple>
										        <?php
										        $langarray = array('Hindi','English','Bengali');
										        $subcatagorieslang = explode('@||@',$product['lang']);
										        foreach($langarray as $langs){
										            
										            if (in_array($langs, $subcatagorieslang))
														{
															$select = "selected";
															//echo('nooo');exit;
														}
														else
														{
															$select = "";
														}
										        ?>
												   <option value="<?php echo $langs; ?>" <?php echo $select; ?> ><?php echo $langs; ?></option>
												 <?php
												 
										        }
												 ?>
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
										            if($gends == $product['gender']){
										                $select = "selected";
										            }
										            else
													{
														$select = "";
													}
										        ?>
												   <option value="<?php echo $gends; ?>" <?php echo $select; ?> ><?php echo $gends; ?></option>
												 <?php
												 
										        }
												 ?>
											</select>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Email</label>
										<div class="col-md-9">
										  <input name="email" type="email" class="form-control"  value="<?php echo $product['email']; ?>" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Youtube Video Code</label>
										<div class="col-md-9">
										  <input name="yvc" type="text" class="form-control"  value="<?php echo $product['yvc']; ?>" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Adhar Number</label>
										<div class="col-md-9">
										  <input name="adharnumber" type="number" class="form-control" required  value="<?php echo $product['adharnumber']; ?>" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Pan Number ( Optional )</label>
										<div class="col-md-9">
										  <input name="pannumber" type="text" class="form-control"   value="<?php echo $product['pannumber']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Max Distance Traven ( In KMS Optional )</label>
										<div class="col-md-9">
										  <input name="mdt" type="number" class="form-control"   value="<?php echo $product['mdt']; ?>" >
										</div>
									  </div>
									  
									  
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Skill Sets</label>
										<div class="col-md-9">
										  <select name="skillsets[]" placeholder="Choose Multiple Skill Sets" data-allow-clear="1" multiple >
												   <?php
												   $find_skills = find("all", SKILLSETS, '*', "", array());
												   $skillsets = explode('@||@',$product['skillsets']);
													if($find_skills)
													{
														$sl=0;
														foreach($find_skills as $cskls)
														{
															if (in_array("".$cskls['id']."", $skillsets))
															{
																$select = "selected";
															}
															else
															{
																$select = "";
															}
												  ?>
														<option <?php echo $select; ?> value="<?php echo $cskls['id']; ?>" ><?php echo $cskls['name'] ?></option>
														<?php
														}
													}	
												  ?>
											</select>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Tag Text</label>
										<div class="col-md-7">
										  <input name="tagtext" type="text" class="form-control" value="<?php echo $product['tagtext']; ?>">
										</div>
										<div class="col-md-2">
										  <input name="tagcolor" type="color" class="form-control" value="<?php echo $product['tagcolor']; ?>">
										</div>
									  </div>
									  
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Last Employer Name ( Optional )</label>
										<div class="col-md-9">
										  <input name="lastemployer" type="text" class="form-control"   value="<?php echo $product['lastemployer']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Last Employer Contact ( Optional )</label>
										<div class="col-md-9">
										  <input name="lecontact" type="number" class="form-control"   value="<?php echo $product['lecontact']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Reference Name ( Optional )</label>
										<div class="col-md-9">
										  <input name="refname" type="text" class="form-control"   value="<?php echo $product['refname']; ?>" >
										</div>
									  </div>
									  
									  
									   <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Reference Contact ( Optional )</label>
										<div class="col-md-9">
										  <input name="refcontact" type="number" class="form-control"   value="<?php echo $product['refcontact']; ?>">
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Date Of Birth</label>
										<div class="col-md-9">
										  <input name="dob" type="date" class="form-control"  value="<?php echo $product['dob']; ?>" required>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Profile Picture</label>
										<div class="col-md-9">
										  <input name="uploadfile" id="uploadfile" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $product['logo']; ?>" width="20%">
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Document</label>
										<div class="col-md-9">
										  <input name="uploadfile2" type="file" class="form-control" >
										  <br><br>
										  <img src="<?php echo $product['doc']; ?>" width="20%">
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Password</label>
										<div class="col-md-9">
										  <input name="password" type="text" class="form-control" required value="<?php echo $product['password']; ?>" >
										</div>
									  </div>
									  
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Eperience in Years</label>
										<div class="col-md-9">
										  <input name="exp" type="number" class="form-control" required value="<?php echo $product['exp']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Cost Per Day</label>
										<div class="col-md-9">
										  <input name="cost" type="number" class="form-control" required value="<?php echo $product['cost']; ?>" >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Pincode</label>
										<div class="col-md-9">
										  <input name="pincode" type="number" class="form-control" required value="<?php echo $product['pincode']; ?>" >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Work From (Leave Blank For 24 Hours)</label>
										<div class="col-md-9">
										  <input name="workfrom" type="time" class="form-control" value="<?php echo $product['workfrom']; ?>"  >
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Work To (Leave Blank For 24 Hours)</label>
										<div class="col-md-9">
										  <input name="workto" type="time" class="form-control" value="<?php echo $product['workto']; ?>"  >
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Sub Filters</label>
										<div class="col-md-9">
										    <select name="subfilters[]" placeholder="Choose Sub Filters" data-allow-clear="1" required multiple id="subfiltersedit">
										      <?php
										           $subcatagories = explode('@||@',$product['subcategory']);
												   $find_categories = find("all", SUBFILTER, '*', "WHERE subcat IN (".implode(',',$subcatagories).") ", array());
												   $subfilters = explode(',',$product['subfilters']);
												   foreach($find_categories as $subcat){
												    if (in_array("".$subcat['id']."", $subfilters))
															{
																$select = "selected";
															}
															else
															{
																$select = "";
															}
															
													$subfilterdetails = find("first", SUBFILTER, '*', "WHERE id = '".$subcat['id']."' ", array());
													$findfiler = find("first", FILTER, '*', "WHERE id = '".$subfilterdetails['filter']."' ", array());
												   ?>
												   <option <?php echo $select; ?> value="<?php echo $subcat['id']; ?>" ><?php echo $subcat['name'] ?> ( <?php echo $findfiler['name']; ?> )</option>
												   <?php
												                         }
												   ?>
											</select>
										</div>
									  </div>
									  
									  
									  <div class="form-group">
										<label>SEO Title</label>
										<input value="<?php echo $product['seotitle']; ?>" name="seotitle" type="text" placeholder="SEO Title" class="form-control" >
									  </div>
									  
									  
									  <div class="form-group">
										<label>SEO Description</label>
										<input value="<?php echo $product['seodescription']; ?>" name="seodescription" type="text" placeholder="SEO Description" class="form-control" >
									  </div>
									  
									  <div class="form-group">  
										<label>SEO Keywords</label>
										<input value="<?php echo $product['seokeywords']; ?>" name="seokeywords" type="text" placeholder="SEO Keywords" class="form-control" >
									  </div>
									  
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Visible ( Write 1 to Make The Vendor Invisible )</label>
										<div class="col-md-9">
										  <input name="visible" type="number" class="form-control"  value="<?php echo $product['visible']; ?>" >
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