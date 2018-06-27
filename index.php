<?php include 'header.php';?>
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