<?php
	require_once('functions.php');
	session_start();
	class SendInfo
	{
		public $account;
		public $available;
	}
	if(isset($_SESSION['valid_user']))
	{
		
		$db = db_connect();
		//$query = "select SentAmount from customers where Name='".$_SESSION['valid_user']."'";
		//$result = $db->query($query);
		//$row = $result->fetch_assoc();
		//$amount = stripslashes($row['SentAmount']);
		$query = "select Account from customers where Name='".$_SESSION['valid_user']."'";
		$result = $db->query($query);
		$db->close();
		$row = $result->fetch_assoc();
		$SendInfo->account = stripslashes($row['Account']);
		$SendInfo->available = $SendInfo->account * 10;
		echo json_encode($SendInfo);
	}
?>