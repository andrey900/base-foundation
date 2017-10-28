<?php

namespace App\Services;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class MailServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['mailer'] = function ($c) {
			$transport = new Swift_NullTransport;
			return new Swift_Mailer($transport);	
		};
	}
}