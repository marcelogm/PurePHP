<?php
namespace Pure\Kernel;
use Pure\Routes\Route;
use Pure\Routes\UrlManager;

/**
 * Motor que executa ações básicas de controle processos
 */
class Engine {

    // Singleton
    private static $instance = null;
    // Route que foi pedida pelo usuário
    private $route_requested;

    /**
     * Metódos do sistema
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    /**
     * Retorna instancia de Engine
     * torna o motor acessivel a qualquer parte do código
     * @return type
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new Engine();
        }
        return self::$instance;
    }

    /**
     * Inicio do processo de rotas
     */
    public function begin() {
        $manager = UrlManager::get_instance();
        $path = $manager->get_route();
        $path = $manager->route_exists($path);
        $this->route_requested = $path;
        $this->action_loader($path);
    }

    /**
     * Carrega a ação a partir da rota criada
     * @param Route $route
     */
    private function action_loader(Route $route) {
        $class_name = $route->get_controller();
        $action_name = $route->get_action();
        $id = $route->get_id();

        try {
            $class = 'app\\controller\\' . $class_name;
            $controller = new $class();
            $controller->before_action();
            $controller->$action_name($id);
            $controller->after_action();
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Retorna a última rota executada pelo motor
     * @return type
     */
    public function get_requested_route() {
        return $this->route_requested;
    }

}
