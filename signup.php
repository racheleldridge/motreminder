<?php include 'header.php';?>


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
						<h2>Please complete form</h2>
<?php 
	if($_POST['fn'] AND $_POST['ln'] AND $_POST['em'] AND filter_var($_POST['em'], FILTER_VALIDATE_EMAIL)) {
		echo 'you entered the details';
		if(!($_POST['pw'] == $_POST['cpw'])) {
			
			echo 'Passwords dont match';
		}
	}

?>						
						<p>yutyutu</p>
						<!--
						<?php print_r($_POST); ?>
						<hr />
						<?php var_dump($_POST); ?>
						-->
					</div>
				</div>
			</div>
		</section><?php include 'footer.php';?>
		
		