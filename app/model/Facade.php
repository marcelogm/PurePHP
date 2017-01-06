<?php
namespace App\Model;
use App\Model\Entities\Person;
use App\Model\Entities\Password;
use App\Model\Entities\Balance;
use App\Model\Repository\PasswordRepository;
use App\Model\Repository\PeopleRepository;
use App\Model\Repository\BalanceRepository;

class Facade {

    private static $instance = null;
    private $people_rep;
    private $pass_rep;
    private $balance_rep;

    private function __construct() {
        $this->people_rep = new PeopleRepository();
        $this->pass_rep = new PasswordRepository();
        $this->balance_rep = new BalanceRepository();
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new Facade();
        }
        return self::$instance;
    }

    public function save_person(Person $person) {
        $this->people_rep->save($person);
    }

    public function select_person($id) {
        return $this->people_rep->select($id);
    }

    public function select_person_by_email($email) {
        return $this->people_rep->select_by_email($email);
    }

    public function save_password(Password $pass) {
        $this->pass_rep->save($pass);
    }

    public function select_password($id) {
        return $this->pass_rep->select($id);
    }

    public function select_password_by_hash($hash) {
        return $this->pass_rep->selectByHash($hash);
    }

    public function save_balance(Balance $balance) {
        $this->balance_rep->save($balance);
    }

    public function delete_balance($id) {
        $this->balance_rep->delete($id);
    }

    public function select_balance($id) {
        return $this->balance_rep->select($id);
    }

    public function select_balance_offset($profile, $limit = 5, $offset = 1) {
        return $this->balance_rep->select_desc_offset($profile, $limit, $offset);
    }

    public function get_day_sum_from($id, $day) {
        return $this->balance_rep->select_day_sum_from($id, $day);
    }

    public function get_month_sum_from($id, $month) {
        return $this->balance_rep->select_month_sum_from($id, $month);
    }

    public function get_period_sum_from($id, $begin, $end) {
        return $this->balance_rep->select_period_sum_from($id, $begin, $end);
    }

    public function count_day_from($id, $day) {
        return $this->balance_rep->count_day_from($id, $day);
    }

    public function count_month_from($id, $month) {
        return $this->balance_rep->count_month_from($id, $month);
    }

    public function count_period_from($id, $begin, $end) {
        return $this->balance_rep->count_period_from($id, $begin, $end);
    }

    public function select_balance_for_period($id, $begin, $end, $limit = 5, $offset = 1) {
        return $this->balance_rep->select_period_from($id, $begin, $end, $limit, $offset);
    }

    public function select_balance_for_month($id, $month, $limit = 5, $offset = 1) {
        return $this->balance_rep->select_month_from($id, $month, $limit, $offset);
    }

    public function select_balance_for_day($id, $month, $limit = 5, $offset = 1) {
        return $this->balance_rep->select_day_from($id, $month, $limit, $offset);
    }

}
