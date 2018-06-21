<?php include 'header.php';?>
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
							echo "xxxx";
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
							WHERE session_id = ? ORDER BY c.car_reg ASC";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("s",$_COOKIE['acem']);
								$stmt->execute();
								$stmt->store_result();
								if($stmt->num_rows === 0) exit('No rows');
								$stmt->bind_result($p,$c,$cc,$m,$r,$d); 
								while($stmt->fetch()) {
									$output .= "<tr><td>".$c."</td><td>".$d."</td><td>".$r."</td><td><a href=\"#?c=".$c."&r=".$r."\">Delete</td></tr>";
								}

								$stmt->close();
							}
							//alert are you sure if any delete is clicked
							//then use the information in the url to delete from the database
							//use the session cookie
							$_GET['c'] = cleanA($_GET['c']);
							$_GET['r'] = cleanA($_GET['r']);
								$mysqli = new mysqli($servername, $username, $password, $dbname);
								if (mysqli_connect_errno()) {
									printf("Connect failed: %s\n", mysqli_connect_error());
									exit();
								}
								$stmt = $mysqli->prepare("UPDATE people SET activated = b'1' WHERE activation_code = ?");
								$stmt->bind_param("s",$_GET['a']);
								$stmt->execute();
								$stmt->close();
								echo "<div class='re-activated'><h2>Thank you!</h2><p>You have successfully activated your account</p><p>Click <a href='signin.php'>here</a> to sign in</p></div>";
							}
							//if the link is wrong							
							else {
								echo "<p>Please supply a valid activation code</p>";
							}

					?>
					<table class="table table-condensed table-striped">
						<thead><tr><th>Reg</th><th>Date</th><th>Days</th><th>&nbsp;</th></tr></thead>
						<tbody>
						<?php echo $output; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
<?php include 'footer.php';?>