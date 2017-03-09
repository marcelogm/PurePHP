<?php
namespace Pure\Bases;
use Pure\Exceptions\ClassException;

/**
 * Plugin short summary.
 *
 * Plugin description.
 *
 * @version 1.0
 * @author 00271922
 */
abstract class Plugin
{

	protected $plugin;
	private $class_reference;
	private static $instance = null;

	private function __construct()
	{
		$this->self_autoloader_registration();
		$source = $this->source();
		$uppername = strtoupper($source['class']);
		if(!defined($uppername . '_BASE_PATH'))
		{
			define($uppername . '_BASE_PATH', BASE_PATH . 'app/plugins/sources/' . strtolower($source['namespace']) . '/');
		}
		$this->class_reference = '\\' . $source['namespace'] . '\\' . $source['class'];
	}

	public static function create()
	{
		$class = get_called_class();
		$newest = new $class;
		$newest->plugin = new $newest->class_reference();
		return $newest;
	}

	private function self_autoloader_registration()
	{
		spl_autoload_register(
			function ($classname)
			{
				$classname = ltrim($classname, '\\');
				$filename  = '';
				$namespace = '';
				if ($lastnspos = strripos($classname, '\\'))
				{
					$namespace = substr($classname, 0, $lastnspos);
					$namespace = strtolower($namespace);
					$classname = substr($classname, $lastnspos + 1);
					$filename  = str_replace('\\', '/', $namespace) . '/';
				}
				$filename .= str_replace('_', '/', $classname) . '.php';
				$to_require = BASE_PATH . 'app/plugins/sources/' . $filename;
				if (!file_exists($to_require))
				{
					return false;
				}
				require_once($to_require);
				return true;
			}
		);
	}

	public function __call($method, $arguments)
	{
		if(method_exists($this->plugin, $method))
		{
			$result = call_user_func_array(array($this->plugin, $method), $arguments);
			return $result;
		} else {
			$class = get_class($this);
			throw new \BadMethodCallException('O método ' . $method . ' não está presente em ' . $class);
		}
	}

	public abstract function source();

}