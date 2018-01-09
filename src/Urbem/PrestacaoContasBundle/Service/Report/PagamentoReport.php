<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\PagamentoModel;

/**
 * Class PagamentoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class PagamentoReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $entidades = $entidadesModel->getEntidades($exercicio);
        $entidades = array_map(function (array $entidade) {
            return $entidade['cod_entidade'];
        }, $entidades);

        $pagamentos = [];
        if (count($entidades) > 0) {
            $pagamentos = (new PagamentoModel($this->entityManager))
                ->getDadosExportacao($exercicio, $entidades, $dataInicial, $dataFinal);
        }

        return $this->selectColumnsToReport($pagamentos, [
            'cod_empenho',
            'cod_entidade',
            'cod_ordem',
            'data_pagamento',
            'vl_pago',
            'sinal_valor',
            'observacao',
            'exercicio_empenho',
        ]);
    }
}
