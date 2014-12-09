<?php
	// include function files for this application
	require_once('functions.php');
	session_start();
	//create short variable names
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	
	if ($username && $passwd) 
	{
	// they have just tried logging in
	  if(login($username, $passwd))
	  {
	  	$_SESSION['valid_user'] = $username;
	  }
	}
	
	if(isset($_SESSION['valid_user']))
	{
		unlink('/uploads/telnum.txt');
	  	JumpTo("Main.php");
	}
	else 
	{
		echo '<script>alert("用户名或密码错误！")</script>';
		JumpTo("index.php");	
	}
?>