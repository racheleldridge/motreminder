<?php include 'header.php';?>
	<!--Description section-->
		<section id="description">
			<div class="container">
				<div>
					<h1>What do we do?</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel consectetur tortor. Nunc massa mi, sollicitudin eu massa eu, tempor tempor dui. Cras sed placerat ex, ut tincidunt ligula. Sed rhoncus, tortor sed condimentum cursus, lorem sem maximus leo, ut imperdiet augue mauris nec dolor. Vestibulum porta vestibulum eros, eu rhoncus erat. In laoreet eros id dui cursus consequat. Vivamus ultricies vestibulum odio vel varius. Ut vestibulum nisi a massa semper efficitur. In ac fermentum lorem, ac tristique ligula.</p>
				</div>
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