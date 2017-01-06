<?php

define('BASE_PATH', __DIR__ . '/');
require(BASE_PATH . 'pure/kernel/autoloader.php');

use Pure\Kernel\Engine;

$app = Engine::get_instance();
$app->execute();