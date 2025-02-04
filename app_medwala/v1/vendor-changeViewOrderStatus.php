<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if(isset($_GET['confirmedorders'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND (status = 'paid' OR status = 'COD') ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions);
        	        
        	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['packedchangeStatus'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        date_default_timezone_set("Asia/Calcutta");
            		$date = date('Y-m-d');
            		$time = date("h:i:s");
            		$quoteid=$obj['quoteid'];
            		$table=QUOTATIONREQUEST;
            		$set_value="status=:status,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
            		$where_clause="WHERE quoteid=".$quoteid;
            		$execute=array(
            		':status'=>'packed',
            		':orderprocess'=>72,
                    ':status_background_color_for_app'=>'#FFF',
                    ':status_text_color_for_app'=>'#FFD700'
            		);
            		$update=update($table, $set_value, $where_clause, $execute);
            		
            		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='packed' ", array());
            		 $quoid= $find_track['quoteid']; 
                	 $table=TRACKING;
                	 $set_value="status=:status,date=:date,time=:time";
                	 $where_clause="WHERE quoteid='$quoid' AND command='packed' " ;
                	 $execute=array(  
                    
                	    ':status'=>'ok',
                	    ':date'=>$date,
                	    ':time'=>$time,
                	    );
                	    $update=update($table, $set_value, $where_clause, $execute);
        	        
            	        $array = array("response"=> "Success");
            	        
            	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['shipedchangeStatus'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        date_default_timezone_set("Asia/Calcutta");
            		$date = date('Y-m-d');
            		$time = date("h:i:s");
            		$quoteid=$obj['quoteid'];
            		$table=QUOTATIONREQUEST;
            		$set_value="status=:status,orderprocess=:orderprocess,deliveryotp=:deliveryotp,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
            		$where_clause="WHERE quoteid=".$quoteid;
            		$execute=array(  
            	
            		':status'=>'shipped',
            		':orderprocess'=>90,
            		':deliveryotp'=>random_int(100000, 999999),
                    ':status_background_color_for_app'=>'#FFF',
                    ':status_text_color_for_app'=>'#8FBC8F'
            		);
            		$update=update($table, $set_value, $where_clause, $execute);
            		
            		    $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='shipped' ", array());
            		 $quoid= $find_track['quoteid']; 
                	 $table=TRACKING;
                	 $set_value="status=:status,date=:date,time=:time";
                	 $where_clause="WHERE quoteid='$quoid' AND command='shipped' " ;
                	 $execute=array(  
                    
                	    ':status'=>'ok',
                	    ':date'=>$date,
                	    ':time'=>$time,
                	    );
                	    $update=update($table, $set_value, $where_clause, $execute);
        	        
            	        $array = array("response"=> "Success");
            	        
            	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['packedorders'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'packed' ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions);
        	        
        	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['shippedorders'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'shipped' ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions);
        	        
        	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['deliverystatuschange'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	            date_default_timezone_set("Asia/Calcutta");
                		$date = date("d-m-Y H:i:s");
                		$date1 = date("d-m-Y");
                		$time = date("h:i:s");
                		$quoteid=$obj['quoteid'];
                		$deliverotp=$obj['deliveryotp'];
        	            $find_order = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid = '".$quoteid."' AND deliveryotp='$deliverotp' ", array());
        	            if($find_order){
        	                
        	                $quoteid=$obj['quoteid'];
                    		$table=QUOTATIONREQUEST;
                    		$set_value="status=:status,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,deliverydate=:deliverydate";
                    		$where_clause="WHERE quoteid=".$quoteid;
                    		$execute=array(  
                    	    
                    		':status'=>'delivered',
                    		':orderprocess'=>100,
                            ':status_background_color_for_app'=>'#FFF',
                            ':status_text_color_for_app'=>'#056608',
                            ':deliverydate'=>$date,
                    		);
                    		$update=update($table, $set_value, $where_clause, $execute);
                    		
                    			 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='delivered' ", array());
                    		 $quoid= $find_track['quoteid']; 
                        	 $table=TRACKING;
                        	 $set_value="status=:status,date=:date,time=:time";
                        	 $where_clause="WHERE quoteid='$quoid' AND command='delivered' " ;
                        	 $execute=array(  
                            
                        	    ':status'=>'ok',
                        	    ':date'=>$date1,
                        	    ':time'=>$time,
                        	    );
                        	    $update1=update($table, $set_value, $where_clause, $execute);
                        	    
                        	    if($update && $update1)
                        		{
                        		    $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_order['shopid']."'  ", array()); 
                            	 $find_quote = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid = '$quoteid' AND status='delivered' ", array());  
                            	 if($find_quote['payid']!='COD')
                            	 {
                            		date_default_timezone_set("Asia/Calcutta");
                        			$date = date('Y-m-d');
                        			$time=date('h:i:s');
                        			$balance=$find_shop['wallet']+$find_quote['shopamount'];
                        			$table=WALLETTRANSACTION;
                        			$fields="amount,details,balance,shopid,date,time,type";
                        			$values=":amount,:details,:balance,:shopid,:date,:time,:type";
                        			$execute=array(
                        				':amount'=>$find_quote['shopamount'],
                        				':details'=>'credited for  quoteid - #'.$quoteid,
                        				':balance'=>$balance,
                        				':shopid'=>$find_quote['shopid'],
                        				':date'=>$date,
                        				':time'=>$time,
                        				':type'=>'credit',
                        				);
                        			
                        			$save_data = save($table, $fields, $values, $execute);
                        			$shopid=$find_quote['shopid'];
                        			$table=SHOP;
                                	$set_value="wallet=:wallet";
                                	$where_clause="WHERE id='$shopid' " ;
                                	$execute=array(  
                                    
                                	    ':wallet'=>$balance,
                                	    );
                                	$update2=update($table, $set_value, $where_clause, $execute);
                        			
                            	 }
                            	 else
                            	 {
                            	     date_default_timezone_set("Asia/Calcutta");
                        			$date = date('Y-m-d');
                        			$time=date('h:i:s');
                        			$balance=$find_shop['wallet']-$find_quote['shopamount'];
                        			$table=WALLETTRANSACTION;
                        			$fields="amount,details,balance,shopid,date,time,type";
                        			$values=":amount,:details,:balance,:shopid,:date,:time,:type";
                        			$execute=array(
                        				':amount'=>$find_quote['shopamount'],
                        				':details'=>'debited for  quoteid - #'.$quoteid,
                        				':balance'=>$balance,
                        				':shopid'=>$find_quote['shopid'],
                        				':date'=>$date,
                        				':time'=>$time,
                        				':type'=>'debit',
                        				);
                        			
                        			$save_data = save($table, $fields, $values, $execute);
                        			$shopid=$find_quote['shopid'];
                        			$table=SHOP;
                                	 $set_value="wallet=:wallet";
                                	 $where_clause="WHERE id='$shopid' " ;
                                	 $execute=array(  
                                    
                                	    ':wallet'=>$balance,
                                	    );
                                	    $update2=update($table, $set_value, $where_clause, $execute);
                            	 }
                        			
                        		}
                        		
        	                
        	                $array = array("response"=> "Success");
            	        
            	            echo json_encode($array);exit; 
        	            }
        	            else{
        	                echo json_encode('Incorrect Delivery OTP!');exit;   
        	            }
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['deliveredorders'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'delivered' ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions);
        	        
        	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['cancelledorders'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'cancel' ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions);
        	        
        	        echo json_encode($array);exit; 
        	    }
        	    else{
        	        echo json_encode('User is Not Valid!!');exit;   
        	    }    
        	}
        	else{
        	    echo json_encode('User is Not Valid!');exit;   
        	}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    
?>