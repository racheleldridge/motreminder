<?php
//gets rid of the cookies
if (isset($_COOKIE['signincookie'])) {
		setcookie("acem" ,'', time() - 3600);
		setcookie('signincookie', '', time() - 3600);
		unset($_COOKIE['signincookie']);
		unset($_COOKIE['acem']);
		echo "<div id='signout' class='signinsucsess'><p>You have successfully signed out of your account</p>
		<p>Click <a href='index.php'>here</a> to go to the home page</p></div>";
	}
?>
<?php include 'header.php';?>
<section id="signout">
<div></div>
</section>
<?php include 'footer.php';?>