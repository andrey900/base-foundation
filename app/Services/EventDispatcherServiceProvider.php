<?php

namespace App\Services;

use App\Ext\Kernel;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
* 
*/
class EventDispatcherServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['dispatcher'] = function ($c) {
            return new EventDispatcher();
        };
	}
}

/**
* Потом переделать!!!
*/
/*class Dispatcher
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

Dispatcher::setDispatcher(Kernel::getInstance('container')->dispatcher);*/