<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal;

class DocumentoFiscalFactory
{
    public function getDocumentoFiscalType($documentoFiscalType)
    {
        $className = __NAMESPACE__ . '\\Type\\' . ucfirst($documentoFiscalType) . "Type";

        if (! class_exists($className)) {
            throw new \RuntimeException('Incorrect type [documento fiscal]');
        }

        return new $className;
    }
}
