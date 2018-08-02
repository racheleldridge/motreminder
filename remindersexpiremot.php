<?php include 'config.php';?>
<?php
function sendUpdate($name,$to,$d,$jsonout,$ct=0) {
	$subject = 'MOT Updated';
	$from = NOREPLYEMAIL;
	$carinfotable = "
		<table>
			<tr><th>CAR REG<th><td>".$jsonout[0]->registration."</td></tr>
			<tr><th>CAR MAKE<th><td>".$jsonout[0]->make."</td></tr>
			<tr><th>CAR MODEL<th><td>".$jsonout[0]->model."</td></tr>
			<tr><th>CAR FUEL<th><td>".$jsonout[0]->fuelType."</td></tr>
			<tr><th>CAR COLOUR<th><td>".$jsonout[0]->primaryColour."</td></tr>
		</table>	
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
	$message = '<html><body>';
	$message .= "<p>Dear ".stripslashes($name).",</p><p>This is a quick message to let you know we've seen you've had an MOT for your car. We have updated your reminders for the car below</p>".$carinfotable."<h2>NEXT MOT DATE: ".$d."</h2>";
	$message .= '</body></html>';
	echo "<p>Processing: ".$ct." / ".$jsonout[0]->registration."</p>";
	mail($to, $subject, $message, $headers);
}
//todays date in the correct format
$today = date("Y-m-d");
//if the MOT expiry date is less than the date (The MOT has expired)
$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$sql = "SELECT p.people_no, c.car_reg, c.colour, c.make, c.reminder_days, c.mot_date, c.motquery, p.first_name, p.last_name ,p.email 
	FROM car c
	JOIN people p 
	ON c.people_no = p.people_no
	WHERE mot_date <= ?";
if ($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param("s",$today);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows === 0) exit("<h5>No MOT's expired</h5>");
	$stmt->bind_result($p,$c,$cc,$m,$r,$d,$datain,$pf,$pl,$pe);	
	while ($stmt->fetch()) {
		$name = $pf." ".$pl; 
		//go to the DVLA and get the car information
		$jsonout = array();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,ROOTURL."?registration=".$c);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","x-api-key:".APIKEY));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		if (curl_errno($ch))   {
			$error['errors'] = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
		} 
		else {
			if (stripos($response,"errorMessage") === false) {
				$jsonout = json_decode($response);
				$iok = "ok";
			} 
			else {
				echo "<h5 class=\"error\">Invalid car registration</h5>";
			}
			//if the DVLA have a newer date then update the information (the MOT has been completed)
			$md = str_replace(".","-",$jsonout[0]->motTests[0]->expiryDate);
			if ($md > $d) {
				
				$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				$co = $jsonout[0]->primaryColour;
				$m = $jsonout[0]->make;
				$rd = date('Y-m-d', strtotime($md. ' - '.$r));
				$xsql = "UPDATE car c 
					INNER JOIN people p 
					ON c.people_no = p.people_no  
					SET c.colour = ?, c.make = ?, c.mot_date = ?, reminder_date = ?
					WHERE c.car_reg = ? AND p.people_no = ?";
				if ($xstmt = $mysqli->prepare($xsql)) {
					$xstmt->bind_param("ssssss",$co,$m,$md,$rd,$c,$p);
					$xstmt->execute();
					$stmt->fetch();
					sendUpdate($name,$pe,$d,unserialize($datain),$ct);
					echo "cars updated";
				}
			}
			curl_close($ch);
		}
	}			
	$stmt->close();
}
?>