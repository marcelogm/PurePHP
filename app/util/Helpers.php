<?php
namespace App\Util;
use Pure\Kernel\Engine;
use App\Model\Entities\Person;
use App\Util\SessionManager;
use App\Model\Facade;
use App\Util\PasswordManager;
use App\Model\Entities\Balance;
use DateTime;

class Helpers {

    public static function redirect($route) {
        header('location: ' . DOMAIN . $route);
    }

    public static function is_request_from($routes = []) {
        $engine = Engine::get_instance();
        $atual = $engine->get_requested_route();
        foreach ($routes as $route) {
            if ($atual->equals($route)) {
                return true;
            }
        }
        return false;
    }

    public static function is_authenticated() {
        $session = SessionManager::getInstance();
        return !($session->get('user_id') == false);
    }

    public static function authenticate($email, $secret) {
        $f = Facade::get_instance();
        $profile = $f->select_person_by_email($email);
        if ($profile != null) {
            $pass = $f->select_password($profile->password);
            $pmanager = PasswordManager::getInstance();
            if ($pmanager->retrievePassword($secret, $pass) && $profile->activated) {
                Helpers::set_login($profile);
                return true;
            }
        }
        return false;
    }

    public static function validade_name($name) {
        $regex = '~^([a-z0-9]+,)+$~i';
        return (preg_match($regex, $name) && strlen($name) > 1);
    }

    public static function validade_email($email) {
        return (strlen($email) > 5);
    }

    public static function is_email_registered($email) {
        $f = Facade::get_instance();
        $user = $f->select_person_by_email($email);
        return ($user->email == $email);
    }

    public static function validade_password($pass, $repass) {
        return (strlen($pass) > 4);
    }

    public static function registrate($name, $email, $pass) {
        $f = Facade::get_instance();
        $pmanager = PasswordManager::getInstance();
        $hash = $pmanager->generatePassword($pass);
        $f->save_password($hash);
        $passFromDb = $f->select_password_by_hash($hash->password);
        $user = new Person($name, $email, '', null, $passFromDb->id, true);
        $userId = $f->save_person($user);
    }

    public static function get_balance_from_POST() {
        $params = ParamsManager::get_instance();
        $session = SessionManager::getInstance();
        $name = $params->from_POST('i_name');
        $value = $params->from_POST('i_value');
        $date = $params->from_POST('i_date');
        $type = $params->from_POST('i_type');
        $profile = $session->get('user_id');
        if ($name != null && $value != null && $date != null && $profile != null && $type != null) {
            if ($type == 'Debito') {
                $value = -$value;
            }
            $balance = new Balance(
                    $name, $value, Helpers::parse_date($date), $profile);
            return $balance;
        }
        return null;
    }

    public static function parse_date($date) {
        $date = DateTime::createFromFormat('d/m/Y', $date);
        return $date->format('Y-m-d');
    }

    public static function display_date($date) {
        $date = DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('d/m/Y');
    }

    public static function parse_month($date) {
        $date = DateTime::createFromFormat('d/m/Y', '01/' . $date);
        return $date->format('Y-m-d');
    }

    public static function display_month($date) {
        $date = DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('m/Y');
    }

    private static function set_login(Person $profile) {
        $session = SessionManager::getInstance();
        $session->set('user_id', $profile->id);
        $session->set('user_name', $profile->name);
        $session->set('user_info', $profile);
    }
}