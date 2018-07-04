<h2>Change password</h2>
<!--this form is for the change password page-->
<form action="changepassword.php" method="post">
	<input type="hidden" value="changepassword" name="do" />
	<input type="hidden" value="<?php echo $_REQUEST['a'];?>" name="a" />
		<div class="form-group">
			<label for="Password">New Password</label>
			<input type="password" class="form-control" id="pw" placeholder="Password" name="pw" pattern="(?=.*\d)(?=.*[a-z]).{8,}" required>
		</div>
		<div class="form-group">
			<label for="ConfirmPassword">Confirm New Password</label>
			<input type="password" class="form-control" id="cpw" placeholder="Confirm Password" name="cpw" required>
		</div>
	<button type="submit" class="btn re-button" name="submit" value="submit">Reset Password</button>
	<div id="message">
		<h3>Password must contain the following:</h3>
		<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
		<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
		<p id="number" class="invalid">A <b>number</b></p>
		<p id="length" class="invalid">Minimum <b>8 characters</b></p>
	</div>
</form>