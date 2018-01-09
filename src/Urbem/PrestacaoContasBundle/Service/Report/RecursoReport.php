<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\RecursoModel;

/**
 * Class RecursoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class RecursoReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $recursos = (new RecursoModel($this->entityManager))
            ->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($recursos, [
            'cod_recurso',
            'nom_recurso'
        ]);
    }

}
