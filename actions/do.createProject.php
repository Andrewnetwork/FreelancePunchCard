<?php
	
	require_once("../constants.php");

	$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
	
	$clientID = $_POST['clientID'];
	$projectName = $_POST['projectName'];
	
	$sql = "INSERT INTO `project` (`project_id`, `client_id`, `name`, `finished`, `dateCreated`) VALUES (NULL, '".$clientID."', '".$projectName."', NULL, CURRENT_TIMESTAMP);";
	
	$mysqli->query( $sql );
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Project Created</title>
<style type="text/css">
<!--


#mainBody 
{
	background-color:#CBFF97;
	padding:1em;
	position:relative; 
	top:-1px;
	left:-1px;
	min-width:800px;
	
}
-->
</style>
<link href="../styles/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 36px;
	color: #00FF00;
}
-->
</style>
<script language="javascript" type="text/javascript">

function redirect()
{
	window.location = "../projectPage.php";
}

</script>
</head>

<body onload="setTimeout(redirect, 2000)">

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<p><img src="../_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" /></p>
				<hr />
				<p class="style1">PROJECT CREATED </p>
			</div>

		</div>
	</div>
	
	<div style="width:70.5%; ">
	<center>
    </center>
	</div>
	
</center>

</body>
</html>

