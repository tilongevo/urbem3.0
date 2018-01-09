<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\Type;

use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;

class AlagoasType extends DocumentoFiscalType
{
    public function form(DocumentoFiscal $documentoFiscal)
    {
        $fieldOptions = [];

        $fieldOptions['codTipo']['type'] = 'entity';
        $fieldOptions['codTipo']['options'] = [
            'class' => 'CoreBundle:Tceal\TipoDocumento',
            'choice_label' => 'descricao',
            'label' => 'label.tipoDocumento',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $fieldOptions['nroDocumento']['type'] = 'number';
        $fieldOptions['nroDocumento']['options'] = [
            'label' => 'label.nroDocumento',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['dtDocumento']['type'] = 'sonata_type_date_picker';
        $fieldOptions['dtDocumento']['options'] = [
            'label' => 'label.dtDocumento',
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_default_date' => date('d/m/Y')
        ];

        $fieldOptions['descricao']['type'] = 'text';
        $fieldOptions['descricao']['options'] = [
            'label' => 'label.descricao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['autorizacao']['type'] = 'text';
        $fieldOptions['autorizacao']['options'] = [
            'label' => 'label.autorizacaoNota',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['modeloNotaFiscal']['type'] = 'text';
        $fieldOptions['modeloNotaFiscal']['options'] = [
            'label' => 'label.modeloNotaFiscal',
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
