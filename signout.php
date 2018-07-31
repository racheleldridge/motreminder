<?php
$title = "Sign out - Annual MOT Reminder App";
$description = "The MOT reminder is an easy way to keep a track of your car MOT's. Whether you're a buisness or just want to keep a track of your family cars, this is the perfect reminder for you! You can have multiple cars and multiple reminders for each. We will send you an email when the reminder is due.";
?>
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