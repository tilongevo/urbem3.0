<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class EntidadesReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class EntidadesReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidades = (new EntidadesModel($this->entityManager))->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($entidades, [
            'cod_entidade',
            'nom_cgm',
        ]);
    }
}
