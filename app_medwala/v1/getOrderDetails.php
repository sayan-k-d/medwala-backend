<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if($obj['reqId'] == 'asudyx3n7ynr82r982mufx2893u982'){
             
        if($obj['orderid'] != ''){
             
        	$find_order = find("first", QUOTATIONREQUEST, '*', "WHERE id = '".$obj['orderid']."'", array());
        	if($find_order){
        	 
        	    $quotation_images = find("all", QUOTEPHOTOS, '*', "WHERE quoteid = '".$find_order['quoteid']."'", array());
        	    
        	    $prescription_iamges = find("all", PRESCRIPTIONS, '*', "WHERE quoteid = '".$find_order['quoteid']."'", array());
        	   
        	    $find_tracking = find("all", TRACKING, '*', "WHERE quoteid = '".$find_order['quoteid']."'", array());
        	    
        	    $quioteItems = find("all", QUOTEITEMS, '*', "WHERE quoteid = '".$find_order['quoteid']."'", array());
        	    
        	    $array = array("response"=> "Success","quotation_images"=> $quotation_images,"prescription_images"=> $prescription_iamges,"tracking"=> $find_tracking,"quioteItems"=> $quioteItems);
                        
                echo(json_encode($array));exit;
        	    
        	}
        	
        }
        else{
            echo(json_encode('Invalid Order ID'));exit;
        }	
        	
    }
    else{
        echo(json_encode('Invalid Req Id'));exit;
    }
    
?>