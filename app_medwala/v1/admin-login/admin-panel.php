<?php
session_start();
  require_once('loader.inc');
  // If the user is not logged in redirect to the login page...


if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit;
}

$totusers = find("all", USER, 'COUNT(id)', "", array());
$toslider = find("all", SLIDER, 'COUNT(id)', "", array());
$toshop = find("all", SHOP, 'COUNT(id)', "", array());
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
                          <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
                            <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
                              <div class="flex-grow-1 d-flex align-items-center">
                                <div class="dot mr-3 bg-violet"></div>
                                <div class="text">
                                  <h6 class="mb-0">TOTAL USERS</h6><span class="text-gray"><?php echo $totusers[0][0]; ?></span>
                                </div>
                              </div>
                              <div class="icon text-white bg-violet"><i class="fas fa-server"></i></div>
                            </div>
                          </div>
                          
                         
                          

                          <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0" >
                            <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between" >
                              <div class="flex-grow-1 d-flex align-items-center">
                                <div class="dot mr-3 bg-blue"></div>
                                <div class="text">
                                  <h6 class="mb-0">TOTAL SHOP </h6><span class="text-gray"><?php echo $toshop[0][0]; ?></span>
                                </div>
                              </div>
                              <div class="icon text-white bg-blue"><i class="fa fa-dolly-flatbed"></i></div>
                            </div>
                          </div>


                           <div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
                            <div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
                              <div class="flex-grow-1 d-flex align-items-center">
                                <div class="dot mr-3 bg-blue"></div>
                                <div class="text">
                                  <h6 class="mb-0">TOTAL SLIDER </h6><span class="text-gray"><?php echo $toslider[0][0]; ?></span>
                                </div>
                              </div>
                              <div class="icon text-white bg-blue"><i class="fa fa-dolly-flatbed"></i></div>
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