<?php
	require_once('admin-login/loader.inc');
	
    	
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);
    
    
    if($obj['reqId'] == 'x2m48cgfuy348mfu38xfu34xflx4wlcfjs4ijf4v'){
        
        if($obj['ratingOrderid'] != ''){
            
            if($obj['ratingGiven'] != ''){
                
                if($obj['phone'] != ''){
                       
                       $find_admin = find("first", USER, '*', "WHERE phone = '".$obj['phone']."' ", array());
                	   if($find_admin){
                	       
                	        $find_quotationrequest = find("first", QUOTATIONREQUEST, '*', "WHERE id = '".$obj['ratingOrderid']."'", array());
                	           
                	           if($find_quotationrequest){
                	                 
                        	         $table=QUOTATIONREQUEST;
                                	 $set_value="rating=:rating";
                                	 $where_clause="WHERE id=".$find_quotationrequest['id'] ;
                                	 $execute=array(
                                	    ':rating'=>$obj['ratingGiven'],
                                	    );
                                	 $update=update($table, $set_value, $where_clause, $execute);
                                	 if($update){
                                	     
                                	     $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_quotationrequest['shopid']."'", array());
                                	     if($find_shop){
                                	         
                                	         $table=SHOP;
                                        	 $set_value="totalrating=:totalrating,ratingcount=:ratingcount";
                                        	 $where_clause="WHERE id=".$find_shop['id'] ;
                                        	 $execute=array(
                                        	    ':totalrating'=>$find_shop['totalrating'] + $obj['ratingGiven'],
                                        	    ':ratingcount'=>$find_shop['ratingcount'] + 1,
                                        	    );
                                        	 $update=update($table, $set_value, $where_clause, $execute);
                                        	 if($update){
                                        	     
                                    	         $find_shop_again = find("first", SHOP, '*', "WHERE id = '".$find_quotationrequest['shopid']."'", array());
                                    	         $table=SHOP;
                                            	 $set_value="rating=:rating";
                                            	 $where_clause="WHERE id=".$find_shop_again['id'] ;
                                            	 $execute=array(
                                            	    ':rating'=>$find_shop_again['totalrating'] / $find_shop_again['ratingcount'],
                                            	    );
                                            	 $update=update($table, $set_value, $where_clause, $execute);
                                            	 
                                        	     echo(json_encode('Success'));exit;
                                        	     
                                        	 }
                                        	 else{
                                        	     echo(json_encode('Invalid Update Shop Rating'));exit;
                                        	 }
                                        	 
                                	     }
                                	     else{
                                	         echo(json_encode('Shop Not Found'));exit;
                                	     }
                                	     
                                	 }
                                	 else{
                                	     echo(json_encode('Invalid Update'));exit;
                                	 }
                        	        
                        	   }
                        	   else{
                        	       echo(json_encode('Invalid Order'));exit;
                        	   }
                	        
                	   }
                	   else{
                	       echo(json_encode('Invalid User'));exit;
                	   }
                }
                else{
                    echo(json_encode('Invalid User'));exit;
                }
                
            }
            else{
                echo(json_encode('Invalid Rating'));exit;
            }
            
        }
        else{
            echo(json_encode('Invalid Order Id'));exit;
        }
        
    }
    else{
        echo(json_encode('Invalid Req Id'));exit;
    }

?>