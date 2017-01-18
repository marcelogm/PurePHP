<?php
namespace Pure\Utils;

/**
 * Gerador de Hash SHA256
 *
 * Facilita a criação de Hash em um padrão seguro
 * utilizando técnias de iteration, salt e timestamp;
 * Ideal para facilitar o processo de geração de hash de senhas
 * Possibilita também a geração de palavras aleatorias.
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Hash
{

	private $MAX_ITERATIONS = 10000;
	private $raw;
	private $data;
	private $salt;
	private $iterations;
	private $timestamp;

	private $has_iteration;
	private $has_timestamp;
	private $has_salt;

	/**
	 * Método construtor da classe
	 */
	public function __construct()
	{
		$this->has_iteration = false;
		$this->has_timestamp = false;
		$this->has_salt = false;
	}

	/**
	 * Gera uma palavra aleatória com um determinado número de caracteres
	 * Sendo essa palavra composta com caracteres padrões,
	 * sem caracteres especiais.
	 *
	 * @param int $length tamanho da palavra a ser gerada
	 * @return string palavra aleatória
	 */
	public static function random_word($length = 64)
	{
		$word = '';
		$len = 62;
		$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for($i = 0; $i < 62; $i++)
		{
			$word .= $charset[mt_rand(0, $len - 1)];
		}
		return $word;
	}

	/**
	 * Gera uma hash de uma palavra aleatória com uma cadeira de 64 caracteres
	 *
	 * @return string hash de palavra aleatoria
	 */
	public function randomize()
	{
		$this->has_iteration = false;
		$this->has_timestamp = false;
		$this->has_salt = false;
		$this->raw = Hash::random_word(64);
		return $this->hashing();
	}

	/**
	 * Gera uma hash com base em uma palavra enviada por parâmetro
	 * O método da opção de concatenação de salt e timestamp, bem como
	 * senha com iteração (repetição do processo de encriptação)  com SHA256.
	 *
	 * Formato do segredo completo:
	 * $value = segredo_bruto . salt . timestamp
	 * hash('sha256', $value) x número de iterações
	 *
	 * @param string $secret segredo a ser encriptado
	 * @param bool $has_salt concatenar salt
	 * @param bool $has_iteration repetir processo de encriptação
	 * @param bool $has_timestamp concatenar timestamp atual
	 * @return string or null hash ou null, caso a string $secret seja vazia
	 */
	public function generate($secret, $has_salt = false, $has_iteration = false, $has_timestamp = false)
	{
		if (strlen($secret) > 0)
		{
			$this->has_iteration = $has_iteration;
			$this->has_timestamp = $has_timestamp;
			$this->has_salt = $has_salt;
			$this->raw = $secret;
			return $this->hashing();
		}
		return null;
	}

	/**
	 * Recupera todos os dados de um segredo
	 * incluindo a palavra não encriptada, a hash gerada,
	 * o possivel salt e timestamp que foi concatenado e o
	 * numero de iterações SHA256 realizadas no objeto atual
	 *
	 * Itens do array:
	 * - raw = segredo bruto
	 * - hash = hash encriptada
	 * - salt = valor inteiro concatenado
	 * - timestamp = timestamp inteiro concatenado
	 * - iterations = numero de iteações
	 *
	 * @return array or null array das informações ou null caso não haja nenhuma hash válida
	 */
	public function get_hash_secret()
	{
		if ($this->data !== null)
		{
			return ['raw' => $this->raw,
				'hash' => $this->data,
				'salt' => $this->salt,
				'timestamp' => $this->timestamp,
				'iterations' => $this->iterations];
		}
		return null;
	}

	/**
	 * Recupera somente a palavra encriptada.
	 *
	 * @return string or null a palavra encriptada ou null caso não haja nenhuma hash válida
	 */
	public function get_hash()
	{
		return ($this->data !== null) ? $this->data : null;
	}

	/**
	 * Processo de geração da hash com base nos critérios definidos em
	 * generate() ou em randomize()
	 *
	 * @return null or string
	 */
	private function hashing()
	{
		$this->data = $this->raw;
		$this->set_salt();
		$this->set_timestamp();
		$this->set_iterations();
		for($i = 0; $i < $this->iterations; $i++)
		{
			$this->data = hash('sha256', $this->data);
		}
		return $this->get_hash();
	}

	/**
	 * Utilizada no processo de criação da hash
	 * Gera e concatena o Timestamp
	 *
	 * @internal
	 */
	private function set_timestamp()
	{
		if ($this->has_timestamp)
		{
			$this->timestamp = time();
			$this->data .= $this->timestamp;
		}
		else
		{
			$this->timestamp = null;
		}
	}

	/**
	 * Utilizada no processo de criação da hash
	 * Gera e concatena o Salt
	 *
	 * @internal
	 */
	private function set_salt()
	{
		if ($this->has_salt)
		{
			$this->salt = mt_rand();
			$this->data .= $this->salt;
		}
		else
		{
			$this->salt = null;
		}
	}

	/**
	 * Utilizada no processo de criação da hash
	 * Gera o valor de iteração
	 *
	 * @internal
	 */
	private function set_iterations()
	{
		$this->iterations = ($this->has_iteration) ? mt_rand(1, $this->MAX_ITERATIONS) : 1;
	}

}