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
	 * @param mixed $offset 
	 * @return Query
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