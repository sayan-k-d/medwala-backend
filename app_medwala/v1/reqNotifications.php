<?php
	require_once('admin-login/loader.inc');                
                        
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if($obj['reqId'] == 'asunydfnuwnx7ffyu3ry7rmx8fwmq3098d30q9xrm8u'){
        
        if($obj['phone'] != ''){
            
                $find_notifications = find("all", NOTIFICATION, '*', " ORDER BY id DESC", array());
                
                echo(json_encode($find_notifications));exit;
            
        }
        else{
            
        }
    }else{
        echo(json_encode('Invalid Req ID'));exit;
    }
?>