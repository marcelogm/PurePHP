<?php

namespace App\Util;

class SessionManager {

    private static $instance = null;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new SessionManager();
            session_start();
        }
        return self::$instance;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function wipe($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
        return null;
    }

    public function contains($key) {
        return isset($_SESSION[$key]);
    }

    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function destroy() {
        session_destroy();
    }

}
