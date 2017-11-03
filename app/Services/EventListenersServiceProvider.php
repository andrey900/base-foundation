<?php

namespace App\Services;

use Pimple\Container;
use App\Events\AuthEvent;
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
		
		$container->dispatcher->addListener(AuthEvent::AFTER_AUTH, array(new \App\Listeners\AuthListener, 'onAfterAuth'));
	}
}