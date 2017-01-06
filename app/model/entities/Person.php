<?php
namespace App\Model\Entities;
use Pure\Base\BaseModel;

class Person extends BaseModel {

    public $name;
    public $nickname;
    public $email;
    public $image_url;
    public $password;
    public $activated;

    public function __construct($name, $email, $nickname = null, $image_url = null, $password = null, $activated = false, $id = null, $created_at = null, $updated_at = null) {
        $this->name = $name;
        $this->email = $email;
        $this->id = $id;
        $this->nickname = $nickname;
        $this->image_url = $image_url;
        $this->password = $password;
        $this->activated = $activated;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

}
