<?php
namespace App\Controller;
use Pure\Base\Controller;
use App\Model\Images;

/**
 * SiteController short summary.
 *
 * SiteController description.
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class SiteController extends Controller
{

	public function index_action()
	{
		$image = Images::find(1234);
		var_dump($image);
	}

}