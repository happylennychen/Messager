<?php
	require_once('functions.php');
	session_start();
	class RecordInfo
	{
		public $msg;
		public $time;
	}
	if(isset($_SESSION['valid_user']))
	{
		$id=$_GET['id'];

		@ $db = db_connect();

		if (mysqli_connect_errno()) {
			echo 'error1';
		}
		$query = "select Message from orders where OrderID = '".$id."';";
		$result = $db->query($query);
		if(!$result)
			echo 'error2';
		$row = $result->fetch_assoc();
		$RecordInfo->msg = stripslashes($row['Message']);


		$query = "select DateTime from orders where OrderID = '".$id."';";
		$result = $db->query($query);
		if(!$result)
			echo 'error3';
		$db->close();
		$row = $result->fetch_assoc();
		$RecordInfo->time = stripslashes($row['DateTime']);

		echo json_encode($RecordInfo);
	}
?>