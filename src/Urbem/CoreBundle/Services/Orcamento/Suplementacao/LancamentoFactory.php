<?php

namespace Urbem\CoreBundle\Services\Orcamento\Suplementacao;

class LancamentoFactory
{
    public function getLancamentoType($lancamentoType)
    {
        $className = __NAMESPACE__ . '\\Type\\' . ucfirst($lancamentoType) . "Type";

        if (! class_exists($className)) {
            throw new \RuntimeException('Incorrect project type');
        }

        return new $className;
    }
}
