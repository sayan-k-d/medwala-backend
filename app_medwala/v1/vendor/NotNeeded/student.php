<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
	$find_artists = find("all", STUDENT, '*', "WHERE teacher = '".$_SESSION['teacherid']."' ", array());
	
	if(isset($_POST['submitstudent']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$table=STUDENT;
		$fields="name,teacher,email,date,phone,parent,address,status";
		$values=":name,:teacher,:email,:date,:phone,:parent,:address,:status";
		$execute=array(
			':name'=>$_POST['name'],
			':email'=>$_POST['email'],
			':teacher'=>$_SESSION['teacherid'],
			':date'=>$date,
			':phone'=>$_POST['phone'],
			':parent'=>$_POST['parent'],
			':address'=>$_POST['address'],
			':status'=>'active',
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:student.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	
	if(isset($_POST['submit'])){
    	$file=$_FILES['doc']['tmp_name'];
    	$unsupported = '';
    	$ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    	if($ext=='xlsx'){
    		require('PHPExcel/PHPExcel.php');
    		require('PHPExcel/PHPExcel/IOFactory.php');
    		
    		
    		$obj=PHPExcel_IOFactory::load($file);
    		foreach($obj->getWorksheetIterator() as $sheet){
    			$getHighestRow=$sheet->getHighestRow();
    			for($i=0;$i<=$getHighestRow + 1;$i++){
    				$name=$sheet->getCellByColumnAndRow(0,$i)->getValue();
    				$email=$sheet->getCellByColumnAndRow(1,$i)->getValue();
    				$phone=$sheet->getCellByColumnAndRow(2,$i)->getValue();
    				$parentphone=$sheet->getCellByColumnAndRow(3,$i)->getValue();
    				$address=$sheet->getCellByColumnAndRow(4,$i)->getValue();
    				
    				$checkifstudentexist = find("first", STUDENT, '*', "WHERE email = '$email' OR phone = '$phone'", array());
    				
    				if($checkifstudentexist == '' && $name!='' && $email!='' && $phone!='' && $address!='' && strlen($phone) == 10 && $name!='Name'){
    					date_default_timezone_set("Asia/Calcutta");
                		$date = date('Y-m-d');
                		$table=STUDENT;
                		$fields="name,teacher,email,date,phone,parent,address,status";
                		$values=":name,:teacher,:email,:date,:phone,:parent,:address,:status";
                		$execute=array(
                			':name'=>$name,
                			':email'=>$email,
                			':teacher'=>$_SESSION['teacherid'],
                			':date'=>$date,
                			':phone'=>$phone,
                			':parent'=>$parentphone,
                			':address'=>$address,
                			':status'=>'active',
                			);
                		$save_data = save($table, $fields, $values, $execute);
    				}
    				else{
    				    
    				    if($name!='Name'){
    				        $unsupported = $unsupported.' '.$name.' | ';
    				    }
    				}
    			}
    		}
    	if($unsupported != ''){
    	    echo("<script>window.alert('Unable To Insert ".$unsupported." . Some Rows Were Missing');</script>"); 
    	}
        echo("<script>window.location.href = 'student.php';</script>");
    	
    	}else{
    		echo "Invalid file format";
    	}
    }
    
	
	if(isset($_POST['submitedit']))
	{
		$table=STUDENT;
		$set_value="name=:name,email=:email,phone=:phone,address=:address,parent=:parent";
		$where_clause="WHERE id=".$_POST['studentid'];
		$execute=array(
			':name'=>$_POST['name'],
			':email'=>$_POST['email'],
			':phone'=>$_POST['phone'],
			':parent'=>$_POST['parent'],
			':address'=>$_POST['address'],
			);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:student.php');
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=STUDENT;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:student.php");
	}
	
	
	if(isset($_GET['studentid']))
	{
		$id=$_GET['studentid'];
		$table=STUDENT;
		$set_value="status=:status";
		$where_clause="WHERE id=".$id;
		$execute=array(
		':status'=>$_GET['status'],
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			echo("<script>window.alert('Status Changed Successfully');</script>");
			echo("<script>window.location.href = 'student.php';</script>");
		}
		else
		{
			echo('error occured');
			exit;
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
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">ALL STUDENTS - <button type="button" style="padding:10px" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Student</button> &nbsp; <button style="padding:10px" type="button" data-toggle="modal" data-target="#myModal2dadq33" class="btn btn-primary">Upload Excel</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD STUDENT</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD STUDENT DETAILS HERE</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Student Name</label>
																<input name="name" type="text" placeholder="Student Name" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Address</label>
																<input name="address" type="text" placeholder="Student Address" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Phone</label>
																<input name="phone" type="tel" title="Enter 10 Digit Phone Numbers" placeholder="Student Phone" class="form-control" pattern="[6-9]{1}[0-9]{9}" required>
															  </div>
															  
															  
															  <div class="form-group">       
																<label>Parent's Phone</label>
																<input name="parent" type="tel" title="Enter 10 Digit Phone Numbers" placeholder="Parent's Phone" class="form-control" pattern="[6-9]{1}[0-9]{9}" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Email</label>
																<input name="email" type="email" placeholder="Student Email" class="form-control" required>
															  </div>
                        									  
															  <div class="form-group">       
																<button name="submitstudent" type="submit" class="btn btn-primary">Submit</button>
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
												
												
												
												<!-- Modal-->
													<div id="myModal2dadq33"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD STUDENT</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD MULTIPLE STUDENTS</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Upload Excel File ( <a href="<?php echo DOMAIN_NAME_PATH; ?>teacher/assets/sample_excel_for_student_upload.xlsx" download>Click Here to Download Format</a> )</label>
																<input type="file" name="doc" class="form-control" required />
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
												  <th>ID</th>
												  <th>Name</th>
												  <th>Email</th>
												  <th>Phone</th>
												  <th>Status</th>
												  <th>Actions</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_artists)
												{
													$sl=0;
													foreach($find_artists as $admin)
													{
													$sl++;
											  ?>
												<tr>
												  <th scope="row"><?php echo $admin['id']; ?></th>
												  <td>
												      <?php
												      if(isset($_SESSION['loggedin'])){
												          echo('
												          <a target="_blank" href="'.DOMAIN_NAME_PATH.'student/authmasterstudent.php?authcode=<?php echo uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid().uniqid(); ?>&studentid='.$admin['id'].'">'.$admin['name'].'</a>
												          ');
												      }
												      else{
												          echo('
												          '.$admin['name'].'
												          ');
												      }
												      ?>
												  </td>
												  <td><?php echo $admin['email']; ?></td>
												  <td><?php echo $admin['phone']; ?></td>
												  <td>
												    <select name="artistname" placeholder="Choose One Artist" data-allow-clear="1" onchange="location = this.value;">
														<option selected ><?php echo $admin['status'] ?> ( Current Status )</option>
														<option disabled >-----------</option>
															<option value="student.php?studentid=<?php echo $admin['id']; ?>&status=inactive">inactive</option>
															<option value="student.php?studentid=<?php echo $admin['id']; ?>&status=active">active</option>
													</select>
												  </td>
												  <td><a href="#" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp; <a onclick="return confirm('Are you sure you want to delete this item?');" href="student.php?id=<?php echo $admin['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
												  <!--Edit Modal-->
													<div id="editmodal_<?php echo $admin['id']; ?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Edit <?php echo $admin['name']; ?></h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															<input  value="<?php echo $admin['id']; ?>"  name="studentid" type="hidden">
															
															  <div class="form-group">       
																<label>Student Name</label>
																<input  value="<?php echo $admin['name']; ?>"  name="name" type="text" placeholder="Student Name" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Address</label>
																<input value="<?php echo $admin['address']; ?>"  name="address" type="text" placeholder="Student Address" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Phone</label>
																<input value="<?php echo $admin['phone']; ?>" name="phone" type="tel" title="Enter 10 Digit Phone Numbers" placeholder="Student Phone" class="form-control" pattern="[6-9]{1}[0-9]{9}" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Parent's Phone</label>
																<input name="parent" value="<?php echo $admin['parent']; ?>" type="tel" title="Enter 10 Digit Phone Numbers" placeholder="Parent's Phone" class="form-control" pattern="[6-9]{1}[0-9]{9}" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Email</label>
																<input value="<?php echo $admin['email']; ?>" name="email" type="email" placeholder="Student Email" class="form-control" required>
															  </div>
                        									  
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
	
	<script>
	    function closemodal(id){
	        $('#myModal2').hide();
	    }
	</script>
  </body>
</html>