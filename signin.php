<?php
$title = "Sign in -Annual MOT Reminder App";
$description = "Sign in to the Anual MOT Reminder App - The MOT reminder is an easy way to keep a track of your car MOT's. Whether you're a buisness or just want to keep a track of your family cars, this is the perfect reminder for you! You can have multiple cars and multiple reminders for each. We will send you an email when the reminder is due.";
?>
<?php 
	ob_start();
	include 'header.php';
?>
<?php include 'picture.php';?>
	<!--Both the sign up and the sign in sections-->
		<section id="sign">
			<div class="container">
				<div class="row">
	<!--sign in-->
					<div class="col-12 col-md-6" id="signin">
						<?php 
							//variables
							$error = "";
							$congratulations = "";
							//to check if the form is inputted
							if($_POST['do'] == 'signin'){
								//if the values are entered
								if($_POST['em'] AND $_POST['pwd']) {
									//validate the email
									if(!(filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))) {
										$error .= '<p>Incorrect email </p>';
									}
									//database connection
									$mysqli = new mysqli($servername, $username, $password, $dbname);
									if (mysqli_connect_errno()) {
										printf("Connect failed: %s\n", mysqli_connect_error());
										exit();
									}
									//query
									$sql = "SELECT people_no, first_name, email, pwd, activated FROM people WHERE email = ? AND pwd = ?";
									$enterpwd = md5($_POST['pwd']);
									if ($stmt = $mysqli->prepare($sql)) {
										$stmt->bind_param("ss",$_POST['em'], $enterpwd);
										$stmt->execute();
										$stmt->bind_result($pn,$fn,$em, $pass, $activated);
										$stmt->fetch();
										//if theres a value in the query
										if ($em) {
											//to check if the account is acctivated
											if ($activated == 0) {
												//error message
												$error .= '<p>There is an account with this email but it isnt acctivated click <a href=" ">here</a> to re send the email or click <a href="signup.php"> here</a> to sign up with a different email</p>';
											}
											else {
												//sign in
												$congratulations .= "<p>Sign in sucessfull!</p>";
												$session_kid = generateRandomString(100);

												$xmysqli = new mysqli($servername, $username, $password, $dbname);
												if (mysqli_connect_errno()) {
													printf("Connect failed: %s\n", mysqli_connect_error());
													exit();
												}
												$xsql = "UPDATE people SET session_kid = ? WHERE email = ? AND pwd = ?";
												
												//die("UPDATE people SET session_kid = '".$session_kid."' WHERE email = '".$em."' AND pwd = '".$pass."'");
												
												if ($xstmt = $xmysqli->prepare($xsql)) {
													$xstmt->bind_param("sss",$session_kid, $em,$pass);
													$xstmt->execute();
													$xstmt->fetch();
													$xstmt->close();
												}
												header("location:dashboard.php");									
												setcookie("signincookie" ,$fn);
												setcookie("acem" ,$session_kid);
											}
										} 
										else {
											$error .= '<p>incorrect username/password.</p>';
											include 'signinform.php';
										}
									$stmt->close();
									}
								}
								else {
									$error .= '<p>Please enter a correct email and password</p>';	
									include 'signinform.php';								
								}
							}	
							else {
								include 'signinform.php';
							}
						?>
					</div>
	<!--sign in-->
					<div class="col-12 col-md-6" id="signin">
						<?php 
							//print error
							if($error) {
								echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
							}
							//print congratulations
							if ($congratulations) {	
								echo $congratulations;
							}
						?>
					</div>
				</div>
			</div>
		</section>
<?php include 'footer.php';?>