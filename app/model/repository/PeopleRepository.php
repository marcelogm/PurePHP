<?php
namespace App\Model\Repository;
use Pure\Base\BaseRepository;
use App\Model\Entities\Person;
use PDO;

class PeopleRepository extends BaseRepository {

    public function save(Person $person) {
        try {
            $query = $this->conn->prepare('INSERT INTO `tbl_profile` (`created_at`,'.
                    '`updated_at`,' .
                    '`activated`,' .
                    '`email`,' .
                    '`image_url`,' .
                    '`name`,' .
                    '`nickname`,' .
                    '`password_id`' .
                    ') VALUES (NOW(), NOW(), :activated, :email, :image, :name, :nick, :pass);');
            $query->bindParam(':activated', $person->activated, PDO::PARAM_BOOL);
            $query->bindParam(':email', $person->email, PDO::PARAM_STR);
            $query->bindParam(':image', $person->image_url, PDO::PARAM_STR);
            $query->bindParam(':name', $person->name, PDO::PARAM_STR);
            $query->bindParam(':nick', $person->nickname, PDO::PARAM_STR);
            $query->bindParam(':pass', $person->password, PDO::PARAM_INT);
            if ($query->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $ex) {
            echo 'Erro: save person';
        }
        return false;
    }

    public function update(Person $person) {
        try {
            $query = $this->conn->prepare('UPDATE `tbl_profile` SET '.
                    '`updated_at` = NOW(), ' .
                    '`activated` = :activated, ' .
                    '`email` = :email, ' .
                    '`image_url` = :image, ' .
                    '`name` = :name, ' .
                    '`nickname` = :nick, ' .
                    '`password_id` = :pass WHERE `id` = :id;');
            $query->bindValue(':activated', ($person->activated == true), PDO::PARAM_BOOL);
            $query->bindParam(':email', $person->email, PDO::PARAM_STR);
            $query->bindParam(':image', $person->image_url, PDO::PARAM_STR);
            $query->bindParam(':name', $person->name, PDO::PARAM_STR);
            $query->bindParam(':nick', $person->nickname, PDO::PARAM_STR);
            $query->bindParam(':pass', $person->password, PDO::PARAM_INT);
            $query->bindParam(':id', $person->id, PDO::PARAM_INT);
            if ($query->execute()) {
                return true;
            }
        } catch (Exception $ex) {
            echo 'Erro: update person';
        }
        return false;
    }

    public function delete($id) {
        try {
            $query = $this->conn->prepare('DELETE FROM `tbl_profile` WHERE `id` = :id;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            if ($query->execute()) {
                return true;
            }
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return false;
    }

    public function select($id) {
        $person = null;
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_profile` WHERE `id` = :id;');
            $query->bindParam(':id', $id);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            $person = new Person(
                    $row->name, 
                    $row->email, 
                    $row->nickname, 
                    $row->image_url, 
                    $row->password_id, 
                    $row->activated, 
                    $row->id, 
                    $row->created_at, 
                    $row->updated_at
            );
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return $person;
    }

    public function select_all() {
        $list = [];
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_profile`;');
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($list, new Person(
                        $row->name, 
                        $row->email, 
                        $row->nickname, 
                        $row->image_url, 
                        $row->password_id, 
                        $row->activated, 
                        $row->id, 
                        $row->created_at, 
                        $row->updated_at
                ));
            }
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return $list;
    }

    public function select_by_email($email) {
        $person = null;
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_profile` ' .
                    'WHERE `email` ' .
                    'LIKE :email;');
            $query->bindValue(':email', '%' . $email . '%', PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                $person = new Person(
                        $row->name, 
                        $row->email, 
                        $row->nickname, 
                        $row->image_url, 
                        $row->password_id, 
                        $row->activated, 
                        $row->id, 
                        $row->created_at, 
                        $row->updated_at
                );
            }
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return $person;
    }

}
