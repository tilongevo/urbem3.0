<?php

namespace Urbem\PrestacaoContasBundle\Form\Builder;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;

class FormBuilder extends \Urbem\RedeSimplesBundle\Service\Protocolo\FormBuilder
{
    /**
     * @return FetcherResultInterface
     * @throws ProtocoloException
     */
    public function getCachedResult()
    {
        return $this->fetcher->fetch($this->parameters);
    }
}
