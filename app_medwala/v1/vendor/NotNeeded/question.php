<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
    
    if(isset($_GET['sectionid'])  && isset($_GET['examid'])){
        $find_artists = find("all", QUESTION, '*', "WHERE sectionid = '".$_GET['sectionid']."' AND examid = '".$_GET['examid']."' ", array());
        $find_section = find("first", SECTION, '*', "WHERE id = '".$_GET['sectionid']."'", array());
	    $find_mock = find("first", MOCK, '*', "WHERE id = '".$_GET['mockid']."' ", array());
	    $find_exam = find("first", EXAM, '*', "WHERE id = '".$_GET['examid']."' ", array());
    }
    else{
        header('location:exam.php');
    }
	
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$table=QUESTION;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header("location:question.php?examid=".$_GET['examid']."&sectionid=".$_GET['sectionid']);
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
                                        <li class="breadcrumb-item active" aria-current="page">Questions of <?php echo $find_section['name']; ?></li>
                                      </ol>
                                    </nav>
						    </div>
							<div class="col-lg-12 mb-12">
										<div class="card">
										  <div class="card-header">
											<h6 class="text-uppercase mb-0">ALL QUESTIONS For Section : <?php echo $find_section['name']; ?> | Exam : <?php echo $find_exam['name']; ?> - <a href="add_question.php?examid=<?php echo $_GET['examid']; ?>&sectionid=<?php echo $_GET['sectionid']; ?>&mockid=<?php echo $_GET['mockid']; ?>" class="btn btn-primary">Add New Question</a>  <a href="add_para_question.php?examid=<?php echo $_GET['examid']; ?>&sectionid=<?php echo $_GET['sectionid']; ?>&mockid=<?php echo $_GET['mockid']; ?>" class="btn btn-primary">Add Paragraph Question</a><botton id="btnExport" onClick="fnExcelReport2()" class="btn btn-primary" style="margin-left:10px;">Export to excel</botton></h6>
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table class="table table-striped table-hover card-text" id="">
											  <thead>
												<tr>
												  <th>#</th>
												  <th>Question</th>
												  <th>Answer</th>
												  <th>Option</th>
												  <th>Date</th>
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
													$answer =  $admin['answer'];
											  ?>
												<tr>
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $admin['question']; ?></td>
												  <td><?php echo $admin[$answer]; ?></td>
												  <td><?php echo $answer;?></td>
												  <td><?php echo $admin['date']; ?></td>
												  <td><a href="edit_question.php?id=<?php echo $admin['id']; ?>&examid=<?php echo $_GET['examid']; ?>&sectionid=<?php echo $_GET['sectionid']; ?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp; <a onclick="return confirm('Are you sure you want to delete this item?');" href="question.php?id=<?php echo $admin['id']; ?>&examid=<?php echo $_GET['examid']; ?>&sectionid=<?php echo $_GET['sectionid']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
												  
												</tr>
											<?php
													}
												}
											?>
											  </tbody>
											</table>
											<table id="table_two" style="display:none">
                                              <thead>
                                                <tr>
                                                  <td>Sl</td>
                                                  <td>Question</td>
                                                  <td>Answer</td>
                                                  <td>opa</td>
                                                  <td>opb</td>
                                                  <td>opc</td>
                                                  <td>opd</td>
                                                  <td>ope</td>
                                                  <td>opf</td>
                                                  <td>Solution</td>
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
													$answer =  $admin['answer'];
											  ?>
                                                <tr>
                                                  <td><?php echo $sl; ?></td>
                                                  <td><?php echo $admin['question']; ?></td>
												  <td><?php echo $admin[$answer]; ?> ( <?php echo $answer;?> )</td>
												  <td><?php echo $admin['opa']; ?></td>
												  <td><?php echo $admin['opb']; ?></td>
												  <td><?php echo $admin['opc']; ?></td>
												  <td><?php echo $admin['opd']; ?></td>
												  <td><?php echo $admin['ope']; ?></td>
												  <td><?php echo $admin['opf']; ?></td>
												  <td><?php echo $admin['solution']; ?></td>
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
  <script>
      function fnExcelReport2() {
  var table = document.getElementById('table_two'); // id of table
  var tableHTML = table.outerHTML;
  var fileName = 'download.xls';

  var msie = window.navigator.userAgent.indexOf("MSIE ");

  // If Internet Explorer
  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    dummyFrame.document.open('txt/html', 'replace');
    dummyFrame.document.write(tableHTML);
    dummyFrame.document.close();
    dummyFrame.focus();
    return dummyFrame.document.execCommand('SaveAs', true, fileName);
  }
  //other browsers
  else {
    var a = document.createElement('a');
    tableHTML = tableHTML.replace(/  /g, '').replace(/ /g, '%20'); // replaces spaces
    a.href = 'data:application/vnd.ms-excel,' + tableHTML;
    a.setAttribute('download', fileName);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
}
  </script>
  </body>
</html>