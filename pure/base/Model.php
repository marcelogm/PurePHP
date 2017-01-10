<?php
namespace Pure\Base;
use Pure\Db\Query;

/**
 * Classe básica para Models
 *
 * Deve servir como base para outros models, é
 * dotado de capacidade de acesso e funções básicas da
 * tabela a qual representa
 *
 * @abstract
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
abstract class Model
{

	private static $table_name = null;

	/**
	 * Realiza a construção de um Query Builder para seleção de dados
	 * retornando um objeto que utiliza o comando SELECT em SQL.
	 *
	 * @see Pure\Query
	 * @param array $columns filtro sobre colunas especificas da tabela
	 * @return Query objeto do Query Builder
	 */
	public static function select(array $columns = [], $as = '')
	{
		if (self::$table_name === null) self::set_class_name();

		$query = new Query();
		$query->builder('SELECT ');
		if (empty($columns))
		{
			$query->builder('*');
		} else
		{
			$query->builder(implode(', ', $columns));
		}
		$query->builder(' FROM ' . self::$table_name  . ' ' . $as );
		return $query;
	}

	/**
	 * Realiza uma consulta rápida com valores pré-estabelecidos,
	 * por padrão se o método for chamada sem envio de parametro ela realizará a Query:
	 * - SELECT * FROM table;
	 * Enviando um valor inteiro, realizará a consulta na chave primaria da tabela:
	 * - SELECT * FROM table WHERE id = :param;
	 * Enviando um array de informações (chave-valor), realizará filtros com WHERE como:
	 * - SELECT * FROM table WHERE :key1 = :value1 AND :key2 = :value2;
	 *
	 * Ob.: Caso haja somente uma corespondência para a consulta, como no caso do id,
	 * retorna o objeto sem o encapsulamento do array
	 *
	 * @param integer or array $filters filtros para a WHERE
	 * @return array or object resposta da consulta
	 */
	public static function find($filters = null)
	{
		if(self::$table_name === null) self::set_class_name();
		$query = new Query();
		$query->builder('SELECT * FROM ');
		if ($filters === null)
		{
			$query->builder(self::$table_name);
		}
		else if (is_int($filters))
		{
			$query->builder(self::$table_name . ' WHERE id = ' . $filters);
		}
		else if (is_array($filters))
		{
			$query->builder(self::$table_name . ' WHERE ' .
				implode(' && ', array_map(
					function ($v, $k) {
						return $k . ' LIKE \'' . $v . '\'';
					},
					$filters,
					array_keys($filters))
				)
			);
		}
		$response = $query->execute();
		return (sizeof($response) === 1) ? $response[0] : $response;
	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function update($entities)
	{
		if(self::$table_name === null) self::set_class_name();
	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function delete($entities)
	{
		if(self::$table_name === null) self::set_class_name();
	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function insert($entities)
	{
		if(self::$table_name === null) self::set_class_name();
	}

	/**
	 * Método que recupera valor da tabela em banco de dados
	 * @internal
	 */
	private static function set_class_name()
	{
		self::$table_name = strtolower(explode('\\',get_called_class())[2]);
	}

	/**
	 * Método de criação personalizada
	 *
	 * Utiliza-se nos casos onde o Query Builder não é capaz de gerar
	 * queries, pode-se inserir uma String SQL diretamente no sistema.
	 *
	 * @param string $sql String SQL completa
	 * @return Query objeto do Query Builder
	 */
	public static function build($string = '')
	{
		if(self::$table_name === null)
		{
			self::set_class_name();
		}
		$query = new Query;
		return $query->builder($string);
	}

}