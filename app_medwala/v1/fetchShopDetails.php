<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    if($obj['reqId'] == 'as7ndyiq37yiqu38dm13dum2390uf0293fu0'){
             
    	if($obj['latitude'] != '' && $obj['longitude'] != ''){
    	   // echo(json_encode('Unable to Find Shop'));exit;
    	    if($obj['shopid'] != ''){
    	    
        	    if($obj['phone'] != ''){
        	         
        	        $table=RECENTVISIT;
        			$fields="shop,user";
        			$values=":shop,:user";
        			$execute=array(
        				':shop'=>$obj['shopid'],
        				':user'=>$obj['phone'],
        				);
        			$save_data = save($table, $fields, $values, $execute);
        	         
        	    }
        	    
        	    $find_the_shop = find("first", SHOP, '*', "WHERE id = '".$obj['shopid']."' ", array());
        	    if($find_the_shop){
        	        
        	        $find_gallery = find("all", GALLERY, '*', "WHERE shop_id = '".$find_the_shop['id']."' ", array());
        	        
        	        $b = [];
            
                    foreach ($find_gallery as $key => $value) {
                        $b[$key] = $value['name'];
                    }
        	        
        	        $array = array("response"=> "Success", "shopDetail"=> $find_the_shop, "galleryimages"=> $b , "user"=> $obj['phone']);
                
                    echo(json_encode($array));exit;
        	        
        	    }
        	    else{
                    echo(json_encode('Unable to Find Shop'));exit;
                }
        	
        	    
        	}
        	else{
                echo(json_encode('Invalid Shop ID'));exit;
            }
    	    
    	}
    	else{
            echo(json_encode('Invalid Location'));exit;
        }
    }
    else{
        echo(json_encode('Invalid Req Id'));exit;
    }
    
?>