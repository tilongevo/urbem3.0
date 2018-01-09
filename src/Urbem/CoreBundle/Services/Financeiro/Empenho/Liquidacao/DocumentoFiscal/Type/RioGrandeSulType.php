<?php

namespace Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\Type;

use Urbem\CoreBundle\Entity\Tcers\NotaFiscal;
use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;

class RioGrandeSulType extends DocumentoFiscalType
{
    public function form(DocumentoFiscal $documentoFiscal)
    {
        $fieldOptions = [];

        $fieldOptions['inNumeroNF']['type'] = 'number';
        $fieldOptions['inNumeroNF']['options'] = [
            'label' => 'label.numeroDocumentoFiscal',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['inNumSerie']['type'] = 'text';
        $fieldOptions['inNumSerie']['options'] = [
            'label' => 'Série do Docto Fiscal',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['dtEmissaoNF']['type'] = 'sonata_type_date_picker';
        $fieldOptions['dtEmissaoNF']['options'] = [
            'label' => 'label.dtEmissao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => false,
            'dp_default_date' => date('d/m/Y')
        ];

        return $fieldOptions;
    }

    public function execute(DocumentoFiscal $documentoFiscal)
    {
        // Inclui dados em tcers.nota_fiscal
        $dataForm = $documentoFiscal->getDataForm();

        if (is_null($dataForm['inNumeroNF']->getViewData()) || $dataForm["inNumeroNF"]->getViewData() == '') {
            return false;
        }

        if (is_null($dataForm['inNumSerie']->getViewData()) || $dataForm["inNumSerie"]->getViewData() == '') {
            return false;
        }

        $dtEmissaoNF = \DateTime::createFromFormat("d/m/Y", $dataForm['dtEmissaoNF']->getViewData());

        $notaFiscal = new NotaFiscal();
        $notaFiscal->setFkEmpenhoNotaLiquidacao($documentoFiscal->getNotaLiquidacao());
        $notaFiscal->setNroNota($dataForm['inNumeroNF']->getViewData());
        $notaFiscal->setNroSerie($dataForm['inNumSerie']->getViewData());
        $notaFiscal->setDataEmissao($dtEmissaoNF);

        $documentoFiscal->getEntityManager()->persist($notaFiscal);
        $documentoFiscal->getEntityManager()->flush();
    }

    public function getInfo(DocumentoFiscal $documentoFiscal)
    {
        list($codEmpenho, $codEntidade, $exercicio) = explode('~', $documentoFiscal->getCodEmpenho());

        $em = $documentoFiscal->getEntityManager();

        $notaLiquidacao = $em->getRepository('CoreBundle:Empenho\\NotaLiquidacao')
            -> findOneBy([
                'codEmpenho' => $codEmpenho,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        if (is_null($notaLiquidacao)) {
            return false;
        }

        $notaFiscal = $em->getRepository('CoreBundle:Tcers\\NotaFiscal')
            -> findOneBy([
                'codNota' => $notaLiquidacao->getCodNota(),
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        return $this->getHtml($notaFiscal);
    }

    protected function getHtml($notaFiscal)
    {
        if (empty($notaFiscal)) {
            return '';
        }

        $html = '
            <table class="table table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="text-right">NÚMERO DA NOTA FISCAL</th>
                    <th class="text-right">SÉRIE</th>
                    <th class="text-right">DATA DE EMISSÃO</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-right">'
                        . $notaFiscal->getNroNota() .
                        '</td>
                        <td class="text-right">'
                        . $notaFiscal->getNroSerie() .
                        '</td><td>'
                        . $notaFiscal->getDtEmissao()->format('d/m/Y') .
                        '</td>
                    </tr>
                </tbody>
            </table>';

        return $html;
    }
}
