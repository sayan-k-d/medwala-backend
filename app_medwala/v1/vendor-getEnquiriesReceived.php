<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if(isset($_GET['pendingOngoing'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'pending' ORDER BY id DESC", array());
        	        
        	        $find_ongoing_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'accepted' ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "allUsers"=> $find_all_user, "allPrescriptions"=> $find_all_prescriptions, "find_ongoing_quotes"=> $find_ongoing_quotes);
        	        
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
    if(isset($_GET['getprescriptionsonly'])){
        
        if($obj['reqId'] == 'xanr3y9x8my29mmy30x9y2y'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_all_prescriptions = find("all", PRESCRIPTIONS, '*', "WHERE quoteid = '".$obj['quoteid']."' ", array());
        	        
        	        $array = array("response"=> "Success", "allPrescriptions"=> $find_all_prescriptions);
        	        
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
    else{
        if($obj['reqId'] == 'asjkhfxn73rym8xf20yd3ual3qy8a3rlxq8m3hqfo3h'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop);
        	        
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
                echo(json_encode('Invalid Reqs Id'));exit;
        }    
    }
?>