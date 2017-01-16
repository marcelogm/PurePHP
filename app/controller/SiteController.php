<?php
namespace App\Controller;
use Pure\Base\Controller;
use App\Model\Image;
use App\Model\Person;
use Pure\Db\SQLBuilder;

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
		$image = new Image();
		$person = new Person();
		$image->image_url = 'teste1';
		$image->page_url = 'teste2';
		Image::save($person);
	}

}