<?php

namespace App\Services;

use Pimple\Container;
use App\Factories\Controller;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class ControllerFactoryServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['controllerFactory'] = new Controller($container);
	}
}