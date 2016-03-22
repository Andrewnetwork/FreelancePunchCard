<?php

require_once("../constants.php");

$project_id = $_POST["project_id"]; 

if(strlen($project_id) > 0)
{
	$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
	
	$sql = "UPDATE `project` SET `finished` = '1' WHERE `project`.`project_id` = $project_id  LIMIT 1;";

	$mysqli->query( $sql );
}

?>