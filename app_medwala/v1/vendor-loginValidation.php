<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if($obj['reqId'] == 'askdhniqxr3yim2yx9qduzq3zdakxfagixyfgliuF#'){
    	
        	if($obj['username'] != ''){
        	    
        	    if($obj['password'] != ''){
        	        
        	        $find_username = find("first", SUBACCOUNT, '*', "WHERE username = '".$obj['username']."'", array());
        	        if($find_username){
        	           
        	           if($obj['password'] == $find_username['password']){
        	               
        	                 
        	               
        	               $array = array("response"=> "Success", "shopid"=> $find_username['shopid'], "userid"=> $find_username['id']);
                
                           echo(json_encode($array));exit;
        	               
        	           }
        	           else{
        	               echo json_encode('Invalid Password');exit;   
        	           }
        	               
        	        }
        	        else{
        	            echo json_encode('Invalid Username');exit;   
        	        }
        	        
            	}
            	else{
            	    echo json_encode('Password is Empty!');exit;   
            	}
        	       
        	}
        	else{
        	    echo json_encode('Username is Empty!');exit;   
        	}
    }
    else{
            echo(json_encode('Invalid Req Id'));exit;
    } 
    
	
?>