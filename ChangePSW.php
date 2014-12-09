<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
		$origpsw=$_REQUEST['origpsw'];
		$newpsw=$_REQUEST['newpsw'];
		$db = db_connect();

		if (mysqli_connect_errno()) {
			echo 'error1';
		}
		
		$query = "select * from customers where Name = '".$_SESSION['valid_user']."' and Password = sha1('".$origpsw."')";
		$result = $db->query($query);
		if(!$result)
			echo 'error2';
		
		if($result->num_rows<=0)
			echo '原密码错误，请重试！';
		else 
		{
			$query="update customers set Password = sha1('".$newpsw."') where Name='".$_SESSION['valid_user']."'";
			$db->query($query);
				echo '完成！';
		}
		
		$result->free();
		$db->close();
	}
	else 
	{
		echo 'error4';
	}
?>