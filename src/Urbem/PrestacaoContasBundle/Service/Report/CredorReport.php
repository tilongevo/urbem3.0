<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\CredorModel;

/**
 * Class CredorReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class CredorReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $credores = (new CredorModel($this->entityManager))->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($credores, [
            'cod_credor',
            'credor',
            'cpf_cnpj_credor',
        ]);
    }
}
