<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if($obj['reqId'] == 'asudxin7q3yirqyxr83oryq8zufo83q9prxufqdp9u'){
    	
    	if($obj['userid'] != ''){
    	    
    	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
    	    if($find_subuser){
    	        
    	        
    	        //$find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'pending' ORDER BY id DESC", array());
    	        
    	        $find_accepted = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'accepted' ORDER BY id DESC", array());
    	        
    	        $enq_received = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'pending' ORDER BY id DESC", array());
    	        
    	        $quotation_sent = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'submitted' ORDER BY id DESC", array());
    	        
    	        $confirmed_orders = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND (status = 'paid' OR status = 'COD') ORDER BY id DESC", array());
    	        
    	        $packed_orders  = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'packed' ORDER BY id DESC", array());
    	        
    	        $shipped_orders  = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'shipped' ORDER BY id DESC", array());
    	        
    	        $delivered_orders = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'delivered' ORDER BY id DESC", array());
    	        
    	        $cancelled_orders = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND status = 'cancel' ORDER BY id DESC", array());
    	        
    	        $array = array("response"=> "Success", "enq_received"=> count($enq_received), "quotation_sent"=> count($quotation_sent), "confirmed_orders"=> count($confirmed_orders), "packed_orders"=> count($packed_orders), "shipped_orders"=> count($shipped_orders), "delivered_orders"=> count($delivered_orders), "cancelled_orders"=> count($cancelled_orders), "find_accepted"=> count($find_accepted));
    	        
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