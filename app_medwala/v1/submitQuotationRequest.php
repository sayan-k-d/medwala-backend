<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    function get_domain($url)
    {
      $pieces = parse_url($url);
      $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
    }

    date_default_timezone_set("Asia/Calcutta");
    $date = date("Y-m-d");
    $time = date("h:i:s");
    
    if(isset($_GET['updatePaymentStatus'])){
        if($obj['reqId'] == 'adsdmqx3r323r237r83927rk8r3u8rka3onrhf'){
        	   $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	   if($find_admin){
        	       
        	        if($obj['type'] == 'cancel'){
        	            $table=QUOTATIONREQUEST;
            			$set_value="status=:status,cancelreason=:cancelreason,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,orderprocess=:orderprocess";
                		$where_clause="WHERE id=".$obj['itemid'];
                		$execute=array(
                    	  ':status'=>'cancel',
                    	  ':status_background_color_for_app'=>'#f2918a',
                          ':status_text_color_for_app'=>'#c20000',
                          ':orderprocess'=>'0',
                          ':cancelreason'=>$obj['reason'],
                		);
                		$update=update($table, $set_value, $where_clause, $execute);
                		if($update){
                		    
                		     $finalqutationreq = find("first", QUOTATIONREQUEST, '*', "WHERE id = '".$obj['itemid']."' ", array());
                    		 $qtid=$finalqutationreq['quoteid'];
                    		 
                    		  $finalqutationreqss = find("all", TRACKING, '*', "WHERE quoteid = '".$qtid."' AND command!='pending' AND command!='accepted' AND command!='submitted' ", array());
                    		  if($finalqutationreqss)
                    		  {
                    		      
                		            $table=TRACKING;
                            		$where_clause="WHERE quoteid = '".$qtid."' AND command!='pending' AND command!='accepted' AND command!='submitted' ";
                            		$execute=array();
                            		delete($table, $where_clause, $execute);
                    		      
                    		  }
                    		  
                    		  
                    		  
                    		$table=TRACKING;
                            $fields="quoteid,status,date,time,details,command";
                            $values=":quoteid,:status,:date,:time,:details,:command";
                            $execute=array(
                              ':quoteid'=>$qtid,
                              ':details'=>'Order Cancelled',
                              ':command'=>'cancel',
                              ':status'=>'ok',
                              ':date'=>$date,
                              ':time'=>$time,
                              );
                            $save_data = save($table, $fields, $values, $execute);
                            
                            
                            echo(json_encode('Success'));exit;
                             
                		}
                		else{
                		    echo(json_encode('Unable To Update'));exit;
                		}
        	        }
        	        else{
        	           if($obj['payid'] == 'COD'){
        	               
        	                $table=QUOTATIONREQUEST;
                			$set_value="payid=:payid,status=:status,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,orderprocess=:orderprocess";
                    		$where_clause="WHERE id=".$obj['itemid'];
                    		$execute=array(
                        	  ':payid'=>'COD',
                        	  ':status'=>'COD',
                        	  ':status_background_color_for_app'=>'#f2918a',
                              ':status_text_color_for_app'=>'#c20000',
                              ':orderprocess'=>'54',
                    		);
                		    $update=update($table, $set_value, $where_clause, $execute);
                	       if($update){
                	            
                    	         date_default_timezone_set("Asia/Calcutta");
                                 $date = date("Y-m-d");
                                 $time = date("h:i:s");
                                 $find_quotationrequest = find("first", QUOTATIONREQUEST, '*', "WHERE id = '".$obj['itemid']."'", array());
                        		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$find_quotationrequest['quoteid']."' AND command='paid' ", array());
                        		 $quoid= $find_track['quoteid']; 
                        		 
                            	 $table=TRACKING;
                            	 $set_value="details=:details,command=:command,status=:status,date=:date,time=:time";
                            	 $where_clause="WHERE id=".$find_track['id'];
                            	 $execute=array(
                            	    ':details'=>'Cash on Delivery Selected',
                            	    ':command'=>'COD',
                            	    ':status'=>'ok',
                            	    ':date'=>$date,
                            	    ':time'=>$time,
                            	    );
                            	 $update=update($table, $set_value, $where_clause, $execute);
                        		    
                                 
                                 echo(json_encode('Success'));exit;
                    		}
                    		else{
                    		    echo(json_encode('Unable To Update'));exit;
                    		}  
        	               
        	           }
        	           else{
        	                $table=QUOTATIONREQUEST;
                			$set_value="payid=:payid,status=:status,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,orderprocess=:orderprocess";
                    		$where_clause="WHERE id=".$obj['itemid'];
                    		$execute=array(
                        	  ':payid'=>$obj['payid'],
                        	  ':status'=>'paid',
                        	  ':status_background_color_for_app'=>'#f2918a',
                              ':status_text_color_for_app'=>'#c20000',
                              ':orderprocess'=>'54',
                    		);
                		    $update=update($table, $set_value, $where_clause, $execute);
                	       if($update){
                	           
                    	         date_default_timezone_set("Asia/Calcutta");
                                 $date = date("Y-m-d");
                                 $time = date("h:i:s");
                                 $find_quotationrequest = find("first", QUOTATIONREQUEST, '*', "WHERE id = '".$obj['itemid']."' AND status='paid' ", array());
                        		 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$find_quotationrequest['quoteid']."' AND command='paid' ", array());
                        		 $quoid= $find_track['quoteid']; 
                            	 $table=TRACKING;
                            	 $set_value="status=:status,date=:date,time=:time";
                            	 $where_clause="WHERE quoteid='$quoid' AND command='paid' " ;
                            	 $execute=array(
                            	    ':status'=>'ok',
                            	    ':date'=>$date,
                            	    ':time'=>$time,
                            	    );
                            	 $update=update($table, $set_value, $where_clause, $execute);
                        		    
                                 echo(json_encode('Success'));exit;
                                 
                    		}
                    		else{
                    		    echo(json_encode('Unable To Update'));exit;
                    		}       
        	           }
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
    else if(isset($_GET['getAllUserQuotationSubmitted'])){
        if($obj['reqId'] == 'd7q367qjz63j9q8d3k3dze108k239e8129e2ue9u2e'){
        	   $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	   if($find_admin){
        	       $find_quotations = find("all", QUOTATIONREQUEST, '*', "WHERE userid = '".$find_admin['id']."' AND status = 'submitted' ORDER BY id DESC", array());
        	       
        	       if($find_quotations){
        	           
                        $quiteids = '';
                        if($find_quotations){
                            foreach($find_quotations as $quotations){
                               if($quiteids == ''){
                                    $quiteids = $quotations['quoteid'];           
                               }
                               else{
                                   $quiteids = $quiteids.','.$quotations['quoteid']; 
                               }
                            }  
                        }
                        
                        $find_quote_items = find("all", QUOTEITEMS, '*', "WHERE quoteid IN($quiteids)", array());
        	           
        	           $array = array("response"=> "Success","userQuotations"=> $find_quotations,"quoteItems"=> $find_quote_items);
                        
                       echo(json_encode($array));exit;
        	       }
        	       else{
        	           echo(json_encode('nodata'));exit;
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
    else if(isset($_GET['SavePrescriptions'])){
        if($obj['reqId'] == '13ruy2inryi23nro3iyro23icrui23ru23r'){
        	    if($obj['prescriptionName'] != ''){
        	        
        	        if($obj['prescriptions'] != ''){
        	                
        	                $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	                
            	            $quoteid = time().rand(pow(10, 3-1), pow(10, 3)-1);
        	                date_default_timezone_set("Asia/Calcutta");
                            $date = date("Y-m-d");
                            $time = date("h:i:s");
        	                $table=SAVEDPRESCRIPTIONS;
                            $fields="name,userid,date,time,quoteid";
                            $values=":name,:userid,:date,:time,:quoteid";
                            $execute=array(
                              ':name'=>$obj['prescriptionName'],
                              ':userid'=>$find_admin['id'],
                              ':quoteid'=>$quoteid,
                              ':date'=>$date,
                              ':time'=>$time,
                              );
                            $save_data = save($table, $fields, $values, $execute);
        	                if($save_data){
        	                    
        	                    foreach($obj['prescriptions'] as $prescriptions){
        	                        
        	                        if(get_domain($prescriptions['URI']) == 'medwala.in' && $prescriptions['base64'] == ''){
                                        
                                        $table=PRESCRIPTIONS;
                                        $fields="quoteid,image,date,time,type";
                                        $values=":quoteid,:image,:date,:time,:type";
                                        $execute=array(
                                          ':quoteid'=>$quoteid,
                                          ':image'=>$prescriptions['URI'],
                                          ':date'=>$date,
                                          ':time'=>$time,
                                          ':type'=>'Saved',
                                          );
                                        $save_data = save($table, $fields, $values, $execute);
                                        
        	                        }
        	                        else{
        	                            
        	                            $filename_path = $find_admin['phone']."_saved_prescriptions_".$quoteid."_".uniqid().".jpg"; 
            
                                        $decoded=base64_decode($prescriptions['base64']); 
                                        
                                        file_put_contents("saved_prescriptions/".$filename_path,$decoded);
                                        
                                        $table=PRESCRIPTIONS;
                                        $fields="quoteid,image,date,time,type";
                                        $values=":quoteid,:image,:date,:time,:type";
                                        $execute=array(
                                          ':quoteid'=>$quoteid,
                                          ':image'=>'https://https://medwala.optimumpointbiz.com//app_medwala/v1/saved_prescriptions/'.$filename_path,
                                          ':date'=>$date,
                                          ':time'=>$time,
                                          ':type'=>'Saved',
                                          );
                                        $save_data = save($table, $fields, $values, $execute);
                                        
        	                        }
        	                        
        	                    }
        	                    
        	                    echo(json_encode('Success'));exit;
        	                    
        	                }
        	                else{
        	                    echo(json_encode('Invalid Saving'));exit;
        	                }
            	    }
            	    else{
            	        echo(json_encode('Invalid Prescriptions'));exit;
            	    }
        	        
        	    }
        	    else{
        	        echo(json_encode('Invalid Prescription Name'));exit;
        	    }
        	   
        }
        else{
            echo(json_encode('Invalid Req Id'));exit;
        }
    }
    else{
        if($obj['reqId'] == 'duhyqiumeq7e19mey729e9gdm7q2hex9h2m'){
             
        	if($obj['latitude'] != '' && $obj['longitude'] != ''){
        	    
        	    $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
        	    if($find_admin){
        	        
        	        if($obj['shopID'] != ''){
        	    
                	   if($obj['prescriptions'] != ''){
            	    
                    	   if($obj['selectedAddress'] != ''){
                    	       
                	                //echo(json_encode('asdasdsdad'));exit;
                	                $find_shop = find("first", SHOP, '*', "WHERE id = '".$obj['shopID']."' ", array());
                	                $quoteid = time().rand(pow(10, 3-1), pow(10, 3)-1);
                	                date_default_timezone_set("Asia/Calcutta");
                                    $date = date("Y-m-d");
                                    $time = date("h:i:s");
                                    
                                    $userdetails = find("first", USERADDRESS, '*', "WHERE id = '".$obj['selectedAddress']."' ", array());
                                    
                	                $table=QUOTATIONREQUEST;
                                    $fields="name,userid,shopid,shopname,addressid,quoteid,status,date,time,status_background_color_for_app,status_text_color_for_app,orderprocess,lati,longi,fulladdress,pincode,phone";
                                    $values=":name,:userid,:shopid,:shopname,:addressid,:quoteid,:status,:date,:time,:status_background_color_for_app,:status_text_color_for_app,:orderprocess,:lati,:longi,:fulladdress,:pincode,:phone";
                                    $execute=array(
                                      ':name'=>'',
                                      ':userid'=>$find_admin['id'],
                                      ':shopid'=>$obj['shopID'],
                                      ':shopname'=>$find_shop['name'],
                                      ':addressid'=>$obj['selectedAddress'],
                                      ':quoteid'=>$quoteid,
                                      ':status'=>'pending',
                                      ':status_background_color_for_app'=>'#f2918a',
                                      ':status_text_color_for_app'=>'#000000',
                                      ':orderprocess'=>'0',
                                      ':date'=>$date,
                                      ':time'=>$time,
                                      ':lati'=>$userdetails['lati'],
                                      ':longi'=>$userdetails['longi'],
                                      ':fulladdress'=>$userdetails['fulladdress'],
                                      ':pincode'=>$userdetails['pincode'],
                                      ':phone'=>$userdetails['phone'],
                                      );
                                    $save_data = save($table, $fields, $values, $execute);
                	                if($save_data)
                	                {
                        	                  $a=array('Quotation Requested','Order Accepted','Pending Payment','Paid Successfully','Order Packed','Order Out For Delivery','Delivered'); 
                        	                  $b=array('pending','accepted','submitted','paid','packed','shipped','delivered');
                        	                  if(is_array($a))
                        	                  {
                                                foreach ($a as $x =>$row)
                                                {
                                                    
                                                    if($b[$x]=='pending')
                                                    {
                                                        date_default_timezone_set("Asia/Calcutta");
                                                        $date = date("Y-m-d");
                                                        $time = date("h:i:s");
                                                        $status='ok';
                                                    }
                                                    else
                                                    {
                                                        $date = '';
                                                        $time = '';
                                                        $status='';
                                                    }
                                                    
                                	                $table=TRACKING;
                                                    $fields="quoteid,status,date,time,details,command";
                                                    $values=":quoteid,:status,:date,:time,:details,:command";
                                                    $execute=array(
                                                      
                                                      ':quoteid'=>$quoteid,
                                                      ':details'=>$row,
                                                      ':command'=>$b[$x],
                                                      ':status'=>$status,
                                                      ':date'=>$date,
                                                      ':time'=>$time,
                                                      );
                                                    $save_data = save($table, $fields, $values, $execute);
                                                    
                                                }
                                            }
                	                     
                	                    foreach($obj['prescriptions'] as $prescriptions){
                	                        
                	                        date_default_timezone_set("Asia/Calcutta");
                                            $date = date("Y-m-d");
                                            $time = date("h:i:s");
                	                        
                	                        if(get_domain($prescriptions['URI']) == 'medwala.in' && $prescriptions['base64'] == ''){
                                                
                                                $table=PRESCRIPTIONS;
                                                $fields="quoteid,image,date,time";
                                                $values=":quoteid,:image,:date,:time";
                                                $execute=array(
                                                  ':quoteid'=>$quoteid,
                                                  ':image'=>$prescriptions['URI'],
                                                  ':date'=>$date,
                                                  ':time'=>$time,
                                                  );
                                                $save_data = save($table, $fields, $values, $execute);
                                                
                	                        }
                	                        else{
                	                            $filename_path = $find_admin['phone']."_prescription_".$quoteid."_".uniqid().".jpg"; 
                    
                                                $decoded=base64_decode($prescriptions['base64']); 
                                                
                                                file_put_contents("quote_prescriptions/".$filename_path,$decoded);
                                                
                                                $table=PRESCRIPTIONS;
                                                $fields="quoteid,image,date,time";
                                                $values=":quoteid,:image,:date,:time";
                                                $execute=array(
                                                  ':quoteid'=>$quoteid,
                                                  ':image'=>'https://medwala.in/app_medwala/v1/quote_prescriptions/'.$filename_path,
                                                  ':date'=>$date,
                                                  ':time'=>$time,
                                                  );
                                                $save_data = save($table, $fields, $values, $execute);
                                                
                	                        }
                	                        
                	                        
                	                    }
                	                    
                	                    echo(json_encode('Success'));exit;
                	                    
                	                }
                	                else{
                	                    echo(json_encode('Invalid Saving'));exit;
                	                }
                        	   
                        	}
                        	else{
                                echo(json_encode('Invalid Selected Address'));exit;
                            }
                    	   
                    	}
                    	else{
                            echo(json_encode('Invalid Prescriptions'));exit;
                        }
                	   
                	}
                	else{
                        echo(json_encode('Invalid Shop'));exit;
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
?>