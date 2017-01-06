<?php
namespace Pure\Base;

/**
 * Classe básica de Exception do Framework
 *
 * Serve como base para outras exceptions lançadas ao longo
 * da execução do programa.
 * 
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
abstract class PException extends \Exception
{
	/**
	 * Construtor da exception.
	 * Chama método pai.
	 * @param string $message 
	 * @param int $code 
	 * @param Throwable $previous 
	 */
	public function __construct($message = '', $code = 0, \Throwable $previous = NULL) 
	{
		parent::__construct($message, $code, $previous);
	}

	/**
	 * Representação textual da exception lançada.
	 * @return string mensagem
	 */
	public function __toString()
	{
		return __CLASS__ . ': ' . $this->message . '\n';
	}

}