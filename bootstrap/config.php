<?php

/*
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\GlobFileLoader;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;



class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('database');
        $rootNode
            ->children()
                ->booleanNode('auto_connect')
                    ->defaultTrue()
                ->end()
                ->scalarNode('default_connection')
                    ->defaultValue('default')
                ->end()
            ->end();
        return $treeBuilder;
    }
}
$configuration = new Configuration();
// $processedConfig = $this->processConfiguration( $configuration, $configs );
$recipient = $configuration->getConfigTreeBuilder()->buildTree()->getParametr('database');
p($recipient);die;

try {
    $configuration = Yaml::parse(CONFIG_PATH);
} catch (\InvalidArgumentException $exception) {
    exit("Are you sure the configuration files exist?");
}

$locator = new FileLocator(CONFIG_PATH);*/
// $locator->locate('config.yml');

// const CONFIG_EXTS = '.{php,xml,yaml,yml}';
// $loader->import($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');
// $loader->import($confDir.'/packages/'.$this->getEnvironment().'/**/*'.self::CONFIG_EXTS, 'glob');
// $loader->import($confDir.'/container'.self::CONFIG_EXTS, 'glob');

// $loader = new App\Ext\PhpLoader($locator);
// $loader->setResolver(new Symfony\Component\Config\Loader\LoaderResolver);

// VarDumper::dump($loader->import('*.{php}', 'php'));die;
/*
$configDirectories = array(__DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config');

$locator = new FileLocator($configDirectories);
$yamlUserFiles = $locator->locate('users.yml', null, false);

$resources = array();

foreach ($yamlUserFiles as $yamlUserFile) {
    $resources[] = new FileResource($yamlUserFile);
}

$cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'appUserMatcher.php';

$userMatcherCache = new ConfigCache($cachePath, true);
// the second constructor argument indicates whether or not we are in debug mode

$loaderResolver = new LoaderResolver(array(new YamlUserLoader));
$delegatingLoader = new DelegatingLoader($loaderResolver);

$delegatingLoader->load(__DIR__ . DIRECTORY_SEPARATOR . '/users.yml');

if (!$userMatcherCache->isFresh()) {
    foreach ($resources as $resource) {
        $delegatingLoader->load($resource->getResource());
    }

    // The code for the UserMatcher is generated elsewhere
    // $code = ...;
    $userMatcherCache->write($code, $resources);
}

// you may want to require the cached code:
require $cachePath;
*/

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Loader\GlobFileLoader;
use Symfony\Component\Config\FileLocator;

$r = new GlobFileLoader();
p($r);die;
// $yaml = new YamlConfigLoader('/path/where/config/will/be');
// $config = new Config();
// $config->setConfigResolver($yaml);
// $config->import('myconfig.yml');
// $config->get('myconfig.config.key');

/*$loader = new PhpLoader(new FileLocator);
$data = $loader->load(CONFIG_PATH.'app.php');
p($data);*/

/*
$t = file_get_contents(BASE_PATH.'bootstrap/myconfig.yml');
$configValues = Yaml::parse($t);
p($t);
p($configValues);
p($configValues['config']);*/

use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use AppLib\ConfigLoaders\YamlLoader;
use AppLib\ConfigLoaders\PhpLoader;

$locator = new FileLocator([BASE_PATH.'bootstrap']);
$loaderResolver = new LoaderResolver(array(new YamlLoader($locator), new PhpLoader($locator)));
$delegatingLoader = new DelegatingLoader($loaderResolver);

// YamlUserLoader is used to load this resource because it supports
// files with the '.yml' extension
$t = $delegatingLoader->import('*.{yml}');
p($t);
$t = $delegatingLoader->load('myconfig.php');
p($t);