<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Model\CargosModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\CedidosAdidosModel;

/**
 * Class CedidosAdidosReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class CedidosAdidosReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        $entidadesModel = new EntidadesModel($this->entityManager);
        $cedidosAdidosModel = new CedidosAdidosModel($this->entityManager);

        $entidades = [];
        foreach ($entidadesModel->getEntidades($exercicio) as $entidade) {
            $codEntidade = $entidade['cod_entidade'];

            if ($cedidosAdidosModel->hasEsquemaForEntidade('pessoal', $codEntidade) || $codEntidade == $codEntidadePrefeitura) {
                $entidades[] = $entidade;
            }
        }

        $periodosMovimentacao = $cedidosAdidosModel
            ->getIntervaloPeriodosMovimentacaoCompetencia($dataInicial, $dataFinal, 'folhapagamento');

        $cedidosAdidos = [];
        foreach ($periodosMovimentacao as $periodoMovimentacao) {
            foreach ($entidades as $entidade) {
                $codEntidade = $entidade['cod_entidade'];
                $stEntidade = "";

                if ($codEntidadePrefeitura != $codEntidade) {
                    $stEntidade = sprintf('_%d', $codEntidade);
                }

                $dadosExportacao = $cedidosAdidosModel
                    ->getDadosExportacao($exercicio, $stEntidade, $periodoMovimentacao['cod_periodo_movimentacao'], $entidade['cod_entidade']);

                $cedidosAdidos = array_merge($cedidosAdidos, $dadosExportacao);
            }
        }

        return $this->selectColumnsToReport($cedidosAdidos, [
            'numero_entidade',
            'mes_ano',
            'matricula_servidor',
            'nom_cgm',
            'situacao',
            'ato_cedencia',
            'dt_inicial',
            'dt_final',
            'tipo_cedencia',
            'indicativo_onus',
            'orgao_cedente_cessionario',
            'num_convenio',
            'local',
        ]);
    }
}
