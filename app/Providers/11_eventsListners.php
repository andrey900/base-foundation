<?php

use App\Events\UsersEvent;

$container->dispatcher->addListener(UsersEvent::AFTER_REGISTER, array(new \App\Listeners\AcmeListener, 'onFooAction'));