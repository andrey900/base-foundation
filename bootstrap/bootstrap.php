<?php

require 'define.php';
require BASE_PATH.'vendor'.DS.'autoload.php';
require 'functions.php';

use AppLib\Config\ConfigLoader;





$configLoader = new ConfigLoader([CONFIG_PATH]);
$settings = $configLoader->cacheLoad($configLoader, true);

$app = new \Slim\App($settings);
$container = $app->getContainer();

$configLoader->loadRoutes();
$configLoader->loadProviders();

return $app;