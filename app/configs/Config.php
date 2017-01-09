<?php
namespace App\Configs;
use Pure\Routes\Route;

/**
 * Classe de configurações
 *
 * Classe que centraliza as principais configurações feitas pelo usuário
 * Utiliza métodos estáticos para recuperar informações em foram de array
 *
 * @version 1.1
 * @author Marcelo Gomes Martins
 */
class Config
{
	/**
	 * Retorna um array de rotas padrões utilizadas pelo sistema de rotas do framework
	 *
	 * O item 'DefaultRoute' representa a rota que será carregada caso o usuário 
	 * não especifique uma. Da mesma forma, 'DefaultErrorRoute' será carregada
	 * caso haja algum erro ou a rota não exista.
	 * 
	 *
	 * @return Route[] rotas padrões do Framework
	 */
	public static function routes()
	{
		return [
			'DefaultRoute' => new Route('Site','index'),
			'DefaultErrorRoute' => new Route('Error', 'index'),
		];
	}

	/**
	 * Retorna um array de strings padrões utilizadas pelo banco de dados.
	 *
	 * address - endereço do host onde o banco de dados está hospedado
	 * port - porta do servidor de banco de dados
	 * dbname - nome do banco de dados
	 * username - nome de usuário do banco de dados
	 * password - senha de usuário do banco de dodos
	 *
	 * @example
	 * $infos = Config::database();
	 * $name = $info['username'];
	 *
	 * @return string[]
	 */
	public static function database()
	{
		return [
			'address' => 'localhost',
			'port' => '3306',
			'dbname' => 'prntsc',
			'username' => 'root',
			'password' => ''
		];
	}

}