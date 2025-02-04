<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if($obj['reqId'] == 'aduyq3n7yxry892nry28mru0r193mur01rxieaoulhfxngdsvfgs'){
         
        $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
	    if($find_admin){
	        
	        $find_all_orders = find("all", QUOTATIONREQUEST, '*', "WHERE userid = '".$find_admin['id']."' ORDER BY id DESC ", array());
	        
	        echo(json_encode($find_all_orders));exit;
            
	    }
	    else{
	        echo(json_encode('Invalid User'));exit;
	    }
    	
    }
    else{
        echo(json_encode('Invalid Req Id'));exit;
    }
?>