<?php
namespace Pure\Base;

/**
 * Classe base para exceptions do framework
 */
class BaseException extends Exception {
    
    /**
     * Construtor da classe
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Texto de descrição da exception
     * @return type string
     */
    public function __toString() {
        return 'PURE: ' . __CLASS__ . ': ' . $this->code . ' - ' . $this->message . '<br>';
    }

}
