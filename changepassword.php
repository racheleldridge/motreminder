<?php include 'header.php';?>
<section id="changepassword">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">				
				<?php
					$fptp = $_POST['a'];
					$error = "";
					$congratulations = "";
					if($_POST['do'] == 'changepassword'){
						if($_POST['pw'] AND $_POST['cpw']) {
							$mysqli = new mysqli($servername, $username, $password, $dbname);
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}
							$sql = "SELECT first_name FROM people WHERE temp_p = ?";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("s", $fptp);
								$stmt->execute();
								$stmt->bind_result($fn);
								$stmt->fetch();
								$stmt->close();
								if ($fn) {
									if(!($_POST['pw'] == $_POST['cpw'])) {
										$error .= '<p>Passwords dont match</p>';
										include 'cp.php';
									}
									else {
										$mysqli = new mysqli($servername, $username, $password, $dbname);
										if (mysqli_connect_errno()) {
											printf("Connect failed: %s\n", mysqli_connect_error());
											exit();
										}
										$newpassword = md5($_POST['pw']);
										$sql = "UPDATE people SET pwd = ? WHERE temp_p = ?";
										if ($stmt = $mysqli->prepare($sql)) {
											$stmt->bind_param("ss",$newpassword, $fptp);
											$stmt->execute();
											$stmt->fetch();
											$congratulations .= "<div class='col-12'><div class='signinsucsess'><h2>Congratulations!</h2><p>Password successfully changed.Click <a href='signin.php'>here</a> to sign in.</p></div></div>";
											$stmt->close();
										}
									}
								}
								else {
									$error .= '<p>Please use a correct change password link</p>';
									include 'cp.php';
								}
							}
							else {
								include 'cp.php';
							}
						}
						else {
							$error .= '<p>Please enter the all the feilds</p>';
							include 'cp.php';
						}
					}
					else {
						//if the form isnt sent
						include 'cp.php';
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
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
					}
				?>
				<?php
					$instructions = "<h2>Instructions</h2>
					<ol>
						<li>Enter your new password</li>
						<li>Make sure it is memorable so you can login with it</li>
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