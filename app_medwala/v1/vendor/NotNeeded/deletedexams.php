<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
	$find_artists = find("all", EXAM, '*', "WHERE teacher = '".$_SESSION['teacherid']."' AND trash = '1' ", array());
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
											<h6 class="text-uppercase mb-0">ALL DELETED EXAMS</h6>
												
										  </div>
										  <div class="card-body"  style="overflow: scroll">     
											<table id="example" class="table table-striped table-hover card-text">
											  <thead>
												<tr>
												  <th>Exam ID</th>
												  <th>Name</th>
												  <th>Mock</th>
												  <th>Timer</th>
												  <th>From</th>
												  <th>To</th>
												  <th>Number Of Questions</th>
												  <th>Rank Table</th>
												  <th>Sections</th>
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
                                                    $find_mock = find("first", MOCK, '*', "WHERE id = '".$admin['mockid']."' ", array());
											  ?>
												<tr>
												  <th scope="row"><?php echo $admin['id']; ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><?php echo $find_mock['name']; ?></td>
												  <td><?php echo $admin['timertype']; ?></td>
												  <td><?php echo implode(' ',explode('T',$admin['fromdate'])); ?></td>
												  <td><?php echo implode(' ',explode('T',$admin['todate'])); ?></td>
												  <td><?php echo count($find_questions); ?></td>
												  <td><a target="_blank" href="ranktable.php?examid=<?php echo $admin['id']; ?>" class="btn btn-outline-primary">Rank Table ( <?php echo count($find_rank); ?> )</a></td>
												  <td><a href="section.php?examid=<?php echo $admin['id']; ?>" class="btn btn-outline-info">Sections ( <?php echo count($find_section); ?> )</a></td>
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