<form action="dashboard.php" method="post">
	<input type="hidden" value="forgotpassword" name="do" />
	<div class="row">
		<div class="col-9">
			<div class="form-group">
				<!--<label for="car_reg">Car Registration</label>-->
				<input type="text" name='cr' class="form-control" id="cr" placeholder="Enter car Registration" required>
			</div>
		</div>
		<div class="col-3">
			<button type="submit" class="btn re-button">Add Car</button>
		</div>
	</div>
</form>