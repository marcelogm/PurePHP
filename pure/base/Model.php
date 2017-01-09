<?php
namespace Pure\Base;
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

	/**
	 * Método construtor
	 *
	 * Responsável por definir o nome da tabela $this->table_name.
	 */
	public function __construct()
	{
		$this->table_name =	strtolower(get_called_class);
	}

	/**
	 * Realiza a construção de uma query do tipo SELECT
	 *
	 * @see Pure\Query
	 * @param array $columns filtro  sobre colunas espeficas da tabela
	 * @return Query retorna a si mesmo para possibilitar chain method
	 */
	public static function select(array $columns = [])
	{
		$query = new Query();
		$query->builder('SELECT ');
		if(empty($columns))
		{
			$query->builder('*');
		} else
		{

			$query->builder('`images`.`' . implode('`,`images`.`', $columns) . '`');
		}
		$query->builder(' FROM `' . 'images' . '`');
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