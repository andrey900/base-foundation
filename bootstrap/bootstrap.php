<?php

require 'define.php';
require BASE_PATH.'vendor'.DS.'autoload.php';
require 'functions.php';

use AppLib\Config\ConfigLoader;





$configLoader = new ConfigLoader([CONFIG_PATH]);
$settings = $configLoader->cacheLoad($configLoader, true);

$app = new \Slim\App($settings);
$container = $app->getContainer();

if( $container->get('settings')['app']['useDebugBar'] ){
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

$configLoader->loadRoutes();

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

return $app;