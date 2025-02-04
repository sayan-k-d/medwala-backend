<?php
	//require_once('admin-login/loader.inc');
    
    // echo(json_encode('Invalid Coordinates'));exit;
     
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if(isset($obj['reqId']) == 'duhyqiumeq7e19mey729e9gdm7q2hex9h2m'){
        if($obj['latitude'] != '' && $obj['longitude'] != ''){
            
            $LocationData = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$obj['latitude'].','.$obj['longitude'].'&key=AIzaSyAFkLT1PNls0HcQ6eb2ARdlj5SvsVMyQqk');
    
            $convertfromjsonarray = json_decode($LocationData, true);
            
            $locationname = $convertfromjsonarray['results'][0]['address_components'][1]['long_name'];
            
            $location_address = substr($convertfromjsonarray['results'][0]['formatted_address'],0,40);
            //echo(json_encode('Invalid Req ID'));exit;
            
            $array = array("response"=> "Success", "location_name"=> $locationname, "location_address"=>$location_address);
            
            echo(json_encode($array));exit;
        }
        else{
            echo(json_encode('Invalid Coordinates'));exit;
        }
    }
    else{
        echo(json_encode('Invalid Req ID'));exit;
    }
?>