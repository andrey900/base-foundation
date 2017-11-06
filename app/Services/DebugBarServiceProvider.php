<?php

namespace App\Services;

use App\Ext\Kernel;
use Pimple\Container;
use AppLib\SlimRouteCollector;
use AppLib\TraceableTwigEnvironment;
use Pimple\ServiceProviderInterface;
use DebugBar\Bridge\MonologCollector;
use Kitchenu\Debugbar\ServiceProvider;
use DebugBar\Bridge\Twig\TwigCollector;
use DebugBar\DataCollector\ConfigCollector;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;

/**
* 
*/
class DebugBarServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$user = Kernel::getInstance('user');

		if( $container->get('settings')['app']['useDebugBar'] && 
			$user->id && 
			$user->isAdmin()
		){
			$provider = new ServiceProvider([
				'storage' => [
					'enabled' => false
				], 
				'collectors' => [
					'phpinfo'    => true,  // Php version
		            'messages'   => true,  // Messages
		            'time'       => true,  // Time Datalogger
		            'memory'     => true,  // Memory usage
		            'exceptions' => true,  // Exception displayer
		            'route'      => false,
		            'request'    => true,  // Request logger
		        ]
		    ]);
			$provider->register(Kernel::getInstance('app'));

		    $container->debugbar->addCollector(new SlimRouteCollector($container->router, $container->request));

			$container->debugbar->addCollector(new ConfigCollector($container->get('settings')->all()));

			$container->debugbar->addCollector(new MonologCollector($container->logger));

			$env = new TraceableTwigEnvironment($container->view->getEnvironment());
			$container->debugbar->addCollector(new TwigCollector($env));
			$container->view->setEnvironment($env);

			$collector = new PDOCollector(new TraceablePDO($container->db->getConnection()->getPdo()));
			$container->debugbar->addCollector($collector);
		}
	}
}