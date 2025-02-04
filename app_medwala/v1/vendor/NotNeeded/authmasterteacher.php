<?php 
session_start();
	require_once('loader.inc');
	
	if(isset($_GET['teacherid'])){
	    if(isset($_SESSION['loggedin']) && isset($_SESSION['adminname'])){
	        $_SESSION['teacherid'] = $_GET['teacherid'];
            $_SESSION['loggedinteacher'] = TRUE;
    		header('Location:'.DOMAIN_NAME_PATH.'teacher/admin-panel.php');
	    }else{
	        exit;
	    }
	    
	}
	
?>