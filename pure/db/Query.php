<?php
namespace Pure\Db;
use Pure\Db\Database;

/**
 * Classe que representa uma Querry
 *
 * Capacidade de gerar filtros para querys básicas
 * e executar os comandos gerados;
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Query
{

	private $query_string;

	public function __construct()
	{

	}

	public function builder($sql = '')
	{
		$this->query_string .= $sql;
		return $this;
	}

	/**
	 * Adiciona a clausula WHERE na Query
	 *
	 * @param array $filters
	 * @return Query
	 */
	public function where(array $filters = [])
	{
		if(!empty($filters))
		{
			$this->query_string .= ' WHERE ' . implode(' && ', array_map(
				function ($v, $k) { 
					return '`' . $k . '` = \'' . $v . '\''; 
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	public function like(array $filters = [])
	{
		if(!empty($filters))
		{
			$this->query_string .= ' WHERE ' . implode(' && ', array_map(
				function ($v, $k) { 
					return '`' . $k . '` LIKE \'' . $v . '\''; 
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	public function order_by(array $filters = [])
	{
		if(!empty($filters))
		{
			$this->query_string .= ' ORDER BY ' . implode(' && ', array_map(
				function ($v, $k) { 
					return $k . ' ' . $v; 
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	public function limit($limit)
	{
		if(is_int($limit))
		{
			$this->query_string .= ' LIMIT ' . $limit;
		}
		return $this;
	}

	public function offset($offset)
	{
		if(is_int($offset))
		{
			$this->query_string .= ' OFFSET ' . $offset;
		}
		return $this;
	}

	/**
	 * Executa a query construida a partir do
	 * query builder.
	 *
	 * @return array informações do banco de dados
	 */
	public function execute()
	{
		$db = Database::get_instance();
		return $db->execute_query($this);
	}

	public function generate()
	{
		return $this->query_string . ';';
	}

}