<?php
	require_once('functions.php');
	session_start();
	$pageNo = $_REQUEST['pageNo'];
	if(!isset($pageNo))
		$pageNo = 1;
	$rowPerPage = $_REQUEST['rowPerPage'];
	if(!isset($rowPerPage))
		$rowPerPage = 15;

	class Record
	{
		public $ID;
		public $Content;
		public $Number;
		public $Time;
		public $Status;
	}
	class JsonData
	{
		public $rowPerPage;
		public $pageNo;
		public $totalCount;
		public $data=array();
	}
	$jsonData = new JsonData();
	$jsonData->pageNo = $pageNo;
	$jsonData -> rowPerPage = $rowPerPage;
	
	$start = ($pageNo-1)*$rowPerPage;
	//$end=$pageNo*$rowPerPage;
	$records = array();
	$db = db_connect();
	
	if (mysqli_connect_errno()) {
		echo "error";
	}
	
	$query = "select count(*) from orders where CustomerName = '".$_SESSION['valid_user']."';";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$jsonData -> totalCount = $row['count(*)'];
	
	$query = "select Message,OrderID,DateTime from orders where CustomerName = '".$_SESSION['valid_user']."' order by OrderID DESC limit ".$start.",".$jsonData -> rowPerPage.";";
	$result = $db->query($query);
	if(!$result)
		echo "error";
	//如果结果多于一个，报错
	for($i=0; $i<$result->num_rows; $i++)	//建立一个Record类数组records
	{
		$row = $result->fetch_assoc();
		$id = stripslashes($row['OrderID']);
		
		$q = "select count(*) from order_items where OrderID = '".$id."';";	//从order_items中获得特定id对应的短信数目
		$res = $db->query($q);
		$r = $res->fetch_assoc();
		$cnt = stripslashes($r['count(*)']);
		
		
		$rec = new Record();
		$rec->ID = $id;
		
		$temp = stripslashes($row['Message']);
		
		if(strlen($temp) < 46)
			$rec->Content = $temp;
		else
		{
			$temp = trim($temp);
			$temp = mb_substr($temp,0,40,'utf-8');
			$rec->Content = $temp . "...";
		}
		$rec->Number = $cnt;
		$rec->Time = stripslashes($row['DateTime']);
		$rec->Status = "成功";
		$records[$i]=$rec;
	}
	
	$db->close();
	
	$num_result = $result->num_rows;
	
	for($pos = 0;$pos<$num_result;$pos++)
	{
		//$row = $result->fetch_assoc();
		$jsonData->data[$pos] = $records[$pos];
	}
	echo json_encode($jsonData);/**/
?>