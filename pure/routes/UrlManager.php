<?php
namespace Pure\Routes;

/**
 * Gerenciador de rotas
 *
 * Responsavel por gerenciar, criar, modificar e validar
 * dados enviados por meio de uma URL.
 *
 * @version 1.0
 * @author 00271922
 */
class UrlManager
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
	 * @return UrlManager
	 */
	public static function get_instance(){
		if (self::$instance === null)
		{
			self::$instance = new UrlManager();
		}
		return self::$instance;
	}

	public function get_route()
	{
		if (isset($_GET['PurePage']))
		{
			$requested = trim($_GET['PurePage']);
			$exploded_url = explode('/', $requested);

		}

	}

	public function get_default_route()
	{

	}

	public function get_error_route()
	{

	}


}