<?php include 'header.php';?>
<?php
	if (isset($_COOKIE['signincookie'])) {
		setcookie('signincookie', '', time() - 3600);
		unset($_COOKIE['signincookie']);
		echo "<div id='signout' class='signinsucsess'><p>You have successfully signed out of your account</p>
		<p>Click <a href='index.php'>here</a> to go to the home page</p></div>";
	}
?>
<?php include 'footer.php';?>