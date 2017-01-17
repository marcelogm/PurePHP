<?php
namespace Pure\Base;

/**
 * Classe básica para Controllers
 *
 * Deve servir como base para outros controllers, é
 * dotado de capacidade de acesso a camada Model e responsável
 * por renderizar a camada View
 *
 * @abstract
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
abstract class Controller
{
	private $page = '';
	protected $data = [];

	private $session;
	private $params;

	public function __construct()
	{
		$this->layout = BASE_PATH . '/app/view/layout/default.php';
		$this->page = BASE_PATH . '/app/view/pages/index.php';
	}

	/**
	 * Método que será executado antes do método action
	 */
	public function before()
	{
	}

	/**
	 * Método que será executado depois do método action
	 */
	public function after()
	{
	}

	/**
	 * Renderiza determinado layout
	 * @param string $layout nome do layout em /view/layout
	 */
	public function render($layout = 'index')
	{
		$layout = BASE_PATH . '/app/view/layout/default.php';
		foreach($this->data as $name => $item)
		{
			$$name = $item;
		}
		include($layout);
	}

	/**
	 * Renderiza em JSON o conteúdo da página
	 */
	public function render_json()
	{
		echo json_encode($this->data);
	}

	/**
	 * Summary of load
	 * @param string $page nome da pagina em /view/page
	 */
	private function load($page = 'index')
	{
		$page = BASE_PATH . '/app/view/pages/' . $page . '.php';
		foreach($this->data as $name => $item)
		{
			$$name = $item;
		}
		include($this->page);
	}

}