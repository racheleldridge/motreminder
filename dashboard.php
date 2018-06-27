<?php 
	include 'header.php';
	//to move the page if there is no session cookie
	if (!isset($_COOKIE['acem']))
	{
		header("location:index.php");
 		exit;
	}
	//alert are you sure if any delete is clicked
	//then use the information in the url to delete from the database
	//use the session cookie
	function deleteCar($c,$r,$s) {
		$myc = cleanA($c);
		$myr = cleanA($r);
		$mys = cleanA($s);
		$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		if (strlen($mys) == 100) {
			$sql = "UPDATE car c
				INNER JOIN people p
				ON c.people_no = p.people_no 
				SET deleted = b'1'
				WHERE car_reg = ? AND reminder_days = ? AND session_kid = ?";
			if ($stmt = $mysqli->prepare($sql)) {
				$stmt->bind_param("sss",$myc,$myr,$mys);
				$stmt->execute();
				echo "<div class='re-activated'><h2>Thank you!</h2><p>deleted car</p></div>";
				$stmt->close();
			}
		}
	}
	if($_GET['dw'] == 'd' AND isset($_GET['c']) AND isset($_GET['r'])) {		
		deleteCar($_GET['c'],$_GET['r'],$_COOKIE['acem']);
	}	
?>
	<section id="hello">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-7">
					<?php
						//shows name
						echo '<h2>Hello ' . $_COOKIE['signincookie'].'!</h2>';
					?>
				</div>
				<div class="col-12 col-md-5">
					<div class="row">
						<div class="col-12">
							<?php
/* 								//variables
								$error = "";
								$congratulations = "";
								if($_POST['do'] == 'addcar'){
									if($_POST['cr']) {
											$mysqli = new mysqli($servername, $username, $password, $dbname);
											if (mysqli_connect_errno()) {
												printf("Connect failed: %s\n", mysqli_connect_error());
												exit();
											}
											$sql = "SELECT reminder_days,colour,make,people_no FROM car WHERE car_reg = ?";
												if ($stmt = $mysqli->prepare($sql)) {
													$stmt->bind_param("s",$_POST['cr']);
													$stmt->execute();
													$stmt->bind_result($rd, $colour, $make, $pn);
													$stmt->fetch();
													if ($rd) {
														//put those details into variables to be used for the next query
														if ($pn == $_COOKIE['acem']) {
															if($rd == $_POST['rd']) {
																$error .= '<p>There is already an alert for that</p>';
															}
															else{
																$mysqli = new mysqli($servername, $username, $password, $dbname);
																if (mysqli_connect_errno()) {
																	printf("Connect failed: %s\n", mysqli_connect_error());
																	exit();
																}				
																$sql = "SELECT reminder_days,colour,make,people_no FROM car WHERE car_reg = ?";
																if ($stmt = $mysqli->prepare($sql)) {
																	$stmt->bind_param("s",$_POST['cr']);
																$stmt->execute();
																$stmt->bind_result($rd, $colour, $make, $pn);
																$stmt->fetch();
																}
															}
														//check if there is already the time,reg and person id in the database 
														
													}
													else {
														//get the details from dvla and put them into the same variables
														
													}
												$stmt->close();
											}
								}
								else {
									$error .= '<p>Please enter a correct email and password</p>';	
									include 'addcarform.php';							
								}
							}	
							else {
								include 'addcarform.php';
							} */
							?>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-7">
					<?php
						$output ="";
						$mysqli = new mysqli($servername, $username, $password, $dbname);
						if (mysqli_connect_errno()) {
							printf("Connect failed: %s\n", mysqli_connect_error());
							exit();
						}
						$sql = "SELECT p.people_no, c.car_reg, c.colour, c.make, c.reminder_days, c.mot_date 
						FROM car c
						JOIN people p 
						ON c.people_no = p.people_no
						WHERE session_kid = ? AND deleted = b'0' ORDER BY c.car_reg ASC";
						if ($stmt = $mysqli->prepare($sql)) {
							$stmt->bind_param("s",$_COOKIE['acem']);
							$stmt->execute();
							$stmt->store_result();
							if($stmt->num_rows === 0) exit('No rows');
							$stmt->bind_result($p,$c,$cc,$m,$r,$d); 
							while($stmt->fetch()) {
								$output .= "<div class='row'>
									<div class='col-12 col-md-6 car'>
										<p><strong>Car Registration: </strong>".strtoupper($c)."</p>
										<p><strong>Car Details: </strong>".$cc." ".$m."</p>
										<p><strong>MOT Date: </strong>".$d."</p>
										<p><strong>Reminder Days: </strong>".$r."</p>
										<h5><strong><a href=\"".SITESITELINK."dashboard.php?dw=d&c=".$c."&r=".$r."\">Delete</a></strong></h5>
									</div>
								</div>";
								//$output .= "<tr><td>".$c."</td><td>".$d."</td><td>".$r."</td><td><a href=\"".SITESITELINK."dashboard.php?dw=d&c=".$c."&r=".$r."\">Delete</td></tr>";
							}
							$stmt->close();
						}
					?>
						<?php echo $output; ?>
				</div>
			</div>
		</div>
	</section>
<?php include 'footer.php';?>