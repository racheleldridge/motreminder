<?php
$title = "Annual MOT Reminder App";
$description = "The MOT reminder is an easy way to keep a track of your car MOT's. Whether you're a buisness or just want to keep a track of your family cars, this is the perfect reminder for you! You can have multiple cars and multiple reminders for each. We will send you an email when the reminder is due.";
?>
<?php include 'header.php';?>
<?php
//to move the page if there is no session cookie
	if (isset($_COOKIE['acem']))
	{
		header("location:dashboard.php");
 		exit;
	}
	?>
	<!--Description section-->
		<section id="about">
			<div class="container">
				<?php include 'about.php'?>
			</div>
		</section>
<?php include 'picture.php';?>
	<!--Both the sign up and the sign in sections-->
		<section id="sign">
			<div class="container">
				<div class="row">
	<!--sign up-->
					<div class="col-12 col-md-6" id="signup">
						<?php include 'signupform.php';?>
					</div>
	<!--sign in-->
					<div class="col-12 col-md-6" id="signin">
						<?php include 'signinform.php';?>
					</div>
				</div>
			</div>
		</section>
<?php include 'footer.php';?>