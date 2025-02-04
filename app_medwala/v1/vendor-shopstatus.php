<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if(isset($_GET['update'])){
        
        if($obj['reqId'] == 'azkudymw33xifq73yf8oqyuxromfm3u3fu'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        if($find_shop){
        	            if($obj['val'] == 1){
        	                $val = 'true';
        	            }
        	            else{
        	                $val = 'false';
        	            }
        	            $table=SHOP;
                		$set_value="live=:live";
                		$where_clause="WHERE id=".$find_shop['id'];
                		$execute=array(
                    	  ':live'=>$val,
                		);
                		$update=update($table, $set_value, $where_clause, $execute);
                		
                		echo json_encode('done');exit; 
                		
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
                echo(json_encode('Invalid Req Id'));exit;
        } 
        
    }
    else{
     
        if($obj['reqId'] == 'asudxin7q3yirqyxr83oryq8zufo83q9prxufqdp9u'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        echo json_encode($find_shop['live']);exit; 
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
                echo(json_encode('Invalid Req Id'));exit;
        }    
        
    }
?>