<?php
namespace Pure\Database;
use Pure\Db\Query;

/**
 * Classe báisca para Models
 *
 * Deve servir como base para outros models, é
 * dotado de capacidade de acesso e funções básicas da
 * tabela ao qual representa
 *
 * @abstract
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
abstract class Model
{

	private $table_name;

	public function __construct()
	{
		$this->table_name =	strtolower(get_called_class);
	}

	public static function select(array $columns)
	{
		$query = new Query();
		$query->builder('SELECT ');
		if(empty($columns))
		{
			$query->builder(' * ');
		} else
		{
			foreach($columns as $column)
			{
				$query->builder($column);
			}
		}
		$query->builder(' FROM ' . self::table_name);
		return $query;
	}

	public static function update($entities)
	{

	}

	public static function delete($entities)
	{

	}

	public static function insert($entities)
	{
		if(is_array($entities))
		{

		} else {

		}
	}

	public static function query_builder($string = '')
	{
		$query = new Query;
		return $query->builder($string);
	}

}