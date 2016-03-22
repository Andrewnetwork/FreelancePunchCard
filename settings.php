<?php 
require_once("constants.php");

$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);

$result = $mysqli->query("SELECT * FROM setting");

$htmlOut = "";

while($row = $result->fetch_assoc())
{
	
	$htmlOut .= '<tr>
    <td>
		<div align="center">'.$row['key'].'</div>
	</td>
    <td>
    	 <input onkeydown="updateValue(\''.$row['key'].'\',this)" onchange="updateValue(\''.$row['key'].'\',this)"  style="width:100%;"  type="text" name="textfield" value="'.$row['value'].'" />
	 </td>
    <td><textarea onkeydown="updateNotes(\''.$row['key'].'\',this)"  onchange="updateNotes(\''.$row['key'].'\',this)"style="width:100%; height:100px;" name="textarea">'.$row['notes'].'</textarea></td>
  </tr>';
}

#

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Settings | Freelance Punch Card | Presented by: Andrew Ribeiro</title>
<script language="javascript" type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript">

function updateNotes(key, textFieldObject)
{
	var  garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.updateSetting.php",
	   data: "key="+key+"&notes="+textFieldObject.value,
	   success: function(msg){
	 		// W/e you want to do when the message has been stored in the db. 
	
	   }
	 });
}

function updateValue(key, textFieldObject)
{
	
	var  garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.updateSetting.php",
	   data: "key="+key+"&value="+textFieldObject.value,
	   success: function(msg){
	 		// W/e you want to do when the message has been stored in the db. 
			
	   }
	 });
}

</script>

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

.tableHeading
{
	font-size:20px;

}

.settingname
{
	
}

-->
</style>
<link href="styles/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
</head>

<body>

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<div class="pageTitle">SETTINGS</div>
				<p><a href="index.php"><img src="_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" border="0" /></a></p>
				<a href="index.php" style="text-decoration:none;"><button>HOME</button><br /></a>
				<hr />
				<p style="text-align:justify;">This is the settings page. On this page you can change the settings for your account. The settings have three values: name, value, and notes. The name of a setting is an identifier for that particular setting. The value of a setting is the numerical or textual value for a particular setting, identified by the name of the setting. The notes portion of a setting allows you to note what the setting does.</p>
				<p style="text-align:justify;"><span class="style1">Note</span>: new settings can only be added directly into the database. Adding new settings is for advanced users that wish to add aditional functionality to the software. </p>
				<table width="100%" border="0" cellspacing="10px">
  <tr>
    <td width="20%"><div align="center" class="tableHeading">Name </div></td>
    <td width="30%"><div align="center" class="tableHeading">Value</div></td>
    <td width="50%"><div align="center" class="tableHeading">Notes</div></td>
  </tr>
  
  <?php
  	
	echo($htmlOut);
	
  ?>

</table>
<hr />

				
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
