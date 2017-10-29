<?php

namespace App\Services;

use Pimple\Container;
use Illuminate\Support\Collection;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class CollectionServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['collection'] = $container->factory(function($c){
	    	return new Collection();
	    });
	}
}