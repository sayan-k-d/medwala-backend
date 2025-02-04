<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['vendorid'])) {
	header('Location: index.php');
	exit;
}


 if(isset($_POST['id']))
	{
	    
	    date_default_timezone_set("Asia/Calcutta");
		 $date = date("d-m-Y H:i:s");
		 $date1 = date("d-m-Y");
		 $time = date("h:i:s");
		 $quoteid=$_POST['id'];
		 $deliverotp=$_POST['deliveryotp'];
		 $find_deliverotp = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid = '".$quoteid."' AND deliveryotp='$deliverotp' ", array());
		 if($find_deliverotp)
		 {
    		$quoteid=$_POST['id'];
    		$table=QUOTATIONREQUEST;
    		$set_value="status=:status,orderprocess=:orderprocess,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app,deliverydate=:deliverydate";
    		$where_clause="WHERE quoteid=".$quoteid;
    		$execute=array(  
    	    
    		':status'=>'delivered',
    		':orderprocess'=>100,
            ':status_background_color_for_app'=>'#FFF',
            ':status_text_color_for_app'=>'#056608',
            ':deliverydate'=>$date,
    		);
    		$update=update($table, $set_value, $where_clause, $execute);
    		
    			 $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='delivered' ", array());
    		 $quoid= $find_track['quoteid']; 
        	 $table=TRACKING;
        	 $set_value="status=:status,date=:date,time=:time";
        	 $where_clause="WHERE quoteid='$quoid' AND command='delivered' " ;
        	 $execute=array(  
            
        	    ':status'=>'ok',
        	    ':date'=>$date1,
        	    ':time'=>$time,
        	    );
        	    $update1=update($table, $set_value, $where_clause, $execute);
        	 
    		if($update && $update1)
    		{
    		    $find_shop = find("first", SHOP, '*', "WHERE id = '".$find_deliverotp['shopid']."'  ", array()); 
        	 $find_quote = find("first", QUOTATIONREQUEST, '*', "WHERE quoteid = '$quoteid' AND status='delivered' ", array());  
        	 if($find_quote['payid']!='COD')
        	 {
        		date_default_timezone_set("Asia/Calcutta");
    			$date = date('Y-m-d');
    			$time=date('h:i:s');
    			$balance=$find_shop['wallet']+$find_quote['shopamount'];
    			$table=WALLETTRANSACTION;
    			$fields="amount,details,balance,shopid,date,time,type";
    			$values=":amount,:details,:balance,:shopid,:date,:time,:type";
    			$execute=array(
    				':amount'=>$find_quote['shopamount'],
    				':details'=>'credited for  quoteid - #'.$quoteid,
    				':balance'=>$balance,
    				':shopid'=>$find_quote['shopid'],
    				':date'=>$date,
    				':time'=>$time,
    				':type'=>'credit',
    				);
    			
    			$save_data = save($table, $fields, $values, $execute);
    			$shopid=$find_quote['shopid'];
    			$table=SHOP;
            	 $set_value="wallet=:wallet";
            	 $where_clause="WHERE id='$shopid' " ;
            	 $execute=array(  
                
            	    ':wallet'=>$balance,
            	    );
            	    $update2=update($table, $set_value, $where_clause, $execute);
    			
        	 }
        	 else
        	 {
        	     date_default_timezone_set("Asia/Calcutta");
    			$date = date('Y-m-d');
    			$time=date('h:i:s');
    			$balance=$find_shop['wallet']-$find_quote['shopamount'];
    			$table=WALLETTRANSACTION;
    			$fields="amount,details,balance,shopid,date,time,type";
    			$values=":amount,:details,:balance,:shopid,:date,:time,:type";
    			$execute=array(
    				':amount'=>$find_quote['shopamount'],
    				':details'=>'debited for  quoteid - #'.$quoteid,
    				':balance'=>$balance,
    				':shopid'=>$find_quote['shopid'],
    				':date'=>$date,
    				':time'=>$time,
    				':type'=>'debit',
    				);
    			
    			$save_data = save($table, $fields, $values, $execute);
    			$shopid=$find_quote['shopid'];
    			$table=SHOP;
            	 $set_value="wallet=:wallet";
            	 $where_clause="WHERE id='$shopid' " ;
            	 $execute=array(  
                
            	    ':wallet'=>$balance,
            	    );
            	    $update2=update($table, $set_value, $where_clause, $execute);
        	 }
    		echo("done");exit;	
    		}
    		else
    		{
    			echo("error occured");exit;
    		}
    		
	    }
	    else
	    {
            echo("not match");exit;
	    }
	}