<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\RubricaModel;

/**
 * Class RubricaReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class RubricaReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $rubricas = (new RubricaModel($this->entityManager))
            ->getDadosExportacao($exercicio);

        return $this->selectColumnsToReport($rubricas, [
            'exercicio',
            'cod_estrutural',
            'descricao',
            'tnc',
            'nnc',
        ]);
    }

}
