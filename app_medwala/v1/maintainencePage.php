<?php
    if(isset($_GET['check'])){
         echo json_encode('false');exit;
    }
    else{
?>

<!DOCTYPE html>
<html>
  
<head>
      <title>Kulika Foundation</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
          * {
            box-sizing: border-box;
            
        }
    
        body {
            margin: 0;
            padding: 0;
            font-family: 'Catamaran', sans-serif;
            color: #00225a;
        }

        .wrapper{
            height:100vh;
            width:100%;
        }
        .img_holder img{
            width:100%;
        }
        .des{
            padding:20px 15px;
        }
        .des a{
            display: inline-block;
            color: #fff;
            background: hsl(221deg 100% 63%);
            padding: 10px 20px;
            border-radius: 5px;
            outline: none;
            font-size: 15px;
            text-decoration: none;
        }
        
        @media (min-width:768px){
            .wrapper{
                display:none;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="img_holder">
        <img src="admin-login/img/app-maintenance-img.png" alt="">
    </div>
    <div class="des">
        <h2>Title</h2>
        <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. </p>
        <a href="javascript:void(0)">Read More</a>
    </div>
</div>

</body>
</html>



<?php
 }
?>