<?php 
	//require_once('functions.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>GroupMessager</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="loginpanelwrap">
			<div id="loginheader">
				商务短信平台
			</div>
			<div >
				<form id="loginform" action="login.php" method="post">
					<div class="loginform_row"> 
						<label>用户名:</label>
						<input type="text" class="loginform_input" name="username" />
					</div>
					<div class="loginform_row">
						<label>密&nbsp;&nbsp;&nbsp;码:</label>
						<input type="password" class="loginform_input" name="passwd" />
					</div>
					<div class="loginform_row">
						<input type="submit" id="loginform_submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;陆" />
					</div> 
				</form>
			</div>
		</div>
	</body>
</html>