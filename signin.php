<?php include 'header.php';?>
<?php include 'picture.php';?>
	<!--Both the sign up and the sign in sections-->
		<section id="sign">
			<div class="container">
				<div class="row">
	<!--sign in-->
					<div class="col-12 col-md-6" id="signin">
						<?php 
							$error = "";
							$congratulations = "";
							if($_POST['do'] == 'signin'){
								if($_POST['em'] AND $_POST['pwd']) {
									if(!(filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))) {
										$error .= '<p>Incorrect email </p>';
									}
									$mysqli = new mysqli($servername, $username, $password, $dbname);
									if (mysqli_connect_errno()) {
										printf("Connect failed: %s\n", mysqli_connect_error());
										exit();
									}
									$sql = "SELECT people_no, first_name, email, pwd, activated FROM people WHERE email = ? AND pwd = ?";
									$enterpwd = md5($_POST['pwd']);
									if ($stmt = $mysqli->prepare($sql)) {
										$stmt->bind_param("ss",$_POST['em'], $enterpwd);
										$stmt->execute();
										$stmt->bind_result($pn,$fn,$em, $pass, $activated);
										$stmt->fetch();
										if ($em) {
											if ($activated == 0) {
												$error .= '<p>There is an account with this email but it isnt acctivated click <a href=" ">here</a> to re send the email or click <a href="signup.php"> here</a> to sign up with a different email</p>';
											}
											else {
												$congratulations .= "<p>Sign in sucessfull!</p>";
												setcookie("signincookie" ,$fn);
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
													$xstmt->bind_result();
													$xstmt->fetch();
													$xstmt->close();
												}
												setcookie("acem" ,$session_kid);
												header("location:dashboard.php");
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
							if($error) {
								echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
							}
							if ($congratulations) {	
								echo $congratulations;
							}
						?>
					</div>
				</div>
			</div>
		</section>
<?php include 'footer.php';?>