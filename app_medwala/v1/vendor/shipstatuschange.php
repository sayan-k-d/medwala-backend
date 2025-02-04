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
		  $time = date("h:i:s");
		$quoteid=$_POST['id'];
		$table=QUOTATIONREQUEST;
		$set_value="status=:status,orderprocess=:orderprocess,deliveryotp=:deliveryotp,status_background_color_for_app=:status_background_color_for_app,status_text_color_for_app=:status_text_color_for_app";
		$where_clause="WHERE quoteid=".$quoteid;
		$execute=array(  
	
		':status'=>'shipped',
		':orderprocess'=>90,
		':deliveryotp'=>random_int(100000, 999999),
        ':status_background_color_for_app'=>'#FFF',
        ':status_text_color_for_app'=>'#8FBC8F'
		);
		$update=update($table, $set_value, $where_clause, $execute);
		
		    $find_track = find("first", TRACKING, '*', "WHERE quoteid = '".$quoteid."' AND command='shipped' ", array());
		 $quoid= $find_track['quoteid']; 
    	 $table=TRACKING;
    	 $set_value="status=:status,date=:date,time=:time";
    	 $where_clause="WHERE quoteid='$quoid' AND command='shipped' " ;
    	 $execute=array(  
        
    	    ':status'=>'ok',
    	    ':date'=>$date,
    	    ':time'=>$time,
    	    );
    	    $update=update($table, $set_value, $where_clause, $execute);
					//STOCK UPDATE END
		if($update)
		{
			echo("done");
		}
		else
		{
			echo("error occured");exit;
		}
		
	}