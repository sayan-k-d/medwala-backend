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
	    $find_question = find("first", QUESTION, '*', "WHERE id = '".$_GET['id']."' ", array());
    }
    else{
        header('location:exam.php');
    }
    
    if(isset($_POST['submit']))
		{
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d h:i:s');
			$table=QUESTION;
			$set_value="question=:question,opa=:opa,opb=:opb,opc=:opc,opd=:opd,ope=:ope,opf=:opf,solution=:solution,answer=:answer,para=:para";
		    $where_clause="WHERE id=".$find_question['id'];
			$execute=array(
				':question'=>$_POST['question'],
				':opa'=>$_POST['opa'],
				':opb'=>$_POST['opb'],
				':opc'=>$_POST['opc'],
				':opd'=>$_POST['opd'],
				':ope'=>$_POST['ope'],
				':opf'=>$_POST['opf'],
				':para'=>$_POST['para'],
				':solution'=>$_POST['solution'],
				':answer'=>$_POST['answer'],
				);
			$update=update($table, $set_value, $where_clause, $execute);
			if($update)
			{
				header("location:question.php?examid=".$_GET['examid']."&sectionid=".$_GET['sectionid']);
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
									<h3 class="h6 text-uppercase mb-0">Edit Question For Section : <?php echo $find_section['name']; ?> | Exam : <?php echo $find_exam['name']; ?></h3>
								  </div>
								  <div class="card-body">
									<form method="post"  enctype="multipart/form-data" class="form-horizontal">
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Question</label>
										<div class="col-md-9">
										  <textarea name="question" class="form-control editor"><?php echo $find_question['question']; ?></textarea>
										</div>
									  </div>
									  
									  <?php
									  if($find_question['para'] != ''){
									      echo('
									      <div class="form-group row">
    										<label class="col-md-3 form-control-label">Paragraph</label>
    										<div class="col-md-9">
    										  <textarea name="para" class="form-control editor">'.$find_question['para'].'</textarea>
    										</div>
    									  </div>
									      ');
									  }
									  else{
									      echo('
									      <div class="form-group row" style="display:none">
    										<label class="col-md-3 form-control-label">Paragraph</label>
    										<div class="col-md-9">
    										  <textarea name="para" class="form-control editor">'.$find_question['para'].'</textarea>
    										</div>
    									  </div>
									      ');
									  }
									  ?>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option A</label>
										<div class="col-md-9">
										  <textarea name="opa" class="form-control editor"><?php echo $find_question['opa']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									 <div class="form-group row">
										<label class="col-md-3 form-control-label">Option B</label>
										<div class="col-md-9">
										  <textarea name="opb" class="form-control editor"><?php echo $find_question['opb']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option C</label>
										<div class="col-md-9">
										  <textarea name="opc" class="form-control editor"><?php echo $find_question['opc']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option D</label>
										<div class="col-md-9">
										  <textarea name="opd" class="form-control editor"><?php echo $find_question['opd']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option E</label>
										<div class="col-md-9">
										  <textarea name="ope" class="form-control editor"><?php echo $find_question['ope']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Option F</label>
										<div class="col-md-9">
										  <textarea name="opf" class="form-control editor"><?php echo $find_question['opf']; ?></textarea>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Select Answer</label>
										<div class="col-md-9">
										    <?php
										    $answer = $find_question['answer'];
										    ?>
										  <select name="answer" placeholder="Select Answer" data-allow-clear="1" required>
												<option  value="opa" <?php echo $find_question['answer'] == 'opa' ? 'selected' : '' ?> >Option A</option>
												<option  value="opb" <?php echo $find_question['answer'] == 'opb' ? 'selected' : '' ?>>Option B</option>
												<option  value="opc" <?php echo $find_question['answer'] == 'opc' ? 'selected' : '' ?>>Option C</option>
												<option  value="opd" <?php echo $find_question['answer'] == 'opd' ? 'selected' : '' ?>>Option D</option>
												<option  value="ope" <?php echo $find_question['answer'] == 'ope' ? 'selected' : '' ?>>Option E</option>
												<option  value="opf" <?php echo $find_question['answer'] == 'opf' ? 'selected' : '' ?>>Option F</option>
											</select>
										</div>
									  </div>
									  
									  <div class="line"></div>
									  <div class="form-group row">
										<label class="col-md-3 form-control-label">Solution</label>
										<div class="col-md-9">
										  <textarea name="solution" class="form-control editor"><?php echo $find_question['solution']; ?></textarea>
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