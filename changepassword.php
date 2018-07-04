<?php include 'header.php';?>
<section id="changepassword">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">				
				<?php
					//variables
					$fptp = $_POST['a'];
					$error = "";
					$congratulations = "";
					//to check if the form is inputted
					if($_POST['do'] == 'changepassword'){
						//if the values are entered 
						if($_POST['pw'] AND $_POST['cpw']) {
							$mysqli = new mysqli($servername, $username, $password, $dbname);
							//database connection
							if (mysqli_connect_errno()) {
								printf("Connect failed: %s\n", mysqli_connect_error());
								exit();
							}
							//sql query
							$sql = "SELECT first_name FROM people WHERE temp_p = ?";
							if ($stmt = $mysqli->prepare($sql)) {
								$stmt->bind_param("s", $fptp);
								$stmt->execute();
								$stmt->bind_result($fn);
								$stmt->fetch();
								$stmt->close();
								//if there is a value in the query
								if ($fn) {
									//to check if the passwords are the same
									if(!($_POST['pw'] == $_POST['cpw'])) {
										//error message
										$error .= '<p>Passwords dont match</p>';
										include 'cp.php';
									}
									else {
										//database connection
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
											//congratulations message
											$congratulations .=
											"<div class='col-12'><div class='signinsucsess'><h2>Congratulations!</h2><p>Password successfully changed.Click <a href='signin.php'>here</a> to sign in.</p></div></div>";
											$stmt->close();
										}
									}
								}
								else {
									//error message
									$error .= '<p>Please use a correct change password link</p>';
									include 'cp.php';
								}
							}
							else {
								include 'cp.php';
							}
						}
						else {
							//error message
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
				//if the congratulations message is shown
				if ($congratulations) {	
					print_r($congratulations);
				}
			?>
			<div class="col-12 col-md-6">
				<?php 
					//if there is an error it gets displays here
					if($error) {
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
					}
				?>
				<?php
					//instructions are displayed if there isnt a congratulations message
					$instructions = "<h2>Instructions</h2>
					<ol>
						<li>Enter your new password</li>
						<li>Make sure it is memorable so you can login with it</li>
						<div class='message'>
							<ul>
								<li id='length' class='invalid'>Minimum 8 characters</li>
								<li id='number' class='invalid'>A number</li>
							</ul>
						</div>
					</ol>";
					if (!($error == "") || $congratulations == "") {
						print_r($instructions);
					}
				?>
				<script>
							var password = document.getElementById("pw")
							, confirm_password = document.getElementById("cpw");
							function validatePassword(){
								if(password.value != confirm_password.value) {
									confirm_password.setCustomValidity("Passwords Don't Match");
								} 
								else {
									confirm_password.setCustomValidity('');
								}
							}
							password.onchange = validatePassword;
							confirm_password.onkeyup = validatePassword;
						</script>
						<script>
							var myInput = document.getElementById("pw");
							var number = document.getElementById("number");
							var length = document.getElementById("length");
							// When the user starts to type something inside the password field
							myInput.onkeyup = function() {  
								// Validate numbers
								var numbers = /[0-9]/g;
								if(myInput.value.match(numbers)) {  
									number.classList.remove("invalid");
									number.classList.add("valid");
								} 
								else {
									number.classList.remove("valid");
									number.classList.add("invalid");
								}
								// Validate length
								if(myInput.value.length >= 8) {
									length.classList.remove("invalid");
									length.classList.add("valid");
								} 
								else {
									length.classList.remove("valid");
									length.classList.add("invalid");
								}
							}
						</script>
			</div>
		</div>
	</div>


	
</section>
<?php include 'footer.php';?>