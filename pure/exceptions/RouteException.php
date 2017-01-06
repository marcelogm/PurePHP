<?php
namespace Pure\Exceptions;
use Pure\Base\PException;

/**
 * Exception de Rota
 *
 * Exception disparada quando não é possivel recuperar uma rota
 * válida digitada no navegador pelo usuário ($_GET['PurePage']), 
 * da rota padrão 'DefaultRoute' (@see App\Configs\Config) ou
 * da rota padrão para erros 'DefaultErrorRoute' (@see App\Configs\Config).
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class RouteException extends PException
{

	public function __construct()
	{
		parent::__construct('Falha na manipulação de rota. Rota inválida ou não existente.');
	}

}