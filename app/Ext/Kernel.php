<?php

namespace App\Ext;

use AppLib\Config\ConfigLoader;
use AppLib\SessionMiddleware;
use App\Models\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Pimple\ServiceProviderInterface;

/**
* SingletonClass and factory for other base classes
*/
class Kernel
{
	public static $debug = false;
	public static $useCache = true;

	protected static $instance;

	protected $app;
	protected $user;
	protected $settings;
	protected $container;
	protected $configLoader;

	private function __construct()
	{

	}

	private function __clone()
	{

	}

	public static function instanceApp()
	{
		if( !static::instanceKernel()->app )
			static::instanceKernel()->app = new \Slim\App(static::instanceConfig(static::$debug));

		return static::instanceKernel()->app;
	}

	public static function instanceContainer()
	{
		if( !static::instanceKernel()->container )
			static::instanceKernel()->container = static::instanceApp()->getContainer();

		return static::instanceKernel()->container;
	}

	public static function instanceConfig($debug = false)
	{
		if( !static::instanceKernel()->configLoader ){
			static::instanceKernel()->configLoader = new ConfigLoader([CONFIG_PATH]);
			if( static::$useCache )
				static::instanceKernel()->settings = static::instanceKernel()->configLoader->cacheLoad(static::instanceKernel()->configLoader, $debug);
			else
				static::instanceKernel()->settings = static::instanceKernel()->configLoader->load();
		}

		return static::instanceKernel()->settings;
	}

	public static function instanceKernel()
	{
		if( !static::$instance )
			static::$instance = new static;

		return static::$instance;
	}

	public static function instanceUser()
	{
		if( !static::instanceKernel()->user ){
			$session = static::getInstance('container')->get('session');
			if( $session['auth'] && $session['auth']['user.id'])
				static::instanceKernel()->user = Users::find($session['auth']['user.id']);
		}

		return static::instanceKernel()->user;
	}

	public static function getInstance($type = false)
	{
		switch ($type) {
			case 'settings':
			case 'config':
				return static::instanceConfig();
			case 'app':
				return static::instanceApp();
			case 'container':
				return static::instanceContainer();
			case 'user':
				return static::instanceUser();

			default:
				return static::instanceKernel();
		}
	}

	public static function load()
	{
		static::instanceApp();

		$settings = static::instanceConfig();

		if( !$settings['settings']['app']['debugMode'] ){
			error_reporting(0);
		} else {
			error_reporting(E_ERROR|E_PARSE|E_CORE_ERROR|E_COMPILE_ERROR|E_USER_ERROR);
		}
        
        static::loadSession();
        
		static::registerServices();

		if( $settings['settings']['app']['loadAliaces'] && $settings['settings']['app']['aliases'] )
			static::classAliace(new Collection($settings['settings']['app']['aliases']));

		static::loadRoutes();

		return static::instanceApp();
	}
    
    protected static function loadSession()
    {  
        $sessionStart = new SessionMiddleware(static::getInstance('config')['settings']['session']);
        $sessionStart->initSession();
    }

	protected static function loadRoutes()
	{
		$app = static::instanceApp();
		foreach (static::instanceKernel()->configLoader->getConfigPath() as $paths) {
			$files = new \FilesystemIterator($paths.'routes'.DS);
			foreach($files as $file)
			{
				if( $file->getExtension() == 'php' ){
					include_once $file->getPathname();
				}
			}
		}
	}

	protected static function registerServices()
    {
    	$services = new Collection(static::instanceContainer()->settings['serviceProviders']);

        /** @var ServiceProviderInterface[] $services */
    	if( $services->isNotEmpty() ){
	        $services->each(function($serviceClass, $key) {
	        	if( class_exists($serviceClass) ){
	        		$service = new $serviceClass;
		            if ($service instanceof ServiceProviderInterface) {
		                static::instanceContainer()->register($service);
		            }
	        	}
	        });
    	}
    }

    protected static function classAliace(Collection $aliases)
    {
    	$container = static::getInstance('container');
    	$aliases->each(function ($item, $key) use ($container) {
    		if( $container->has($key) ){
    			if( strpos($item, '\\') !== 0 )
    				$item = '\\'.$item;

    			class_alias(get_class($container->get($key)), $item, false);
    		}
    	});
    }
}