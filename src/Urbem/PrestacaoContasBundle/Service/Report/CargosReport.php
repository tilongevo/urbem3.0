<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Model\CargosModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class CargosReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class CargosReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        $entidadesModel = new EntidadesModel($this->entityManager);
        $cargosModel = new CargosModel($this->entityManager);

        $entidades = [];
        foreach ($entidadesModel->getEntidades($exercicio) as $entidade) {
            $codEntidade = $entidade['cod_entidade'];

            if ($cargosModel->hasEsquemaForEntidade('pessoal', $codEntidade) || $codEntidade == $codEntidadePrefeitura) {
                $entidades[] = $entidade;
            }
        }

        $cargos = [];
        foreach ($entidades as $entidade) {
            $codEntidade = $entidade['cod_entidade'];

            $folhaPagamentoSchemaName = 'folhapagamento';
            $stEntidade = "";

            if ($codEntidadePrefeitura != $codEntidade
                && $cargosModel->hasEsquemaForEntidade('folhapagamento', $codEntidade)) {
                $folhaPagamentoSchemaName = sprintf('%s_%d', $folhaPagamentoSchemaName, $codEntidade);
                $stEntidade = sprintf('_%d', $codEntidade);
            }

            $periodosMovimentacao = $cargosModel
                ->getIntervaloPeriodosMovimentacaoCompetencia($dataInicial, $dataFinal, $folhaPagamentoSchemaName);

            foreach ($periodosMovimentacao as $periodoMovimentacao) {
                $ultimoTimestampPeriodoMovimentacao = $cargosModel
                    ->getUltimoTimestampPeriodoMovimentacao($stEntidade, $periodoMovimentacao['cod_periodo_movimentacao']);

                $ultimoTimestampPeriodoMovimentacao = $ultimoTimestampPeriodoMovimentacao['ultimotimestampperiodomovimentacao'];

                $dadosExportacao = $cargosModel->getDadosExportacao($ultimoTimestampPeriodoMovimentacao, $exercicio, $stEntidade, $codEntidade, $periodoMovimentacao['cod_periodo_movimentacao']);

                $cargos = array_merge($cargos, $dadosExportacao);
            }
        }

        return $this->selectColumnsToReport($cargos, [
            'numero_entidade',
            'mes_ano',
            'codigo',
            'descricao_cargo',
            'tipo_cargo',
            'lei',
            'descricao_padrao',
            'cargahoraria_mensal',
            'cargahoraria_semanal',
            'valor',
            'vigencia',
            'regime_subdivisao',
            'vagas_criadas',
            'vagas_ocupadas',
            'vagas_disponiveis'
        ]);
    }
}
