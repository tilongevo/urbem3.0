<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\FuncoesModel;

/**
 * Class FuncoesReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class FuncoesReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $funcoes = (new FuncoesModel($this->entityManager))->getDadosExportacao();

        return $this->selectColumnsToReport($funcoes, [
            'exercicio',
            'cod_funcao',
            'descricao',
        ]);
    }
}
