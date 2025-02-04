<?php
/*
=========================================================================================================================
COPYRIGHT: NEOCODERZ TECHNOLOGIES
PRODUCT NAME: TRAVEL PORTAL
PAGE NAME: CONFIG.PHP
PAGE FUNCTIONALITY: CONSISTS OF FUNCTION TO CONNECT WITH DATABASE SERVER AND DATABASE.
=========================================================================================================================
*/

function Db_Connect()
{
	global $db;
	if(DATABASE_NAME=='')
	{
		return '';
	}
	else
	{
		//MAKE THIS OPEN IN SERVER END
		$db = new PDO("mysql:dbname=".DATABASE_NAME."; host=".DATABASE_SERVER."", DATABASE_USERNAME, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

		//MAKE THIS CLOSE IN SERVER END
		//$db = new PDO("mysql:dbname=".DATABASE_NAME."; host=".DATABASE_SERVER."", DATABASE_USERNAME, DATABASE_PASSWORD);
		return $db;
	}
}
?>