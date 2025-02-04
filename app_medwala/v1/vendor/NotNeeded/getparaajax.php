<?php
session_start();
	require_once('loader.inc');
	if (!isset($_SESSION['loggedinteacher'])) {
	header('Location: index.php');
	exit;
}
    if(isset($_POST['selectquestion'])){
        $find_question = find("first", QUESTION, '*', "WHERE id = '".$_POST['selectquestion']."'", array());
        echo($find_question['para']);exit;
    }
?>
