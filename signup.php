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
							if($_POST['do'] == 'signup'){
								if($_POST['fn'] AND $_POST['ln'] AND $_POST['em'] AND $_POST['pw'] AND $_POST['cpw'] {
									if(!(filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))) {
										$error .= 'Incorrect email';
									}
									if(!($_POST['pw'] == $_POST['cpw'])) {
										$error .= 'Passwords dont match';
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
										//echo $activated."xxx";
										if ( $em) {
											if ($activated == 0) {
												$error .= "there is an account that has the email but isnt activated";
											}
											else {
												$error .= "there is an account that has the email - sign in";
											}
											include 'signupform.php';
										} 
										else {
											$stmt = $mysqli->prepare("INSERT INTO people (first_name, last_name,email,pwd,activation_code) VALUES (?, ?, ?, ?, ?)");
											$stmt->bind_param("sssss", $_POST['fn'], $_POST['ln'],$_POST['em'],$_POST['pw'],generateRandomString(50));
											$stmt->execute();
											echo "<h2>Congratulation</h2><P>Your account was created successfully. Please check your emails and click on the activation link to activate your account</p>";
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
					<div class="col-12 col-md-6" id="signin">
						<h2>Instructions</h2>
						<?php 
						if($error) {
							echo "<div style=\"padding:10px 0px; color:red; font-weight:600;\"><h3>Oops!</h3>".$error."</div>";;
						}
						?>
						<ol>
							<li>Complete all the fields</li>
							<li>Make sure you enter the correct email address. We will send an activation email to you to complete your registration.</li>
						</ol>
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