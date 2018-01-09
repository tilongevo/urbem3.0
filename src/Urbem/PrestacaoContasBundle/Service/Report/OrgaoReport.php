<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\OrgaoModel;

/**
 * Class OrgaoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class OrgaoReport extends AbstractReport
{
    /**
     * @return array
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $orgaos = (new OrgaoModel($this->entityManager))->getDadosExportacao();

        return $this->selectColumnsToReport($orgaos, [
            'exercicio',
            'num_orgao',
            'nom_orgao'
        ]);
    }
}
