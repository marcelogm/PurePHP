<?php
namespace Pure\Routes;
use App\Configs\Config;
use Pure\Routes\Route;

/**
 * Gerenciador de URLs
 * Responsável por transformar a URL em uma 
 * rota válida que será utilizada pelo motor
 */
class UrlManager {

    private static $instance = null;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    /**
     * Retorna uma instancia de UrlManager
     * @return type
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new UrlManager();
        }
        return self::$instance;
    }

    /**
     * Verifica se o texto digitado representa uma rota
     * @param Route $route
     * @return Route
     */
    public function route_exists(Route $route) {
        $class = 'app\\controller\\' . $route->get_controller();
        $filename = 'app/controller/' . $route->get_controller() . '.php';
        $action = $route->get_action();
        if (!is_file($filename) || !class_exists($class) || !method_exists($class, $action)) {
            return $this->get_error_route();
        }
        return $route;
    }

    /**
     * Retorna rota digitada na URL
     * @return Route
     */
    public function get_route() {
        if (isset($_GET['PurePage'])) {
            $exploded = explode('/', $_GET['PurePage']);
            $route = new Route(
                    (isset($exploded[0])) ? $exploded[0] : null, 
                    (isset($exploded[1])) ? $exploded[1] : null, 
                    (isset($exploded[2])) ? $exploded[2] : null
            );
            return $route;
        }
        return $this->get_default_route();
    }

    /**
     * Retorna rota padrão, caso exista
     * @return type
     */
    public function get_default_route() {
        $conf_routes = Config::routes();
        if (!isset($conf_routes['DefaultRoute'])) {
            echo 'Erro ao carregar rota padrão.';
        } else
            return $conf_routes['DefaultRoute'];
    }

    /**
     * Retorna rota de erro, caso exista
     * @return type
     */
    public function get_error_route() {
        $conf_routes = Config::routes();
        if (!isset($conf_routes['DefaultErrorRoute'])) {
            echo 'Erro ao carregar rota de erro.';
        } else
            return $conf_routes['DefaultErrorRoute'];
    }

}
