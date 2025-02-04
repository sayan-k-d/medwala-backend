<?php 
session_start();
	require_once('loader.inc');
	
	if(isset($_GET['venid'])){
	    
	    if(isset($_SESSION['loggedin']) && isset($_SESSION['adminname'])){
	        $_SESSION['loggedinvendor'] = TRUE;
    		$_SESSION['vendorphone'] = $_GET['vendorphone'];
    		$_SESSION['vendorid'] = $_GET['venid'];;
        
    		header('Location: admin-panel.php');
	    }else{
	        exit;
	    }
	    
	}
	
?>