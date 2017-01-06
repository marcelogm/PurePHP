<?php
namespace App\View\Components;
use App\Util\DynamicHtml;
use App\Util\Helpers;
?>

<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Teller</a>
    </div>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <?php
            foreach ($items as $item):
                DynamicHtml::navbar_item($item);
            endforeach;
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if (Helpers::is_authenticated() && isset($profile)) {
                DynamicHtml::dropdown_profile($profile);
            }
            ?>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>