<?php

namespace App\Services;

use Pimple\Container;
use App\Events\UsersEvent;
use Pimple\ServiceProviderInterface;


/**
* 
*/
class EventListenersServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container->dispatcher->addListener(UsersEvent::AFTER_REGISTER, array(new \App\Listeners\AcmeListener, 'onFooAction'));
	}
}