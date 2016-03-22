<?php
// FreelancePunchCard.class.php
// Requires: constants.php

class FreelancePunchCard
{
	// # Begin Private #
	private $mysqli; 
	// # End Private #
	
	public static $queries = array
	(
		"Sl",
		"EKE"
	);
	
	public function __construct()
	{
		$this->mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);
	}
	
	public function getMysqli()
	{
		return $this->mysqli;
	}
}


?>