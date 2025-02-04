<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    

    if(isset($_GET['addNewAddress'])){
        
        if($obj['reqId'] == 'duhyqiumeq7e19mey729e9gdm7q2hex9h2m'){
             
        	if($obj['latitude'] != '' && $obj['longitude'] != ''){
        	    
        	    $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	    if($find_admin){
        	        if($obj['type'] == 'edit'){
        	            $findAddress = find("first", USERADDRESS, '*', "WHERE id = '".$obj['addressID']."'", array());
        	            if($findAddress){
            	            $table=USERADDRESS;
                			$set_value="name=:name,fulladdress=:fulladdress,pincode=:pincode,lati=:lati,longi=:longi,userid=:userid,phone=:phone";
                    		$where_clause="WHERE id=".$findAddress['id'];
                    		$execute=array(
                        	  ':name'=>$obj['addressName'],
                              ':fulladdress'=>$obj['fullAddress'],
                              ':pincode'=>$obj['pincode'],
                              ':lati'=>$obj['latitude'],
                              ':longi'=>$obj['longitude'],
                              ':userid'=>$find_admin['id'],
                              ':phone'=>$find_admin['phone'],
                    		);
                    		$update=update($table, $set_value, $where_clause, $execute);
                    		if($update){
                    		    $array = array("response"=> "Success");
                        
                                echo(json_encode($array));exit;
                    		}
                    		else{
                    		    echo(json_encode('Unable To Update Address'));exit;
                    		}
                    		
        	            }
        	            else{
        	                echo(json_encode('Unable To Find Address'));exit;
        	            }
        	        }
        	        else{
        	            $table=USERADDRESS;
                        $fields="name,fulladdress,pincode,lati,longi,userid,phone,deliverto,deliverymobile,buidingnumber";
                        $values=":name,:fulladdress,:pincode,:lati,:longi,:userid,:phone,:deliverto,:deliverymobile,:buidingnumber";
                        $execute=array(
                          ':name'=>$obj['addressName'],
                          ':fulladdress'=>$obj['fullAddress'],
                          ':pincode'=>$obj['pincode'],
                          ':lati'=>$obj['latitude'],
                          ':longi'=>$obj['longitude'],
                          ':userid'=>$find_admin['id'],
                          ':phone'=>$find_admin['phone'],
                          ':deliverto'=>$obj['deliverto'],
                          ':deliverymobile'=>$obj['deliverymobile'],
                          ':buidingnumber'=>$obj['buidingnumber'],
                          );
                        $save_data = save($table, $fields, $values, $execute);
                        if($save_data){
                            $array = array("response"=> "Success");
                        
                            echo(json_encode($array));exit;
                        }
                        else{
                        
                            echo(json_encode('Unable To Save Address'));exit;
                        }
        	        }
                    
        	    }
        	    else{
        	        echo(json_encode('Invalid User'));exit;
        	    }
        	    
        	}
        	else{
                echo(json_encode('Invalid Location'));exit;
            }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else if(isset($_GET['DeleteAddress'])){
        
        if($obj['reqId'] == 'x37nrx8d93783uk9wdiwu3doiuowu3d8uodu'){
             
        	$find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	    if($find_admin){
        	        
        	        $table=USERADDRESS;
                    $where_clause="WHERE id=".$obj['deleteItemid'];
                    $execute=array();
                    $delete = delete($table, $where_clause, $execute);
        	        if($delete){
            		    $array = array("response"=> "Success");
                
                        echo(json_encode($array));exit;
            		}
            		else{
            		    echo(json_encode('Unable To Update Address'));exit;
            		}
        	        
        	    }
        	    else{
        	        echo(json_encode('Invalid User'));exit;
        	    }
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else if(isset($_GET['withoutLatlng'])){
        if($obj['reqId'] == 'dduwenrx38ryc83rf823r8f9ur9w3ur32ru32r'){
        	  
        	  if($obj['phone'] != ''){
        	    
            	    $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
            	    
            	    $find_addresses = find("all", USERADDRESS, '*', "WHERE userid = '".$find_admin['id']."' ORDER BY id DESC", array());
            	    
            	    $array = array("response"=> "Success", "addresses"=> $find_addresses);
                    
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
        if($obj['reqId'] == 'dduwenrx38ryc83rf823r8f9ur9w3ur32ru32r'){
        	if($obj['latitude'] != '' && $obj['longitude'] != ''){
        	    
        	  if($obj['phone'] != ''){
        	    
            	    $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
            	    
            	    $find_addresses = find("all", USERADDRESS, '*, ( 6371 * ACOS( COS( RADIANS( '.$obj['latitude'].' ) ) * COS( RADIANS( lati ) ) * COS( RADIANS( longi ) - RADIANS( '.$obj['longitude'].' ) ) + SIN( RADIANS( '.$obj['latitude'].' ) ) * SIN( RADIANS( lati ) ) ) ) AS distance', "WHERE userid = '".$find_admin['id']."' HAVING distance <50 ORDER BY id DESC", array());
            	    
            	    $array = array("response"=> "Success", "addresses"=> $find_addresses);
                    
                    echo(json_encode($array));exit;
            	    
            	}
            	else{
                    echo(json_encode('Invalid User'));exit;
                }
        	    
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