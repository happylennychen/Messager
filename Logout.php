<?php
	require_once('functions.php');
	session_start();
	unset($_SESSION['valid_user']);
	session_destroy();
	unlink('/uploads/telnum.txt');
	$db = db_connect();
				
	if (mysqli_connect_errno()) {
		PHP_alert('error');
	}
	$query = "TRUNCATE  `temp`;";
		//PHP_alert($query);
	$result = $db->query($query);
	if(!$result)
		PHP_alert('xxx');
	JumpTo("index.php");
?>