<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\BalanceteDespesaModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class BalanceteDespesaReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class BalanceteDespesaReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $balanceteDespesaModel = new BalanceteDespesaModel($this->entityManager);

        $balancetesDepesa = [];
        $entidades = $entidadesModel->getEntidades($exercicio);

        if (count($entidades) > 0) {
            $entidades = $this->selectColumnsToReport($entidades, ['cod_entidade']);
            $entidades = array_map(function (array $entidade) {
                return $entidade['cod_entidade'];
            }, $entidades);

            $balancetesDepesa = $balanceteDespesaModel->getDadosExportacao($exercicio, $dataInicial, $dataFinal, $entidades);
            $balancetesDepesa = $this->selectColumnsToReport($balancetesDepesa, [
                'cod_entidade',
                'num_orgao',
                'num_unidade',
                'cod_funcao',
                'cod_subfuncao',
                'cod_programa',
                'num_pao',
                'cod_subelemento',
                'cod_recurso',
                'saldo_inicial',
                'atualizacao',
                'credito_suplementar',
                'credito_especial',
                'credito_extraordinario',
                'reducoes',
                'suplementacoes',
                'reducao',
                'vl_empenho',
                'liquidado_per',
                'pago_per',
            ]);

            return $balancetesDepesa;
        }
    }
}
