<?php
namespace App\Views\Layout;
?>
<!DOCTYPE html>
<html lang="en">
<?= $this->render_component('head') ?>
<body>
	<?= $this->render_component('header'); ?>

	<div class="container" style="margin-top: 60px;">
		<div class="starter-template">
			<h1>Bootstrap in PurePHP </h1>
			<p class="lead">
				<?= $this->content(); ?>
			</p>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
