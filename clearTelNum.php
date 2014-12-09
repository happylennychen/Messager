<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
			$db = db_connect();
				
			if (mysqli_connect_errno()) {
				PHP_alert('error');
			}
			$query = "TRUNCATE  `temp`;";
				//PHP_alert($query);
			$result = $db->query($query);
			if(!$result)
				PHP_alert('xxx');
			$query = "select count(*) from temp;";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			echo($row['count(*)']);
	}
	else 
	{
		echo '<script>alert("请登录")</script>';
		JumpTo("index.php");	
	}
?>