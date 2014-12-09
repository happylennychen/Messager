<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
		$id=$_GET['id'];

		//PHP_alert("删除");
		@ $db = db_connect();

		if (mysqli_connect_errno()) {
			echo 'error';
		}

		$query = "delete from order_items where OrderID = '".$id."';";
		$result = $db->query($query);
		if(!$result)
			echo 'error';
		//如果结果多于一个，报错

		$query = "delete from orders where OrderID = '".$id."';";
		$result = $db->query($query);
		if(!$result)
			echo 'error';
		//如果结果多于一个，报错

		$db->close();
		echo '完成!';
	}
	else 
	{
		echo 'error';
	}
?>