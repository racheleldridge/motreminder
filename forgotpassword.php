<?php
$title = "Forgotten Password - Annual MOT Reminder App";
$description = "The MOT reminder is an easy way to keep a track of your car MOT's. Whether you're a buisness or just want to keep a track of your family cars, this is the perfect reminder for you! You can have multiple cars and multiple reminders for each. We will send you an email when the reminder is due.";
?>
<?php include 'header.php';?>
<section id="forgottenpassword">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<?php 
					//variables
					$error = "";
					$congratulations = "";
					//to check if the form is inputted
					if($_POST['do'] == 'forgotpassword'){
						//if the values are entered
						if($_POST['em']) {
							$mysqli = new mysqli($servername, $username, $password, $dbname);
							//database connection
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}
							//sql query
							$sql = "SELECT first_name, activated, activation_code FROM people WHERE email = ?";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("s",$_POST['em']);
								$stmt->execute();
								$stmt->bind_result($fn, $activated, $ac);
								$stmt->fetch();
								//if there is a value in the query
								if (!($fn == "")) {
									//to check if the account is activated - if not send the email
									if ($activated == 0){
										$error .= "<p>This account isnt activated. We have resent you the activation email. If you dont have access to that email and would like to create a new account please click <a href='signup.php'>here</a></p>"; 
										//email
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
									//send the change password email
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
										//email
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
									//error message
									$error .= '<p>Incorrect email</p>';
									include 'fp.php';
								}
								//closing database
								$stmt->close();
							}			
						}
						else {
							//error messages
							$error .= '<p>Incorrect email </p>';
							include 'fp.php';
						}
					}
					else {
						//when the form isnt submitted yet
						include 'fp.php';
					}
				?>
			</div>
			<?php
				//if the congratulations message is shown
				if ($congratulations) {	
					print_r($congratulations);
				}
			?>
			<div class="col-12 col-md-6">
				<?php 
					//if there is an error it gets displays here
					if($error) {
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";;
					}
				?>
				<?php
					//instructions are displayed if there isnt a congratulations message
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