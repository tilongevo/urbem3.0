<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\LiquidacaoModel;

/**
 * Class Liquidacao
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class LiquidacaoReport extends AbstractReport
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

        $liquidacoes = [];
        if (count($entidades) > 0) {
            $liquidacoes = (new LiquidacaoModel($this->entityManager))
                ->getDadosExportacao($exercicio, $entidades, $dataInicial, $dataFinal);
        }

        return $this->selectColumnsToReport($liquidacoes, [
            'cod_empenho',
            'cod_entidade',
            'cod_nota',
            'data_pagamento',
            'valor_liquidacao',
            'sinal_valor',
            'observacao',
            'exercicio',
        ]);
    }
}
