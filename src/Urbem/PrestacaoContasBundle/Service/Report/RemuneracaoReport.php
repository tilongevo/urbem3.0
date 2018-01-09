<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\RemuneracaoModel;

/**
 * Class RemuneracaoReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class RemuneracaoReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $remuneracaoModel = new RemuneracaoModel($this->entityManager);
        $entidadesModel = new EntidadesModel($this->entityManager);

        $entidades = $entidadesModel->getEntidades($exercicio);

        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        $intervalosPeriodoMovimentacao = $remuneracaoModel
            ->getIntervaloPeriodosMovimentacaoDaSituacao($dataInicial, $dataFinal);


        $remuneracoes = [];
        foreach ($entidades as $entidade) {
            $hasSchema = $entidadesModel->hasEsquemaForEntidade('pessoal', $entidade['cod_entidade']);
            $codEntidade = $entidade['cod_entidade'];
            $stEntidade = '';

            if ($codEntidade != $codEntidadePrefeitura) {
                $stEntidade = sprintf('_%d', $codEntidade);
            } else {
                $hasSchema = true;
            }

            if ($hasSchema == true) {
                foreach ($intervalosPeriodoMovimentacao as $intervaloPeriodoMovimentacao) {
                    $dataCompetencia = DateTime::createFromFormat('Y-m-d', $intervaloPeriodoMovimentacao['dt_final']);

                    $dadosExportacao =
                        $remuneracaoModel->getDadosExportacao($dataCompetencia, $codEntidade, $exercicio, $stEntidade, $intervaloPeriodoMovimentacao['cod_periodo_movimentacao']);

                    $remuneracoes = array_merge($remuneracoes, $dadosExportacao);
                }
            }
        }
        
        return $this->selectColumnsToReport($remuneracoes, [
            'cod_entidade',
            'mesano',
            'registro',
            'cgm',
            'remuneracao_bruta',
            'redutor_teto',
            'remuneracao_natalina',
            'remuneracao_ferias',
            'remuneracao_outras',
            'deducoes_irrf',
            'deducoes_obrigatorias',
            'demais_deducoes',
            'remuneracao_apos_deducoes',
            'salario_familia',
            'jetons',
            'verbas',
        ]);
    }
}
