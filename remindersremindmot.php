<?php include 'config.php';?>
<?php
//function that sends the email
function sendReminder($name,$to,$d,$arr,$ct=0) {
	$subject = 'MOT Reminder for you';
	$from = NOREPLYEMAIL;
	
	$carinfotable = "
	<table>
		<tr><th>CAR REG<th><td>".$arr[0]->registration."</td></tr>
		<tr><th>CAR MAKE<th><td>".$arr[0]->make."</td></tr>
		<tr><th>CAR MODEL<th><td>".$arr[0]->model."</td></tr>
		<tr><th>CAR FUEL<th><td>".$arr[0]->fuelType."</td></tr>
		<tr><th>CAR COLOUR<th><td>".$arr[0]->primaryColour."</td></tr>
	</table>	
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
	$message = '<html><body>';
	$message .= "<p>Dear ".stripslashes($name).",</p><p>This is a quick MOT reminder for the car with the information below.</p>".$carinfotable."<h2>NEXT MOT DATE: ".$d."</h2>";
	$message .= '</body></html>';
	echo "<p>Processing: ".$ct." / ".$arr[0]->registration."</p>";
	mail($to, $subject, $message, $headers);
}
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
?>
<?php
$today = date("Y-m-d");
//check if any of the reminder dates are today
$mysqli = new mysqli($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$sql = "SELECT p.people_no, c.car_reg, c.colour, c.make, c.reminder_days, c.mot_date, c.motquery, p.first_name, p.last_name ,p.email 
	FROM car c
	JOIN people p 
	ON c.people_no = p.people_no
	WHERE reminder_date <= ?";
	if ($stmt = $mysqli->prepare($sql)) {
		$stmt->bind_param("s",$today);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows === 0) exit('<h5>There are no reminders set</h5>');
		$stmt->bind_result($p,$c,$cc,$m,$r,$d,$datain,$pf,$pl,$pe);
		while($stmt->fetch()) {
			echo "x";
			$name = $pf." ".$pl; 
		//check the car if the MOT has been done already
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
					echo "ok";
				} 
				else {
					echo "<h5 class=\"error\">Invalid car registration</h5>";
				}
				$md = str_replace(".","-",$jsonout[0]->motTests[0]->expiryDate);
				if ($md > $d) {
					echo "if";
					$mysqli = new mysqli($servername, $username, $password, $dbname);
					if (mysqli_connect_errno()) {
						printf("Connect failed: %s\n", mysqli_connect_error());
						exit();
					}
					$co = $jsonout[0]->primaryColour;
					$m = $jsonout[0]->make;
					$rd = date('Y-m-d', strtotime($md. ' - '.$r));
					$sql = "UPDATE car c 
						INNER JOIN people p 
						ON c.people_no = p.people_no  
						SET c.colour = ?, c.make = ?, c.mot_date = ?, reminder_date, = ?
						WHERE c.car_reg = ? AND p.people_no = ?";
					if ($stmt = $mysqli->prepare($sql)) {
						$stmt->bind_param("ssssss",$co,$m,$md,$rd,$c,$p);
						$stmt->execute();
						$stmt->fetch();
						sendUpdate($name,$pe,$d,unserialize($datain),$ct);
						echo "cars updated";
						
					}
				}
				else {
					echo "send email";
					sendReminder($name,$pe,$d,unserialize($datain),$ct);
					$ct++;
				}
			curl_close($ch);
			}
		}
	$stmt->close();

	}
?>