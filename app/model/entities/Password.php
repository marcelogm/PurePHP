<?php
namespace App\Model\Entities;
use Pure\Base\BaseModel;

class Password extends BaseModel {

    public $password;
    public $salt;
    public $iterations;

    public function __construct($pass = null, $salt = null, $iterations = null, $id = null) {
        $this->password = $pass;
        $this->salt = $salt;
        $this->iterations = $iterations;
        $this->id = $id;
    }

}
