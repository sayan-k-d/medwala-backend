<?php 
session_start();
	 require_once('loader.inc');
	//require "PHPMailer/PHPMailerAutoload.php";
	
	    $phone = $_POST['phone'];
	
    	if(isset($_POST['phone'])){
    	    $six_digit_random_number = mt_rand(100000, 999999);
          $_SESSION['otp'] = password_hash($six_digit_random_number, PASSWORD_DEFAULT);
          $_SESSION['phone'] = $phone;
        		$curl = curl_init();
    
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=cxMyZsre0CkpNPtXWVw3Bd8FJI975h6YbnoQDR1GvzfiSOKEaHwNom4pRHF2PZ6YQkbacAGVI7hOxve1&sender_id=TXTIND&message=".urlencode('Your Login One Time Passcode Is - '.$six_digit_random_number)."&route=v3&numbers=".urlencode($phone),
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                  ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
                
                
                //print_r($six_digit_random_number);exit;
    	}

	
	
?>