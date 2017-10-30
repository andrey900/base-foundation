<?php

namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system.
 */
class GroupsEvent extends Event
{
    const BEFORE_SAVE = 'group.before.save';
    const AFTER_SAVE = 'group.after.save';

    protected $group;

    public function __construct($group)
    {
    	$this->group = $group;
    }
}