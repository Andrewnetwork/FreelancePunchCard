<?php

require_once("../constants.php");

$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);

$name      = $_POST['name'];
$date      = $_POST['date'];
$cycle     = $_POST['cycleID'];
$amount    = $_POST['amount'];
$paid      = $_POST['paid'];
$notes     = $_POST['notes'];
$projectID = $_POST['projectID']; 

if( strlen($projectID) > 0 && (preg_match("/[0-9]/", $projectID) != 0) )
{
	if( strlen($name) > 0 )
	{
		if(preg_match("/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/",$date) > 0)
		{
			if( preg_match("/[0-9]/", $amount ) > 0 )
			{
				$cycleValue = "NULL"; 
			
				if(strlen($cylce) > 0 && $cycle > 0)
				{
					$cycleValue = "'".$cycle."'";
				}
				
				if(strlen($notes) <= 0)
				{
					$notes = " ";
				}
				
				$sql = "INSERT INTO `charge` (`charge_id`, `charge_name`, `date`, `cycle_id`, `notes`,`project_id`, `amount`,`paid`) VALUES (NULL, '".$name."', '".$date."', ".$cycleValue.", '".$notes."', '".$projectID."', '".$amount."', '".$paid."');";
				
				
				if(!$mysqli->query( $sql ))
				{
					echo("Failure executing query");
				}
				
				
				
			}
			else
			{
				echo("You must enter a valid amount!");
			}
		}
		else
		{
			echo("You must enter a valid date!");
		}
	}
	else
	{
		echo("You must enter a name for this charge!");
	}

}
else
{
	echo("Error retreving project id!");
}

?>