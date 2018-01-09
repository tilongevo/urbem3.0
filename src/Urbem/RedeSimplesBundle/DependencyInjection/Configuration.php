<?php

namespace Urbem\RedeSimplesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('rede_simples');
        $root->isRequired();
        $root->children()
            ->scalarNode('cache_dir')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('form_create')
            ->isRequired()
                ->children()
                    ->arrayNode('endpoint')
                        ->isRequired()
                        ->children()
                            ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('fetch')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('post')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('status')->isRequired()->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
