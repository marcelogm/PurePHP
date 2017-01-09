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
 * @author 00271922
 */
class SiteController extends Controller
{

	public function index_action()
	{
		$list = Images::select()
			->like(['image_url' => '%imgur%'])
			->order_by(['image_url' => 'ASC'])
			->limit(16)
			->offset(5)
			->execute();
		var_dump($list);
	}	

}