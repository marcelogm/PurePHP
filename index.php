<?php
namespace App;
/**
 * Define constantes básicas utilizadas no projeto.
 */
define('BASE_PATH', __DIR__.'/');

/**
 * Inicia autoloader responsável por transformar os
 * "use" em importação para o projeto.
 */
require(BASE_PATH . 'pure/kernel/Autoloader.php');

/**
 * Inicia motor do framework.
 */
use Pure\Kernel\Engine;
$app = Engine::get_instance();
$app->execute();