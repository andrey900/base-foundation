<?php

require 'define.php';
require BASE_PATH.'vendor'.DS.'autoload.php';
require 'functions.php';

require 'config.php';

$dotenv = new Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

/*$container->loadFromExtension('framework', array(
    'form' => true,
));*/

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$provider = new Kitchenu\Debugbar\ServiceProvider();
$provider->register($app);

$container = $app->getContainer();

/*$container['pdo'] = function () {
    return new PDO('sqlite::memory:');
};

$collector = new DebugBar\DataCollector\PDO\PDOCollector($container->pdo);
$container->debugbar->addCollector($collector);

$collector = new DebugBar\Bridge\Twig\TwigCollector($container->twig);
$container->debugbar->addCollector($collector);
*/

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

return $app;