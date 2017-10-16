<?php

$container['view'] = function ($container) {
	$templatesPath = TEMPLATES_PATH.$container->get('settings')['app']['templateName'];
	
	$config = [
        'cache' => (['twigUseCache']) ? CACHE_PATH.'twig'.DS : false,
        'twigDebug' => $container->get('settings')['app']['twigDebug'],
        'file_extension' => 'html'
    ];

	if( isset($container->get('settings')['twig']) ){
		$config = array_merge($config, $container->get('settings')['twig']);
	}

    $view = new \AppLib\Twig($templatesPath, $config);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};