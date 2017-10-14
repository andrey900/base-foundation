<?php

if( $container->get('settings')['app']['useDebugBar'] ){
	global $app;
	$provider = new Kitchenu\Debugbar\ServiceProvider();
	$provider->register($app);
/*$container['pdo'] = function () {
    return new PDO('sqlite::memory:');
};

$collector = new DebugBar\DataCollector\PDO\PDOCollector($container->pdo);
$container->debugbar->addCollector($collector);

$collector = new DebugBar\Bridge\Twig\TwigCollector($container->twig);
$container->debugbar->addCollector($collector);
*/
}