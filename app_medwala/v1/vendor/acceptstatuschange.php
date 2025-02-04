<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['vendorid'])) {
	header('Location: index.php');
	exit;
}


 if(isset($_POST['submit']))
	{
	    date_default_timezone_set("Asia/Calcutta");
        $date = date("Y-m-d");
        $time = date("h:i:s");
       
		 $quoteid=$_POST['quoteid'];
		 
		// echo $_POST['datetimeval']; 
		 
		$datetime= date("d-m-Y H:i:s", strtotime($_POST['datetimeval'])) . "\n";
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
		
					//STOCK UPDATE END
		if($update)
		{
			//echo("done");
			header('Location: quotationrequest.php');
	        exit;
		}
		else
		{
			echo("error occured");exit;
		}
		
	}