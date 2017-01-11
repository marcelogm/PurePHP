<?php

/**
 * Script de carregamento automático de classes
 * @param string $classname
 */
function __autoload($classname)
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
    $to_require = BASE_PATH.$filename;
    require_once($to_require);
	if(method_exists(($namespace . '\\' . $classname), 'static_init'))
	{
		$class = ($namespace . '\\' . $classname);
		$class::static_init();
	}
}

?>