<?php 
namespace App\Views\Layout;
?>

<!DOCTYPE html>
<html lang="en">
	<?= $this->render_component('head') ?>
<body>
    <div class="container-fluid">
		<?= $this->render_component('header'); ?>
    </div>
	<?= $this->content(); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
