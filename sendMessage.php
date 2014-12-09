<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
		//PHP_alert('start');
		$message = $_GET['message'];
		if(isset($message) && !empty($message))
		{
			$db = db_connect();
			
			if (mysqli_connect_errno()) {
				echo 'error';
			}
			
			$query = "select count(*) from temp;";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$cnt = $row['count(*)'];
			//echo $cnt;
			//获取当前系统时间
			//echo(date('Y-m-d H:i:s'));
			$datetime = date('Y-m-d H:i:s');
			//填写数据到Orders表
			$query = "insert into orders (CustomerName, Message, DateTime) values ('".$_SESSION['valid_user']."' , '".$message."', '".$datetime."');";
			$result = $db->query($query);
			if(!$result)
				echo 'error';
			//查询当前的orderID
			$query = "select OrderID from orders where DateTime = '".$datetime."';";
			$result = $db->query($query);
			//如果结果多于一个，报错
			$row = $result->fetch_assoc();
			$orderid = stripslashes($row['OrderID']);
			//填写order_items表格
			$query = "insert into order_items (OrderID, TelNum, Status) select '".$orderid."', telnum, 1 from `temp`;";
			$db->query($query);
			//填写数据到Customers表
			//填写Account
			$query = "select Account from customers where Name='".$_SESSION['valid_user']."'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$account = stripslashes($row['Account']);
			$account -= $cnt*0.1;
			$query = "update customers set Account = '".$account."' where Name='".$_SESSION['valid_user']."'";
			$db->query($query);
			
			//填写SentAmount
			$query = "select SentAmount from customers where Name='".$_SESSION['valid_user']."'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$amount = stripslashes($row['SentAmount']);
			$amount += $cnt;
			$query = "update customers set SentAmount = '".$amount."' where Name='".$_SESSION['valid_user']."'";
			$db->query($query);
			$db->close();/**/
			
			echo '完成!';
		}
		else 
		{
			echo 'error';
		}
	}
	else 
	{
		echo '<script>alert("请登录")</script>';
	}
?>