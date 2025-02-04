<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

if (!isset($_GET['subid'])) {
	header('Location: jobrole.php');
	exit;
}

	$find_artists = find("all", SKILLSETS, '*', "WHERE roleid = '".$_GET['subid']."'", array());
	$findsubcat = find("first", JOBROLE, '*', "WHERE id = '".$_GET['subid']."' ", array());
	if(isset($_POST['submit']))
	{
		$table=SKILLSETS;
		$fields="name,roleid";
		$values=":name,:roleid";
		$execute=array(
			':name'=>$_POST['name'],
			':roleid'=>$_GET['subid'],
			);
		$save_data = save($table, $fields, $values, $execute);
		if($save_data)
		{
			header('location:skillsets.php?subid='.$_GET['subid']);
		}
		else
		{
			echo("error occured");exit;
		}
		
	}
	
	if(isset($_POST['submitedit']))
	{
		$table=SKILLSETS;
		$set_value="name=:name";
		$where_clause="WHERE id=".$_POST['id'];
		$execute=array(
		':name'=>$_POST['name']
		);
		$update=update($table, $set_value, $where_clause, $execute);
		if($update)
		{
			header('location:skillsets.php?subid='.$_GET['subid']);
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
		$table=SKILLSETS;
		$where_clause="WHERE id=".$id;
		$execute=array();
		delete($table, $where_clause, $execute);
		header('location:skillsets.php?subid='.$_GET['subid']);
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
											<h6 class="text-uppercase mb-0">SKILL SETS FOR <?php echo $findsubcat['name'];?> - <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Add New Skill Set</button></h6>
												
												
												<!-- Modal-->
													<div id="myModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Add Skill Set</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>NAME</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required>
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
												  <th>Name</th>
												  <th>EDIT</th>
												  <th>DELETE</th>
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
												  <th scope="row"><?php echo $sl ?></th>
												  <td><?php echo $admin['name']; ?></td>
												  <td><button type="button" data-toggle="modal" data-target="#editmodal_<?php echo $admin['id']; ?>" class="btn btn-primary">Edit</button></td>
												  
												  	<!--Edit Modal-->
													<div id="editmodal_<?php echo $admin['id']; ?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
													  <div role="document" class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<h4 id="exampleModalLabel" class="modal-title">Edit Skill</h4>
															<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
														  </div>
														  <div class="modal-body">
															<form method="post" enctype="multipart/form-data" class="form-horizontal">
															
															  <div class="form-group">       
																<label>NAME</label>
																<input name="name" type="text" placeholder="Name" class="form-control" required value="<?php echo $admin['name']; ?>">
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
												
												  <td><a href="skillsets.php?id=<?php echo $admin['id']; ?>&subid=<?php echo $_GET['subid']; ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><button name="delete" type="submit" class="btn btn-primary">Delete</button></a></td>
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