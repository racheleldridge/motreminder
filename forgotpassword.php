<?php include 'header.php';?>
<section id="forgottenpassword">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<?php 
					$error = "";
					$congratulations = "";
					if($_POST['do'] == 'forgotpassword'){
						if($_POST['em']) {
							$mysqli = new mysqli($servername, $username, $password, $dbname);
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}
							$sql = "SELECT first_name, activated, activation_code FROM people WHERE email = ?";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("s",$_POST['em']);
								$stmt->execute();
								$stmt->bind_result($fn, $activated, $ac);
								$stmt->fetch();
								if (!($fn == "")) {
									if ($activated == 0){
										$error .= "<p>This account isnt activated. We have resent you the activation email. If you dont have access to that email and would like to create a new account please click <a href='signup.php'>here</a></p>"; 
										$activationlink = SITESITELINK."activation.php?a=".$ac;
										$activationmessage = "<p>Hi ".$fn."</p><p>Thank you very much for creating an account. Click on the activation link below to activate your account</p><p>Activation link: <a href=\"".$activationlink."\">".$activationlink."</a></p><p>Your great team.</p>";
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
										include 'fp.php';
									}
									else {
										$temp_pass  = generateRandomString(100);
										$congratulations .= "<div class='col-12'><div class='signinsucsess'><p>We have sent you an email to change your password!</p></div></div>";
										$activationlink = SITESITELINK."changepassword.php?a=".$temp_pass;
								$xmysqli = new mysqli($servername, $username, $password, $dbname);
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}									
										$xxstmt = $xmysqli->prepare("UPDATE people SET temp_p = ? WHERE email = ? ");
										$xxstmt->bind_param("ss",$temp_pass,$_POST['em']);
										$xxstmt->execute();
										$xxstmt->close();
										$activationmessage = "<p>Hi ".$fn."</p><p>Click on the link below to change the password to your account</p><p>Link: <a href=\"".$activationlink."\">".$activationlink."</a></p><p>Your great team.</p>";
										$to = $_POST['em'];
										$subject = 'Password Change email for MOT reminder service';
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
									}
								} 
								else {
									$error .= '<p>Incorrect email</p>';
									include 'fp.php';
								}
								$stmt->close();
							}			
						}
						else {
							$error .= '<p>Incorrect email </p>';
							include 'fp.php';
						}
					}
					else {
						include 'fp.php';
					}
				?>
			</div>
			<?php
				if ($congratulations) {	
					print_r($congratulations);
				}
			?>
			<div class="col-12 col-md-6">
				<?php 
					if($error) {
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";;
					}
				?>
				<?php
				$instructions = "<h2>Instructions</h2>
				<ol>
					<li>Enter your email and we'll send you a link to change your password</li>
					<li>Make sure you enter the correct email address. Otherwise you will not be anble to get back into your account</li>
				</ol>";
				if (!($error == "") || $congratulations == "") {
								print_r($instructions);
							}
				?>
			</div>
		</div>
	</div>
</section>
<?php include 'footer.php';?>