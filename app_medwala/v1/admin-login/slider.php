<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

$find_slider = find("all", SLIDER, '*', "ORDER BY id DESC", array());
	if(isset($_POST['submit']))
	{
	    	$find_posslider = find("all", SLIDER, '*', "WHERE position='".$_POST['position']."' AND place='".$_POST['place']."'", array());
	if($find_posslider)
	{
	    echo("Position Number already Exist"); exit();
	}
	    
		date_default_timezone_set("Asia/Calcutta");
        $date = date('Y-m-d');
        $time=date('h:i:s');
        $ext = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    	$filename=uniqid().uniqid().'.'.$ext;
        $tempname=$_FILES["uploadfile"]["tmp_name"];
        $folder="img/".$filename;
        move_uploaded_file($tempname,$folder);
        $table=SLIDER;
        $fields="date,time,place,pic,position,title,description";
        $values=":date,:time,:place,:pic,:position,:title,:description";
        $execute=array(
          ':date'=>$date,
          ':time'=>$time,
          ':place'=>$_POST['place'],
          ':position'=>$_POST['position'],
          ':pic'=>DOMAIN_NAME_PATH_ADMIN.$folder,
          ':title'=>$_POST['title'],
          ':description'=>$_POST['description']
          );
        $save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:slider.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_POST['submitedit']))
	{
	    $find_posslider = find("all", SLIDER, '*', "WHERE position='".$_POST['position']."' AND place='".$_POST['place']."' AND id !='".$_POST['id']."' ", array());
	if($find_posslider)
	{
	    echo("Position Number already Exist"); exit();
	}
	    if(isset($_FILES["uploadfile2"]["name"]) && $_FILES["uploadfile2"]["name"]!='' && $_FILES["uploadfile2"]["error"]==0)
		{
		    $ext = pathinfo($_FILES["uploadfile2"]["name"], PATHINFO_EXTENSION);
			$filename=uniqid().uniqid().'.'.$ext;
			$tempname=$_FILES["uploadfile2"]["tmp_name"];
			$newfile_location="img/".$filename;
			$folder=DOMAIN_NAME_PATH_ADMIN."img/".$filename;
			move_uploaded_file($tempname,$newfile_location);
		}
		else
		{
			$folder= $_POST['pic'];
		}
		
		$table=SLIDER;
		$set_value="pic=:pic,place=:place,position=:position,title=:title,description=:description";
		$where_clause="WHERE id=".$_POST['id'];
		$execute=array(
		
			':place'=>$_POST['place'],
			':pic'=>$folder,
			':position'=>$_POST['position'],
			':title'=>$_POST['title'],
            ':description'=>$_POST['description']
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:slider.php');
			exit;
			
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=SLIDER;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:slider.php");
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medwala</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
 <?php require_once('includes/admin_links.php');?>
  </head>
  <body>

	<?php require_once('includes/header.php');?>


	<div class="d-flex align-items-stretch">
			<?php require_once('includes/sidebar.php');?> 
			<div class="page-holder w-100 d-flex flex-wrap">
				<div class="container-fluid px-xl-5">
					<section class="py-5">
						<div class="row">
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">HERE ARE ALL ACTIVE SLIDERS - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Slider</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD Slider</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>Add Slider Image</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group row">       
																<label class="col-md-3 form-control-label">PICTURE</label>
                                                                 <div class="col-md-9">
																<input name="uploadfile" type="file" class="form-control" >
															  </div>
															  </div>
															  
															  <div class="line"></div>
                                                                <div class="form-group row">       
                                                               <label class="col-md-3 form-control-label">Title</label>
                                                                 <div class="col-md-9">
                                                                <input name="title" type="text" placeholder="Title" class="form-control">
                                                                </div>
                                                                </div>
                                                                
                                                                <div class="line"></div>
                                                                <div class="form-group row">       
                                                               <label class="col-md-3 form-control-label">Description</label>
                                                                 <div class="col-md-9">
                                                                <input name="description" type="text" placeholder="Description" class="form-control">
                                                                </div>
                                                                </div>
															  <div class="line"></div>
                                                                <div class="form-group row">       
                                                               <label class="col-md-3 form-control-label">POSITION</label>
                                                                 <div class="col-md-9">
                                                                <input name="position" type="number" placeholder="Position" class="form-control">
                                                                </div>
                                                                </div>
                                
                                                                 <div class="line"></div>
                                                                <div class="form-group row">       
                                                                  <label class="col-md-3 form-control-label">PLACE</label>
                                                                  <div class="col-md-9">
                                                                <select name="place" placeholder="place" data-allow-clear="1" required class="form-control">
                                                                  <option value="" >Select Place</option>
                                                                     <option value="loginpagebanner" >Login Page Banners</option>
                                                                     <option value="homepagebanner" >Home Page Banners</option>
                                                                    <option value="partnerpagebanner" >Partner Paage Banners</option>
                                                                </select>
                                                                </div>
                                                                 </div>
															  <div class="form-group">       
																<button name="submit" type="submit" class="btn btn-primary">Submit</button>
															  </div>
															</form>
														  </div>
														  <div class="modal-footer">
															<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
														  </div>
														</div>
													  </div>
													</div>
												<!-- Modal-->
													
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Pic</th>
												  <th>Place</th>
												  <th>Position</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_slider)
												{
													$sl=0;
													foreach($find_slider as $admin)
													{
													$sl++;

											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><img src="<?php echo $admin['pic']; ?>" style="max-height:80px;"></td>
												  <td><?php echo $admin['place']; ?></td>
												  <td><?php echo $admin['position']; ?></td>
												   <td>
												       <a href="#" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" ><button name="edit" class="btn btn-primary">Edit</button></a></td>
												  <td><a href="slider.php?id=<?php echo $admin['id']; ?>"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
												  
												   	<!--Edit Modal-->
													<div id="editmodal_<?php echo $admin['id']; ?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Edit Slider</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  
															  <div class="form-group">       
																<label>Image</label>
																<input name="uploadfile2" type="file" class="form-control">
																<br><br>
										                        <img src="<?php echo $admin['pic']; ?>" width="20%">
										                        <input name="pic" type="hidden" placeholder="Name" class="form-control" required value="<?php echo $admin['pic']; ?>"> 
										                        <input name="id" type="hidden" placeholder="Name" class="form-control" required value="<?php echo $admin['id']; ?>">
															  </div>
                                                                <div class="line"></div>
                                                                <div class="form-group row">       
                                                               <label class="col-md-3 form-control-label">Title</label>
                                                                 <div class="col-md-9">
                                                                <input name="title" type="text" placeholder="Title" class="form-control" value="<?php echo $admin['title']; ?>">
                                                                </div>
                                                                </div>
                                                                
                                                                <div class="line"></div>
                                                                <div class="form-group row">       
                                                               <label class="col-md-3 form-control-label">Description</label>
                                                                 <div class="col-md-9">
                                                                <input name="description" type="text" placeholder="Description" class="form-control" value="<?php echo $admin['description']; ?>">
                                                                </div>
                                                                </div>
															  <div class="form-group">       
                                                                <label>Position</label>
                                                                <input name="position" type="number" placeholder="Position" class="form-control" value="<?php echo $admin['position']; ?>">
                                                                </div>
                                                                <div class="form-group">       
                                                                <label>Place</label>
                                                                <select name="place" placeholder="place" data-allow-clear="1" required class="form-control">
                                                                <?php 
                                                                  if($admin['place'] == 'loginpagebanner'){
                                                                    echo('
                                                                    <option value="loginpagebanner" selected>Login Page Banners</option>
                                                                    <option value="homepagebanner" >Home Page Banners</option>
                                                                    <option value="partnerpagebanner" >Partner Paage Banners</option>
                                                                    ');
                                                                  }
                                                                  elseif($admin['place'] == 'partnerpagebanner'){
                                                                    echo('
                                                                    <option value="loginpagebanner" >Login Page Banners</option>
                                                                    <option value="homepagebanner"  >Home Page Banners</option>
                                                                    <option value="partnerpagebanner"selected >Partner Paage Banners</option>
                                                                    ');
                                                                  }
                                                                  else{
                                                                    echo('
                                                                    <option value="loginpagebanner" >Login Page Banners</option>
                                                                     <option value="partnerpagebanner" >Partner Paage Banners</option>
                                                                    <option value="homepagebanner" selected>Home Page Banners</option>
                                                                    ');
                                                                  }
                                                                ?>
                                                                </select>
                                                                </div>
																 
															  <input type="hidden" value="<?php echo $admin['id']; ?>" name="id">
															  
															  <div class="form-group">       
																<button name="submitedit" type="submit" class="btn btn-primary">Submit</button>
															  </div>
															</form>
														  </div>
														  <div class="modal-footer">
															<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
														  </div>
														</div>
													  </div>
													</div>
												<!--Edit Modal-->
												</tr>
											<?php
													}
												}
											?>
											  </tbody>
											</table>
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