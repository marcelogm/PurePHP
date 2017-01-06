<?php
namespace Pure\Base;
use App\Util\SessionManager;
use App\Util\ParamsManager;

/**
 * Classe base para controllers do framework
 */
abstract class BaseController {

    // Objeto SessionManager
    protected $session;
    // Objeto ParamsManager
    protected $params;
    // array
    protected $data;
    // array
    protected $menu;

    /**
     * Função que será executada após executar método action.
     */
    public function after_action() {}

    /**
     * Função que será executada antes de executar método action.
     */
    public function before_action() {}

    /**
     * Função que renderiza página em app/view/ 
     * $this->render('pages/index.php');
     * 
     * @param type $path origem do arquivo
     * @param type $data dado serializavel
     */
    public function render($path, $data = []) {
        foreach ($data as $key => $item) {
            $$key = $item;
        }
        $view = BASE_PATH . 'app/view/' . $path . '.php';
        if (!is_file($view)) {
            echo 'Erro ao renderizar página '.$view;
        } else {
            include($view);
        }
    }

    /**
     * Construtor da classe,
     * Instancia objetos ligados ao controller
     */
    public function __construct() {
        $this->session = SessionManager::getInstance();
        $this->params = ParamsManager::get_instance();
        $this->data = [];
        $this->menu = [];
    }

}
