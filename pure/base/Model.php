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
	 * Realiza a construção de um Query Builder para seleção de dados
	 * retornando um objeto que utiliza o comando SELECT em SQL.
	 *
	 * @see Pure\Query
	 * @param array $columns filtro sobre colunas especificas da tabela
	 * @return Query objeto do Query Builder
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

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function update($entities)
	{

	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function delete($entities)
	{

	}

	/**
	 * @todo
	 * @param mixed $entities
	 */
	public static function insert($entities)
	{

	}

	/**
	 * Função de criação personalizada
	 *
	 * Utiliza-se nos casos onde o Query Builder não é capaz de gerar
	 * queries, pode-se inserir uma String SQL diretamente no sistema.
	 *
	 * @param string $sql String SQL completa
	 * @return Query objeto do Query Builder
	 */
	public static function build($string = '')
	{
		$query = new Query;
		return $query->builder($string);
	}

}