<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if(isset($_GET['loginpagebanner'])){
        if($obj['reqId'] == 'ina7q7r37ifa379n3f023f8839280894cn24hgnrwrc9r23y238'){
    	
        	$find_admin = find("all", SLIDER, '*', "WHERE place = 'loginpagebanner' ORDER BY position*1 ASC", array());
        	
        	
            $b = [];
            
            foreach ($find_admin as $key => $value) {
                $b[$key] = $value['pic'];
            }
        
        	echo json_encode($b);exit;
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        } 
    }
    if(isset($_GET['partnerpagebanner'])){
        if($obj['reqId'] == 'mhgcr8yw49n8y89fmxh4kjfhskdhfjkhdsfk'){
    	
        	$find_admin = find("all", SLIDER, '*', "WHERE place = 'partnerpagebanner' ORDER BY position*1 ASC", array());
            $b = [];
            
            foreach ($find_admin as $key => $value) {
                $b[$key] = array( 
        			'key' => ''.$value['id'].'',
        			'title' => ''.$value['title'].'',
        			'text' => ''.$price['description'].'',
        			'image' => ''.$value['pic'].'',
        			);
            }
        
        	echo json_encode($b);exit;
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        } 
    }
    else{
        if($obj['reqId'] == 'ina7q7r37ifa379n3f023f8839280894cn24hgnrwrc9r23y238'){
        
    	
        	$find_admin = find("all", SLIDER, '*', "WHERE place = 'homepagebanner' ORDER BY position*1 ASC", array());
        	
        	
            $b = [];
            
            foreach ($find_admin as $key => $value) {
                $b[$key] = $value['pic'];
            }
        
        	echo json_encode($b);exit;
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        } 
    }
    
	
?>