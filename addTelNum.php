<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
		$telnum=$_GET['telnum'];
		if(isset($telnum))
		{
			/*$fp = fopen('/uploads/telnum.txt', 'a');
			$telArray=file('/uploads/telnum.txt');
			if(count($telArray)==0)
			{
				fwrite($fp, $telnum);
				//PHP_alert("telArray == 0");
			}
			else
				fwrite($fp, "\n".$telnum);
			fclose($fp);*/
			$db = db_connect();
				
			if (mysqli_connect_errno()) {
				echo 'error';
			}
			$query = "INSERT INTO `temp` (`telnum`) VALUES ('".$telnum."');";
			//echo $query;
			$result = $db->query($query);
			if(!$result)
				echo 'xxx';
			$query = "select count(*) from temp;";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
				echo($row['count(*)']);
		}
				//JumpTo("TextMessage.php");
	}
	else 
	{
		echo '<script>alert("请登录")</script>';
		JumpTo("index.php");	
	}
?>