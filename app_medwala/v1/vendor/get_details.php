<?php
session_start();
	require_once('loader.inc');
	
    if(isset($_POST['value']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$time = date('H:i:s');
		 $name=$_POST['value'];
		 
		 $artist = find("all", MEDICINELIST, '*', "WHERE name LIKE '".$name."%' ", array());
		
		if(!empty($artist))
		{
			 foreach ($artist as $res){
			 	 $json_response[] = $res;
			 }
			
        echo json_encode($json_response);
		}
		else
		{
			echo "
      <div class='alert alert-danger mt-3 text-center' role='alert'>
          Medicine not found
      </div>
      ";
			exit;
		}
	}	


 ?>                      

