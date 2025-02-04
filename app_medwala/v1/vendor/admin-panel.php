<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedinvendor'])) {
	header('Location: index.php');
	exit;
}


if(isset($_COOKIE['vendor']) && !isset($_SESSION['loggedinvendor'])) {
    //print_r($_COOKIE);
    $find_usercookie = find("first", SHOP, '*', "WHERE phone_of_owner = '".$_COOKIE['vendor']."' ", array());
    if($find_usercookie){
        $_SESSION['vendorid'] = $find_usercookie['id'];
         $_SESSION['loggedinvendor'] = TRUE;
        header('location:admin-panel.php');exit;
    }
}

if(!isset($_SESSION['loggedinvendor'])) {
    $findtheteacher = find("first", SHOP, '*', "WHERE id = '".$_SESSION['vendorid']."'", array());
    if($findtheteacher['status'] != 'active'){
        header('location:logout.php');
	    exit;
    }
}

date_default_timezone_set("Asia/Calcutta");
$date = date('Y-m-d');
$time = date('H:i:s');


?>
<!DOCTYPE html>
<html>
  <head>
</script>
    <?php require_once('includes/header.php');?>
    <div class="d-flex align-items-stretch">
     <?php require_once('includes/sidebar.php');?> 
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
              <div class="row">
			
				
				 
			  </div>
          </section>
          
        </div>
		
		
       <?php require_once('includes/footer.php');?>
      </div>
    </div>
    
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    
    <script>
        function filterresults(id) {
            //alert(id);
            $('.mocks').hide();
            $('.mock_'+id).show();
            
            $('.filterbtns').removeClass("selected");
            $('#filterbtns_'+id).addClass( "selected" );
        }
    </script>
  </body>
</html>