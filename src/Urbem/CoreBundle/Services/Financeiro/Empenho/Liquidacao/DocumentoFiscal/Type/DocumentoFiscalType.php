<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\Type;

use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;

abstract class DocumentoFiscalType
{
    abstract public function form(DocumentoFiscal $documentoFiscal);

    abstract public function execute(DocumentoFiscal $documentoFiscal);

    abstract public function getInfo(DocumentoFiscal $documentoFiscal);
}
