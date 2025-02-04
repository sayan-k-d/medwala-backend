<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('loader.inc');
session_start();

if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}

if(isset($_GET['examid'])){
    $find_exam = find("first", EXAM, '*', "WHERE id = '".$_GET['examid']."'", array());
}
else{
    header('location: admin-panel.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../student/assetsexam/img/favicon.png" type="image/x-icon" />
    <title><?php echo $find_exam['name']; ?> | Result page</title>
    <link rel="stylesheet" href="../student/assetsexam/css/font-awesome.min.css">
    <link href="../student/assetsexam/css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="../student/assetsexam/css/style.css" rel="stylesheet">
</head>
<body>
  <div class="page_content">

    <div class="exam_summary_sec">
        <div class="clearfix top_title">
            <div class="title_left">
                <h2 text-center>Students Ranks For <?php echo $find_exam['name']; ?></h2>
            </div>
            <div class="btn_right">
                <button id="btnExport" onClick="fnExcelReport()">Export to xls</button>
            </div>
        </div>
    
    <div class="table_sec"  style="overflow-x:auto;">
      <table id="theTable">
          <thead>
            <tr>
              <td>Rank</td>
              <td>Name of The Student</td>
              <td>Score</td>
              <td>percentage</td>
              <td>View Details</td>
             </tr>
          </thead>
          <tbody>
              <?php
          $find_rank = find("all", RANK, '*', "WHERE examid = '".$find_exam['id']."' ORDER BY score * 1 DESC", array());
          //print_r($find_rank);exit;
          if($find_rank){
              $sl = 0;
              foreach($find_rank as $rank){
                  $sl++;
                  $findstudent = find("first", STUDENT, '*', "WHERE id = '".$rank['studentid']."'", array());
                  $theattempt = find("first", ATTEMPT, '*', "WHERE examid = '".$_GET['examid']."' AND attemptuid = '".$rank['attemptuid']."' ", array());
            
          ?>
            <tr>
              <td><?php echo $sl; ?></td>
              <td><?php echo $findstudent['name']; ?></td>
              <td><?php echo $theattempt['score']; ?></td>
              <td><?php echo substr($theattempt['percentage'],0,5); ?></td>
              <td><a target="_blank" href="<?php echo DOMAIN_NAME_PATH; ?>q/<?php echo $rank['attemptuid']; ?>">View Details</a></td>
            </tr>
             <?php 
              }
          }
            ?>
          </tbody>
      </table>
      <iframe id="dummyFrame" style="display:none"></iframe>
    </div>
  </div>
  
  </div>

    <!--js-->
    <script src="../student/assetsexam/js/jquery.min.js"></script>
    <script src="../student/assetsexam/js/bootstrap.js"></script>
    <script src="asset/js/slick.min.js"></script>
    <script src="../student/assetsexam/js/custom.js"></script>
   <!--js end-->
   


</body>
</html>
