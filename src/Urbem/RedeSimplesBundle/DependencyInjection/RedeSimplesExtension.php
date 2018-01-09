<?php

namespace Urbem\RedeSimplesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Urbem\RedeSimplesBundle\Service\Protocolo\Cache\FileCache;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\Implementation\RestFetcher;
use Urbem\RedeSimplesBundle\Service\Protocolo\FormBuilder;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBag;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\FetchProcessor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\Implementation\JSON\JsonParser;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\SendProcessor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\StatusProcessor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Transaction\SendTransaction;
use Urbem\RedeSimplesBundle\Service\Protocolo\Transaction\StatusTransaction;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class RedeSimplesExtension extends Extension
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

        /* http://symfony.com/doc/current/service_container/definitions.html */

        /* Form Create */
        $definition = new Definition(FormBuilder::class);
        $definition->addArgument(new Definition(FetchProcessor::class));
        $definition->addArgument(new Definition(RestFetcher::class));
        $definition->addArgument(new Definition(JsonParser::class));
        $definition->addArgument(new Definition(FileCache::class, [$config['cache_dir']]));
        $definition->addArgument(new Definition(ParameterBag::class, [$config['form_create'] + [ParameterBag::CACHE_KEY => 'form_create']]));

        $container->setDefinition('rede_simples.form_create', $definition);

        /* Form Send */
        $definition = new Definition(SendTransaction::class);
        $definition->addArgument(new Reference('rede_simples.protocolo.model'));
        $definition->addArgument(new Definition(SendProcessor::class));
        $definition->addArgument(new Definition(RestFetcher::class));
        $definition->addArgument(new Definition(JsonParser::class));
        $definition->addArgument(new Definition(ParameterBag::class, [$config['form_create']]));

        $container->setDefinition('rede_simples.form_send_transaction', $definition);

        /* Form Status */
        $definition = new Definition(StatusTransaction::class);
        $definition->addArgument(new Reference('rede_simples.protocolo.model'));
        $definition->addArgument(new Definition(StatusProcessor::class));
        $definition->addArgument(new Definition(RestFetcher::class));
        $definition->addArgument(new Definition(JsonParser::class));
        $definition->addArgument(new Definition(ParameterBag::class, [$config['form_create']]));

        $container->setDefinition('rede_simples.form_status_transaction', $definition);
    }
}
