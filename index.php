<?php
define('BASE_PATH', __DIR__ . '/');
define('PURE_DEBUG', true);
define('PURE_ENV', 'development');
require(BASE_PATH . 'app/configs/env/environment.php');
require(BASE_PATH . 'pure/kernel/autoloader.php');

use Pure\Kernel\Engine;

$app = Engine::get_instance();
$app->execute();