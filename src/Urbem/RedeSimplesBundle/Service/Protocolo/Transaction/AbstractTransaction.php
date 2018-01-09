<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Transaction;

use Urbem\CoreBundle\Entity\RedeSimples\Protocolo;
use Urbem\RedeSimplesBundle\Model\ProtocoloModel;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBagInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ParserInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ProcessorInterface;

abstract class AbstractTransaction
{
    /**
     * @var ProtocoloModel
     */
    protected $protocoloModel;

    /**
     * @var ProcessorInterface
     */
    protected $processor;

    /**
     * @var FetcherInterface
     */
    protected $fetcher;

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var ParameterBagInterface
     */
    protected $parameters;

    /**
     * Status constructor.
     * @param ProtocoloModel $protocoloModel
     * @param ProcessorInterface $processor
     * @param FetcherInterface $fetcher
     * @param ParserInterface $parser
     * @param ParameterBagInterface $parameters
     */
    public function __construct(
        ProtocoloModel $protocoloModel,
        ProcessorInterface $processor,
        FetcherInterface $fetcher,
        ParserInterface $parser,
        ParameterBagInterface $parameters)
    {
        $this->protocoloModel = $protocoloModel;
        $this->processor = $processor;
        $this->fetcher = $fetcher;
        $this->parser = $parser;
        $this->parameters = $parameters;
    }

    /**
     * @param Protocolo $protocolo
     * @return Protocolo
     */
    abstract public function transact(Protocolo $protocolo);
}
