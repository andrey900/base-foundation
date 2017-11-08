<?php

use App\Middleware\PermissionMiddleware;
use \App\Ext\Kernel;
use \Slim\Middleware\Session;

$app->add(new Session(Kernel::getInstance('config')['settings']['session']));
$app->add(new App\Middleware\PermissionMiddleware());

$app->get('/', \Controllers\Home::class.':home')->setName('page.home');
