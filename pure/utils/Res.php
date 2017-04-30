<?php
namespace Pure\Utils;

/**
 * Arquivo de recursos
 * Respos�vel por recuperar strings e arrays de determinado arquivo XML
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Res
{
	// raw do xml
	private static $xml;
	// dados em cache
	private static $data = [];

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

	/**
	 * Recuperar string do arquivo "app/assets/strings/en-US.xml"
	 * @param mixed $name nome da variavel
	 * @deprecated mixed $from grupo
	 * @return string valor
	 */
	public static function get_string($name, $from = 'items') {
		if(self::$xml === null)
		{
			self::prepare($name, $from);
		}
		foreach(self::$data[$from][0] as $item) {
			if($item['name'] == $name) {
				return $item['value']->__toString();
			}
		}
		return '';
	}

	/**
	 * Recuperar array do arquivo "app/assets/strings/en-US.xml"
	 * @param mixed $name nome da variavel
	 * @deprecated mixed $from grupo
	 * @return array valor
	 */
	public static function get_array($name, $from = 'items') {
		if(self::$xml === null)
		{
			self::prepare($name, $from);
		}
		foreach(self::$data[$from][0] as $item) {
			if($item['name'] == $name) {
				$array = [];
				foreach($item->string as $subitem) {
					$att = $subitem->attributes();
					$array[$att['name']->__toString()] = $att['value']->__toString();
				}
				return $array;
			}
		}
		return [];
	}

	/**
	 * M�todo interno de prepara��o
	 * @todo i18n
	 * @param mixed $name 
	 * @param mixed $from 
	 */
	private static function prepare($name, $from) {
		//@TODO: multilang
		$str = file_get_contents(BASE_PATH . 'app/assets/strings/en-US.xml');
		self::$xml = new \SimpleXMLElement($str);
		if(!isset(self::$data[$from])) {
			self::$data[$from] = self::$xml->xpath($from);
		}
	}

}