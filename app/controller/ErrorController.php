<?php
namespace App\Controller;
use Pure\Base\Controller;

/**
 * ErrorController short summary.
 *
 * ErrorController description.
 *
 * @version 1.0
 * @author 00271922
 */
class ErrorController extends Controller
{

	public function index_action(){
		echo 'Ops, essa página não existe.';
	}

}