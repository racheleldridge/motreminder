<?php
	$servername = "localhost";
	$username = "rachel_e";
	$password = "password";
	$dbname = "motreminder_re";

	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	define("SITESITELINK","http://localhost/rachel/motreminder/motreminder/"); //Add trailling slash 
	define("NOREPLYEMAIL","noreply@creote.com");
	
	function cleanEmail($string) {
   return preg_replace('/[^A-Za-z0-9]\-_@./', '', $string); // Removes special chars.
}
?>