<?php
	//print_r($_SESSION['admindata']['0']);exit;
	require_once('loader.inc');
	$about = find("first", ABOUT, '*', "", array());
	  

?>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MedWala</title>
    <meta name="description" content="">
    <meta name="viewport" content= "width=device-width, user-scalable=no">
    <meta name="robots" content="all,follow">
	<?php require_once('admin_links.php');?>
  </head>
  <body>
<header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-align-left"></i></a><a href="admin-panel.php" class="navbar-brand font-weight-bold text-uppercase text-base">Medwala</a>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item">
          </li>
          <li class="nav-item dropdown ml-auto"><a id="userInfo" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><img src="assets/images/dashboard/user-alt-512.webp" alt="Jason Doe" style="max-width: 2.5rem;" class="img-fluid rounded-circle shadow"></a>
            <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><strong class="d-block text-uppercase headings-font-family">Master</strong><small>Admin</small></a>
              <div class="dropdown-divider"></div><a href="edit-admin.php" class="dropdown-item">Profile Settings</a>
              <div class="dropdown-divider"></div><a href="logout.php" class="dropdown-item">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>