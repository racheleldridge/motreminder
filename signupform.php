	<h2>Sign Up</h2>
	<form action="signup.php" onsubmit="validatePassword()" method="post">
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
			<input type="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email" name="em" value="<?php echo $_POST[em];?>" required>
		</div>
		<div class="form-group">
			<label for="Password">Password *</label>
			<input type="password" class="form-control" id="pw" placeholder="Password" name="pw" pattern="(?=.*\d)(?=.*[a-z]).{8,}" required>
		</div>
		<div class="form-group">
			<label for="ConfirmPassword">Confirm Password *</label>
			<input type="password" class="form-control" id="cpw" placeholder="Confirm Password" name="cpw" required>
		</div>
		<script>
			var password = document.getElementById("pw")
			, confirm_password = document.getElementById("c");

			function validatePassword(){
				if(password.value != confirm_password.value) {
					confirm_password.setCustomValidity("Passwords Don't Match");
				} 
				else {
					confirm_password.setCustomValidity('');
				}
			}

			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		</script>
		<!-- <div class="g-recaptcha" data-sitekey="6Lf8EFwUAAAAAPQhbIInFYeP9KkbrGs5aHGPOswp" required></div> -->
		<div class="row">
			<div class="col-6">
				<button type="submit" class="btn re-button" name="submit" value="submit">Sign up</button>
			</div>
			<div class="col-6">
				<p>* required feilds</p>
			</div>
		</div>
		<div id="message">
			<h3>Password must contain the following:</h3>
			<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
			<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
			<p id="number" class="invalid">A <b>number</b></p>
			<p id="length" class="invalid">Minimum <b>8 characters</b></p>
		</div>
	</form>
	<script>
var myInput = document.getElementById("Password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
