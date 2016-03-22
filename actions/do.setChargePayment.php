<?php
// do.setChargePayment.php
// Andrew J. Ribeiro
// Freelance Punch Card 
// June 17, 2010

require_once("../constants.php");

// action: what you want the script to do. 
// setPaid: set the paid flag to true. 
// setUnpaid: set the paid flag to false.
$action = $_POST["action"];

// charge_id: id of a particular record you would like to 
// modify the charge feild to either paid or unpaid. See action. 
$charge_id = $_POST["charge_id"]; 

if( strlen($action) > 0 )
{	
	$sql = "";
	
	if( strcmp($action,"setPaid") == 0 )
	{
		// Set paid. 
		$sql = "UPDATE `charge` SET `paid` = '1' WHERE `charge`.`charge_id` = $charge_id LIMIT 1;";
	}
	elseif(strcmp($action,"setUnpaid") == 0)
	{
		// Set unpaid.
		$sql = "UPDATE `charge` SET `paid` = '0' WHERE `charge`.`charge_id` = $charge_id LIMIT 1;";
	}
	else
	{
		echo ("Error: action is malformed ( ".$action." )!");
		exit(0);
	}
	
	$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
	
	$mysqli->query( $sql );
}

?>