<?php
namespace Pure\Kernel;
use Pure\Routes\UrlManager;

/**
 * Motor de carregamento de páginas do Framework
 *
 * Classe principal do Framework, é a responsável por
 * carregar o controller, executar a action e lidar com informações
 * básicas de rotas manipulando a classe UrlManager.
 * É caracterizada por ser única no contexto, sendo acessivel
 * utilizando o método estático get_intance.
 *
 * @see Pure\Routes\UrlManager
 * @version 1.1
 * @author Marcelo Gomes Martins
 */
class Engine
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
	 * @return Engine
	 */
	public static function get_instance(){
		if (self::$instance === null)
		{
			self::$instance = new Engine();
		}
		return self::$instance;
	}

	/**
	 * Inicia a aplicação recuperando a URL requisitada,
	 * gerando uma rota válida com ela e encaminhando para 
	 * a construção do controller.
	 */
	public function execute()
	{
		$manager = UrlManager::get_instance();
	}

	private function load_model()
	{

	}

	private function load_controller()
	{
		
	}

	private function load_action()
	{
		
	}
	
}