<?php

namespace App\Services;

use Pimple\Container;
use SlimSession\Helper as Session;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class SessionServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['session'] = function ($c) {
          return new Session;
        };
	}
}