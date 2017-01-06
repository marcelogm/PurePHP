<?php
namespace App;

define('BASE_PATH', __DIR__.'/');
require(BASE_PATH . 'pure/kernel/Autoloader.php');

use Pure\Kernel\Engine;

$app = Engine::get_instance();
