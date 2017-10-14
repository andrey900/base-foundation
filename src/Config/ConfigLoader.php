<?php

namespace AppLib\Config;

use Dotenv\Dotenv;
use App\Ext\Configuration;
use Illuminate\Support\Collection;
use AppLib\Config\Loaders\PhpLoader;
use AppLib\Config\Loaders\YamlLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;

/**
* 
*/
class ConfigLoader
{
	protected $configPaths;
	protected $locator;
	protected $loaderResolver;
	protected $extensions = ['php', 'yml', 'yaml'];
	private $config = [];
	private $compiledConfig = [];

	private $loaded = false;
	private $proccessConfiguration = false;
	private $loadedResources = [];

	public function __construct(array $paths)
	{
		$this->configPaths = $paths;

		$this->locator = new FileLocator($paths);
		
		$this->loaderResolver = new LoaderResolver([
			new YamlLoader($this->locator), 
			new PhpLoader($this->locator)
		]);

		try{
			$dotenv = new Dotenv(BASE_PATH);
			$dotenv->load();
		} catch(\Dotenv\Exception\InvalidPathException $e){
		}
	}

	public function load()
	{
		if( $this->isLoad() )
			return $this->get();

		$delegatingLoader = new DelegatingLoader($this->loaderResolver);

		foreach ($this->configPaths as $path) {
			$files = new \FilesystemIterator($path);
			foreach($files as $file)
			{
				if( in_array($file->getExtension(), $this->extensions) ){
					$filename = substr($file->getFilename(), 0, strpos($file->getFilename(), '.'));
					$this->config[$filename] = $delegatingLoader->load($file->getFilename());
					$this->loadedResources[] = new FileResource($file->getPathname());
				}
			}
		}

		$this->loaded = true;

		return $this->get();
	}

	public function get()
	{
		if( !$this->isLoad() )
			return $this->load();

		if( $this->proccessConfiguration )
			return $this->compiledConfig;

		$processor = new Processor();

		foreach ($this->config as $module => $settings) {
			$clName = '\\App\\Ext\\Configuration\\'.$module;

			$envSettings = $settings;

			if( !class_exists($clName) ){
				$this->compiledConfig[$module] = $envSettings;
				continue;
			}

			$configChecker = new Configuration();
		    $this->compiledConfig[$module] = $processor->processConfiguration(
		        new $clName,
		        [$module => $envSettings]
		    );
		}

	    $this->proccessConfiguration = true;

	    $this->compiledConfig = $this->afterCompiled($this->compiledConfig);

		return $this->compiledConfig;
	}

	public static function cacheLoad(ConfigLoader $configLoader, $debug = false)
	{
		$cachePath = CACHE_PATH.'config'.DS.'appconfig.php';

		// Режим отладки определяет, будут ли проверяться на изменения ресурсы, из которых строился кеш
		$cacheFile = new ConfigCache($cachePath, $debug);

		if (!$cacheFile->isFresh() || clearCache()) {
		    $cacheFile->write("<?php \n\n return ".var_export($configLoader->load(), true).';'.PHP_EOL, $configLoader->loadedResources);
		}

		return require $cachePath;
	}

	public function isLoad()
	{
		return (bool)$this->loaded;
	}

	protected function afterCompiled(array $config)
	{
		$settings = $config['settings'];
	    unset($config['settings']);

	    if( $settings['routerCacheFile'] ){
	    	$settings['routerCacheFile'] = CACHE_PATH.$settings['routerCacheFile'];
	    }

	    return ['settings' => $settings + $config];
	}

	public function loadRoutes()
	{
		foreach ($this->configPaths as $paths) {
			global $app;
			$files = new \FilesystemIterator($paths.'routes'.DS);
			foreach($files as $file)
			{
				if( $file->getExtension() == 'php' ){
					include $file->getPathname();
				}
			}
		}
	}
}
