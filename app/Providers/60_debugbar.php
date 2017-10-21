<?php

use AppLib\SlimRouteCollector;

if( $container->get('settings')['app']['useDebugBar'] ){
	global $app;
	$provider = new Kitchenu\Debugbar\ServiceProvider([
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
	$provider->register($app);

    $container->debugbar->addCollector(new SlimRouteCollector($container->router, $container->request));

	$container->debugbar->addCollector(new DebugBar\DataCollector\ConfigCollector($container->get('settings')->all()));

	$container->debugbar->addCollector(new DebugBar\Bridge\MonologCollector($container->logger));

	$env = new AppLib\TraceableTwigEnvironment($container->view->getEnvironment());
	$container->debugbar->addCollector(new DebugBar\Bridge\Twig\TwigCollector($env));
	$container->view->setEnvironment($env);

	$collector = new DebugBar\DataCollector\PDO\PDOCollector(new DebugBar\DataCollector\PDO\TraceablePDO($container->db->getConnection()->getPdo()));
	$container->debugbar->addCollector($collector);
}