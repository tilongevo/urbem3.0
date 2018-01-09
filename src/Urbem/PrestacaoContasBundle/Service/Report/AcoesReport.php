<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\AcoesModel;

/**
 * Class ReportAcoes
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class AcoesReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $acoesModel = new AcoesModel($this->entityManager);
        $acoesData = $acoesModel->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($acoesData, ['exercicio', 'num_pao', 'nom_pao']);
    }
}
