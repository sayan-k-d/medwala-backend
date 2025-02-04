<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
    if(isset($_GET['examid']) && isset($_GET['sectionid'])){
        $find_section = find("first", SECTION, '*', "WHERE id = '".$_GET['sectionid']."'", array());
	    $find_exam = find("first", EXAM, '*', "WHERE id = '".$_GET['examid']."' ", array());
	    $find_mock = find("first", MOCK, '*', "WHERE id = '".$_GET['mockid']."' ", array());
	    $find_last_ques = find("all", QUESTION, '*', "WHERE sectionid = '".$_GET['sectionid']."' AND examid = '".$_GET['examid']."' ", array());
    }
    else{
        header('location:exam.php');
    }
    
    if(isset($_POST['submit']))
		{
		    //print_r($_POST['para']);exit;
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d h:i:s');
			$table=QUESTION;
			$fields="question,opa,opb,opc,opd,ope,opf,solution,answer,date,examid,sectionid,para";
			$values=":question,:opa,:opb,:opc,:opd,:ope,:opf,:solution,:answer,:date,:examid,:sectionid,:para";
			$execute=array(
				':question'=>$_POST['question'],
				':opa'=>$_POST['opa'],
				':opb'=>$_POST['opb'],
				':opc'=>$_POST['opc'],
				':opd'=>$_POST['opd'],
				':ope'=>$_POST['ope'],
				':opf'=>$_POST['opf'],
				':solution'=>$_POST['solution'],
				':answer'=>$_POST['answer'],
				':sectionid'=>$_GET['sectionid'],
				':examid'=>$_GET['examid'],
				':para'=>$_POST['para'],
				':date'=>$date,
				);
			$save_data = save($table, $fields, $values, $execute);
			if($save_data)
			{
				header("location:add_para_question.php?examid=".$_GET['examid']."&sectionid=".$_GET['sectionid']."&mockid=".$_GET['mockid']);
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
						    <div class="col-lg-12 mb-12">
						        
						            <nav aria-label="breadcrumb">
                                      <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="mock.php"><?php echo $find_mock['name']; ?></a></li>
                                        <li class="breadcrumb-item"><a href="exam.php?mockid=<?php echo $find_mock['id']; ?>"><?php echo $find_exam['name']; ?></a></li>
                                        <li class="breadcrumb-item"><a href="section.php?examid=<?php echo $_GET['examid']; ?>&mockid=<?php echo $find_mock['id']; ?>"><?php echo $find_section['name']; ?></a></li>
                                        <li class="breadcrumb-item"><a href="question.php?examid=<?php echo $_GET['examid']; ?>&sectionid=<?php echo $find_section['id']; ?>&mockid=<?php echo $find_mock['id']; ?>">Questions</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add Questions</li>
                                      </ol>
                                    </nav>
						    </div>
							<div class="col-lg-12 mb-5">
								<div class="card">
								  <div class="card-header">
									<h3 class="h6 text-uppercase mb-0">Add Question For Section : <?php echo $find_section['name']; ?> | Exam : <?php echo $find_exam['name']; ?></h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									    
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Linkup Question</label>
										<div class="col-md-9">
										  <select placeholder="Select Linkup Question" data-allow-clear="1" onchange="getpara()" id="selectquestion">
												<option selected></option>
												<?php
												$find_questions = find("all", QUESTION, '*', "WHERE examid = '".$_GET['examid']."' AND para != '' ", array());
												//print_r($find_questions);exit;
												if($find_questions){
												    
												    foreach($find_questions as $questions){
												    
												        echo('<option  value="'.$questions['id'].'">'.$questions['question'].'</option>');
												    }
												}
												?>
											</select>
										</div>
									  </div>
									  
									  
									 <script>
									     
									     function getpara(){
									         var selectquestion = $('#selectquestion').val();
									         $.ajax({  
                                				url:"<?php echo DOMAIN_NAME_PATH ?>teacher/getparaajax.php", 
                                				method:"POST",  
                                				data:{selectquestion:selectquestion},
                                				dataType:"text",
                                				cache: false,
                                				success:function(data)  
                                				{
                                				    if(data != ''){
                                				        $('#replace').html('<label class="col-md-3 form-control-label">Paragraph</label><div class="col-md-9"><textarea name="para"  id="para" class="form-control editor1">'+data+'</textarea></div>');
									                    //alert(data);
									                    loadckeditor(1);
									                    
                                				    }
                                				    else{
                                				        alert('Error Occured');
                                				    }
                                					
                                				}  
                                			}) 
									     }
									     
									 </script>
									 
									  
									  <div class="form-group row" id="replace">
										<label class="col-md-3 form-control-label">Paragraph</label>
										<div class="col-md-9">
										  <textarea name="para"  id="para" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Question ( Number : <?php echo count($find_last_ques) + 1; ?> )</label>
										<div class="col-md-9">
										  <textarea name="question" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option A</label>
										<div class="col-md-9">
										  <textarea name="opa" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									 <div class="form-group row">
										<label class="col-md-3 form-control-label">Option B</label>
										<div class="col-md-9">
										  <textarea name="opb" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option C</label>
										<div class="col-md-9">
										  <textarea name="opc" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option D</label>
										<div class="col-md-9">
										  <textarea name="opd" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option E</label>
										<div class="col-md-9">
										  <textarea name="ope" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option F</label>
										<div class="col-md-9">
										  <textarea name="opf" class="form-control editor"></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Answer</label>
										<div class="col-md-9">
										  <select name="answer" placeholder="Select Answer" data-allow-clear="1" required>
												<option selected></option>
												<option  value="opa">Option A</option>
												<option  value="opb">Option B</option>
												<option  value="opc">Option C</option>
												<option  value="opd">Option D</option>
												<option  value="ope">Option E</option>
												<option  value="opf">Option F</option>
											</select>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Solution</label>
										<div class="col-md-9">
										  <textarea name="solution" class="form-control editor"></textarea>
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