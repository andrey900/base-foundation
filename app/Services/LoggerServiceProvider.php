<?php

namespace App\Services;

use Monolog\Logger;
use Pimple\Container;
use Monolog\Handler\StreamHandler;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class LoggerServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['logger'] = function($c) {
		    $logger = new Logger('app');
		    if( $c->get('settings')['app']['enableLogging'] && !$c->get('settings')['app']['logOnlyInDebugBar'] ){
			    $file_handler = new StreamHandler(LOG_PATH.$c->get('settings')['app']['logFileName']);
			    $logger->pushHandler($file_handler);
		    }
		    return $logger;
		};
	}
}