<?php


require_once('admin-login/loader.inc');
	
    	
$json = file_get_contents('php://input');
$obj = json_decode($json, TRUE);

if($obj['reqId'] == 'saiduxn238ur28ru203xfu203fmu2mfx329f'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	       
        	       $find_quotes = find("first", QUOTEITEMS, '*', "WHERE quoteid = '".$obj['quoteid']."'", array());
        	        
        	        $array = array("response"=> "Success", "quotation"=> $find_quotes);
        	        
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
        
        
?>