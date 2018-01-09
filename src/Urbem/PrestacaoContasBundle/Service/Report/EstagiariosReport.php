<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateInterval;
use DateTime;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\EstagiariosModel;

/**
 * Class UnidadesReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class EstagiariosReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    protected function setDataFinal(DateTime $dataFinal, DateTime $dataInicial)
    {
        if ($dataInicial->format('m') == $dataFinal->format('m')) {
            $dataFinal->add((new DateInterval('P1M')));
        }

        return $dataFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $this->setDataFinal($dataFinal, $dataInicial);

        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        $entidadesModel = new EntidadesModel($this->entityManager);
        $estagiariosModel = new EstagiariosModel($this->entityManager);

        $entidades = [];
        foreach ($entidadesModel->getEntidades($exercicio) as $entidade) {
            $codEntidade = $entidade['cod_entidade'];

            if ($entidadesModel->hasEsquemaForEntidade('pessoal', $codEntidade) || $codEntidade == $codEntidadePrefeitura) {
                $entidades[] = $entidade;
            }
        }

        $estagiarios = [];
        foreach ($entidades as $entidade) {
            $codEntidade = $entidade['cod_entidade'];
            $stEntidade = '';

            if ($codEntidadePrefeitura != $codEntidade) {
                $stEntidade = sprintf('_%d', $codEntidade);
            }

            $folhaSituacaoPeriodos = $estagiariosModel
                ->getFolhaSituacaoPeriodo($stEntidade, $dataInicial, $dataFinal);

            foreach ($folhaSituacaoPeriodos as $folhaSituacaoPeriodo) {
                $dadosExportacao = $estagiariosModel->getDadosExportacao($codEntidade, $exercicio, $folhaSituacaoPeriodo['cod_periodo_movimentacao'], $stEntidade);
                $estagiarios = array_merge($estagiarios, $dadosExportacao);
            }
        }

        return $this->selectColumnsToReport($estagiarios, [
            'numero_entidade',
            'mes_ano',
            'numero_estagio',
            'nom_cgm',
            'data_inicio',
            'data_final',
            'data_renovacao',
            'descricao_lotacao',
            'descricao_local',
        ]);
    }
}
