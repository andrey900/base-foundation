<?php

namespace App\Middleware;

use Illuminate\Database\Eloquent\Collection;
use Slim\Http\Body;

class AuthMiddleware extends BaseMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
    	if( $this->checkPermission() ){
    		$response = $next($request, $response);
        	return $response;
    	} else {
            if( !$_SESSION['auth'] )
                $_SESSION['auth'] = new Collection();
    		
            $_SESSION['auth']['last_request'] = $request->getServerParams()['REQUEST_URI'];

    		return $response->withRedirect('/admin/login');
    	}
    }

    protected function checkPermission()
    {
    	$auth = $_SESSION['auth'];
    	if( !$auth )
    		return false;

    	if( !$auth->has('user.id') )
    		return false;

    	return true;
    }
}