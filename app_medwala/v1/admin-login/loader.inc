<?php
include_once('configurations/config.php');
include_once('configurations/dbconnection.php');
include_once('configurations/database_tables.php');
include_once('configurations/common_function.php');
include_once('configurations/modules.php');
$link = Db_Connect();
if(!$link)
{
	exit;
}

$page_name = current_page();

/*if($page_name == 'index.php' || $page_name == 'forgot_password.php')
{
	//DO NOTHING
}
else
{
	module_validation_check(@$_SESSION['SESSION_DATA']['id'], DOMAIN_NAME_PATH_ADMIN.'index.php');
}*/

?>