<?php include 'header.php';?>
<?php include 'picture.php';?>
	<!--Both the sign up and the sign in sections-->
		<section id="sign">
			<div class="container">
				<div class="row">
	<!--sign up-->
					<div class="col-12 col-md-6" id="signup">
						<?php 
							$error = "";
							$congratulations = "";
							if($_POST['do'] == 'signup'){
								if($_POST['fn'] AND $_POST['ln'] AND $_POST['em'] AND $_POST['pw'] AND $_POST['cpw']) {
									if(!(filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))) {
										$error .= '<p>Incorrect email </p>';
									}
									if(!($_POST['pw'] == $_POST['cpw'])) {
										$error .= '<p>Passwords dont match</p>';
									}
									$mysqli = new mysqli($servername, $username, $password, $dbname);
									if (mysqli_connect_errno()) {
										printf("Connect failed: %s\n", mysqli_connect_error());
										exit();
									}
									$sql = "SELECT email,activated FROM people WHERE email = ?";
									if ($stmt = $mysqli->prepare($sql)) {
										$stmt->bind_param("s", $_POST['em']);
										$stmt->execute();
										$stmt->bind_result($em,$activated);
										$stmt->fetch();
										if ( $em) {
											if ($activated == 0) {
												$error .= "<p>There is an account that has the email but isnt activated click <a href=''>here</a> to send the activation email again</p>";
											}
											else {
												$error .= "<p>There is an account that has the email. Click <a href=''>here</a> to sign in</p> ";
											}
											include 'signupform.php';
										}  
										else {
											$rannum = generateRandomString(50);
											$stmt = $mysqli->prepare("INSERT INTO people (first_name, last_name,email,pwd,activation_code) VALUES (?, ?, ?, ?, ?)");
											$stmt->bind_param("sssss", $_POST['fn'], $_POST['ln'],$_POST['em'],md5($_POST['pw']),$rannum);
											$stmt->execute();
											
											$activationlink = SITESITELINK."activation.php?a=".$rannum;
											
											$activationmessage = "<p>Hiya ".stripslashes($_POST['fn'])."</p><p>Thank you very much for creating an account. Click on the activation link below to activate your account</p><p>Activation link: <a href=\"".$activationlink."\">".$activationlink."</a></p><p>Your great team.</p>";
											
											$to = $_POST['em'];
											$subject = 'Activation email for MOT reminder service';
											$from = NOREPLYEMAIL;
											 
											// To send HTML mail, the Content-type header must be set
											$headers  = 'MIME-Version: 1.0' . "\r\n";
											$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
											 
											// Create email headers
											$headers .= 'From: '.$from."\r\n".
												'Reply-To: '.$from."\r\n" .
												'X-Mailer: PHP/' . phpversion();
											 
											// Compose a simple HTML email message
											$message = '<html><body>';
											$message .= $activationmessage;
											$message .= '</body></html>';
											 
											// Sending email
											mail($to, $subject, $message, $headers);

											$congratulations = "<div class='col-12'><div class='signinsucsess'><h2>Congratulations!</h2><P>Your account was created successfully. Please check your emails and click on the link to activate your account.</p><div><div>";
										}		
									$stmt->close();
									}
								}
							}	
							else {
								include 'signupform.php';
							}
						?>
					</div>
	<!--sign in-->
					<?php
						if ($congratulations) {	
							print_r($congratulations);
						}
					?>
					<div class="col-12 col-md-6" id="signin">
						<?php 
							if($error) {
								echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";;
							}
						?>
						<?php
							$instructions = "<h2>Instructions</h2><ol><li>Complete all the fields</li><li>Make sure you enter the correct email address. We will send an activation email to you to complete your registration.</li><li>Without activating your account you will not be able to log in</li></ol>";
							if (!($error == "") || $congratulations == "") {
								print_r($instructions);
							}
						?>
						<!--
						<?php print_r($_POST); ?>
						<hr />
						<?php var_dump($_POST); ?>
						-->
					</div>
				</div>
			</div>
		</section>
<?php include 'footer.php';?>