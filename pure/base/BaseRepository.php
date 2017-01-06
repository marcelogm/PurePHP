<?php
namespace Pure\Base;
use App\Configs\Config;
use PDO;
use PDOException;

/**
 * Classe base para repositórios do framework
 */
class BaseRepository {

    public $conn;

    /**
     * Função construtora de repositório
     */
    function __construct() {
        try {
            $params = Config::database();
            $this->conn = new PDO(
                    'mysql:host=' . $params['address'] .
                    ';port=' . $params['port'] .
                    ';dbname=' . $params['dbname'], $params['username'], $params['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falha na conexão com o banco de dados: ' . $e->getMessage();
        }
    }

}
