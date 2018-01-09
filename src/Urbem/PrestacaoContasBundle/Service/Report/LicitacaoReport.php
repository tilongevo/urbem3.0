<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\LicitacaoModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class LicitacaoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class LicitacaoReport extends AbstractReport
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

        $licitacoes = [];
        if (count($entidades) > 0) {
            $licitacoes = (new LicitacaoModel($this->entityManager))
                ->getDadosExportacao($exercicio, $entidades, $dataInicial, $dataFinal);
        }

        return $this->selectColumnsToReport($licitacoes, [
            'exercicio_entidade',
            'cod_entidade',
            'cod_licitacao',
            'modalidade',
            'exercicio_empenho',
            'cod_empenho',
            'descricao_tipo_licitacao',
            'descricao_tipo_objeto',
            'descricao_objeto',
            'dt_compra_licitacao'
        ]);
    }
}
