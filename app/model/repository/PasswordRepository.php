<?php
namespace App\Model\Repository;
use Pure\Base\BaseRepository;
use App\Model\Entities\Password;
use PDO;

class PasswordRepository extends BaseRepository {

    public function save(Password $pass) {
        try {
            $query = $this->conn->prepare('INSERT INTO `tbl_password` (' .
                    '`created_at`,' .
                    '`updated_at`,' .
                    '`iterations`,' .
                    '`password`,' .
                    '`salt`' .
                    ') VALUES (NOW(), NOW(), :iterations, :pass, :salt);');
            $query->bindParam(':iterations', $pass->iterations, PDO::PARAM_INT);
            $query->bindParam(':pass', $pass->password, PDO::PARAM_STR);
            $query->bindParam(':salt', $pass->salt, PDO::PARAM_INT);
            if ($query->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $ex) {
            echo 'Erro: save person';
        }
        return false;
    }

    public function update(Password $pass) {
        try {
            $query = $this->conn->prepare('UPDATE `tbl_password` SET ' .
                    '`updated_at` = NOW(), ' .
                    '`iterations` = :iterations, ' .
                    '`password` = :pass, ' .
                    '`salt` = :salt ' .
                    'WHERE `id` = :id;');
            $query->bindParam(':iterations', $pass->iterations, PDO::PARAM_INT);
            $query->bindParam(':pass', $pass->password, PDO::PARAM_STR);
            $query->bindParam(':salt', $pass->salt, PDO::PARAM_STR);
            $query->bindParam(':id', $pass->id, PDO::PARAM_INT);
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
            $query = $this->conn->prepare('DELETE FROM `tbl_password` WHERE `id` = :id;');
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
        $pass = null;
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_password` WHERE `id` = :id;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            $pass = new Password(
                    $row->password, 
                    $row->salt, 
                    $row->iterations, 
                    $row->id
            );
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return $pass;
    }

    public function selectByHash($password) {
        $pass = null;
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_password` '.
                    'WHERE `password` '.
                    'LIKE :password;');
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            $pass = new Password(
                    $row->password, 
                    $row->salt, 
                    $row->iterations, 
                    $row->id
            );
        } catch (Exception $ex) {
            echo 'Algo deu errado: ' . $ex->getMessage() . '<br>';
        }
        return $pass;
    }

}
