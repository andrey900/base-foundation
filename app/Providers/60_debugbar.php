<?php

if( $container->get('settings')['app']['useDebugBar'] ){
	global $app;
	$provider = new Kitchenu\Debugbar\ServiceProvider();
	$provider->register($app);

	$container->debugbar->addCollector(new DebugBar\DataCollector\ConfigCollector($container->get('settings')->all()));

	$container->debugbar->addCollector(new DebugBar\Bridge\MonologCollector($container->logger));

	$env = new AppLib\TraceableTwigEnvironment($container->view->getEnvironment());
	$container->debugbar->addCollector(new DebugBar\Bridge\Twig\TwigCollector($env));
	$container->view->setEnvironment($env);

	$collector = new DebugBar\DataCollector\PDO\PDOCollector(new DebugBar\DataCollector\PDO\TraceablePDO($container->db->getConnection()->getPdo()));
	$container->debugbar->addCollector($collector);
}