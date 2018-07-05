<!--the edit form-->
<form action="edit.php" method="post">
	<input type="hidden" value="edit" name="do" />
		<h3>Edit your details</h3>
		<div class="form-group">
			<label for="fn">First name</label>
			<input type="text" name='fn' class="form-control" id="fn" placeholder="<?php echo $fn; ?>">
		</div>
		<div class="form-group">
			<label for="ln">Last name</label>
			<input type="text" name='ln' class="form-control" id="ln" placeholder="<?php echo $ln; ?>">
		</div>
		<div class="form-group">
			<label for="em">Email</label>
			<input type="text" name='em' class="form-control" id="em" placeholder="<?php echo $em; ?>">
		</div>
		<button type="submit" class="btn re-button">Update profile</button>
</form>