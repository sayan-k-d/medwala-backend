<?php
session_start();
if(isset($_POST['pid']))
	{
		$id=$_POST['pid'];
		
		unset($_SESSION['medicine'][$id]);
		print_r($_SESSION['medicine']);
	} 
?>