<?php

require_once("../constants.php");

$key = $_POST["key"];
$value = $_POST["value"];
$notes = $_POST["notes"];

if(strlen($key) != 0)
{
	$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);

	if(strlen($value) != 0)
	{
		
		// Change the value for the value field in the db. 
		$sql = "UPDATE `setting` SET `value` = '".$value."' WHERE `setting`.`key` = '".$key."' LIMIT 1;";
		
		$mysqli->query( $sql );
	}
	
	if(strlen($notes) != 0)
	{
		// Change the value for the notes field in the db. 
		$sql = "UPDATE `setting` SET `notes` = '$notes' WHERE `setting`.`key` = '$key' LIMIT 1;";
		
		$mysqli->query( $sql );
	}
}
else
{
	// No name, do nothing. 
}


?>