<?php

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use MyApp\Helper\Session;

return function (Container $container) {
	
	$settings = [
		'settings' => [
			'contact' => [
				'name' => 'mio nome',
				'email' => 'mia email'
			],
			'db' => [
				'driver' => 'mysql',
				'host' => 'db',
				'database' => 'database',
				'username' => 'user',
				'password' => 'password',
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => '',
			]
		],
	];

	//Aggiunta delle informazioni di contatto al container
	//-----------------------------------------------------------------------------------
	$container->set('contact', function () use ($settings) {

		return $settings['settings']['contact'];
	});	

	//Aggiunta della sessione al container
	//-----------------------------------------------------------------------------------
	$container->set('session', function () use ($settings) {

		return new Session();
	});	


	//Aggiunta di un Database Service al container
	//-----------------------------------------------------------------------------------
	$container->set('db', function () use ($settings) {
		
		$capsule = new Capsule();
		$capsule->addConnection($settings['settings']['db']);

		// Make this Capsule instance available globally via static methods... (optional)
		$capsule->setAsGlobal();
		// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
		$capsule->bootEloquent();

		return $capsule;
	});	
};
