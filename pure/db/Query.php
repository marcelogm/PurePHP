<?php
namespace Pure\Db;
use Pure\Db\Database;

/**
 * Classe Query Builder
 *
 * Objeto representativo de uma Query SQL,
 * a partir dele é possivel realizar consultas usando o método
 * 'execute' ou Strings SQL usando o método 'generate'.
 * É possivel gerar consultas SQL completas, com filtros ou
 * com SQL Puro.
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Query
{
	private $query_string;

	/**
	 * Função de criação personalizada
	 *
	 * Utiliza-se nos casos onde o Query Builder não é capaz de gerar
	 * queries, pode-se inserir uma String SQL diretamente no sistema.
	 *
	 * @param string $sql String SQL completa
	 * @return Query objeto do Query Builder
	 */
	public function builder($sql)
	{
		$this->query_string .= $sql;
		return $this;
	}

	/**
	 * Realiza a filtragem de valores com comparação
	 * entre a coluna e o valor de filtro por meio de um array chave-valor
	 *
	 * Adiciona WHERE na consulta SQL.
	 *
	 * @param array $filters filtros em formato 'coluna' => 'valor'
	 * @return Query objeto do Query Builder
	 */
	public function where(array $filters = [])
	{
		if (!empty($filters))
		{
			$this->query_string .= ' WHERE ' . implode(' AND ', array_map(
				function ($v, $k) {
					return '`' . $k . '` = \'' . $v . '\'';
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	/**
	 * Realiza a filtragrem de valores com comparação
	 * entre a coluna e o valor de filtro por meio de um array chave-valor
	 *
	 * Adiciona WHERE (...) LIKE na consulta SQL, possibilitando a utilização de
	 * caracteres coringa '%'.
	 *
	 * @param array $filters filtros em formato 'coluna' => 'valor'
	 * @return Query objeto do Query Builder
	 */
	public function like(array $filters = [])
	{
		if (!empty($filters))
		{
			$this->query_string .= ' WHERE ' . implode(' AND ', array_map(
				function ($v, $k) {
					return '`' . $k . '` LIKE \'' . $v . '\'';
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	/**
	 * Realiza a ordenação dos dados presentes na consulta,
	 * ordenando de acordo com a chave (coluna) escolhida
	 *
	 * Adiciona ORDER BY na consulta SQL para cada coluna
	 *
	 * @param array $filters filtros em formato 'coluna' => 'ordenacao' ('ASC' ou 'DESC')
	 * @return Query objeto do Query Builder
	 */
	public function order_by(array $filters = [])
	{
		if (!empty($filters))
		{
			$this->query_string .= ' ORDER BY ' . implode(', ', array_map(
				function ($v, $k) {
					return $k . ' ' . $v;
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	/**
	 * Realiza o agrupamentos dos dados da consulta,
	 * agrupando de acordo com o valor escolhido.
	 *
	 * Adiciona GROUP BY na consulta SQL para cada coluna
	 *
	 * @param array $columns filtros para agrupamento de valores
	 * @return Query objeto do Query Builder
	 */
	public function group_by(array $columns = [])
	{
		if (!empty($columns))
		{
			$this->query_string .= ' GROUP BY ' . implode(', ', $columns);
		}
		return $this;
	}

	/**
	 * Adiciona mais uma tabela a Query atual por meio de JOIN
	 *
	 * Utiliza-se o método "on(['column' => 'column'])" para definir
	 * variaveis que serão comparadas para a junção.
	 *
	 * @see on
	 * @param string $table_name Nome da tabela que será adicionada a Query
	 * @param string $type Tipo de JOIN (LEFT, RIGHT, OUTER, FULL)
	 * @return Query objeto do Query Builder
	 */
	public function join($table_name, $type = '')
	{
		$this->query_string .= $type . ' JOIN ' . $table_name;
		return $this;
	}

	/**
	 * Faz a relação entre as tabelas adicionadas por meio de JOIN à Query
	 *
	 * Adiciona ON na consulta SQL
	 *
	 * @param array $filters Nome dos campos que serão comparados ['column' => 'column']
	 * @return Query objeto do Query Builder
	 */
	public function on($filters)
	{
		if (!empty($filters))
		{
			$this->query_string .= ' ON ' . implode(' AND ', array_map(
				function ($v, $k) {
					return $k . ' = ' . $v;
				},
				$filters,
				array_keys($filters)
			));
		}
		return $this;
	}

	/**
	 * Cria um alias para o item anterior da Query SQL
	 *
	 * Adiciona AS na consulta SQL para cada o item anterior
	 *
	 * @deprecated
	 * @param string $alias_name Alias para a ultima tabela construída
	 * @return Query objeto do Query Builder
	 */
	public function alias($alias_name)
	{
		$this->query_string .= ' AS ' . $alias_name;
		return $this;
	}

	/**
	 * Limita o número de resultados buscado pela consulta
	 *
	 * Adiciona LIMIT na consulta SQL
	 *
	 * @param string $limit limite de resultados obtidos
	 * @return Query objeto do Query Builder
	 */
	public function limit($limit)
	{
		if(is_int($limit))
		{
			$this->query_string .= ' LIMIT ' . $limit;
		}
		return $this;
	}

	/**
	 * Junto com o filtro de limite, permite a exibição de valores
	 * posteriores aos exibidos.
	 *
	 * Adiciona OFFSET na consulta SQL
	 *
	 * @param string $offset
	 * @return Query objeto do Query Builder
	 */
	public function offset($offset)
	{
		if(is_int($offset))
		{
			$this->query_string .= ' OFFSET ' . $offset;
		}
		return $this;
	}

	/**
	 * Executa a consulta SQL gerada pelo Query Builder
	 * retornando os valores obtidos do banco de dados.
	 *
	 * @return array lista de objetos do banco de dados
	 */
	public function execute()
	{
		$db = Database::get_instance();
		return $db->execute_query($this);
	}

	/**
	 * Retorna a String de consulta gerada pelo Query Builder
	 *
	 * @return string String SQL
	 */
	public function generate()
	{
		return $this->query_string . ';';
	}

}