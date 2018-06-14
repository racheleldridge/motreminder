<?php include 'header.php';?>
	<section id="hello">
		<div class="container">
		<?php
	
		echo '<p>Hello ' . $_COOKIE['signincookie'].'!</p>';
		?>
		</div>
	</section>
<?php include 'footer.php';?>