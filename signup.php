<?php 
session_start();
require_once('app_medwala/v1/admin-login/loader.inc');
	 $name = $_POST['name'];
	 $email = $_POST['email'];
	 $phone = $_POST['phone']; 
	if(isset($_POST['enteredotp']))
    {

        $enteredotp = preg_replace('/\s+/', '', $_POST['enteredotp']);
        $sentotp = preg_replace('/\s+/', '', $_POST['sentotp']);
	    if(password_verify($enteredotp, $sentotp))
        {
	        
    		$table=APPLYVENDOR;
    		$fields="name,email,phone,shopname,address,status";
    		$values=":name,:email,:phone,:shopname,:address,:status";
    		$execute=array(
    			':name'=>$name,
    			':email'=>$_POST['email'],
    			':phone'=>$_POST['phone'],
    			':shopname'=>$_POST['shopname'],
    			':address'=>$_POST['address'],
    			':status'=>'pending'
    			);
    		$save_data = save($table, $fields, $values, $execute);
    		if($save_data)
    		{
    		    /*$user = find("first", USER, '*', "WHERE email = '$phone' OR phone = '$phone' ", array());
    	        $_SESSION['user']['email'] = $user['email'];
    	        $_SESSION['user']['phone'] = $user['phone'];
    	        $_SESSION['user']['name'] = $user['name'];
    	        $_SESSION['user']['id'] = $user['id'];
    	        setcookie('user', $user['id'], time() + (86400 * 30), "/");*/
    		    echo('Registered');
    		}
    		else{
    		   echo('Error!'); 
    		}
	    }
	    else{
	        echo('incorrect otp');
	    }
	}
	else{
	    $find_about = find("first", ABOUT, '*', "WHERE id = '1' ", array());
	    $user = find("first", APPLYVENDOR, '*', "WHERE email = '$email' OR phone = '$phone' ", array());
	    $shopuser = find("first", SHOP, '*', "WHERE email_of_owner = '$email' OR phone_of_owner = '$phone' ", array());
	    //$smsgateway='CZseRy3qiaWN4DF8UXwj5r9mOfv6P0pgY2zJMt1IhnAdlkVGcBSB2sqKPEgvj9dJomyRi7ZVIaFrbAYp';
	    
	   
    	if($user)
    	{
    		echo('existed');exit;
    	}
    	else if($shopuser)
    	{
    		echo('existed');exit;
    	}
    	else{
    	    
    	    $six_digit_random_number = mt_rand(100000, 999999);
    	    
    	    $curl = curl_init();

             curl_setopt_array($curl, array(
              CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=fzgqj1eFwQBpD6CvyKsE2RH5iduPL7IbA3ocSMXWhUGTtZa90xsxDEARj92qpTlJwheGCdOHINuoZ0Lc&sender_id=TXTIND&message=".urlencode('Your CHECKORO Login OTP is '.$six_digit_random_number)."&route=v3&numbers=".urlencode($phone),
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
            
            
            $hashed_password = password_hash($six_digit_random_number, PASSWORD_DEFAULT);
            print_r($hashed_password);exit;
    	}
	}
?>