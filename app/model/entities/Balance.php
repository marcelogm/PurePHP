<?php
namespace App\Model\Entities;
use Pure\Base\BaseModel;

class Balance extends BaseModel {

    public $name;
    public $value;
    public $date;
    public $profile;

    public function __construct($name = null, $value = null, $date = null, $profile = null, $id = null) {
        $this->name = $name;
        $this->value = $value;
        $this->date = $date;
        $this->profile = $profile;
        $this->id = $id;
    }

}
