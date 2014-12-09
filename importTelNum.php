<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{//echo("1");
		$button1 = $_POST['button1'];
		//if($button1 == "导入")
		{//echo("2");
			if($_FILES['FileName']['error']>0)
			{
				echo 'Problem:';
				switch ($_FILES['FileName']['error'])
				{
					case 1: echo 'File exceeded upload_max_filesize';break;
					case 2: echo 'File exceeded max_file_size';break;
					case 3: echo 'File only partially uploaded';break;
					case 4: echo 'No file uploaded';break;
					case 6: echo 'No temp directory specified';break;
					case 7: echo 'Cannot write to disk';break;
				}
				exit;
			}
			if(is_uploaded_file($_FILES['FileName']['tmp_name']))
			{//echo("3");
				if(move_uploaded_file($_FILES['FileName']['tmp_name'], '/uploads/telnum.txt'))
				{//echo("4");
					//echo("move success");
					//"/uploads/telnum.txt"
					//JumpTo("TextMessage.php");
				}
				else
				{
					echo("cannot move your file!");
				}
				//load data infile "/upload/telnum.txt" into table `temp`
				$db = db_connect();
				
				if (mysqli_connect_errno()) {
					echo('error');
				}
				$query = "TRUNCATE  `temp`;";
					//echo($query);
				$result = $db->query($query);
				if(!$result)
					echo('error1');
				//else
					//echo('OK');
					//LOAD DATA LOCAL INFILE  'D:/uploads/telnum.txt' INTO TABLE  `fithkyo`.`temp`
				$query = "LOAD DATA LOCAL INFILE  'E:/uploads/telnum.txt' INTO TABLE  `fithkyo`.`temp`;";
					//echo($query);
				$result = $db->query($query);
				if(!$result)
					echo('error2');
				//else
					//echo('OK');
				$query = "select count(*) from temp;";
				$result = $db->query($query);
				$row = $result->fetch_assoc();
				echo($row['count(*)']);
			}
			else 
				echo("cannot upload your file!");
		}
		/*else if($button1 == "清空")
		{
			unlink('/uploads/telnum.txt');
			JumpTo("TextMessage.php");
		}*/
	}
	else 
	{
		echo '<script>alert("请登录")</script>';
		JumpTo("index.php");	
	}
?>