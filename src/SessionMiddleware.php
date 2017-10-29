<?php

namespace AppLib;

use Slim\Middleware\Session;
    
class SessionMiddleware extends Session
{
    public function initSession()
    {
        $this->startSession();
    }
}
