<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if(isset($_GET['allquote'])){
        
        if($obj['reqId'] == 'asdkasumy8x3yr8omq3fo93ux2r932uf94'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $find_quotes = find("all", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND rating != '' AND rating IS NOT NULL ORDER BY id DESC", array());
        	        
        	        $find_all_user = find("all", USER, '*', "", array());
        	        
        	        $array = array("response"=> "Success", "shopdetails"=> $find_shop, "allquote"=> $find_quotes, "alluser"=> $find_all_user);
        	        
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