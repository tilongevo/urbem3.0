<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\BalanceteReceitaModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class BalanceteReceitaReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class BalanceteReceitaReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $balanceteReceitaModel = new BalanceteReceitaModel($this->entityManager);

        $entidades = $entidadesModel->getEntidades($exercicio);

        $balancetesReceita = [];
        foreach ($entidades as $entidade) {
            $codEntidade = $entidade['cod_entidade'];

            $results = $balanceteReceitaModel->getDadosExportacao($exercicio, $dataInicial, $dataFinal, $codEntidade);
            $balancetesReceita = array_merge($balancetesReceita, $results);
        }

        return $this->selectColumnsToReport($balancetesReceita, [
            'entidade',
            'cod_estrutural',
            'orgao',
            'unidade',
            'vl_original',
            'ar_jan',
            'ar_fev',
            'ar_mar',
            'ar_abr',
            'ar_mai',
            'ar_jun',
            'ar_jul',
            'ar_ago',
            'ar_set',
            'ar_out',
            'ar_nov',
            'ar_dez',
            'descricao',
            'tipo',
            'nivel',
            'cod_recurso',
        ]);
    }
}
