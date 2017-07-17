<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Res;

/**
 * Controller principal
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class SiteController extends Controller
{

	public function index_action()
	{
		$this->data['teste'] = 'Hello from teste.';
		$this->render();
	}

}
