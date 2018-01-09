<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\Type;

use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;

class MinasGeraisType extends DocumentoFiscalType
{
    public function form(DocumentoFiscal $documentoFiscal)
    {
        $fieldOptions = [];

        $fieldOptions['inscricaoMunicipal']['type'] = 'text';
        $fieldOptions['inscricaoMunicipal']['options'] = [
            'label' => 'Inscrição Municipal',
            'mapped' => false,
            'required' => false
        ];

        return $fieldOptions;
    }

    public function execute(DocumentoFiscal $documentoFiscal)
    {
        // TODO: Implement execute() method.
    }

    public function getInfo(DocumentoFiscal $documentoFiscal)
    {
        // TODO: Implement getInfo() method.
    }
}
