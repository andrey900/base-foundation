<?php

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('app');
    if( $c->get('settings')['app']['enableLogging'] && !$c->get('settings')['app']['logOnlyInDebugBar'] ){
	    $file_handler = new \Monolog\Handler\StreamHandler(LOG_PATH.$c->get('settings')['app']['logFileName']);
	    $logger->pushHandler($file_handler);
    }
    return $logger;
};
