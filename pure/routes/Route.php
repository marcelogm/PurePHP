<?php
namespace Pure\Routes;

/**
 * Classe que representa uma rota
 */
class Route {

    private $controller;
    private $action;
    private $id;

    /**
     * Transforma as strings passadas por parametro
     * em rotas válidas
     * 
     * @param type $controller
     * @param type $action
     * @param type $id
     */
    public function __construct($controller = '', $action = '', $id = '') {
        $this->controller = ucfirst($controller) . 'Controller';
        $this->action = $action . '_action';
        $this->id = $id;
    }

    public function get_controller() {
        return $this->controller;
    }

    public function get_action() {
        return $this->action;
    }

    public function get_id() {
        return $this->id;
    }

    /**
     * Verifica se a rota enviada por parametro é 
     * igual a rota atual
     * 
     * @param \Pure\Routes\Route $route
     * @return boolean
     */
    public function equals(Route $route) {
        $route_lower_c = strtolower($route->controller);
        $lower_c = strtolower($this->controller);
        $route_lower_a = strtolower($route->action);
        $lower_a = strtolower($this->action);
        if ($route_lower_c === $lower_c && $route_lower_a === $lower_a) {
            return true;
        }
        return false;
    }

}
