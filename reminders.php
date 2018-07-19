<?php include 'config.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$today = date("Y-m-d");

function sendReminder($f,$l,$to,$d,$arr,$ct=0) {
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
	$message .= "<p>Dear ".stripslashes($f." ".$l).",</p><p>This is a quick MOT reminder for the car with the information below.</p>".$carinfotable."<h2>NEXT MOT DATE: ".$d."</h2>";
	$message .= '</body></html>';
	echo "<p>Processing: ".$ct." / ".$arr[0]->registration."</p>";
	//mail($to, $subject, $message, $headers);
}
													
				$output ="";
				$mysqli = new mysqli($servername, $username, $password, $dbname);
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}

				$sql = "SELECT p.people_no, c.car_reg, c.colour, c.make, c.reminder_days, c.mot_date, c.motquery, p.first_name, p.last_name ,p.email 
					FROM car c
					JOIN people p 
					ON c.people_no = p.people_no
					WHERE reminder_date = ? AND c.deleted = b'0'";
				if ($stmt = $mysqli->prepare($sql)) {
					$stmt->bind_param("s",$today);
					$stmt->execute();
					$stmt->store_result();
					if($stmt->num_rows === 0) exit('<h5>There are no reminders set</h5>');
					$stmt->bind_result($p,$c,$cc,$m,$r,$d,$datain,$pf,$pl,$pe);
					$ct = 1;					
					while($stmt->fetch()) {
						sendReminder($pf,$pl,$pe,$d,unserialize($datain),$ct);
						$ct++;
					}
					$stmt->close();
				}
				
?>