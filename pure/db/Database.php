<?php
namespace Pure\Db;
use App\Configs\Config;
use Pure\Exceptions\DatabaseException;
use PDO;

/**
 * Banco de Dados
 *
 * Classe representativa do banco de dados.
 * Gera conexão e estabelece funcionalidades básicas do banco de dado.
 *
 * @internal
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Database
{
    private static $instance = null;
	private $connection;

	/**
	 * Método construtor
	 * Executa a validação de campos de configurações,
	 * bem como inicia conexão com o PDO.
	 *
	 * @access privado para proibir novas instances.
	 * @internal método de uso interno
	 */
	private function __construct()
	{
		$config = Config::database();
		if(!$this->config_validation($config))
		{
			throw new DatabaseException('Parametros da função Config::database() são inválidos.');
		}
		try {
			$this->connection = new PDO(
				'mysql:host=' . $config['address'] .
				';port=' . $config['port'] .
				';dbname=' . $config['dbname'] ,
				$config['username'],
				$config['password']
			);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e)
		{
			throw new DatabaseException('Não foi possível iniciar conexão com o banco de dados: ' . $e->getMessage());
		}
	}

	private function __clone(){}
	private function __wakeup(){}

	/**
	 * Recupera a única instance disponível do objeto
	 *
	 * @see Singleton
	 * @link https://pt.wikipedia.org/wiki/Singleton
	 * @return Database
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new Database();
		}
		return self::$instance;
	}

	/**
	 * Valida configurações da classe Config::database(),
	 * verificando se o objeto é um array e tem todos os itens
	 * necessarios para configurar o banco de dados.
	 *
	 * @param string[] $config
	 * @return boolean resposta
	 */
	private function config_validation($config)
	{
		return (is_array($config) &&
				array_key_exists('address', $config) &&
				array_key_exists('port', $config) &&
				array_key_exists('dbname', $config) &&
				array_key_exists('username', $config) &&
				array_key_exists('password', $config));
	}

	/**
	 * Executa query no banco de dados
	 *
	 * @param Query $query a ser executada
	 * @throws DatabaseException caso não seja uma query valida
	 * @return array array de objetos do banco de dados
	 */
	public function execute_query($query)
	{
		$list = [];
		try {
			$statement = $this->connection->prepare($query->generate());
			var_dump($query->generate());
			$statement->execute();
			while($object = $statement->fetchObject())
			{
				array_push($list, $object);
			}
			return $list;
		} catch(\Exception $e)
		{
			throw new DatabaseException('Falha ao executar query: ' .
				$query->generate() .
				' Mais informações: ' .
				$e->getMessage()
			);
		}
	}

	/**
	 * Executa inserção de valor no banco de dados
	 *
	 * @param mixed $query de inserção de dados
	 * @throws DatabaseException caso não seja uma inserção válida
	 * @return boolean resultado da inserção
	 */
	public function execute_update($query)
	{
		try {
			$statement = $this->connection->prepare($query->generate());
			var_dump($query->generate());
			return $statement->execute();
		}
		catch(\Exception $e)
		{
			throw new DatabaseException('Falha ao executar inserção: ' .
				$query->generate() .
				' Mais informações: ' .
				$e->getMessage()
			);
		}
	}

}