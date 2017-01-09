<?php
namespace Pure\Util;

/**
 * Classe de segurança
 *
 * Responsável pelas funções básicas de segurança do framework
 * Validação de formulários e técnicas contra invações, injections e spoofings
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class SecurityManager
{
	private static $instance = null;

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
	 * @return SecurityManager
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new SecurityManager();
		}
		return self::$instance;
	}
}