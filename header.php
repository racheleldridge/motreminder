<!--DB-->
	<?php include 'config.php';?>
<!DOCTYPE html>
<html>
	<head>
		<!--Meta tags-->
		    <meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="A MOT reminder app">
			<meta name="author" content="Rachel Eldridge">
		<!--favicon-->
			<link rel="icon" href="images/favicon.ico">
		<!--title-->
			<title>MOT Reminder</title>
		<!--Bootstrap style-->
		    <link href="css/bootstrap.min.css" rel="stylesheet">   
		<!--Font CSS-->
			<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">			
		<!--Personal style-->
			<link href="css/style.css" rel="stylesheet">
		<!--reCAPTCHA-->
			<script src='https://www.google.com/recaptcha/api.js'></script>
		
	</head>
	<body>
	<!--Navigation-->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark re-nav">
			<h1 class="re-center"><a class="navbar-brand" href="#">The MOT Reminder</a></h1></br>
			<button class="navbar-toggler re-center re-navbutton" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><img src="images/lines.png"></span>
			</button>
			<div class="collapse navbar-collapse re-center" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">About</a>
					</li>
					<?php
						if(isset($_COOKIE['signincookie'])) {
							echo '
							<li class="nav-item">
								<a class="nav-link" href="edit.php">Edit profile</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="signout.php">Sign out</a>
							</li>';
						}
						else {
							echo '
							<li class="nav-item">
								<a class="nav-link" href="signup.php">Sign Up</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="signin.php">Sign In</a>
							</li>';
						}
					?>
				</ul>
			</div>
		</nav>