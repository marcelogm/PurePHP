<?php
namespace App;
/**
 * Define constantes básicas utilizadas no projeto.
 */
define('BASE_PATH', __DIR__.'/');
define('DOMAIN', 'http://localhost/');
/**
 * Inicia autoloader responsável por transformar os 
 * "use" em importação para o projeto.
 */
require(BASE_PATH.'/pure/kernel/Autoloader.php');

/**
 * Inicia motor do framework.
 */
use Pure\Kernel\Engine;
$engine = Engine::get_instance();
$engine->begin();

// Olá desenvolvedores!
// Para o site funcionar bem é necessário modificar alguns arquivos
//
// define('DOMAIN', 'http://localhost/');
// É importante colocar o DOMAIN com / no final
//
// De igual forma, é necessário modificar a variavel DOMAIN no arquivo
// app/view/stylesheets/js/custom.js 
//
// var DOMAIN = "http://localhost/";
//
// E por último, as configurações do banco de dados 
// ficam no arquivo app/configs/Config.php 
// 
// A exportação do banco de dados está no arquivo teller.sql,
// na raiz do projeto.