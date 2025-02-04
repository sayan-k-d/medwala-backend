<?php
	//print_r($_SESSION['admindata']['0']);exit;
	require_once('loader.inc');
	$theteacher = find("first", SHOP, '*', "WHERE id = '".$_SESSION['vendorid']."'", array());
?>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $theteacher['name']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
	<?php require_once('admin_links.php');?>
	<style>
	    .selected {
	        background-color: black;
	        color:white;
	    }
	</style>
  </head>
  <body>
<header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-align-left"></i></a><a href="admin-panel.php" class="navbar-brand font-weight-bold text-uppercase text-base"><?php echo $theteacher['name']; ?></a>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item">
          </li>
          <li class="nav-item dropdown ml-auto"><a id="userInfo" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><img src="<?php echo $theteacher['profile_image']; ?>" alt="<?php echo $theteacher['name']; ?>" style="max-width: 2.5rem;" class="img-fluid rounded-circle shadow"></a>
            <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><small><?php echo $theteacher['name']; ?></small></a>
              <!--<div class="dropdown-divider"></div><a href="edit-admin.php" class="dropdown-item">Settings</a>-->
              <div class="dropdown-divider"></div><a href="logout.php" class="dropdown-item">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    
    
    <!-- MODAL FOR SUPPORT -->
    <div class="modal fade" id="supportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="
            overflow: hidden;
        ">
           <!--Form with header-->
            <div class="card border-primary rounded-0" style="margin:0px">

                <div class="card-header p-0">
                    <div class="bg-primary text-white text-center py-2">
                        <h3 style="color:white"><i class="fa fa-envelope"></i> Write to us:</h3>
                        <p class="m-0">We Are Here To Help. Let Us Know How We Can</p>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" id="vendorsupport">
                        <!--Body-->
                        <div class="form-group">
                            <label>Your Name</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-light"><i class="fa fa-user text-primary"></i></div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Full Name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Your Email</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon bg-light"><i class="fa fa-envelope text-primary"></i></div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Registered Phone Number</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon bg-light"><i class="fa fa-tag prefix text-primary"></i></div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Mobile Number" name="phn" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon bg-light"><i class="fa fa-pencil text-primary"></i></div>
                                <textarea class="form-control" name="msg" required></textarea>
                            </div>
                        </div>
                    
                        <div class="text-center">
                            <button class="btn btn-primary btn-block rounded-0 py-2" type="submit" name="submit" id="supprtfrmsubmitbtn" >Submit</button>
                            <div class="loader" id="supprtfrmsubmitprocess" style="display:none"></div>
                        </div>
                        
                        <div class="text-center">
                            <p style="color:green;display:none" id="supportmodalsuccessmsg" >We have received your query and will contact you as soon as possible</p>
                        </div>
                    </form>
                </div>

            </div>
            <!--Form with header-->
        </div>
      </div>
    </div>
    