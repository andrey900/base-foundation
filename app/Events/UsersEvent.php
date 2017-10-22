<?php

namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system.
 */
class UsersEvent extends Event
{
    const BEFORE_REGISTER = 'user.before.register';
    const AFTER_REGISTER = 'user.after.register';
    const AFTER_SAVE = 'user.after.save';

    protected $user;

    public function __construct($user)
    {
    	$this->user = $user;
    }
}