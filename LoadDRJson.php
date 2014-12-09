<?php
	require_once('functions.php');
	session_start();
	//$id = 98;
	$id=$_GET['id'];
	$pageNo = $_REQUEST['pageNo'];
	if(!isset($pageNo))
		$pageNo = 1;
	$rowPerPage = $_REQUEST['rowPerPage'];
	if(!isset($rowPerPage))
		$rowPerPage = 10;
	class RawData
	{
		public $ID;
		public $Tel;
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
	
	$db = db_connect();
	
	if (mysqli_connect_errno()) {
		echo 'error';
	}
	
	$query = "select count(*) from order_items where OrderID = '".$id."';";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$jsonData -> totalCount = $row['count(*)'];
	
	
	$query = "select TelNum,Status from order_items where OrderID = '".$id."' limit ".$start.",".$jsonData -> rowPerPage.";";
	$result = $db->query($query);
	if(!$result)
		echo 'error';
	$db->close();
	//如果结果多于一个，报错
	for($i=0; $i<$result->num_rows; $i++)	//建立一个Record类数组records
	{
		$row = $result->fetch_assoc();
		$raw = new RawData();
		$raw->ID=stripslashes($row['OrderID']);
		$raw->Tel = stripslashes($row['TelNum']);
		$raw->Status = "成功";
		$jsonData->data[$i] = $raw;
	}
	echo json_encode($jsonData);/**/
?>