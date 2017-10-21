<?php

namespace AppLib;

use Closure;
use Slim\Route;
use ReflectionMethod;
use ReflectionFunction;
use Kitchenu\Debugbar\DataCollector\SlimRouteCollector as SlimRouteCollectorBase;

/**
* 
*/
class SlimRouteCollector extends SlimRouteCollectorBase
{
	
	protected function getRouteInformation(Route $route)
    {
        $result = [];

        $result['uri'] = $route->getMethods()[0] . ' ' . $route->getPattern();

        $result['name'] = $route->getName() ?: '';

        $result['group'] = '';
        foreach ($route->getGroups() as $group) {
            $result['group'] .= $group->getPattern();
        }

        $callable = $route->getCallable();

        $result['middleware'] = [];
        foreach ($route->getMiddleware() as $middleware) {
            $closureMiddleware = Closure::bind(function () {
                return get_class($this->callable);
            }, $middleware, DeferredCallable::class);
            if(method_exists($closureMiddleware, '__invoke')){
            	$_response = $closureMiddleware->__invoke();
            	$result['middleware'][] = $_response;
            }
        }

        if(is_array($callable)) {
            $result['callable'] = get_class($callable[0]) . ':' . $callable[1];
            $reflector = new ReflectionMethod($callable[0], $callable[1]);
        } elseif ($callable instanceof Closure) {
            $result['callable'] = $this->formatVar($callable);
            $reflector = new ReflectionFunction($callable);
        } elseif (is_object($callable)) {
            $result['callable'] = get_class($callable);
            $reflector = new ReflectionMethod($callable, '__invoke');
        } else {
            $result['callable'] = $callable;
            $callable = explode(':', $callable);
            if (isset($callable[1])) {
                if( class_exists($callable[0]) )
                    $reflector = new ReflectionMethod($callable[0], $callable[1]);
            } else {
            	$reflector = new ReflectionMethod($callable, '__invoke');
            }
        }

        if( $reflector )
        	$result['file'] = $reflector->getFileName() . ':' . $reflector->getStartLine() . '-' . $reflector->getEndLine();

        return $result;
    }	
}