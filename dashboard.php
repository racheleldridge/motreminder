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
		//if the length is correct
		if (strlen($mys) == 100) {
			$sql = "UPDATE car c
				INNER JOIN people p
				ON c.people_no = p.people_no 
				SET deleted = b'1'
				WHERE car_reg = ? AND reminder_days = ? AND session_kid = ?";
			if ($stmt = $mysqli->prepare($sql)) {
				$stmt->bind_param("sss",$myc,$myr,$mys);
				$stmt->execute();
				echo "<h5 class='re-deleted'>Car Deleted</h5>";
				$stmt->close();
			}
		}
	}
?>
<section id="hello">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<?php
					//shows name
					echo '<h2>Hello ' . $_COOKIE['signincookie'].'!</h2>';
					if($_GET['dw'] == 'd' AND isset($_GET['c']) AND isset($_GET['r'])) {	
						deleteCar($_GET['c'],$_GET['r'],$_COOKIE['acem']);
					}
				?>
			</div>
			<div class="col-12 col-md-6 addcar">
				<!--Add car-->
				<?php
					//variables
					$error = "";
					$congratulations = "";
					//add car
					if($_POST['do'] == 'addcar'){
						if($_POST['cr'] AND $_POST['rd']) {
							$mysqli = new mysqli($servername, $username, $password, $dbname);
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}
							$sql = "SELECT c.car_reg, c.reminder_days
								FROM car c			
								JOIN people p
								ON c.people_no = p.people_no
								WHERE car_reg = ? AND reminder_days = ? AND session_kid = ?";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("sss",$_POST['cr'], $_POST['rd'],$_COOKIE['acem']);
								$stmt->execute();
								$stmt->bind_result($r,$rd);
								$stmt->fetch();
								if ($rd) {
									$error .= "there is already an alert for this";
								}
								else {
									$mysqli = new mysqli($servername, $username, $password, $dbname);
									if (mysqli_connect_errno()) {
										printf("Connect failed: %s\n", mysqli_connect_error());
										exit();
									}
									$sql = "SELECT people_no FROM people WHERE session_kid = ?";
									if ($stmt = $mysqli->prepare($sql)) {
										$stmt->bind_param("s",$_COOKIE['acem']);
										$stmt->execute();
										$stmt->bind_result($pn);
										$stmt->fetch();
										$mysqli = new mysqli($servername, $username, $password, $dbname);
										if (mysqli_connect_errno()) {
											printf("Connect failed: %s\n", mysqli_connect_error());
											exit();
										}
										$colour = "colour";
										$make = "make";
										$datetime = "2018-07-02 12:26:10";
										$date = "2018-07-02";
										$sql = "INSERT INTO car (car_reg, colour, make, reminder_days,date_added,people_no, mot_date, deleted)
											VALUES (?, ?, ?, ?, ?, ?, ?, b'0')";
										if ($stmt = $mysqli->prepare($sql)) {
											$stmt->bind_param("sssssss",$_POST['cr'],$colour,$make,$_POST['rd'],$datetime,$pn,$date);
											$stmt->execute();
											$stmt->fetch();
											$congratulations = "<div class='col-12'><div class='signinsucsess'><P>Car Created!</p></div></div>";
											$stmt->close();
										}
									}
								}
							}
						}
						else {
							//when the values arent entered correctly
							$error .= '<p>Please enter the values correctly</p>';
							include 'addcarform.php';
						}
					}
					else {
						//when the form isnt inputted
						include 'addcarform.php';
					}
					//print out the values
					if($error) {
						include 'addcarform.php';
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
					}
					if($congratulations) {
						echo $congratulations;
						include 'addcarform.php';
					}
				?>
			</div>
			<?php
				$output ="";
				$mysqli = new mysqli($servername, $username, $password, $dbname);
				if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				$sql = "SELECT p.people_no, c.car_reg, c.colour, c.make, c.reminder_days, c.mot_date, c.motquery  
					FROM car c
					JOIN people p 
					ON c.people_no = p.people_no
					WHERE p.session_kid = ? AND c.deleted = b'0' ORDER BY c.mot_date ASC";
				if ($stmt = $mysqli->prepare($sql)) {
					$stmt->bind_param("s",$_COOKIE['acem']);
					$stmt->execute();
					$stmt->store_result();
					if($stmt->num_rows === 0) exit('<h5>There are no reminders set</h5>');
					$stmt->bind_result($p,$c,$cc,$m,$r,$d,$datain); 
					while($stmt->fetch()) {
						$dataout = unserialize($datain);
						$reminderdate = date('Y-m-d', strtotime($d. ' - '.$r));
						$output .="<div class='col-12 col-md-3 car'>
							<p><strong>Car Registration: </strong>".strtoupper($c)."</p>
							<p><strong>Car Details: </strong>".$cc." ".$m."</p>
							<p><strong>MOT Date: </strong>".$d."</p>
							<p>TEST: ".$dataout[0]->motTests[0]->completedDate."</p>
							<p><strong>Reminder Days: </strong>".$r."</p>
							<p><strong>Reminder Date: </strong>".$reminderdate."</p>
							<h5><strong><a href=\"".SITESITELINK."dashboard.php?dw=d&c=".$c."&r=".$r."\">Delete</a></strong></h5>
						</div>";
					}
					$stmt->close();
				}
			?>
		</div>
		<div class="row justify-content-md-center">
			<?php echo $output; ?>
		</div>
	</section>
<?php include 'footer.php';?>