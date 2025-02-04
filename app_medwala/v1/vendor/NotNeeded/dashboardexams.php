<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}

if (!isset($_GET['mockid'])) {
	header('location:admin-panel.php');exit;
}

if(isset($_COOKIE['teacher']) && !isset($_SESSION['loggedinteacher'])) {
    //print_r($_COOKIE);
    $find_usercookie = find("first", TEACHERS, '*', "WHERE phone = '".$_COOKIE['teacher']."' ", array());
    if($find_usercookie){
        $_SESSION['teacherid'] = $find_usercookie['id'];
        $_SESSION['loggedinteacher'] = TRUE;
        header('location:admin-panel.php');exit;
    }
}

if (!isset($_SESSION['loggedin'])) {
    $findtheteacher = find("first", TEACHERS, '*', "WHERE id = '".$_SESSION['teacherid']."'", array());
    if($findtheteacher['status'] != 'active'){
        header('Location: logout.php');
	    exit;
    }
}

$findmock = find("first", MOCK, '*', "WHERE id = '".$_GET['mockid']."'", array());
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
          <section class="py-5 text-center">
              <h2>Exams For <?php echo $findmock['name']; ?></h2>
              <hr>
            <div class="row">
                <?php
                  date_default_timezone_set("Asia/Calcutta");
	           	  $datetime = strtotime(date('Y-m-d h:i:s'));
                  $findexams = find("all", EXAM, '*', "WHERE teacher = '".$_SESSION['teacherid']."' AND mockid = '".$_GET['mockid']."'  AND todatestrtotime >= '$datetime' AND (trash != '1' OR trash IS NULL )", array());
                  //print_r($findexams);exit;
                  if($findexams){
                     foreach($findexams as $exams){
                         
                         $countdown = '<span style="font-size: 20px;color: green;font-weight: 600;" class="mb-0 mt-3 mt-lg-0" id="demo'.$exams['id'].'"></span>
							<script>
								var countDownDate'.$exams['id'].' = new Date("'.$exams['fromdate'].'").getTime();

								// Update the count down every 1 second
								var x'.$exams['id'].' = setInterval(function() {

								  var now'.$exams['id'].' = new Date().getTime();
									
								  // Find the distance between now and the count down date
								  var distance'.$exams['id'].' = countDownDate'.$exams['id'].' - now'.$exams['id'].';
									
								  // Time calculations for days, hours, minutes and seconds
								  var days'.$exams['id'].' = Math.floor(distance'.$exams['id'].' / (1000 * 60 * 60 * 24));
								  var hours'.$exams['id'].' = Math.floor((distance'.$exams['id'].' % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								  var minutes'.$exams['id'].' = Math.floor((distance'.$exams['id'].' % (1000 * 60 * 60)) / (1000 * 60));
								  var seconds'.$exams['id'].' = Math.floor((distance'.$exams['id'].' % (1000 * 60)) / 1000);
									
								  // Output the result in an element with id="demo"
								  document.getElementById("demo'.$exams['id'].'").innerHTML = days'.$exams['id'].' + "d " + hours'.$exams['id'].' + "h " + minutes'.$exams['id'].' + "m " + seconds'.$exams['id'].' + "s  Remaining";
								  
									
								  // If the count down is over, write some text 
								  if (distance'.$exams['id'].' < 0) {
									clearInterval(x'.$exams['id'].');
									document.getElementById("demo'.$exams['id'].'").innerHTML = "LIVE";
								  }
								}, 1000);
								
								
							</script>
							';
                  ?>  
                  <div class="col-sm-6" style="padding-top:15px;padding-bottom:15px">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $exams['name']; ?> - <?php echo $countdown; ?></h5>
                        <?php echo $exams['instructions']; ?>
                      </div>
                    </div>
                  </div>
                  <?php
                     } 
                  }
                  ?>
            </div>
          </section>
        </div>
		
		
       <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 text-center text-md-left text-primary">
                <p class="mb-2 mb-md-0">Your company &copy; 2018-2021</p>
              </div>
              <div class="col-md-6 text-center text-md-right text-gray-400">
                <p class="mb-0">Design by <a href="serveque.in" >Serveque</a></p>
              </div>
            </div>
          </div>
        </footer>
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