<?php

/**
 * Classe representativa de Rota
 *
 * Uma rota é a representação de um caminho a seguir para
 * acessar determinado conteúdo.
 * A rota é obtida a partir da URL digitada pelo usuário, sendo assim:
 *
 * @example
 * Ao digitar sitename.com/info/about
 * O usuário está dizendo que deseja acessar a página 'about' do
 * controller 'info';
 *
 * @see App\Configs\Config
 * Na classe Config é possivel encontrar rotas padrões
 * as quais serão utilizadas ao longo da execução caso
 * o usuário não especifique qual rota deseja ('DefaultRoute')
 * ou a rota desejada não exista ('DefaultErorrRoute')
 *
 * @version 1.0
 * @author 00271922
 */
class Route
{
	private $controller;
	private $action;
	private $param;

	/**
	 * Construtor da rota
	 * Transforma as strings enviadas de acordo com os padrões 
	 * do framework.
	 * @param string $controller nome da classe de controle
	 * @param string $action nome da ação
	 * @param string $param parametros que essa ação receberá
	 */
	public function __construct($controller = '', $action = '', $param = '')
	{
		$this->controller = ucfirst($controller) . 'Controller';
		$this->action = $action . '_action';
		$this->param = $param;
	}



}