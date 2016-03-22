<?php

require_once("../constants.php");

// Get data. 
$startDate  = $_POST["startDate"];
$weekLength = $_POST["weekLength"];
$paid       = $_POST["paid"]; 
$projectID  = $_POST["projectID"]; 

// Validate ID.
if(strlen($projectID) > 0 && is_numeric( $projectID ) )
{
	// Validate date. 
	if( strlen($startDate) >= 6 &&( preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/", $startDate) > 0 ) )
	{
		// Validate paid. 
		if( strlen($paid) > 0 && is_numeric($paid) )
		{
			// Validate week length
			if( strlen($weekLength) > 0 && is_numeric($weekLength))
			{
				// All data is validated. Insert into db. 
				$sql = "INSERT INTO `freelancepunchcard`.`billingcycle` (`cycle_id`, `startdate`, `weeklength`, `paid`,   
				       `project_id`) VALUES (NULL, '".$startDate."', '".$weekLength."', '".$paid."', '".$projectID."');";
				
				$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
				
				if(!$mysqli->query( $sql ))
				{
					echo("Fatal Error: The database is currently down. Please try again later.");
				}
			}
			else
			{
				echo("Improper value for week length. Enter a number that is greater than zero!");
			}
		}
		else
		{
			echo("Invalid value for the 'paid' feild!");
		}
	}
	else
	{
		echo("You must enter a valid month (yyyy-mm-dd). I.e. 2010-06-20.");
	}
}
else
{
	echo("Invalid project ID!");
}
 

?>