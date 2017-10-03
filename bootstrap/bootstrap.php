<?php

require 'define.php';
require BASE_PATH.'vendor'.DS.'autoload.php';

$dotenv = new Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

/*$container->loadFromExtension('framework', array(
    'form' => true,
));*/

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\GlobFileLoader;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;

try {
    $configuration = Yaml::parse(CONFIG_PATH);
} catch (\InvalidArgumentException $exception) {
    exit("Are you sure the configuration files exist?");
}

$locator = new FileLocator(CONFIG_PATH);
// $locator->locate('config.yml');

// const CONFIG_EXTS = '.{php,xml,yaml,yml}';
// $loader->import($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');
// $loader->import($confDir.'/packages/'.$this->getEnvironment().'/**/*'.self::CONFIG_EXTS, 'glob');
// $loader->import($confDir.'/container'.self::CONFIG_EXTS, 'glob');

// $loader = new App\Ext\PhpLoader($locator);
// $loader->setResolver(new Symfony\Component\Config\Loader\LoaderResolver);

// VarDumper::dump($loader->import('*.{php}', 'php'));die;

$configDirectories = array(__DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config');

$locator = new FileLocator($configDirectories);
$yamlUserFiles = $locator->locate('users.yml', null, false);

$resources = array();

foreach ($yamlUserFiles as $yamlUserFile) {
    $resources[] = new FileResource($yamlUserFile);
}

$cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'appUserMatcher.php';

$userMatcherCache = new ConfigCache($cachePath, true);
// the second constructor argument indicates whether or not we are in debug mode

$loaderResolver = new LoaderResolver(array(new YamlUserLoader));
$delegatingLoader = new DelegatingLoader($loaderResolver);

$delegatingLoader->load(__DIR__ . DIRECTORY_SEPARATOR . '/users.yml');

if (!$userMatcherCache->isFresh()) {
    foreach ($resources as $resource) {
        $delegatingLoader->load($resource->getResource());
    }

    // The code for the UserMatcher is generated elsewhere
    // $code = ...;
    $userMatcherCache->write($code, $resources);
}

// you may want to require the cached code:
require $cachePath;


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