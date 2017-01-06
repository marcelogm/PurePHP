<?php
namespace App\View\Pages;
use App\Util\DynamicHtml;
?>

<div class="container-fluid">
    <br><br>
    <div class="container custom-inverse">
        <center>
            <legend>
                <h1>
                    <div class="custom-text-logo">Teller </div>
                    <small>Rápido, simples e útil.</small>
                </h1>
                <br>
            </legend>
            <hr class="featurette-divider">
            <div class="row">
                <div class="col-lg-4">
                    <?php DynamicHtml::image_circle('demo1.jpg') ?>
                    <h2>Rápido</h2>
                    <h3>
                        <small>Você cadastra todas suas despesas em poucos minutos.</small>
                    </h3>
                </div>
                <div class="col-lg-4">
                    <?php DynamicHtml::image_circle('demo2.jpg') ?>
                    <h2>Simples</h2>
                    <h3>
                        <small>Totalmente descomplicado, basta registrar e usar.</small>
                    </h3>
                </div>
                <div class="col-lg-4">
                    <?php DynamicHtml::image_circle('demo3.jpg') ?>
                    <h2>Útil</h2>
                    <h3>
                        <small>Com ele você consegue administrar suas desepesas, organizar e manter todos os seus gastos registrados.</small>
                    </h3>
                </div>
            </div>
            <hr class="featurette-divider">
        </center>
    </div>
</div>