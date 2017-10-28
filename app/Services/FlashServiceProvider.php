<?php

namespace App\Services;

use Pimple\Container;
use Slim\Flash\Messages;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class FlashServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['flash'] = function () {
		    return new Messages();
		};
	}
}