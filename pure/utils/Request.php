<?php
namespace Pure\Utils;
use Pure\Kernel\Engine;
use Pure\Routes\UrlManager;
use Pure\Routes\Route;

/**
 * Request short summary.
 *
 * Request description.
 *
 * @version 1.0
 * @author 00271922
 */
class Request
{

	public static function is_to($routes = [])
	{
		$manager = UrlManager::get_instance();
		$current = $manager->get_route();
		foreach($routes as $route)
		{
			if($current->equals($route))
			{
				return true;
			}
		}
		return false;
	}

	public static function redirect($destination)
	{
		if (is_a($destination, Route::class))
		{
			$engine = Engine::get_instance();
			$engine->load_route($destination);
		} else if (is_string($destination))
		{
			$manager = UrlManager::get_instance();
			header('location: ' . $manager->get_base_url() . $destination);
		}
		return false;
	}

	public static function redirect_to_url($url)
	{
		if (is_string($url))
		{
			header('location: ' . $url);
			exit();
		}
		return false;
	}

	public static function reload()
	{

	}

	/**
	 * @todo
	 * @param mixed $content
	 * @param mixed $method
	 * @param mixed $header
	 */
	public static function send($content, $method, $header)
	{

	}

}