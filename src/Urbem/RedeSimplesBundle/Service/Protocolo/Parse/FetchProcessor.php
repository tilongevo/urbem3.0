<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\Field;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollection;

class FetchProcessor implements ProcessorInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\NodeInterface
     */
    protected function getConfig()
    {
        $tree = new TreeBuilder();

        $root = $tree->root('form');
        $root->children()
            ->arrayNode('fields')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('type')->cannotBeEmpty()->defaultValue('text')->end()
                        ->scalarNode('label')->isRequired()->cannotBeEmpty()->end()
                        ->booleanNode('required')->defaultFalse()->end()
                        ->variableNode('multiple')->defaultValue(null)->end()
                        ->variableNode('auto_populate')->defaultValue(null)->end()
                        ->variableNode('return_object_key')->defaultValue(null)->end()
                        ->variableNode('field_not_in')->defaultValue(null)->end()
                        ->scalarNode('style')->defaultValue(null)->end()
                        ->variableNode('data')->defaultValue(null)->end()
                        ->arrayNode('choices')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('value')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('label')->isRequired()->cannotBeEmpty()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $tree->buildTree();
    }

    /**
     * @param FetcherResultInterface $result
     * @param ParserInterface $parser
     * @return FieldCollection
     * @throws ProtocoloException
     */
    public function process(FetcherResultInterface $result, ParserInterface $parser)
    {
        $config = $parser->parse($result);

        if (false === is_array($config)) {
            throw ProtocoloException::expectedMethodReturnType(ParserInterface::class, 'parse', 'array', $config);
        }

        $parsed = (new Processor())->process($this->getConfig(), $config);

        $parsed['fields'] = array_map(function ($field) {
            return new Field($field);
        }, $parsed['fields']);

        return new FieldCollection($parsed['fields']);
    }
}
