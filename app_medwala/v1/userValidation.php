<?php
	require_once('admin-login/loader.inc');
    
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    
    if(isset($_GET['signup'])){
        
        if($obj['reqId'] == 'cn249t7nty279t40qy7tm0cr2klqa894'){
        	
        	$find_user = find("first", USER, '*', "WHERE email = '".$obj['email']."'", array());
    	    if($find_user){
    	        echo(json_encode('emailexist'));exit;
    	    }
    	    else{
    	        
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=fzgqj1eFwQBpD6CvyKsE2RH5iduPL7IbA3ocSMXWhUGTtZa90xsxDEARj92qpTlJwheGCdOHINuoZ0Lc&sender_id=TXTIND&message=".urlencode('Your OTP For Sign Up is - '.$obj['phoneOTP'])."&route=v3&numbers=".urlencode($obj['user']),
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
                $decoderesponce = json_decode($response, TRUE);
                if($decoderesponce['return'] == 1){
                    $resp = "smssent";
                }
                else{
                    $resp = "wentwrong";
                }
                
                if($resp == 'smssent'){
                        echo(json_encode('otpsent'));exit;
                }
                else{
                    echo(json_encode('Unable To Send OTP To Phone Number! Please Try Again Later'));exit;
                }
    	    }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
        
    }
    else if(isset($_GET['UpdateUserInformation'])){
        
        if($obj['reqId'] == 'ajasdhn73yrxm389dy289dm3yx2389dyu2398yd239fu9m38dm8d'){
        	
        	$find_user = find("first", USER, '*', "WHERE email = '".$obj['oldEmail']."' AND phone = '".$obj['oldPhone']."'", array());
        	
    	    if($find_user){
    	        
    	        $find_existing_user = find("first", USER, '*', "WHERE id != '".$find_user['id']."'  AND (email = '".$obj['email']."' OR phone = '".$obj['phone']."') ", array());
    	        if($find_existing_user){
    	            echo(json_encode('Email / Phone Number Already Exist'));exit;
    	        }
    	        else{
    	            
    	            $table=USER;
        			$set_value="name=:name,email=:email,phone=:phone";
            		$where_clause="WHERE id=".$find_user['id'];
            		$execute=array(
                	  ':name'=>$obj['name'],
                      ':email'=>$obj['email'],
                      ':phone'=>$obj['phone'],
            		);
            		$update=update($table, $set_value, $where_clause, $execute);
    	            if($update){
            		    echo(json_encode('Success'));exit;
            		}
            		else{
            		    echo(json_encode('Unable To Update Information.Please Contact Support'));exit;
            		}
    	        }
    	    }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
        
    }
    else if(isset($_GET['handlephoneotpresend'])){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=fzgqj1eFwQBpD6CvyKsE2RH5iduPL7IbA3ocSMXWhUGTtZa90xsxDEARj92qpTlJwheGCdOHINuoZ0Lc&sender_id=TXTIND&message=".urlencode('Your New OTP is - '.$obj['phoneOTP'])."&route=v3&numbers=".urlencode($obj['user']),
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
        $decoderesponce = json_decode($response, TRUE);
        if($decoderesponce['return'] == 1){
            $resp = "smssent";
            echo(json_encode($resp));exit;
        }
        else{
            $resp = "wentwrong";
            echo(json_encode($resp));exit;
        }
    }
    else if(isset($_GET['submitnewuser'])){
        if($obj['reqId'] == 'ans8d789301f83290r7n32cy30kejfhlmsdfm8927'){
            if($obj['name'] != ''){
                
                if($obj['email'] != ''){
                    
                    if($obj['user'] != ''){
                            date_default_timezone_set("Asia/Calcutta");
                            $date = date("Y-m-d");
                            $time = date("h:i:s");
                            $table=USER;
                            $fields="name,email,phone,status,joindate,jointime";
                            $values=":name,:email,:phone,:status,:joindate,:jointime";
                            $execute=array(
                              ':name'=>$obj['name'],
                              ':email'=>$obj['email'],
                              ':phone'=>$obj['user'],
                              ':joindate'=>$date,
                              ':jointime'=>$time,
                              ':status'=>'active',
                              );
                            $save_data = save($table, $fields, $values, $execute);
                            if($save_data){
                                echo(json_encode('registeredsuccessfully'));exit;
                            }
                            else{
                                echo(json_encode('Something Went Wrong While Registering'));exit;
                            }
                    }else{
                        echo(json_encode('Phone Number Missing'));exit;
                    }
                    
                }else{
                    echo(json_encode('Email Missing'));exit;
                }
                
            }
            else{
                echo(json_encode('Name Missing'));exit;
            }
        }
        else{
        	echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else if(isset($_GET['updateFcmTokenSignin'])){
        if($obj['reqId'] == '7sa6bdn78q3r683x793mf8i3unf3niuf8'){
            if($obj['name'] != ''){
                
                if($obj['email'] != ''){
                    
                    if($obj['user'] != ''){
                        
                        $find_user = find("first", USERS, '*', "WHERE email = '".$obj['email']."' AND phone = '".$obj['user']."' ", array());
                        if($find_user){
                            $table=USERS;
                			$set_value="fcmtoken=:fcmtoken";
                    		$where_clause="WHERE id=".$find_user['id'];
                    		$execute=array(
                    		':fcmtoken'=>$obj['fcmtoken'],
                    		);
                    		$update=update($table, $set_value, $where_clause, $execute);
                            if($update){
                                echo(json_encode('Success'));exit;
                            }
                            else{
                                echo(json_encode('Something Went Wrong While Registering'));exit;
                            }
                        }
                        else{
                            echo(json_encode('Invalid User'));exit;
                        }
                    }else{
                        echo(json_encode('Phone Number Missing'));exit;
                    }
                    
                }else{
                    echo(json_encode('Email Missing'));exit;
                }
                
            }
            else{
                echo(json_encode('Name Missing'));exit;
            }
        }
        else{
        	echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else{
        $validateNumber = preg_match('/^[6-9]\d{9}$/', $obj['user']);
	
    	if($validateNumber == '1'){
    	    
    	    if($obj['reqId'] == 'asnd732dy2nhp9dmd8jd38dadnahd7w8dq7830'){
        	
            	$find_user = find("first", USER, '*', "WHERE phone = '".$obj['user']."'", array());
        	    if($find_user){
                    
                    $curl = curl_init();
        
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=fzgqj1eFwQBpD6CvyKsE2RH5iduPL7IbA3ocSMXWhUGTtZa90xsxDEARj92qpTlJwheGCdOHINuoZ0Lc&sender_id=TXTIND&message=".urlencode('Your OTP For Sign Up is - '.$obj['phoneOTP'])."&route=v3&numbers=".urlencode($find_user['phone']),
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
                    $decoderesponce = json_decode($response, TRUE);
                    if($decoderesponce['return'] == 1){
                        $resp = "smssent";
                    }
                    else{
                        $resp = "wentwrong";
                    }
                    
                    if($resp == 'smssent'){
                            $msg = array("otpsent", $find_user['name'], $find_user['phone'], $find_user['email']);
        	                echo(json_encode($msg));exit;
                    }
                    else{
                        echo(json_encode('Unable To Send OTP To Phone Number! Please Try Again Later'));exit;
                    }
        	    }
        	    else{
        	        $msg = array("unregistereduser", '');
        	        echo(json_encode($msg));exit;
        	    }
            }
            else{
                $msg = array("Invalid Req Id", '');
        	    echo(json_encode($msg));exit;
            }
    	}
    	else{
    	        $msg = array("invalidnumber", '');
        	    echo(json_encode($msg));exit;
    	}
    }
    
	
?>