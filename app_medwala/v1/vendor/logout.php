<?php
session_start();
session_destroy();
// Redirect to the login page:
setcookie('kitchen', null, -1, '/'); 
header('Location: index.php');exit;
?>