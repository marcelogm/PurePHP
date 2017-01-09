<?php
namespace Pure\Db;

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
	/**
	 * Método construtor
	 *
	 * @access privado para proibir novas instances.
	 * @internal função de uso interno
	 */
	private function __construct() {}

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
			self::$instance = new Engine();
		}
		return self::$instance;
	}

}