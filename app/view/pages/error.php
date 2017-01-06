<?php
namespace App\View\Pages;
use App\Util\DynamicHtml;
?>

<div class="jumbotron">
    <div class="container">
        <div class="col-md-offset-2 col-md-8 text-center">
            <h2>
                Ops! Essa página não existe :(
                <br>
                <small>Está perdido?</small>
            </h2>
            <p>
                <a class="btn btn-primary btn-lg custom-btn-color" href="<?= DynamicHtml::link_to('') ?>">Leve-me para a home!</a>
            </p>
        </div>
    </div>
</div>
