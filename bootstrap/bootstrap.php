<?php

require 'define.php';
require BASE_PATH.'vendor'.DS.'autoload.php';
require 'functions.php';

session_start();

use AppLib\Config\ConfigLoader;

$configLoader = new ConfigLoader([CONFIG_PATH]);
$settings = $configLoader->cacheLoad($configLoader, true);

if( !$settings['settings']['app']['debugMode'] ){
	error_reporting(0);
} else {
	error_reporting(E_ERROR|E_PARSE|E_CORE_ERROR|E_COMPILE_ERROR|E_USER_ERROR);
}

$app = new \Slim\App($settings);
$container = $app->getContainer();

$configLoader->loadProviders();
$configLoader->loadRoutes();

return $app;