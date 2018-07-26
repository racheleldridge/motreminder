<!--access the dvla--> 
<?php
	
	$myreg  = preg_replace('/[^a-zA-Z0-9]/','',$_POST['cr']);
	$errors = array();
	$jsonout = array();
	if (strlen($myreg)>2 AND $_POST['do'] == "getdvla") {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,ROOTURL."?registration=".$myreg);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","x-api-key:".APIKEY));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		if (curl_errno($ch))   {
			$error['errors'] = 'ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
		} 
		else {
			if (stripos($response,"errorMessage") === false) {
				$jsonout = json_decode($response);
				$iok = "ok";
			} else {
				$ierror = "<h5 class=\"error\">Invalid car registration</h5>";
			}
		}
		curl_close($ch);
	}
?>
<div class="row">
	<div class="col-6">
	<!--add car form-->
		<form action="dashboard.php" method="post">
			<input type="hidden" name="do" value="<?=($_POST['do'] == "getdvla" AND $iok == "ok")?"addcar":"getdvla";?>" />
			<input type="hidden" name="dataout" value="<?=base64_encode(serialize($jsonout));?>" />
			<h3>Add a Car:</h3>
			<?=$ierror;?>
			<div class="form-group">
				<label for="cr">Car Registration</label>
				<input type="text" name='cr' class="form-control" id="cr" placeholder="Car Registration" value="<?=$jsonout[0]->registration;?>" required <?=($_POST['do'] == "getdvla" AND $iok == "ok")?" readonly":"";?>>
			</div>
	</div>
	<div class="col-6">
	<!--if the form comes back okay-->
		<?php if ($iok == "ok") { ?>
			<div class="form-group">
				<p class="lead">If the information below if correct, please select a reminder timescale and click add car.</p>
				<table class="table table-sm">
					<tr><th>Car make</th><td><?=$jsonout[0]->make;?></td></tr>
					<tr><th>Car model</th><td><?=$jsonout[0]->model;?></td></tr>
					<tr><th>Car colour</th><td><?=$jsonout[0]->primaryColour;?></td></tr>
					<tr><th>Last MOT date</th><td><?=$jsonout[0]->motTests[0]->completedDate;?></td></tr>
					<tr><th>MOT Status</th><td><?=$jsonout[0]->motTests[0]->testResult;?></td></tr>
					<tr><th>Last MOT mileage</th><td><?=$jsonout[0]->motTests[0]->odometerValue;?></td></tr>
					<tr><th>MOT due date</th><td><?=$jsonout[0]->motTests[0]->expiryDate;?></td></tr>
				</table>
			</div>
			<div class="form-group">
				<label for="rd">How many days before do you want to be reminded?</label>
				<select name="rd" id="rd">
					<option value="1 week">1 Week</option>
					<option value="2 weeks">2 Weeks</option>
					<option value="1 month">1 Month</option>
				</select>
			</div>
		<?php } ?>		
		<button type="submit" class="btn re-button"><?=($_POST['do'] == "getdvla" AND $iok == "ok")?"Add Car":"Check Car Details";?></button>
	</div>
</div>
</form>