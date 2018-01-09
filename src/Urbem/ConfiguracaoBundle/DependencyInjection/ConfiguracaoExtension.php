<?php

namespace Urbem\ConfiguracaoBundle\DependencyInjection;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Urbem\ConfiguracaoBundle\Service\Configuration\ConfigurationReader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ConfiguracaoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /* http://symfony.com/doc/current/service_container/definitions.html */

        $list = [];

        foreach ($config as $service => $moduleConfig) {
            $name = sprintf('configuration.%s', $service);
            $alias = sprintf('configuration.%s', $moduleConfig['module_id']);

            $list[] = new Reference($name);

            $definition = new Definition(ConfigurationReader::class);
            $definition->setLazy(true);
            $definition->addArgument(new Reference('doctrine.orm.entity_manager'));
            $definition->addArgument([
                'id' => $moduleConfig['module_id'],
                'name' => $moduleConfig['module_name'],
                'image' => $moduleConfig['module_image'],
                'service' => $service,
                'groups' => $moduleConfig['groups'],
            ]);

            $container->setDefinition($name, $definition);
            $container->setAlias($alias, $name);
        }

        $container->setDefinition('configuration.list', new Definition(ArrayCollection::class, [$list]));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
