<?php

namespace App\Services;

use Pimple\Container;
use App\Ext\RoutePermissions;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class PermissionServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['permission'] = function($c){
			return new RoutePermissions;
		};
	}
}