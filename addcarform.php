<form action="dashboard.php" method="post">
	<input type="hidden" value="addcar" name="do" />
		<h3>Add a Car:</h3>
		<div class="form-group">
			<label for="cr">Car Registration</label>
			<input type="text" name='cr' class="form-control" id="cr" placeholder="Car Registration" required>
		</div>
		<div class="form-group">
			<label for="rd">How many days before you want to be reminded?</label>
			<select name="rd">
				<option value="1week">1 Week</option>
				<option value="2week">2 Weeks</option>
				<option value="1month">1 Month</option>
			</select>
		</div>
		<button type="submit" class="btn re-button">Add Car</button>
</form>