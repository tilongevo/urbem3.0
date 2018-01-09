<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\Field;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Status\Response;

class StatusProcessor implements ProcessorInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\NodeInterface
     */
    protected function getConfig()
    {
        $tree = new TreeBuilder();

        $root = $tree->root('response');
        $root->children()
            ->scalarNode('message')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('status')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('fields')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('label')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('data')->defaultValue(null)->end()

                    ->end()
                ->end()
            ->end()
        ->end();

        return $tree->buildTree();
    }

    /**
     * @param FetcherResultInterface $result
     * @param ParserInterface $parser
     * @return Response
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
            $field['type'] = 'text';
            $field['required'] = false;
            $field['choices'] = [];

            return new Field($field);
        }, $parsed['fields']);

        return new Response($parsed);
    }
}
