<?php

namespace App\Listeners;

use App\Ext\Kernel;
use Symfony\Component\EventDispatcher\Event;

class AuthListener
{
    public function onAfterAuth(Event $event)
    {
    	$session = Kernel::getInstance('container')->get('session');
        $session['auth']['user.groups'] = $event->getGroups()->keyBy('id')->keys()->toArray();
    }
}