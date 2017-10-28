<?php

namespace App\Services;

use AppLib\Twig;
use Pimple\Container;
use Slim\Views\TwigExtension;
use Pimple\ServiceProviderInterface;

/**
* 
*/
class TwigServiceProvider implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container['view'] = function ($c) {
		    $appConfig = $c->get('settings')['app'];
		    $templatesPath = TEMPLATES_PATH.$appConfig['templateName'];

		    if( strpos($c->request->getUri()->getPath(), $appConfig['adminUrl']) === 0 ){
			   $templatesPath = TEMPLATES_PATH.$appConfig['adminTemplateName'];
		    }

			$config = [
		        'cache' => ($appConfig['twigUseCache']) ? CACHE_PATH.'twig'.DS : false,
		        'twigDebug' => $appConfig['twigDebug'],
		        'auto_reload' => $appConfig['twigAutoReload'],
		        'file_extension' => 'html'
		    ];

			if( isset($c->get('settings')['twig']) ){
				$config = array_merge($config, $c->get('settings')['twig']);
			}

		    $view = new Twig($templatesPath, $config);

		    // Instantiate and add Slim specific extension
		    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
		    $view->addExtension(new TwigExtension($c['router'], $basePath));

		    return $view;
		};
	}
}