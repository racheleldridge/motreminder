	<h2>Sign Up</h2>
	<form action="signup.php" method="post">
		<input type="hidden" value="signup" name="do" />
		<div class="form-group">
			<label for="FirstName">First name *</label>
			<input type="text" class="form-control" placeholder="First name" id="fn" name="fn" value="<?php echo $_POST[fn];?>" required>
		</div>
		<div class="form-group">
			<label for="LastName">Last name *</label>
			<input type="text" class="form-control" placeholder="Last name" name="ln" value="<?php echo $_POST[ln];?>"required>
		</div>
		<div class="form-group">
			<label for="Email">Email address *</label>
			<input type="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email" name="em" required>
		</div>
		<div class="form-group">
			<label for="Password">Password *</label>
			<input type="password" class="form-control" id="Password" placeholder="Password" name="pw" required>
		</div>
		<div class="form-group">
			<label for="ConfirmPassword">Confirm Password *</label>
			<input type="password" class="form-control" id="Password" placeholder="Confirm Password" name="cpw" required>
		</div>
		<div class="g-recaptcha" data-sitekey="6Lf8EFwUAAAAAPQhbIInFYeP9KkbrGs5aHGPOswp" required></div>
		<div class="row">
			<div class="col-6">
				<button type="submit" class="btn re-button" name="submit" value="submit">Sign up</button>
			</div>
			<div class="col-6">
				<p>* required feilds</p>
			</div>
		</div>
	</form>