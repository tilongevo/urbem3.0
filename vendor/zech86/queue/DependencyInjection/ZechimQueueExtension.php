<?php

namespace Zechim\QueueBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Zechim\QueueBundle\Service\Producer\CommandProducer;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ZechimQueueExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $config['exchange'] = $config['default_exchange'];
        $config['routing_key'] = $config['default_routing_key'];

        unset($config['default_exchange'], $config['default_routing_key']);

        $definition = new Definition(CommandProducer::class);
        $definition->addArgument($config);

        $container->setDefinition('zechim_queue.default_command_producer', $definition);
    }
}
