<?php include 'header.php';?>
	<section id="hello">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-6">
					<?php
						//shows name
						echo '<h2>Hello ' . $_COOKIE['signincookie'].'!</h2>';
					?>
				</div>
				<div class="col-12 col-md-6">
					<div class="row">
						<div class="col-12">
							<?php include 'addcarform.php';?>
						</div>
						<div class="col-12">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include 'footer.php';?>