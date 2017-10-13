<?php

namespace App\Ext;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
* 
*/
class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blog');
 
        $rootNode
            ->children()
                ->scalarNode('title')
                    ->isRequired()
                ->end()
                ->scalarNode('description')
                    ->defaultValue('')
                ->end()
                ->booleanNode('rss')
                    ->defaultValue(false)
                ->end()
                ->integerNode('posts_main_page')
                    ->min(1)
                    ->max(10)
                    ->defaultValue(5)
                ->end()
                ->arrayNode('social')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('url')->end()
                            ->scalarNode('icon')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
 
        return $treeBuilder;
    }
}