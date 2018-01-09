<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Send\Response;

class SendProcessor implements ProcessorInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\NodeInterface
     */
    protected function getConfig()
    {
        $tree = new TreeBuilder();

        $root = $tree->root('response');
        $root->children()->scalarNode('protocol')->isRequired()->cannotBeEmpty()->end();

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

        return new Response($parsed);
    }
}
