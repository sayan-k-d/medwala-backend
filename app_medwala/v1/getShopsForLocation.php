<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    

    if(isset($_GET['alldata'])){
        
        if($obj['reqId'] == 'duhyqiumeq7e19mey729e9gdm7q2hex9h2m'){
             
        	if($obj['latitude'] != '' && $obj['longitude'] != ''){
        	    
        	   
        	    
        	    $find_admin = find("all", SHOP, '*, ( 6371 * ACOS( COS( RADIANS( '.$obj['latitude'].' ) ) * COS( RADIANS( lati ) ) * COS( RADIANS( longi ) - RADIANS( '.$obj['longitude'].' ) ) + SIN( RADIANS( '.$obj['latitude'].' ) ) * SIN( RADIANS( lati ) ) ) ) AS distance', "HAVING distance < 100 ORDER BY distance", array());
        	    
        	    $array = array("response"=> "Success", "allshops"=> $find_admin);
                
                echo(json_encode($array));exit;
        	
        	    
        	}
        	else{
                echo(json_encode('Invalid Location'));exit;
            }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else if(isset($_GET['recent'])){
        
        if($obj['reqId'] == 'sdasagfdbttyjbukyujytj'){
             
        	if($obj['phone'] != ''){
             
            	$find_admin = find("all", RECENTVISIT, '*', "WHERE user = '".$obj['phone']."' ORDER BY id DESC", array());
            	
            	if($find_admin){
            	   
            	   $b = [];
            
                    foreach ($find_admin as $key => $value) {
                        $b[$key] = $value['shop'];
                    }
            	}
            	
            	$shops_ids = implode(',', $b);
            	
            	$findshops = find("all", SHOP, '*', "WHERE id IN($shops_ids)", array());
            	
            	
        	    $array = array("response"=> "Success", "allshops"=> $findshops);
                
                echo(json_encode($array));exit;
            }
            else{
                echo(json_encode('Invalid User'));exit;
            }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else{
        if($obj['reqId'] == 'duhyqiumeq7e19mey729e9gdm7q2hex9h2m'){
        	if($obj['latitude'] != '' && $obj['longitude'] != ''){
        	    
        	    $find_admin = find("all", SHOP, '*, ( 6371 * ACOS( COS( RADIANS( '.$obj['latitude'].' ) ) * COS( RADIANS( lati ) ) * COS( RADIANS( longi ) - RADIANS( '.$obj['longitude'].' ) ) + SIN( RADIANS( '.$obj['latitude'].' ) ) * SIN( RADIANS( lati ) ) ) ) AS distance', "HAVING distance < deliverydistance*1 ORDER BY distance", array());
        	    
        	    $find_adminrating = find("all", SHOP, '*, ( 6371 * ACOS( COS( RADIANS( '.$obj['latitude'].' ) ) * COS( RADIANS( lati ) ) * COS( RADIANS( longi ) - RADIANS( '.$obj['longitude'].' ) ) + SIN( RADIANS( '.$obj['latitude'].' ) ) * SIN( RADIANS( lati ) ) ) ) AS distance', "HAVING distance < deliverydistance*1 ORDER BY rating*1 DESC", array());
        	    
        	    $array = array("response"=> "Success", "shops_fetched"=> $find_admin, "shops_fetched_rating"=> $find_adminrating);
                
                echo(json_encode($array));exit;
        	
        	    
        	}
        	else{
                echo(json_encode('Invalid Location'));exit;
            }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
?>