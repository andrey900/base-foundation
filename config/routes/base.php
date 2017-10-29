<?php

use \App\Ext\Kernel;
use \Slim\Middleware\Session;

$app->add(new Session(Kernel::getInstance('config')['settings']['session']));

$app->get('/', \Controllers\Home::class.':home');
