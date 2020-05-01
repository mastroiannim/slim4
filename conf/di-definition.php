<?php

use MyApp\Helper\Session as Session;
use Illuminate\Database\Capsule\Manager as Capsule;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;

/**
 * http://php-di.org/doc/php-definitions.html
 * 
 */

return [

    'settings.db' => [
        'driver' => 'mysql',
        'host' => 'db',
        'database' => 'database',
        'username' => 'user',
        'password' => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
    'settings.app' => [
        'env' => 'DEVELOPMENT',
        'contact' => [
            'name' => 'michele',
            'email' => '@itispaleocapa.it'
        ]
    ],

    'Session' => DI\create(Session::class),

    Capsule::class => DI\factory(function ($db) {

        $capsule = new Illuminate\Database\Capsule\Manager();
		$capsule->addConnection($db);
		// Make this Capsule instance available globally via static methods... (optional)
		$capsule->setAsGlobal();
		// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
		$capsule->bootEloquent();
		return $capsule;
    })->parameter('db', DI\get('settings.db')),

    Twig::class => DI\factory(function ($app) {
        
        $loader = new FilesystemLoader(__DIR__ . '/../view');
		$twig = new Twig($loader, [__DIR__ . '/../var/cache']);
        if ($app['env'] === 'DEVELOPMENT') {
			$twig->enableDebug();
		}
		return $twig;
    })->parameter('app', DI\get('settings.app'))

];