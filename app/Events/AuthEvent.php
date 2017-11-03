<?php

namespace App\Events;

use App\Models\Users;
use Symfony\Component\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system.
 */
class AuthEvent extends Event
{
    const AFTER_AUTH = 'auth.after.session';

    protected $user;

    public function __construct(Users $user)
    {
    	$this->user = $user;
    }

    public function getGroups()
    {
    	return $this->user->groups;
    }

    public function getUser()
    {
    	return $this->user;
    }
}
