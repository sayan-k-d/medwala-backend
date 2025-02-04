<?php

	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    

    
    date_default_timezone_set("Asia/Calcutta");
	$date = date('Y-m-d');
	$time=date('h:i:s');
	
    if(isset($_GET['viewMedicines'])){
        
        if($obj['reqId'] == 'aduynad73yi7yffy82fu3m8ofbsg3ysgihgwi'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_subuser['shopid']."'", array());
        	        
        	        $orderdetails = find("first", QUOTATIONREQUEST, '*', "WHERE shopid = '".$find_subuser['shopid']."' AND quoteid = '".$obj['quoteid']."'", array());
        	        
        	        $medicineitems = find("all", QUOTEITEMS, '*', "WHERE quoteid = '".$obj['quoteid']."'", array());
        	        
        	        $array = array("response"=> "Success", "orderdetails"=> $orderdetails, "medicines"=> $medicineitems);
        	        
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
    else if(isset($_GET['addmedicine'])){
        
        if($obj['reqId'] == 'aduynad73yi7yff768y82fu3m8ofbsg3ysgihgwi'){
			
			$findmedname = find("first", MEDICINELIST, '*', "WHERE name = '".$obj['medname']."'", array());
			if($findmedname){
			    $medid = $findmedname['id'];
			}
			else{
			    $medid = '';
			}
			
        	$table=QUOTEITEMS;
			$fields="medid,medname,quoteid,qty,mrp,price,total,discount,date,time";
			$values=":medid,:medname,:quoteid,:qty,:mrp,:price,:total,:discount,:date,:time";
			$execute=array(
				':medid'=>$medid,
				':medname'=>$obj['medname'],
				':quoteid'=>$obj['quoteid'],
				':qty'=>$obj['qty'],
				':mrp'=>$obj['mrp'],
				':price'=>$obj['price'],
				':discount'=>$obj['discount'],
				':total'=>$obj['qty']*$obj['price'],
				':date'=>$date,
				':time'=>$time,
				);
			$save_data = save($table, $fields, $values, $execute);
			if($save_data){
			    
			    $find_items = find("all", QUOTEITEMS, '*', "WHERE quoteid = '".$obj['quoteid']."'", array());
			    
			    $array = array("response"=> "Success", "items"=> $find_items);
        	        
        	    echo json_encode($array);exit; 
			}
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['submitQuotation'])){
        
        if($obj['reqId'] == 'asiunxiq3ycrfiwy3fo3yfoof'){
			
			if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        $quoterequest = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid='".$obj['quoteid']."' ORDER BY id DESC", array());
        	        if($quoterequest){
        	            
        	            $table=QUOTATIONREQUEST;
                		$set_value="shopamount=:shopamount,delivery_hour_by_shop=:delivery_hour_by_shop,status=:status,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
                		$where_clause="WHERE id=".$quoterequest['id'];
                		$execute=array(
                		':shopamount'=>$obj['amount'],
                		':delivery_hour_by_shop'=>$obj['delivery_hour_by_shop'],
                		'status'=>'submitted',
                	    ':orderprocess'=>36,
                		':status_background_color_for_app'=>'#FFF',
                		':status_text_color_for_app'=>'#008000'
                		);
                		$update=update($table, $set_value, $where_clause, $execute);
                		date_default_timezone_set("Asia/Calcutta");
                        $date = date("Y-m-d");
                        $time = date("h:i:s");
                		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$obj['quoteid']."' AND command='submitted' ", array());
                		 $quoid= $find_track['quoteid']; 
                    	 $table=TRACKING;
                    	 $set_value="status=:status,date=:date,time=:time";
                    	 $where_clause="WHERE quoteid='$quoid' AND command='submitted' " ;
                    	 $execute=array(  
                        
                    	    ':status'=>'ok',
                    	    ':date'=>$date,
                    	    ':time'=>$time,
                    	    );
                    	    $update=update($table, $set_value, $where_clause, $execute);
                    	    if($update){
                    	        $array = array("response"=> "Success");
        	        
        	                    echo json_encode($array);exit; 
        	                    
                    	    }
                    	    else{
                    	        echo json_encode('Unable To Update order Status!!');exit;  
                    	    }
        	        }
            		else{
            		    echo json_encode('Something Went Wrong!!');exit;  
            		}
        	        
        	        $array = array("response"=> "Success", "orderdetails"=> $orderdetails, "medicines"=> $medicineitems);
        	        
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
    else if(isset($_GET['getAllMedicines'])){
        
        if($obj['reqId'] == 'asdjkmyx2ir3uno28ur89u4t9un290tu2v9tu'){
			
			$all_meds = find("all", MEDICINELIST, '*', "ORDER BY name ASC", array());
			
			$b = [];
            
            foreach ($all_meds as $key => $value) {
                $b[$key] = $value['name'];
            }
			
			$array = array("response"=> "Success", "meds"=> $b, "completemeds"=> $all_meds);
        	        
        	echo json_encode($array);exit; 
        	
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else if(isset($_GET['deleteMedicine'])){
        
        if($obj['reqId'] == 'askxnri73ymm83m2r8cnum380vtu4t39itm3'){
			
			$findthatmedicine = find("first", QUOTEITEMS, '*', "WHERE id = '".$obj['medid']."'", array());
			if($findthatmedicine){
			    $table=QUOTEITEMS;
        		$where_clause="WHERE id=".$findthatmedicine['id'];
        		$execute=array();
        		$delete = delete($table, $where_clause, $execute);
        		if($delete){
        		    
        		    $array = array("response"=> "Success");
        	        
        	        echo json_encode($array);exit; 
        		}
        		else{
        		    echo(json_encode('Unable To Process Request'));exit;
        		}
			}
			else{
        		    echo(json_encode('Unable To Process Request.'));exit;
            }
        }
        else{
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
?>