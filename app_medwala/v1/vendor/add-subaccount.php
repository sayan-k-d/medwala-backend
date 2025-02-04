<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

	if(isset($_POST['submit']))
		{
		    $find_subaccount_first = find("first", SUBACCOUNT, '*', "WHERE username = '".$_POST['username']."' ORDER BY id desc", array());
		    if($find_subaccount_first)
		    {
		        echo("<script>window.alert('Username Already Exists');</script>");
			    echo("<script>window.location.href = 'all-subaccount.php';</script>"); exit;
		    }
			date_default_timezone_set("Asia/Calcutta");
			$date = date('Y-m-d');
			$time=date('h:i:s');
			
			$table=SUBACCOUNT;
			$fields="username,password,shopid,date,time";
			$values=":username,:password,:shopid,:date,:time";
			$execute=array(
				':username'=>$_POST['username'],
				':password'=>$_POST['password'],
				':shopid'=>$_SESSION['vendorid'],
				':date'=>$date,
				':time'=>$time,
				);
			
			$save_data = save($table, $fields, $values, $execute);
			if($save_data)
			{
			
			
				header('location:all-subaccount.php');
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
									<h3 class="h6 text-uppercase mb-0">Add New Subaccount</h3>
								  </div>
								  <div class="card-body">
                                    <form method="post"  enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">UserName</label>
                                            <div class="col-md-9">
                                            <input name="username" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="line"></div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Password </label>
                                            <div class="col-md-9">
                                            <input name="password" type="password" class="form-control" required>
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
