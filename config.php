<?php
	//database info
/* 	$servername = "localhost";
	$username = "ukrachex_rachmr";
	$password = "i5IK=#&%SHma";
	$dbname = "ukrachex_motreminderx";
	define("SERVERNAME", 'localhost');
	define("USERNAME", 'ukrachex_rachmr');
	define("PASSWORD", 'i5IK=#&%SHma');
	define("DBNAME", 'ukrachex_motreminderx'); */
	//define("SITESITELINK","http://rachel.55uk.net/motreminder"); //Add trailling slash
	
	$servername = "localhost";
	$username = "rachel_e";
	$password = "password";
	$dbname = "motreminder_re";
	define("SERVERNAME", 'localhost');
	define("USERNAME", 'rachel_e');
	define("PASSWORD", 'password');
	define("DBNAME", 'motreminder_re');
	define("SITESITELINK","http://192.168.1.70/rachel/motreminder/motreminder/");	
	define("NOREPLYEMAIL","noreply@creotec.com");
	//check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	//function to get randome values
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	

	//function to clear a string of special characters
	function cleanA($string) {
		return preg_replace('/[^A-Za-z0-9 ]/', '', $string); // Removes special chars.
	}
							
	function cleanEmail($string) {
		return preg_replace('/[^A-Za-z0-9]\-_@./', '', $string); // Removes special chars.
	}
	
	define("APIKEY","ptZAjbJWQO2LSzitce0JM9wZo4ASO2yV7XWGmoD7");
	define("ROOTURL","https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests");
?>