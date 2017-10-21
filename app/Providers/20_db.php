<?php

$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $config = $container['settings']['db'];
    if( $config['driver'] == 'sqlite' ){
    	$config['database'] = BASE_PATH.$config['database'];
    }
    $capsule->addConnection($config);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container->db;