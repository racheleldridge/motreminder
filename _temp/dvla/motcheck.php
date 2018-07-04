<?php

define("APIKEY","ptZAjbJWQO2LSzitce0JM9wZo4ASO2yV7XWGmoD7");
define("ROOTURL","https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests");

$_POST['creg'] = "rf12hxa";

$myreg  = preg_replace('/[^a-zA-Z0-9]/','',$_POST['creg']);

$errors = array();
$jsonout = array();

if (strlen($myreg)>2) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,ROOTURL."?registration=".$myreg);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","x-api-key:".APIKEY));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);

	if (curl_errno($ch))   {
		$error['errors'] = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
	} else {
		if (stripos($response,"errorMessage") === false) {
			$jsonout = json_decode($response);
		} else {
			echo "[".$response."]";
		}
	}
	curl_close($ch);
	
} else {
	$errors['error'] = "Error: No car registration submitted";
	echo json_encode($errors);
}

$output = serialize($jsonout);
$dataout = unserialize($output);
print_r($dataout);

echo "Car Reg:".$jsonout[0]->registration."<hr />";
echo "Last MOT: ".$jsonout[0]->motTests[0]->expiryDate."<hr />";
echo "<h3>MOT History</h3>";
foreach($jsonout[0]->motTests AS $mots) {
	echo "<hr /><p>MOT Date: ".$mots->completedDate."<br />MOT Result: ".$mots->testResult."<br />Car Mileage:".$mots->odometerValue."</p>";
}

echo "<textarea style=\"width:100%; height:500px;\">";
print_r($jsonout);
echo "</textarea>";

?>