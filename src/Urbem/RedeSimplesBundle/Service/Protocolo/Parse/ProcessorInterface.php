<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollectionInterface;

interface ProcessorInterface
{
    /**
     * @param FetcherResultInterface $result
     * @param ParserInterface $parser
     * @return FieldCollectionInterface
     */
    public function process(FetcherResultInterface $result, ParserInterface $parser);
}
