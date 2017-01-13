<?php
namespace Pure\Base;
use Pure\Db\SQLBuilder;
use Pure\Db\Database;
use Pure\Db\SQLType;
use App\Configs\Config;

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

	/**
	 * Método que recupera o mapeamento das colunas das tabelas
	 * Sendo a chave o nome da coluna presente na tabela
	 * e o tipo de dado o valor do array
	 * Caso o usuário tenha personalizado o método Class::table_map()
	 * retorna o mapeamento alternativo
	 *
	 * @internal
	 * @return array chave-valor ['nome_da_coluna' => 'tipo_de_dado']
	 */
	protected static function get_table_map()
	{
		$called = get_called_class();
		if(!method_exists($called, 'table_map'))
		{
			$sql = new SQLBuilder();
			// Faz consulta sobre a estrutura da tabela
			$response = $sql->builder(
				'SELECT column_name col, data_type dat FROM information_schema.columns WHERE table_name = \'' .
				self::get_table_name() .
				'\' AND table_schema = \'' .
				Config::database()['dbname'] .
				'\'')->execute();
			$map = [];
			// Cria mapeamento
			foreach($response as $object)
			{
				$map[$object->col] = $object->dat;
			}
			return $map;
		}
		// Caso o usuário tenha personalizado um mapeamento diferente
		return $called::table_map();
	}

	/**
	 * Método que recupera o nome da tabela no banco de dados
	 * Por padrão, Pure entende que o mesmo nome do modelo será utilizado no banco de dados
	 * Caso o usuário tenha personalizado o método Class::table_name()
	 * retorna o nome personalizado
	 *
	 * @internal
	 * @return string nome do banco de dados
	 */
	protected static function get_table_name()
	{
		$called = get_called_class();
		if(method_exists($called, 'table_name'))
		{
			// Caso o usuário tenha personalizado um nome diferente para a tabela em banco
			return $called::table_name();
		}
		// Nome baseado no nome da classe
		return strtolower(explode('\\',$called)[2]);
	}

	/**
	 * Realiza uma consulta rápida com valores pré-estabelecidos,
	 * por padrão se o método for chamada sem envio de parametro ela realizará a SQLBuilder:
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
		$sql = new SQLBuilder();
		$sql->builder('SELECT * FROM ');
		if ($filters === null)
		{
			$sql->builder(self::get_table_name());
		}
		else if ((int)filters)
		{
			$sql->builder(self::get_table_name() . ' WHERE id = ' . $filters);
		}
		else if (is_array($filters))
		{
			$sql->builder(self::get_table_name() . ' WHERE ' .
				implode(' && ', array_map(
						function ($key, $value) {
							return $value . ' LIKE \'' . $key . '\'';
						},
						array_keys($filters),
						$filters
					)
				)
			);
		}
		$response = $sql->execute();
		return (sizeof($response) === 1) ? $response[0] : $response;
	}

	/**
	 * Realiza a inserção de registro no banco de dados por meio de um instance
	 * de uma classe de modelo
	 *
	 * Utiliza o comando de inserção INSERT do SQL,
	 * cada dado preenchido no modelo será um item da clausula VALUES
	 *
	 * - Resultado: INSERT INTO ('name', 'age') VALUES ('marcelo', '21')
	 *
	 * @param Model $entities objeto que herde Model
	 * @return SQLBuilder resultado da inserção
	 */
	public static function insert(Model $entities)
	{
		$map = self::get_table_map();
		$sql = new SQLBuilder(SQLType::DML);
		foreach($map as $field => &$value)
		{
			if (property_exists($entities, $field))
			{
				$value = '\'' . $entities->$field . '\'';
			} else {
				unset($map[$field]);
			}
		}
		return $sql->builder('INSERT INTO ' . self::get_table_name() . ' (' .
				implode(', ', array_keys($map)) .
				') VALUES (' .
				implode(', ', array_values($map)) .
				')');
	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function update($columns = [])
	{
		$sql = new SQLBuilder(SQLType::DML);
		$sql->builder('UPDATE ' . self::get_table_name());
		foreach($map as $fields => &$value)
		{
			if (property_exists($entities, $fields))
			{

			}
		}
	}

	/**
	 * Realiza a construção de um SQLBuilder para seleção de dados
	 * retornando um objeto que utiliza o comando SELECT em SQL.
	 *
	 * - String: 'name'
	 * - Resultado: SELECT name
	 *
	 * - Array: ['name', 'age']
	 * - Resultado: SELECT name, age FROM model
	 *
	 * @see Pure\Db\SQLBuilder
	 * @param string or array $columns filtro sobre colunas especificas da tabela
	 * @return SQLBuilder objeto do SQLBuilder
	 */
	public static function select($columns = [])
	{
		$sql = new SQLBuilder();
		$sql->builder('SELECT ');
		if (is_string($columns))
		{
			$sql->builder($columns);
		}
		else if (is_array($columns) && !empty($columns))
		{
			$sql->builder(implode(', ', $columns));
		} else
		{
			$sql->builder('*');
		}
		$sql->builder(' FROM ' . self::get_table_name());
		return $sql;
	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function delete($entities)
	{
	}

	/**
	 * Método de criação personalizada
	 *
	 * Utiliza-se nos casos onde o SQLBuilder não é capaz de gerar
	 * consultas, pode-se inserir uma String SQL diretamente no sistema.
	 *
	 * @param string $sql String SQL completa
	 * @return SQLBuilder objeto do SQLBuilder
	 */
	public static function build($string = '', $type = SQLType::DQL)
	{
		$sql = new SQLBuilder($type);
		return $sql->builder($string);
	}

}