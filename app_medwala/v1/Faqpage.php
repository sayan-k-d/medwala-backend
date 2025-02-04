<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
@media (min-width:768px){
    .faq-point{
        display:none;
    }
}
.faq-point {
	margin-top: 30px;
}

.faq-point-box {
	margin-bottom: 20px;
}

.faq-point-box:last-child {
	margin-bottom: 0;
}

.faq-point-box-title {
    font-size: 16px;
    color: #000;
    padding: 11px 40px 11px 15px;
    background: #efe13b;
    font-weight: 600;
    position: relative;
    cursor: pointer;
    border-radius: 100px;
    transition: all .4s ease-in-out;
}

.faq-point-box-title::after {
    content: "\f067 ";
    position: absolute;
    top: 50%;
    right: 15px;
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-size: 16px;
    color: #000;
    transition: all .4s ease-in-out;
    transform: translate(0, -54%);
}

.faq-point-box-title.active::after {
    content: "\f068 ";
   
}

.faq-point-box-description {
	background: #ffffff;
	padding: 20px 15px;
	box-shadow: 0px 20px 40px 0px rgba(75, 115, 125, 0.08);
	display: none;
	color:#707070;
}

.faq-point-box-description.active {
	display: block;
}
</style>
</head>
<body>


<div class="container">
<div class="faq-point">
 
<div class="faq-point-box">
<h3 class="faq-point-box-title active">How to add prescription 

</h3>
 <div class="faq-point-box-description active">
 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate nisi velit totam autem harum tempore atque magni quidem neque ab. Eum dolorem similique est, deleniti ipsa impedit in vel nostrum!</p>
 </div>
  </div>
 <div class="faq-point-box">
<h3 class="faq-point-box-title">How to add prescription </h3>
<div class="faq-point-box-description">
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate nisi velit totam autem harum tempore atque magni quidem neque ab. Eum dolorem similique est, deleniti ipsa impedit in vel nostrum!</p>
</div>
</div>
</div>
</div>
<script>
$(".faq-point-box-title").click(function() {
  $(this).toggleClass('active');
  $(this).next().slideToggle();
  $('.faq-point-box-title').not($(this)).removeClass('active');
  $('.faq-point-box-description').not($(this).next()).slideUp();
});
</script>

</body>
</html>
