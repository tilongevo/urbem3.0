<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\EmpenhoModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class EmpenhoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class EmpenhoReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $empenhoModel = new EmpenhoModel($this->entityManager);

        $entidades = $entidadesModel->getEntidades($exercicio);

        $empenhos = [];
        foreach ($entidades as $entidade) {
            $dadosExportacao = $empenhoModel->getDadosExportacao($exercicio, $dataInicial, $dataFinal, $entidade['cod_entidade']);
            $empenhos = array_merge($empenhos, $dadosExportacao);
        }

        return $this->selectColumnsToReport($empenhos, [
            'cod_entidade',
            'num_orgao',
            'num_unidade',
            'cod_funcao',
            'cod_subfuncao',
            'cod_programa',
            'cod_subprograma',
            'num_pao',
            'cod_estrutural',
            'cod_recurso',
            'contrapartida',
            'num_empenho',
            'dt_empenho',
            'vl_empenhado',
            'sinal',
            'cgm',
            'historico',
            'nom_modalidades',
            'nro_licitacao',
            'exercicio',
        ]);
    }
}
