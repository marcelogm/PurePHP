<?php
namespace App\Util;
use App\Model\Entities\Password;

class PasswordManager {

    private static $instance = null;
    private static $MAX_INTERATIONS = 10000;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PasswordManager();
        }
        return self::$instance;
    }

    public function retrievePassword($secret, Password $pass) {
        $secret .= $pass->salt;
        $hash = $this->hashing($secret, $pass->iterations);
        return ($hash === $pass->password);
    }

    public function generatePassword($secret) {
        $pass = new Password();
        $iterations = rand(0, self::$MAX_INTERATIONS);
        $pass->iterations = $iterations;
        $salt = rand();
        $pass->salt = $salt;
        $secret .= $salt;
        $pass->password = ($this->hashing($secret, $iterations));
        return $pass;
    }

    public function hashing($secret, $iterations) {
        try {
            for ($i = 0; $i < $iterations; $i++) {
                $secret = hash('sha256', $secret);
            }
            return $secret;
        } catch (Exception $e) {
            echo $e;
        }
        return null;
    }

}
