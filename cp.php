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
</form>