<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}

if (!isset($_GET['mockid'])) {
	header('Location: mock.php');
	exit;
}

	$find_artists = find("all", EXAM, '*', "WHERE teacher = '".$_SESSION['teacherid']."' AND mockid = '".$_GET['mockid']."' AND (trash != '1' OR trash IS NULL ) ", array());
	$find_mock = find("first", MOCK, '*', "WHERE id = '".$_GET['mockid']."' ", array());
	
	if(isset($_POST['submitstudent']))
	{
	    if($_POST['timertype'] == 'Fixed'){
	        if($_POST['time'] == ''){
	            echo('Cannot Leave Time Field Empty If Timer Type is Fixed');exit;
	        }
	    }
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$table=EXAM;
		$fields="name,timertype,mockid,marks,negativemarks,fromdate,todate,fromdatestrtotime,todatestrtotime,instructions,teacher,date,time";
		$values=":name,:timertype,:mockid,:marks,:negativemarks,:fromdate,:todate,:fromdatestrtotime,:todatestrtotime,:instructions,:teacher,:date,:time";
		$execute=array(
			':name'=>$_POST['name'],
			':timertype'=>$_POST['timertype'],
			':mockid'=>$_GET['mockid'],
			':marks'=>$_POST['marks'],
			':negativemarks'=>$_POST['negativemarks'],
			':fromdate'=>$_POST['fromdate'],
			':todate'=>$_POST['todate'],
			':fromdatestrtotime'=>strtotime(implode(' ',explode('T',$_POST['fromdate']))),
			':todatestrtotime'=>strtotime(implode(' ',explode('T',$_POST['todate']))),
			':instructions'=>$_POST['instructions'],
			':teacher'=>$_SESSION['teacherid'],
			':time'=>$_POST['time'],
			':date'=>$date,
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:exam.php?mockid='.$_GET['mockid']);
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	
	if(isset($_POST['submitedit']))
	{
	    //print_r(implode(' ',explode('T',$_POST['fromdate'])));exit;
		$table=EXAM;
		$set_value="name=:name,timertype=:timertype,mockid=:mockid,time=:time,marks=:marks,negativemarks=:negativemarks,fromdate=:fromdate,todate=:todate,fromdatestrtotime=:fromdatestrtotime,todatestrtotime=:todatestrtotime,instructions=:instructions";
		$where_clause="WHERE id=".$_POST['studentid'];
		$execute=array(
			':name'=>$_POST['name'],
			':timertype'=>$_POST['timertype'],
			':mockid'=>$_GET['mockid'],
			':marks'=>$_POST['marks'],
			':negativemarks'=>$_POST['negativemarks'],
			':fromdate'=>$_POST['fromdate'],
			':todate'=>$_POST['todate'],
			':fromdatestrtotime'=>strtotime(implode(' ',explode('T',$_POST['fromdate']))),
			':todatestrtotime'=>strtotime(implode(' ',explode('T',$_POST['todate']))),
			':instructions'=>$_POST['instructions'],
			':time'=>$_POST['time'],
			);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:exam.php?mockid='.$_GET['mockid']);exit;
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_GET['id']))
	{
	    $table=EXAM;
		$set_value="trash=:trash";
		$where_clause="WHERE id=".$_GET['id'];
		$execute=array(
			':trash'=>1,
			);
		$update=update($table, $set_value, $where_clause, $execute);
		header('location:exam.php?mockid='.$_GET['mockid']);exit;
	}
	
	
	
	if(isset($_POST['submitexcel'])){
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
    			    
    				$question= $sheet->getCellByColumnAndRow(0,$i)->getValue();
    				$sectionid = $sheet->getCellByColumnAndRow(9,$i)->getValue();
    				$examid = $sheet->getCellByColumnAndRow(10,$i)->getValue();
    				
    				
    				if($question != '' && $sectionid!='' && $examid!='' && $question!='Question'){
    					date_default_timezone_set("Asia/Calcutta");
			            $date = date('Y-m-d h:i:s');    
                		$table=QUESTION;
            			$fields="question,opa,opb,opc,opd,ope,opf,solution,answer,date,examid,sectionid";
            			$values=":question,:opa,:opb,:opc,:opd,:ope,:opf,:solution,:answer,:date,:examid,:sectionid";
                		$execute=array(
                			':question'=>$sheet->getCellByColumnAndRow(0,$i)->getValue(),
            				':opa'=>$sheet->getCellByColumnAndRow(1,$i)->getValue(),
            				':opb'=>$sheet->getCellByColumnAndRow(2,$i)->getValue(),
            				':opc'=>$sheet->getCellByColumnAndRow(3,$i)->getValue(),
            				':opd'=>$sheet->getCellByColumnAndRow(4,$i)->getValue(),
            				':ope'=>$sheet->getCellByColumnAndRow(5,$i)->getValue(),
            				':opf'=>$sheet->getCellByColumnAndRow(6,$i)->getValue(),
            				':solution'=>$sheet->getCellByColumnAndRow(8,$i)->getValue(),
            				':answer'=>$sheet->getCellByColumnAndRow(7,$i)->getValue(),
            				':sectionid'=>$sheet->getCellByColumnAndRow(9,$i)->getValue(),
            				':examid'=>$sheet->getCellByColumnAndRow(10,$i)->getValue(),
            				':date'=>$date,
                			);
                		$save_data = save($table, $fields, $values, $execute);
    				}
    				else{
    				    
    				    if($name!='Name'){
    				        $unsupported = $unsupported.' '.$question.' | ';
    				    }
    				}
    			}
    		}
    	if($unsupported != ''){
    	    echo("<script>window.alert('Unable To Insert ".$unsupported." . Some Rows Were Missing');</script>"); 
    	}
        echo("<script>window.location.href = 'exam.php';</script>");
    	echo("<script>window.alert('Insert Process Completed Successfully!');</script>"); 
    	
    	}else{
    		echo "Invalid file format";
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
											<h6 class="text-uppercase mb-0">ALL EXAMS FOR <?php echo $find_mock['name']; ?>- <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Exam</button>  &nbsp; <button style="padding:10px" type="button" data-toggle="modal" data-target="#myModal2dadq33" class="btn btn-primary">Upload Excel Questions</button></h6>
												
													<!-- Modal-->
													<div id="myModal2dadq33"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD QUESTIONS</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD MULTIPLE QUESTIONS</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Upload Excel File ( <a href="<?php echo DOMAIN_NAME_PATH; ?>teacher/assets/sample_excel_for_question_upload.xlsx" download>Click Here to Download Format</a> )</label>
																<input type="file" name="doc" class="form-control" required />
															  </div>
                        									  
															  <div class="form-group">       
																<button name="submitexcel" type="submit" class="btn btn-primary">Submit</button>
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
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">ADD EXAM</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<p>ADD EXAM DETAILS HERE</p>
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>Exam Name</label>
																<input name="name" type="text" placeholder="Exam Name" class="form-control" required>
															  </div>
															  
															  <div class="form-group">
																<label>Select Timer Type</label>
																	<select id="timertype" name="timertype" placeholder="Select Timer Type" data-allow-clear="1" required onchange="changeoftimertype()">
																		<option selected></option>
																		<option  value="Fixed">Fixed</option>
																		<option  value="Sectional">Sectional</option>
																	</select>
															  </div>
															  
															  <div class="form-group" id="timeforexam" style="display:none;">       
    																<label>Time in Minutes</label>
    																<input name="time" type="number" placeholder="Time in Minutes" class="form-control">
    														  </div>
    														  
    														  <script>
    														      function changeoftimertype(){
    														         var timerype = $('#timertype').val();
    														         if(timerype == 'Fixed'){
    														             $('#timeforexam').show();
    														         }
    														         else{
    														             $('#timeforexam').hide();
    														         }
    														      }
    														  </script>
															  
															  <div class="form-group">       
																<label>Question Marks</label>
																<input name="marks" type="text" placeholder="Question Marks" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Negative Marks</label>
																<input name="negativemarks" type="text" placeholder="Negative Marks" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Start Date And Time</label>
																<input name="fromdate"  type="datetime-local" placeholder="Student Start Date And Time" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student End Date And Time</label>
																<input name="todate"  type="datetime-local" placeholder="Student End Date And Time" class="form-control" required>
															  </div>
															  
															  <div class="form-group">
																<label>Instructions</label>
																	<textarea name="instructions" class="form-control editor" ></textarea>
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
													
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>Exam ID</th>
												  <th>Name</th>
												  <th>Timer</th>
												  <th>From</th>
												  <th>To</th>
												  <th>Number Of Questions</th>
												  <th>Rank Table</th>
												  <th>Sections</th>
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
                                                    $find_section = find("all", SECTION, '*', "WHERE examid = '".$admin['id']."'", array());
                                                    $find_questions = find("all", QUESTION, '*', "WHERE examid = '".$admin['id']."'", array());
                                                    $find_rank = find("all", RANK, '*', "WHERE examid = '".$admin['id']."'", array());
											  ?>
												<tr>
												  <th scope="row"><?php echo $admin['id']; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $admin['timertype']; ?></td>
												  <td><?php echo implode(' ',explode('T',$admin['fromdate'])); ?></td>
												  <td><?php echo implode(' ',explode('T',$admin['todate'])); ?></td>
												  <td><?php echo count($find_questions); ?></td>
												  <td><a target="_blank" href="ranktable.php?examid=<?php echo $admin['id']; ?>" class="btn btn-outline-primary">Rank Table ( <?php echo count($find_rank); ?> )</a></td>
												  <td><a href="section.php?examid=<?php echo $admin['id']; ?>&mockid=<?php echo $_GET['mockid']; ?>" class="btn btn-outline-info">Sections ( <?php echo count($find_section); ?> )</a></td>
												  <td><a href="#" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp; <a onclick="return confirm('Are you sure you want to delete this item?');" href="exam.php?id=<?php echo $admin['id']; ?>&mockid=<?php echo $_GET['mockid']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
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
																<label>Exam Name</label>
																<input name="name" type="text" placeholder="Exam Name" class="form-control" required value="<?php echo $admin['name']; ?>">
															  </div>
															  
															  <div class="form-group" style="display:none">
																<label>Select Timer Type</label>
																	<select id="timertype<?php echo $admin['id']; ?>" name="timertype" placeholder="Select Timer Type" data-allow-clear="1" required onchange="changeoftimertypeedit(<?php echo $admin['id']; ?>)">
																		<option selected value="<?php echo $admin['timertype']; ?>"><?php echo $admin['timertype']; ?></option>
																		<option  value="Fixed">Fixed</option>
																		<option  value="Sectional">Sectional</option>
																	</select>
															  </div>
															  
															  
															  <?php
															  if($admin['timertype'] == 'Fixed'){
															      $display = "";
															  }else{
															      $display = "display:none;";
															  }
															  ?>
															  <div class="form-group" id="timeforexam<?php echo $admin['id']; ?>" style="<?php echo $display; ?>">       
    																<label>Time in Minutes</label>
    																<input name="time" type="number" placeholder="Time in Minutes" class="form-control" value="<?php echo $admin['time']; ?>">
    														  </div>
    														  
    														  
															  
															  <div class="form-group">       
																<label>Question Marks</label>
																<input name="marks" value="<?php echo $admin['marks']; ?>" type="text" placeholder="Question Marks" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Negative Marks</label>
																<input name="negativemarks" value="<?php echo $admin['negativemarks']; ?>" type="text" placeholder="Negative Marks" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student Start Date And Time</label>
																<input name="fromdate" value="<?php echo $admin['fromdate']; ?>"  type="datetime-local" placeholder="Student Start Date And Time" class="form-control" required>
															  </div>
															  
															  <div class="form-group">       
																<label>Student End Date And Time</label>
																<input name="todate" value="<?php echo $admin['todate']; ?>"  type="datetime-local" placeholder="Student End Date And Time" class="form-control" required>
															  </div>
															  
															  <div class="form-group">
																<label>Instructions</label>
																	<textarea name="instructions" class="form-control editor" ><?php echo $admin['instructions']; ?></textarea>
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
	
	<script>
      function changeoftimertypeedit(id){
         var timerype = $('#timertype'+id).val();
         if(timerype != 'Fixed'){
             $('#timeforexam'+id).show();
         }
         else{
             $('#timeforexam'+id).hide();
         }
      }
  </script>
  </body>
</html>