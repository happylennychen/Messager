<?php

function JumpTo($url)
{
	echo "<script>location.href='$url';</script>";
}

function PHP_alert($msg)
{
	?>
	<script>
		alert("<?php echo "$msg"?>");
	</script>
	<?php 
}

function db_connect() {
   //@$db = new mysqli('localhost', 'root', '', 'fithkyo');
   @$db = new mysqli('localhost', 'fithkyo', 'O000000', 'fithkyo');
   if (!$db) {
     throw new Exception('Could not connect to database server');
   } else {
     return $db;
   }
}

function login($username, $password) {
	@ $db = db_connect();

	if (mysqli_connect_errno()) {
	return false;
	}

	$query = "select * from customers where Name = '".$username."' and Password = sha1('".$password."')";
	$result = $db->query($query);
	if(!$result)
		return false;

	if($result->num_rows<=0)
		return false;

	$result->free();
	$db->close();
	return true;
	/*if($username == "sp1")
		return true;
	else 
		return false;*/
}
?>