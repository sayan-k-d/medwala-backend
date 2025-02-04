<?php 
session_start();
require_once('app_medwala/v1/admin-login/loader.inc');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <title>Medwala - Privacy Policy</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg  sticky-top">
      <div class="container">
        <a class="navbar-brand" href="https://medwala.in/"
          ><img src="../assets/Mediwala logo.jpg" width="150"
        /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span><i class="bi bi-list" style="font-size: 32px"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto fs-5">
            <li class="nav-item p-1">
              <a class="nav-link active" aria-current="page" href="https://medwala.in/">Home</a>
            </li>
            <li class="nav-item p-1">
              <a class="nav-link" href="https://medwala.in/about.php">About Us</a>
            </li>
            <li class="nav-item dropdown p-1">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Contact
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Email</a></li>
                <li><a class="dropdown-item" href="#">Phone Number</a></li>
                
              </ul>
            </li>
            <li class="nav-item p-1">
              <a class="nav-link  btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#signupmodal">Sign up as partner</a>
            </li>
            <li class="nav-item p-1">
              <a class="nav-link  btn btn-primary" href="pay.php">Pay Now</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!--Carosel images-->
    
    
    <div class="container">
        <div class="row">
            <p>Welcome to Medwala! By accessing and using our services, you agree to comply with and be bound by the following terms and conditions. Please read these terms carefully before using our website, mobile applications, or any other services provided by Medwala.</p>
            <br><br>

            <h3>1. Acceptance of Terms</h3>
            <p>By accessing or using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please refrain from using our services.</p>
            <br><br>
            <h3>2. User Eligibility</h3>
            <p>You must be at least 18 years old to use our services. By using our services, you represent and warrant that you are at least 18 years old and are capable of entering into a legally binding agreement.</p>
            <br><br>
            <h3>3. Account Registration</h3>
            <p>To access certain features of our services, you may need to create an account. You are responsible for maintaining the confidentiality of your account information and agree to accept responsibility for all activities that occur under your account.</p>
            <br><br>
            <h3>4. Privacy</h3>
            <p>Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and safeguard your information.</p>
            <br><br>
            <h3>5. Use of Services</h3>
            <p>You agree to use our services in accordance with all applicable laws and regulations. You shall not engage in any conduct that may disrupt the functionality of our services or compromise the security of our platform.</p>
            <br><br>
            <h3>6. Product Information</h3>
            <p>While we strive to provide accurate and up-to-date information, we do not warrant the accuracy, completeness, or reliability of any product information on our website or other platforms. Please consult with a healthcare professional for advice regarding medical conditions and treatments.</p>
            <br><br>
            <h3>7. Intellectual Property</h3>
            <p>All content, trademarks, logos, and other intellectual property on our platform are the property of Medwala or its licensors. You may not use, reproduce, or distribute any content without our express permission.</p>
            <br><br>
            <h3>8. Disclaimer of Warranties</h3>
            <p>Our services are provided "as is" and "as available" without any warranties, expressed or implied. We do not guarantee that our services will meet your requirements or be uninterrupted, secure, or error-free.</p>
            <br><br>
            <h3>9. Limitation of Liability</h3>
            <p>Medwala and its affiliates shall not be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of your use of, or inability to use, our services.</p>
            <br><br>
            
            <h3>10. Changes to Terms</h3>
            <p>We reserve the right to update or modify these Terms and Conditions at any time. The most current version will be posted on our website with the last updated date.</p>
            <br><br>
            <h3>Contact Us</h3>
            <p>If you have any questions or concerns about these Terms and Conditions, please contact us at contact@medwala.com.</p>
            <br><br>
            <p>Thank you for choosing Medwala!<p>
        </div>
    </div>
    
    

    <div class="container">
      <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
        <div class="col mb-3">
          <a href="https://medwala.in/">
            <img src="../assets/Mediwala logo.jpg" alt="" width="180" />
          </a>
          <p>Inhand Solutions Pvt Ltd</p>
        </div>
        <div class="col mb-3"></div>
        <div class="col mb-3">
          <h5>Company</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="https://medwala.in/about.php">About Us</a></li>
          </ul>
        </div>
        <div class="col mb-3">
        <!--  <h5>Contact Us</h5>-->
        <!--  <ul class="nav flex-column">-->
        <!--    <li class="nav-item mb-2">Need Support</li>-->
        <!--    <li class="nav-item mb-2">Partner with Us</li>-->
        <!--  </ul>-->
        </div>
        <div class="col mb-3">
          <h5>Legal</h5>
          <ul class="nav flex-column">
            <!--<li class="nav-item mb-2">FAQ</li>-->
            <li class="nav-item mb-2"><a href="https://medwala.in/terms.php">Terms & Conditions</a></li>
            <li class="nav-item mb-2"><a href="https://medwala.in/policy.php">Privacy Policy</a></li>
          </ul>
        </div>
      </footer>
    </div>
    
    <!--Signup-->
    
    <div class="modal" id="signupmodal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h4 class="modal-title">Signup</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div id="signupdivotp" style="display:none">
              <form action="javascript:void(0);">
                  <h3> OTP Verification</h3>
                  <p style="color:#b4b4b4;margin-bottom:15px;font-weight: 400;">We Have Sent an OTP To Your Registered Mobile Number</p>
                  <p style="color:red;margin-bottom:15px;display:none" id="signupmsg2">Sorry! Incorrect OTP !</p>
                  <p style="color:green;margin-bottom:15px;display:none" id="signupmsg3">You Have Successfully Signed Up ! Please Wait Redirecting in <span id="usersec"> </span> Seconds</p>
                  <input type="text" class="form-control"   placeholder="Enter OTP" name="signupotp"  id="signupotp" class="form-control"/>
                  <input type="hidden" id="sentotpsignup">
                  <p style="color:#b4b4b4;margin-bottom:15px;margin-top:15px;font-weight: 400;" id="timerh4">Resend OTP in <span id="counttimersignup"><span> Seconds</p>
                  <p  id="resendotpsignup" ><a href="#" onclick="signupmodal()">Haven't Received OTP? Resend OTP</a></p>
                  <div style="margin-top:15px">
                        <div class="spinner-border text-info" role="status" id="processingsignup2" style="display:none">
                           
                        </div>
                        <button type="submit"  onclick="signupnow()" id="otpvalidatesignup" class="btn  btn-success w-100" >Submit OTP</button>
                  </div>
              </form>
          </div>
          <div id="signupform">
              <p>You Are Just One Step Away From Signing Up</p>
              <p style="color:red;display:none" id="signupmsg">Sorry! Email Or Phone Is Already Registed With Us!</p>
               <form action="javascript:void(0);">
                      <div class="mb-2">
                        <input type="text" class="form-control"  placeholder="Name Of Owner" id="fullnamesignup" required/>
                      </div>
                      <div class="mb-2">
                        <input type="text" class="form-control"  placeholder="Email Of Owner" id="emailidsignup"  required/>
                      </div>
                     <div class="mb-2">
                        <input type="text" class="form-control"  placeholder="Phone Of Owner" id="phonesignup" required pattern="[6-9]{1}[0-9]{9}" title="Only 10 digits phone number allowed"/>
                      </div>
                      <div class="mb-2">
                        <input type="text" class="form-control"  placeholder="Shop Name" id="shopname" required/>
                      </div>
                     
                     <div class="mb-2">
                        <input type="text" class="form-control"  placeholder="Address" id="address" required/>
                      </div>
                      
                     <div class="mb-2">
                            <input type="hidden" id="sentotpsignup">
                      </div>
                      <div class="mb-2">
                        <div class="spinner-border text-info" role="status" id="signuploader" style="display:none">
                           
                        </div>
                        <button onclick="signupmodal()" class="btn  btn-success w-100" id="signupsubbtn">Continue</button>
                    
                  </form>
                  <div class="mb-2 text-center">
                    <p>Have An Account? <a href="https://medwala.in/app_medwala/v1/vendor/index.php"  >Log In</a></p>
              </div>
             
             
          </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <script>
        function signupmodal()
        {
            var name = $("#fullnamesignup").val();
            var email = $("#emailidsignup").val();
            var phone = $("#phonesignup").val();
            var shopname = $("#shopname").val();
            var address = $("#address").val();
           
            
            if(name == ''){
                alert('Cannot Be Empty!');
                return false;
            }
            if(email == ''){
                alert('Cannot Be Empty!');
                return false;
            }
            if(phone == ''){
                alert('Cannot Be Empty!');
                return false;
            }
            if(phone.length >= 11 || phone.length <= 9){
                alert('Only 10 Digit Phone Numbrs Are Allowed');
                return false;
            }
            if(shopname == ''){
                alert('Cannot Be Empty!');
                return false;
            } 
            if(address == ''){
                alert('Cannot Be Empty!');
                return false;
            }
             $("#signupsubbtn").hide();
             $("#signuploader").show();
            
              $.ajax({  
                url:"signup.php", 
                method:"POST",  
                data:{name:name,email:email,phone:phone,shopname:shopname,address:address},
                dataType:"text",
                cache: false,
                success:function(data)  
                {
                    $("#signuploader").hide();
                    $("#signupsubbtn").show();
                    if(data.trim() == 'existed')
                    { 
                        document.getElementById("signupform").style.display = "block";
                        document.getElementById("signupmsg").style.display = "block";
                        document.getElementById("signupdivotp").style.display = "none";
                        
                    }
                    
                    else{
                        $("#sentotpsignup").val(data);
                        document.getElementById("signupdivotp").style.display = "block";
                        document.getElementById("signupform").style.display = "none";
                        var count = 20;
                        $("#counttimersignup").text(count);
                        var myTimer = setInterval(function(){
                            if(count > 0)
                            {
                                count = count - 1;
                                $("#counttimersignup").text(count);
                            }
                            else 
                            {
                               clearInterval(myTimer);
                               document.getElementById("resendotpsignup").style.display = "block";
                            }
                        },1000);
                    } 
                }  
            })
        }
        
        
         function signupnow()
        {
            var name = $("#fullnamesignup").val();
            var email = $("#emailidsignup").val();
            var phone = $("#phonesignup").val();
            var shopname = $("#shopname").val();
            var address = $("#address").val();
            var enteredotp = $("#signupotp").val();
            var sentotp = $("#sentotpsignup").val();
            var password = $("#passsignup").val();
            $("#processingsignup2").show();
            $("#otpvalidatesignup").hide();
             $.ajax({  
                url:"signup.php", 
                method:"POST",  
                data:{name:name,email:email,phone:phone,shopname:shopname,address:address,enteredotp:enteredotp,sentotp:sentotp,password:password},
                dataType:"text",
                cache: false,
                success:function(data)  
                {
                    $("#processingsignup2").hide();
                    $("#otpvalidatesignup").show();
                    if(data.trim() == 'incorrect otp'){
                        document.getElementById("signupmsg2").style.display = "block";
                    }
                    
                    else if(data.trim() == 'Registered')
                    {
                        $('#signupmodal').hide();
                        swal("Good job!", "You Have Registered Sucessfully. Please Wait For Admin Approval!", "success")
                        .then((value) => {
                          location.reload();
                        });
                        
                    }
                    else{
                        alert('Something Went Wrong');
                    }
                    
                }  
            })
        }
    </script>
  </body>
</html>
