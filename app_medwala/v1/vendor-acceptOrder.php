<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if(isset($_GET['orderAccept'])){
        
        if($obj['reqId'] == 'aufmx83mfo2mfuxo23ufo3pfoio23ifp23fi2pip'){
    	
        	if($obj['userid'] != ''){
        	    
        	    $find_subuser = find("first", SUBACCOUNT, '*', "WHERE id = '".$obj['userid']."'", array());
        	    if($find_subuser){
        	        
        	        if($obj['quoteid'] != ''){ 
        	            
        	            date_default_timezone_set("Asia/Calcutta");
                        $date = date("Y-m-d");
                        $time = date("h:i:s");
                        
                        $datetime= date("d-m-Y H:i:s", strtotime($obj['date'])) . "\n";
                       
                		$quoteid=$obj['quoteid'];
                		 
                		$table=QUOTATIONREQUEST;
                		$set_value="status=:status,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,exp_del_datetime=:exp_del_datetime";
                		$where_clause="WHERE quoteid=".$quoteid;
                		$execute=array(  
                	
                		':status'=>'accepted',
                		':orderprocess'=>18,
                		':status_background_color_for_app'=>'#FFF',
                		':status_text_color_for_app'=>'#0000FF',
                		':exp_del_datetime'=>$datetime,
                		
                		);
                		$update=update($table, $set_value, $where_clause, $execute);
                		
                		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='accepted' ", array());
                		 $quoid= $find_track['quoteid']; 
                    	 $table=TRACKING;
                    	 $set_value="status=:status,date=:date,time=:time";
                    	 $where_clause="WHERE quoteid='$quoid' AND command='accepted' " ;
                    	 $execute=array(  
                        
                    	    ':status'=>'ok',
                    	    ':date'=>$date,
                    	    ':time'=>$time,
                    	    );
                    	    $update=update($table, $set_value, $where_clause, $execute);
                    	    if($update)
                    		{
                    			echo json_encode('Success');exit; 
                    	        exit;
                    		}
                    		else
                    		{
                    			echo json_encode("error occured");exit;
                    		}
        	            
        	        }
        	        else{
        	            echo json_encode('Invalid Order!');exit; 
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
                echo(json_encode('Invalid Reqq Id'));exit;
        } 
        
    }
    else{
        if($obj['reqId'] == 'asjkhfxn73rym8xf20yd3ual3qy8a3rlxq8m3hqfo3h'){
    	
        	if($obj['userid'] != ''){
        	    
        	    date_default_timezone_set("Asia/Calcutta");
        		$date = date('Y-m-d');
        		$quoteid=$obj['quoteid'];
        		
        		$table=QUOTATIONREQUEST;
        		$set_value="status=:status,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
        		$where_clause="WHERE quoteid=".$quoteid;
        		$execute=array(  
        	
        		':status'=>'cancel',
        		':status_background_color_for_app'=>'#FFF',
        		':status_text_color_for_app'=>'#FF0000'
        		);
        		$update=update($table, $set_value, $where_clause, $execute);
        		
        					//STOCK UPDATE END
        		if($update)
        		{
        		    
                            		 
                		  $finalqutationreqss = find("all", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command!='pending'  ", array());
                		  if($finalqutationreqss)
                		  {
                		      
            		            $table=TRACKING;
                        		$where_clause="WHERE quoteid = '".$quoteid."' AND command!='pending'  ";
                        		$execute=array();
                        		delete($table, $where_clause, $execute);
                		      
                		  }
                		date_default_timezone_set("Asia/Calcutta");
                        $date = date("Y-m-d");
                        $time = date("h:i:s");
                		$table=TRACKING;
                        $fields="quoteid,status,date,time,details,command";
                        $values=":quoteid,:status,:date,:time,:details,:command";
                        $execute=array(
                          ':quoteid'=>$quoteid,
                          ':details'=>'Order Cancelled By Shop',
                          ':command'=>'cancel',
                          ':status'=>'ok',
                          ':date'=>$date,
                          ':time'=>$time,
                          );
                        $save_data = save($table, $fields, $values, $execute);
                                    
        			    echo json_encode('Success');exit; 
        		}
        		else
        		{
        			echo json_encode('Error!');exit; 
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