<?php
namespace App\Util;

class ParamsManager {

    private static $instance = null;
    private $MAX_INTERATIONS = 10000;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new ParamsManager();
        }
        return self::$instance;
    }

    public function from_POST($key) {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return false;
    }

    public function from_GET($key) {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return false;
    }

    public function get($key) {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } else if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return false;
    }

    public function contains($key) {
        return (isset($_GET[$key]) || isset($_POST[$key]));
    }

}
