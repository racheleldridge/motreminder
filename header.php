<!--DB-->
<?php 
	ob_start();
	include 'config.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<!--Meta tags-->
		    <meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="<?php echo $description;?>">
			<meta name="keywords" content="HTML,CSS,PHP,MOT,MOT reminder,reminder">
			<meta name="author" content="Rachel Eldridge">
		<!--favicon-->
			<link rel="icon" href="images/favicon.ico">
		<!--title-->
			<title><?php echo $title;?></title>
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
		<?php
			if(isset($_COOKIE['signincookie'])) {
				echo "<a class='navbar-brand' href='index.php'><h3 class='re-center'>Hello ". $_COOKIE['signincookie']."!</h3></a></br>";
			}
			else {
				echo "<h3 class='re-center'><a class='navbar-brand' href='index.php'>The MOT Reminder</a></h3></br>";
			}	
		?>
			<button class="navbar-toggler re-center re-navbutton" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><img src="images/lines.png"></span>
			</button>
			<div class="collapse navbar-collapse re-center" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<?php
						//if the cookie is there
						if(isset($_COOKIE['signincookie'])) {
							echo '
							<li class="nav-item">
								<a class="nav-link" href="dashboard.php">Dashboard</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="aboutpage.php">About</a>
							</li>
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
								<a class="nav-link" href="index.php">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="index.php#about">About</a>
							</li>
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