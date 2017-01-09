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

	private $session;
	private $params;

	public function __construct(){
		
	}
	
	public function before()
	{
		echo ' Antes ';
	}

	public function after()
	{
		echo ' Depois ';
	}

}