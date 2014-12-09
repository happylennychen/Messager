<?php
	require_once('functions.php');
	$pageNo = $_REQUEST['pageNo'];
	if(!isset($pageNo))
		$pageNo = 1;
	$rowPerPage = $_REQUEST['rowPerPage'];
	if(!isset($rowPerPage))
		$rowPerPage = 10;
	class RawData
	{
		public $Telno;
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
	
	//$tArray=file('/uploads/telnum.txt');
	$db = db_connect();
				
	if (mysqli_connect_errno()) {
		echo 'error';
	}
					
	$query = "select count(*) from temp;";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$jsonData -> totalCount = $row['count(*)'];
	//$jsonData -> totalCount = count($tArray);
	/*for($j=0;$j<300000;$j++)
	{
		$tArray[$j] = $j+1;
	}*/
	$query = "select telnum from temp limit ".$start.",".$jsonData -> rowPerPage.";";
	$result = $db->query($query);
	$num_result = $result->num_rows;
	
	for($pos = 0;$pos<$num_result;$pos++)
	{
		$row = $result->fetch_assoc();
		$jsonData->data[$pos] = new RawData();
		$jsonData->data[$pos]->Telno = $row['telnum'];
	}
	echo json_encode($jsonData);
?>