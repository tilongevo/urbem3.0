<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\ComprasModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class ComprasReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class ComprasReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $comprasModel = new ComprasModel($this->entityManager);

        $entidades = $entidadesModel->getEntidades($exercicio);
        $entidades = array_map(function (array $entidade) {
            return $entidade['cod_entidade'];
        }, $entidades);

        $compras = [];
        if (count($entidades) > 0) {
            $compras = $comprasModel->getDadosExportacao($exercicio, $entidades, $dataInicial, $dataFinal);
        }

        return $this->selectColumnsToReport($compras, [
            'exercicio_entidade',
            'cod_entidade',
            'cod_compra_direta',
            'modalidade',
            'exercicio_empenho',
            'cod_empenho',
            'descricao_tipo_licitacao',
            'descricao_tipo_objeto',
            'descricao_objeto',
            'dt_compra_licitacao',
        ]);
    }
}
