	<h2>Sign In</h2>
	<!-- this form is for the change sign in page-->
	<form action="signin.php" method="post">
		<input type="hidden" value="signin" name="do" />
		<div class="form-group">
			<label for="Email">Email address</label>
			<input type="email" name='em' class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email" required>
		</div>
		<div class="form-group">
			<label for="Password">Password</label>
			<input type="password" name="pwd" class="form-control" id="Password" placeholder="Password" required>
			<!--<div class="g-recaptcha" data-sitekey="6Lf8EFwUAAAAAPQhbIInFYeP9KkbrGs5aHGPOswp" required></div>-->
		</div>
		<div class="row">
			<div class="col-6">
				<button type="submit" class="btn re-button">Sign in</button>
			</div>
			<div class="col-6">
				<a href="forgotpassword.php"><p>Forgotten Password</p></a>
			</div>
		</div>
	</form>