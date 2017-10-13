<?php

namespace AppLib\Config;

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
	protected $extensions = ['php', 'yml'];
	private $config = [];

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
					$this->config[substr($file->getFilename(), 0, -4)] = $delegatingLoader->load($file->getFilename());
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
			return $this->config;

		$processor = new Processor();

		$configuration = new Configuration();
	    $processedConfiguration = $processor->processConfiguration(
	        $configuration,
	        $this->config['data']
	    );
		 
	    // configuration validated
	    p($processedConfiguration);

	    $this->proccessConfiguration = true;
		
		return $this->config;
	}

	protected function cacheConfig()
	{
		$cachePath = CACHE_PATH.DS.'config'.DS.'appconfig.php';

		// Режим отладки определяет, будут ли проверяться на изменения ресурсы, из которых строился кеш
		$cacheFile = new ConfigCache($cachePath, true);

		if (!$cacheFile->isFresh()) {
		    //Здесь строим кэш из загруженных данных
		    //Пишем кеш. Рядом с файлом кеша запишется файл с метаданными со списком исходных ресурсов
		    $cacheFile->write("<?php \n\n return ".var_export($this->config, true), $this->loadedResources);
		}

		// Подключаем файл кеша
		// require $cachePath;
	}

	public function isLoad()
	{
		return (bool)$this->loaded;
	}
}
