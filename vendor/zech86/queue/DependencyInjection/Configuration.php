<?php

namespace Zechim\QueueBundle\DependencyInjection;

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
        $root = $treeBuilder->root('zechim_queue');
        $root->addDefaultsIfNotSet();
        $root->children()
            ->scalarNode('host')->defaultValue('localhost')->end()
            ->scalarNode('port')->defaultValue(5672)->end()
            ->scalarNode('user')->defaultValue('guest')->end()
            ->scalarNode('password')->defaultValue('guest')->end()
            ->scalarNode('default_routing_key')->defaultValue('queue_1')->end()
            ->scalarNode('default_exchange')->defaultValue('exchange_1')->end()
        ->end();


        return $treeBuilder;
    }
}