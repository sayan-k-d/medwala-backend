<?php
session_start();
	require_once('loader.inc');
	
    if(isset($_POST['query']))
	{
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
		$time = date('H:i:s');
		 $name=$_POST['query'];
		 
		 $artist = find("all", MEDICINELIST, '*', "WHERE name LIKE '%".$name."%' ORDER BY id DESC LIMIT 5", array());
		  
		
		if(!empty($artist))
		{
			 
			  foreach ($artist as $res) {
			 	echo('<li value="'.$res['name'].'">'.$res['name'].'</li>');
			  }
			 
     
		}
		
		else
		{
			echo('');
			exit();
		}
	}	


 ?>                      

