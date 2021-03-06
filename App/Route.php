<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);
		
		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
		);
		
		$routes['tweet'] = array(
			'route' => '/tweet',
			'controller' => 'AppController',
			'action' => 'tweet'
		);
		
		$routes['search_users'] = array(
			'route' => '/search_users',
			'controller' => 'AppController',
			'action' => 'search_users'
		);

		$routes['follow'] = array(
			'route' => '/follow',
			'controller' => 'AppController',
			'action' => 'follow'
		);

		$routes['removeTweet'] = array(
			'route' => '/removeTweet',
			'controller' => 'AppController',
			'action' => 'removeTweet'
		);

		$this->setRoutes($routes);
	}
}
?>