<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\UnidadesModel;

/**
 * Class UnidadesReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class UnidadesReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $subFuncoes = (new UnidadesModel($this->entityManager))
            ->getDadosExportacao();

        return $this->selectColumnsToReport($subFuncoes, [
            'exercicio',
            'num_orgao',
            'num_unidade',
            'nom_unidade'
        ]);
    }

}
