<?php

namespace App\Model\Repository;
use Pure\Base\BaseRepository;
use App\Model\Entities\Balance;
use PDO;

class BalanceRepository extends BaseRepository {

    public function save(Balance $balance) {
        try {
            $query = $this->conn->prepare('INSERT INTO `tbl_balance` (' .
                    '`created_at`,' .
                    '`updated_at`,' .
                    '`name`,' .
                    '`value`,' .
                    '`date`,' .
                    '`profile_id`' .
                    ') VALUES (NOW(), NOW(), :name, :value, :date, :profile);');
            $query->bindParam(':name', $balance->name, PDO::PARAM_STR);
            $query->bindParam(':value', $balance->value, PDO::PARAM_STR);
            $query->bindParam(':date', $balance->date, PDO::PARAM_STR);
            $query->bindParam(':profile', $balance->profile, PDO::PARAM_STR);
            if ($query->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $ex) {
            echo 'Erro: save balance';
        }
        return false;
    }

    public function update(Balance $balance) {
        try {
            $query = $this->conn->prepare('UPDATE `tbl_balance` SET ' .
                    '`updated_at` = NOW(), ' .
                    '`name` = :name, ' .
                    '`value` = :value, ' .
                    '`date` = :date ' .
                    'WHERE `id` = :id;');
            $query->bindParam(':name', $balance->name, PDO::PARAM_STR);
            $query->bindParam(':value', $balance->value, PDO::PARAM_STR);
            $query->bindParam(':date', $balance->date, PDO::PARAM_STR);
            $query->bindParam(':id', $balance->id, PDO::PARAM_INT);
            if ($query->execute()) {
                return true;
            }
        } catch (Exception $ex) {
            echo 'Erro: update balance';
        }
        return false;
    }

    public function delete($id) {
        try {
            $query = $this->conn->prepare('DELETE FROM `tbl_balance` WHERE `id` = :id;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            if ($query->execute()) {
                return true;
            }
        } catch (Exception $ex) {
            echo 'Erro: delete balance';
        }
        return false;
    }

    public function select($id) {
        $balance = null;
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_balance` WHERE `id` = :id;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                $balance = new Balance(
                        $row->name, $row->value, $row->date, $row->profile_id, $row->id
                );
            }
        } catch (Exception $ex) {
            echo 'Erro: select balance';
        }
        return $balance;
    }

    public function select_desc_offset($profile, $limit, $offset) {
        $list = [];
        try {
            $query = $this->conn->prepare('SELECT * FROM `tbl_balance` ' .
                    'WHERE `tbl_balance`.`profile_id` = :profile ' .
                    'ORDER BY `tbl_balance`.`created_at` ' .
                    'DESC LIMIT :limit ' .
                    'OFFSET :offset;');
            $offset = (($offset - 1) * $limit);
            $query->bindParam(':profile', $profile, PDO::PARAM_INT);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($list, new Balance(
                        $row->name, $row->value, $row->date, $row->profile_id, $row->id
                ));
            }
        } catch (Exception $ex) {
            echo 'Erro: select balance';
        }
        return $list;
    }

    public function select_day_from($id, $day, $limit, $offset) {
        $list = [];
        try {
            $query = $this->conn->prepare('SELECT `bal`.* ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE `bal`.`date` = DATE(:day) ' .
                    'AND `pro`.`id` = :id ' .
                    'ORDER BY `bal`.`date` DESC ' .
                    'LIMIT :limit ' .
                    'OFFSET :offset;');
            $offset = (($offset - 1) * $limit);
            $query->bindParam(':day', $day, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($list, new Balance(
                        $row->name, $row->value, $row->date, $row->profile_id, $row->id
                ));
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return $list;
    }

    public function select_month_from($id, $month, $limit, $offset) {
        $list = [];
        try {
            $query = $this->conn->prepare('SELECT `bal`.* ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE MONTH(`bal`.`date`) = MONTH(:month) ' .
                    'AND YEAR(`bal`.`date`) = YEAR(:month) ' .
                    'AND `pro`.`id` = :id ' .
                    'ORDER BY `bal`.`date` DESC ' .
                    'LIMIT :limit ' .
                    'OFFSET :offset;');
            $offset = (($offset - 1) * $limit);
            $query->bindParam(':month', $month, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($list, new Balance(
                        $row->name, $row->value, $row->date, $row->profile_id, $row->id
                ));
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return $list;
    }

    public function select_period_from($id, $begin, $end, $limit, $offset) {
        $list = [];
        try {
            $query = $this->conn->prepare('SELECT `bal`.* FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `bal`.`profile_id` = `pro`.`id` ' .
                    'WHERE `pro`.`id` = :id ' .
                    'AND `bal`.`date` >= :begin ' .
                    'AND `bal`.`date` <= :end ' .
                    'ORDER BY `bal`.`date` DESC ' .
                    'LIMIT :limit ' .
                    'OFFSET :offset;');
            $offset = (($offset - 1) * $limit);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':begin', $begin, PDO::PARAM_STR);
            $query->bindParam(':end', $end, PDO::PARAM_STR);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($list, new Balance(
                        $row->name, $row->value, $row->date, $row->profile_id, $row->id
                ));
            }
        } catch (Exception $ex) {
            echo 'Erro: select balance';
        }
        return $list;
    }

    public function count_day_from($id, $day) {
        try {
            $query = $this->conn->prepare('SELECT COUNT(`bal`.`value`) AS `count` ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE `bal`.`date` = DATE(:day) ' .
                    'AND `pro`.`id` = :id;');
            $query->bindParam(':day', $day, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->count;
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return null;
    }

    public function count_month_from($id, $month) {
        try {
            $query = $this->conn->prepare('SELECT COUNT(`bal`.`value`) AS `count` ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE MONTH(`bal`.`date`) = MONTH(:month) ' .
                    'AND YEAR(`bal`.`date`) = YEAR(:month) ' .
                    'AND `pro`.`id` = :id;');
            $query->bindParam(':month', $month, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->count;
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return null;
    }

    public function count_period_from($id, $begin, $end) {
        try {
            $query = $this->conn->prepare('SELECT COUNT(*) AS count FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `bal`.`profile_id` = `pro`.`id` ' .
                    'WHERE `pro`.`id` = :id ' .
                    'AND `bal`.`date` >= :begin ' .
                    'AND `bal`.`date` <= :end;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':begin', $begin, PDO::PARAM_STR);
            $query->bindParam(':end', $end, PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->count;
            }
        } catch (Exception $ex) {
            echo 'Erro: select balance';
        }
        return 0;
    }

    public function select_day_sum_from($id, $day = null) {
        try {
            $query = $this->conn->prepare('SELECT SUM(`bal`.`value`) AS `total` ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE `bal`.`date` = DATE(:day) ' .
                    'AND `pro`.`id` = :id;');
            $query->bindParam(':day', $day, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->total;
            }
        } catch (Exception $ex) {
            echo 'Erro: select day sum';
        }
        return null;
    }

    public function select_month_sum_from($id, $month = null) {
        try {
            $query = $this->conn->prepare('SELECT SUM(`bal`.`value`) AS `total` ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE MONTH(`bal`.`date`) = MONTH(:month) ' .
                    'AND YEAR(`bal`.`date`) = YEAR(:month) ' .
                    'AND `pro`.`id` = :id;');
            $query->bindParam(':month', $month, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->total;
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return null;
    }

    public function select_period_sum_from($id, $begin, $end) {
        try {
            $query = $this->conn->prepare('SELECT SUM(`bal`.`value`) AS `total` ' .
                    'FROM `tbl_balance` AS `bal` ' .
                    'JOIN `tbl_profile` AS `pro` ' .
                    'ON `pro`.`id` = `bal`.`profile_id` ' .
                    'WHERE `pro`.`id` = :id ' .
                    'AND `bal`.`date` >= :begin ' .
                    'AND `bal`.`date` <= :end;');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':begin', $begin, PDO::PARAM_STR);
            $query->bindParam(':end', $end, PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            if ($row != null) {
                return $row->total;
            }
        } catch (Exception $ex) {
            echo 'Erro: select month sum';
        }
        return null;
    }

}
