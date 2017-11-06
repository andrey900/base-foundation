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
