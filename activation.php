<?php
$title = "Activate Your Account - Annual MOT Reminder App";
$description = "The MOT reminder is an easy way to keep a track of your car MOT's. Whether you're a buisness or just want to keep a track of your family cars, this is the perfect reminder for you! You can have multiple cars and multiple reminders for each. We will send you an email when the reminder is due.";
?>
<?php include 'header.php';?>
<?php include 'picture.php';?>
	<!--Both the sign up and the sign in sections-->
		<section id="sign">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php
							//clean the link
							$_GET['a'] = cleanA($_GET['a']);
							//check the link 
							if (strlen($_GET['a']) == 50) {
								$mysqli = new mysqli($servername, $username, $password, $dbname);
								if (mysqli_connect_errno()) {
									printf("Connect failed: %s\n", mysqli_connect_error());
									exit();
								}
								//change the activation bit
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
					</div>
				</div>
			</div>
		</section>
<?php include 'footer.php';?>