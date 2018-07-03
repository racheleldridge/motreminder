<?php include 'header.php';?>
<section id="edit">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<?php 
					$mysqli = new mysqli($servername, $username, $password, $dbname);
					if (mysqli_connect_errno()) {
						printf("Connect failed: %s\n", mysqli_connect_error());
						exit();
					}
					//query
					$sql = "SELECT first_name, last_name, email FROM people WHERE session_kid = ?";
					if ($stmt = $mysqli->prepare($sql)) {
						$stmt->bind_param("s",$_COOKIE['acem']);
						$stmt->execute();
						$stmt->bind_result($fn,$ln,$em);
						$stmt->fetch();
						//variables
						$error = "";
						$congratulations = "";
						//to check if the form is inputted
						if($_POST['do'] == 'edit'){
							//if the values are entered
							if($_POST['fn'] OR $_POST['ln'] OR $_POST['em']) {
								//validate the email
								if($_POST['fn']) {
									$fn = $_POST['fn'];
								}
								if($_POST['ln']) {
									$ln = $_POST['ln'];
								}
								if($_POST['em']) {
									if(!(filter_var($_POST['em'], FILTER_VALIDATE_EMAIL))) {
										$error .= '<p>Incorrect email</p>';
									}
									$em = $_POST['em'];
								}
								//database connection
								$mysqli = new mysqli($servername, $username, $password, $dbname);
								if (mysqli_connect_errno()) {
									printf("Connect failed: %s\n", mysqli_connect_error());
									exit();
								}
								//query
								$sql = "SELECT email, session_kid FROM people WHERE email = ?";
								if ($stmt = $mysqli->prepare($sql)) {
									$stmt->bind_param("s",$_POST['em']);
									$stmt->execute();
									$stmt->bind_result($email, $sk);
									$stmt->fetch();
									//if the email is in the database and is not that account
									if($email AND $sk != $_COOKIE['acem']) {
										$error .= '<p>Email already exsists</p>';
										include "editform.php";
									}
									else {
										$mysqli = new mysqli($servername, $username, $password, $dbname);
										if (mysqli_connect_errno()) {
											printf("Connect failed: %s\n", mysqli_connect_error());
											exit();
										}
										//query
										$sql = "UPDATE people 
											SET first_name = ?, last_name = ?, email = ?
											WHERE session_kid = ?";
										if ($stmt = $mysqli->prepare($sql)) {
											$stmt->bind_param("ssss",$fn,$ln,$em,$_COOKIE['acem']);
											$stmt->execute();
											$stmt->fetch();
											//if theres a value in the query
											$congratulations = "<div class='col-12'><div class='signinsucsess'><P>Account updated</p></div></div>";
											$stmt->close();
										}
									}
								}
							}
						}
						else {
							//input information
							include 'editform.php';
						}
					}
					else {
						//when the form isnt inputted
						include 'editform.php';								
					}
				?>
			</div>
			<?php 
			if ($congratulations) {	
				echo $congratulations;
			}
			?>
			<div class="col-12 col-md-6">
				<?php
					if($error) {
						echo "<div class='re-error'><h3>Oops!</h3>".$error."</div>";
					}
					$instructions = "<h2>Instructions</h2><ol><li>Complete the fields you want to change</li><li>Make sure you enter the correct details</li></ol>";
					if (!($error == "") || (!($congratulations))) {
						echo $instructions;
					}
				?>
			</div>
		</div>
	</div>
</section>
<?php include 'footer.php';?>