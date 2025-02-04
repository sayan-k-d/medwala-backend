<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
    
    if(isset($_GET['examid'])){
        $find_section = find("all", SECTION, '*', "WHERE examid = '".$_GET['examid']."'", array());
	    $find_exam = find("first", EXAM, '*', "WHERE id = '".$_GET['examid']."' ", array());
	    $find_mock = find("first", MOCK, '*', "WHERE id = '".$_GET['mockid']."' ", array());
    }
    else{
        header('location:exam.php');
    }

	if(isset($_POST['submit']))
	{
		$table=SECTION;
		$fields="name,examid,time";
		$values=":name,:examid,:time";
		$execute=array(
			':name'=>$_POST['name'],
			':examid'=>$find_exam['id'],
			':time'=>$_POST['time'],
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:section.php?examid='.$_GET['examid']);
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_POST['submitedit']))
	{
		$table=SECTION;
		$set_value="name=:name,time=:time";
		$where_clause="WHERE id=".$_POST['id'];
		$execute=array(
		':name'=>$_POST['name'],
		':time'=>$_POST['time'],
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:section.php?examid='.$_GET['examid']);
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
		$table=SECTION;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		
		header('location:section.php?examid='.$_GET['examid']);
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
                                    
                                    <nav aria-label="breadcrumb">
                                      <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="mock.php"><?php echo $find_mock['name']; ?></a></li>
                                        <li class="breadcrumb-item"><a href="exam.php?mockid=<?php echo $find_mock['id']; ?>"><?php echo $find_exam['name']; ?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Sections of <?php echo $find_exam['name']; ?></li>
                                      </ol>
                                    </nav>
						    </div>
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">SECTIONS OF <?php echo $find_exam['name'];?> - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Section</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Add Section</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>NAME</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required>
															  </div>
															  
															  
															  <?php
															  if($find_exam['timertype'] != 'Fixed'){
															      echo('
															      <div class="form-group">       
    																<label>Time in Minutes</label>
    																<input name="time" type="number" placeholder="Time in Minutes" class="form-control" required>
    															  </div>
															      ');
															  }
															  ?>
															  
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
												  <th>Section ID</th>
												  <th>Name</th>
												  <th>Time in Minutes</th>
												  <th>Questions</th>
												  <th>Actions</th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												if($find_section)
												{
													$sl=0;
													foreach($find_section as $admin)
													{
													$sl++;
                                                    $find_students = find("all", QUESTION, '*', "WHERE sectionid = '".$admin['id']."'", array());
											  ?>
												<tr>
												  <th scope="row"><?php echo $admin['id']; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $admin['time']; ?></td>
												  <td><a href="question.php?examid=<?php echo $find_exam['id']; ?>&sectionid=<?php echo $admin['id']; ?>&mockid=<?php echo $_GET['mockid']; ?>" class="btn btn-outline-info">Questions ( <?php echo count($find_students); ?> )</a></td>
												  <td><a href="#" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp; <a onclick="return confirm('Are you sure you want to delete this item?');" href="section.php?id=<?php echo $admin['id']; ?>&examid=<?php echo $find_exam['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
												  	<!--Edit Modal-->
													<div id="editmodal_<?php echo $admin['id']; ?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Edit Section</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>NAME</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required value="<?php echo $admin['name']; ?>">
															  </div>
															  
															  <?php
															  if($find_exam['timertype'] != 'Fixed'){
															      echo('
															      <div class="form-group">       
    																<label>Time in Minutes</label>
    																<input name="time" type="number" placeholder="Time in Minutes" class="form-control" required value="'.$admin['time'].'">
    															  </div>
															      ');
															  }
															  ?>
															  
															  
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