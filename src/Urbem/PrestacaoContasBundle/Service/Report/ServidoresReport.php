<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Model\CargosModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\ServidoresModel;

/**
 * Class ServidoresReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class ServidoresReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $cargosModel = new CargosModel($this->entityManager);
        $entidadesModel = new EntidadesModel($this->entityManager);
        $servidoresModel = new ServidoresModel($this->entityManager);

        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        $entidades = $entidadesModel->getEntidades($exercicio);

        $entidadesSchemas = [];
        foreach ($entidades as $entidade) {
            $codEntidade = $entidade['cod_entidade'];
            if ($codEntidade == $codEntidadePrefeitura) {
                $entidadesSchemas[] = $codEntidade;
            } elseif ($cargosModel->hasEsquemaForEntidade('pessoal', $codEntidade)) {
                $entidadesSchemas[] = $codEntidade;
            }
        }

        $servidores = [];
        foreach ($entidadesSchemas as $codEntidade) {
            $stEntidade = "";
            $folhaPagamentoSchemaName = 'folhapagamento';

            if ($codEntidade != $codEntidadePrefeitura
                && $cargosModel->hasEsquemaForEntidade('folhapagamento', $codEntidade)) {
                $folhaPagamentoSchemaName = sprintf('%s_%d', $folhaPagamentoSchemaName, $codEntidade);
                $stEntidade = sprintf('_%d', $codEntidade);
            }

            $periodosMovimentacao = $cargosModel
                ->getIntervaloPeriodosMovimentacaoCompetencia($dataInicial, $dataFinal, $folhaPagamentoSchemaName);

            foreach ($periodosMovimentacao as $periodoMovimentacao) {
                $dadosExportaçao =
                    $servidoresModel->getDadosExportacao($periodoMovimentacao['cod_periodo_movimentacao'], $codEntidade, $stEntidade);

                $servidores = array_merge($servidores, $dadosExportaçao);
            }
        }

        return $this->selectColumnsToReport($servidores, [
            'cod_entidade',
            'mesano',
            'matricula',
            'nom_cgm',
            'situacao',
            'dt_admissao',
            'ato_nomeacao',
            'dt_rescisao',
            'descricao_causa_rescisao',
            'descricao_regime_funcao',
            'descricao_sub_divisao_funcao',
            'descricao_funcao',
            'descricao_especialidade_funcao',
            'descricao_padrao',
            'horas_mensais',
            'lotacao',
            'descricao_lotacao',
            'descricao_local',
        ]);
    }
}
