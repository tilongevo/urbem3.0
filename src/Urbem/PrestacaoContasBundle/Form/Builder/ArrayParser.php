<?php

namespace Urbem\PrestacaoContasBundle\Form\Builder;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ParserInterface;

class ArrayParser implements ParserInterface
{
    /**
     * @param FetcherResultInterface $result
     *
     * @return array
     */
    public function parse(FetcherResultInterface $result)
    {
        $data = $result->getData();

        if (false === is_array($data)) {
            throw new \InvalidArgumentException(sprintf(
                '%s->getData() expected a valid array as return. %s was given',
                get_class($result),
                gettype($data)
            ));
        }

        return $data;
    }
}
