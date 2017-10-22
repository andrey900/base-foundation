<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

$container['dispatcher'] = function($c) {
    return new EventDispatcher();
};

/**
* 
*/
class Dispatcher
{
	private function __construct(){}

	protected static $dispatcher;

	public static function setDispatcher(EventDispatcher $dispatcher)
	{
		self::$dispatcher = $dispatcher;
	}

	public static function dispatch($name, $event)
	{
		self::$dispatcher->dispatch($name, $event);
	}
}

Dispatcher::setDispatcher($container->dispatcher);