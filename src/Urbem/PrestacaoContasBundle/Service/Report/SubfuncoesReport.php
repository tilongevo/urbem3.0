<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\SubfuncoesModel;

/**
 * Class RubricaReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class SubfuncoesReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $subFuncoes = (new SubfuncoesModel($this->entityManager))
            ->getDadosExportacao();

        return $this->selectColumnsToReport($subFuncoes, [
            'exercicio',
            'cod_subfuncao',
            'descricao'
        ]);
    }

}
