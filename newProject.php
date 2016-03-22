<?php
	
	require_once("constants.php");

	$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
	
	$result = $mysqli->query("SELECT * FROM `client` ORDER BY `fname` ASC"); 
	
	$clientsList = "";
	
	while( $row = $result->fetch_assoc() )
	{
		
		$clientsList .= '<option value="'.$row["client_id"].'">'.$row["fname"]." ".$row["lname"].'</option>';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>New Project | Freelance Punch Card | Presented by: Andrew Ribeiro</title>
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
<link href="styles/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<div class="pageTitle">NEW PROJECT</div>
				<p><a href="index.php"><img src="_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" border="0" /></a></p>
				<p><a href="index.php" style="text-decoration:none;"><button>HOME</button></a></p>
				<hr />
				<p style="text-align:justify;">This page enables you to create a new project. You will need to have already added the client to the database in order for you to continue. </p>
				<form id="form1" name="form1" method="post" action="actions/do.createProject.php">
                  <p>&nbsp;</p>
                  <p>Project Name:
                    <input type="text" name="projectName" />
                  </p>
                  <p>Client Name:
                    <select name="clientID">
					  <?php
					    echo($clientsList);
					  ?> 
                    </select>
                  </p>
                  <p>
                    <input type="submit" name="Submit" value="Create Project" />
                    <input type="reset" />
                  </p>
				</form>
				<p style="text-align:justify;">&nbsp;</p>
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
