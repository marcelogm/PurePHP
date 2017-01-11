<?php
namespace App\Controller;
use Pure\Base\Controller;
use App\Model\Image;
use App\Model\Person;

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
		$person = new Person();
		$image = Image::find(1234);
		var_dump($image);
		$person->name = 'Marcelo';
		echo Person::insert($person);
	}

}