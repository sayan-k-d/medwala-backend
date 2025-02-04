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
		 $date = date('Y-m-d');
		$quoteid=$_POST['id'];
		
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
                            
			echo("done");
		}
		else
		{
			echo("error occured");exit;
		}
		
	}