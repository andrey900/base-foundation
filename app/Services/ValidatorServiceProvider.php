<?php

namespace App\Services;

use Pimple\Container;
use App\Factories\Validation;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class ValidatorServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['validator'] = function($c){
			return new Validation($c);
		};
	}
}