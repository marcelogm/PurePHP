<?php
namespace App\Controllers;
use Pure\Bases\Controller;

/**
 * Controller de erro
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class ErrorController extends Controller
{

	public function index_action()
	{
		echo 'Ops, essa página não existe.';
	}

}