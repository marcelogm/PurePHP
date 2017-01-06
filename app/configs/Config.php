<?php
namespace App\Configs;
use Pure\Routes\Route;

/**
 * Class Config
 * Classe que centraliza as principais configurações feitas pelo usuário
 * utiliza métodos estáticos para recuperar informações em forma de array
 */
class Config {

    /**
     * Retorna um array de Route padrões utilizado em configurações
     * 
     * Array:
     * DefaultRoute - Rota padrão quando acessada a raiz do site
     * DefaultErrorRouet - Rota padrão para erros
     * 
     * Exemplo:
     * $routes = Config::routes();
     * Route $route = $routes['DefaultRoute'];
     * 
     * @return type array
     */
    public static function routes() {
        return [
            'DefaultRoute' => new Route('Site', 'index'),
            'DefaultErrorRoute' => new Route('Error', 'index')
        ];
    }

    /**
     * Retorna um array de strings padrões utilizadas pelos bancos de dados.
     * 
     * Array:
     * address - endereço do host onde o banco de dados está hospedado
     * port - porta do servidor de banco de dados
     * dbname - nome do banco de dados
     * username - nome de usuário do banco de dados
     * password - senha de usuário do banco de dodos
     * 
     * Exemplo:
     * $infos = Config::database();
     * $name = $info['username'];
     * 
     * @return type array
     */
    public static function database() {
        return [
            'address' => 'xxxxxxxxxxxxxxxxxxxx',
            'port' => 'xxx',
            'dbname' => 'xxxxxxxxxxxx',
            'username' => 'xxxxxxxxxxxx',
            'password' => 'xxxxxxxxxxxx'
        ];
    }

}