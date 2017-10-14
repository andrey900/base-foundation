<?php

namespace App\Ext\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
* 
*/
class settings implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('settings');
 
        $rootNode
            ->children()
                ->booleanNode('displayErrorDetails')
                    ->defaultValue(false)
                ->end()
                ->booleanNode('addContentLengthHeader')
                    ->defaultValue(true)
                ->end()
                ->booleanNode('determineRouteBeforeAppMiddleware')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('outputBuffering')
                    ->defaultValue('append')
                ->end()
                ->scalarNode('routerCacheFile')
                    ->defaultValue(false)
                ->end()
            ->end()
        ;
 
        return $treeBuilder;
    }
}