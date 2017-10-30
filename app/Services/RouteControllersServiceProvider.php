<?php

namespace App\Services;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class RouteControllersServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['Controllers\\Home'] = $container->get('controllerFactory')->instance('Home');
		$container['Controllers\\Admin\\Auth'] = $container->get('controllerFactory')->instance('Auth', 'b');
		$container['Controllers\\Admin\\Users'] = $container->get('controllerFactory')->instance('Users', 'b');
		$container['Controllers\\Admin\\Groups'] = $container->get('controllerFactory')->instance('Groups', 'b');
		$container['Controllers\\Admin\\Test'] = $container->get('controllerFactory')->instance('Test', 'b');
	}
}
