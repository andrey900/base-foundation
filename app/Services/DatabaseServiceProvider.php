<?php

namespace App\Services;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager as DBManager;

/**
* 
*/
class DatabaseServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['db'] = function ($c) {
		    $capsule = new DBManager;
		    $config = $c['settings']['db'];
		    if( $config['driver'] == 'sqlite' ){
		    	$config['database'] = BASE_PATH.$config['database'];
		    }
		    $capsule->addConnection($config);

		    $capsule->setAsGlobal();
		    $capsule->bootEloquent();

		    return $capsule;
		};

		$container->db;
	}
}