<h2>Forgotten Password</h2>
<!--this form is for the forgotten password page-->
<form action="forgotpassword.php" method="post">
	<input type="hidden" value="forgotpassword" name="do" />
	<div class="form-group">
		<label for="Email">Email address</label>
		<input type="email" name='em' class="form-control" id="em" aria-describedby="emailHelp" placeholder="Enter email" required>
	</div>
	<!--<div class="g-recaptcha" data-sitekey="6Lf8EFwUAAAAAPQhbIInFYeP9KkbrGs5aHGPOswp" required></div>-->
	<button type="submit" class="btn re-button">Submit</button>
</form>
			
