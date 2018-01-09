<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\ProgramaModel;

/**
 * Class ProgramaReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class ProgramaReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $programas = (new ProgramaModel($this->entityManager))->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($programas, [
            'exercicio',
            'cod_programa',
            'descricao'
        ]);
    }
}
