<?php
namespace App\View\Compoments;
use App\Util\DynamicHtml;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Teller - Rápido, simples e útil.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://momentjs.com/downloads/moment.js"></script>
        <?= DynamicHtml::script('bootstrap.min.js') ?>
        <?= DynamicHtml::script('custom.js') ?>
        <?= DynamicHtml::script('bootstrap-datetimepicker.min.js') ?>
        <?= DynamicHtml::link_boostrap(); ?>
        <?= DynamicHtml::link_css('custom.css'); ?>
        <?= DynamicHtml::link_css('bootstrap-datetimepicker.css'); ?>
        <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet"> 
    </head>
    <body>