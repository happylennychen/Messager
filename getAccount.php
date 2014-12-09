<?php
	require_once('functions.php');
	session_start();
	class AccountInfo
	{
		public $amount;
		public $account;
	}
	if(isset($_SESSION['valid_user']))
	{
			$db = db_connect();
			$query = "select SentAmount from customers where Name='".$_SESSION['valid_user']."'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$AccountInfo->amount = stripslashes($row['SentAmount']);
			$query = "select Account from customers where Name='".$_SESSION['valid_user']."'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$AccountInfo->account = stripslashes($row['Account'])*10;
			echo json_encode($AccountInfo);
	}
	else 
	{
		echo '请登录';
	}
?>