<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
    	if($obj['userid'] != ''){
    	    
    	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
    	    if($find_subuser){
    	        
    	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
    	        
    	        $allTransactions = find("all", WALLETTRANSACTION, '*', "WHERE shopid = '".$find_subuser['shopid']."' ORDER BY id DESC", array());
    	        
    	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allTransactions"=> $allTransactions);
    	        
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
?>