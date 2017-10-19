<?php

$container['view'] = function ($container) {
    $appConfig = $container->get('settings')['app'];
    $templatesPath = TEMPLATES_PATH.$appConfig['templateName'];

    if( strpos($container->request->getUri()->getPath(), $appConfig['adminUrl']) === 0 ){
	   $templatesPath = TEMPLATES_PATH.$appConfig['adminTemplateName'];
    }

	$config = [
        'cache' => ($appConfig['twigUseCache']) ? CACHE_PATH.'twig'.DS : false,
        'twigDebug' => $appConfig['twigDebug'],
        'auto_reload' => $appConfig['twigAutoReload'],
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