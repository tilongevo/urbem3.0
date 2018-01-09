<?php

namespace Urbem\PrestacaoContasBundle\Form\Builder;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBagInterface;

/**
 * Class ExportTransparencia
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class FieldsFetcher implements FetcherInterface
{
    public function fetch(ParameterBagInterface $parameters)
    {
        return new FetcherResult(['form' => ['fields' => $parameters->get('fields')]]);
    }
}
