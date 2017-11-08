<?php

namespace App\Middleware;

use App\Ext\Kernel;
use Illuminate\Database\Eloquent\Collection;
use Slim\Http\Body;

class PermissionMiddleware extends BaseMiddleware
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
        if( $route = $request->getAttributes()['route'] )
            $routeName = 'route:'.$route->getName();
        else
            return $next($request, $response);

        $routePermission = Kernel::getInstance('container')->get('permission');
        if( !$routePermission->hasModule($routeName) )
            $routeName = 'route:default.default';

        if( $routePermission->isAllowed($routeName, 'access_route') ){
            return $next($request, $response);
        }

        return $response->withStatus(401)->write("Not allowed here");
    }
}