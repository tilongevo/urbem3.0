<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

use Urbem\CoreBundle\Helper\MonthsHelper;

class Rreo extends StnAbstract implements StnInterface
{

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/stn-rreo.js'
        ];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return "$(document).ready(function() {".
            "$('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbMes').hide();
                $('#' + UrbemSonata.uniqId + '_assinaturas').removeAttr(\"required\");".
            "});";
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();

        $exercicio = $this->factory->getSession()->getExercicio();

        // Checa mês ou bimestre
        if (isset($params['tipoRelatorio']) && $params['tipoRelatorio'] == "opt_mes") {
            $mes = $params['cmbMes'];
            $params['titulo_periodo'] =  sprintf("%s de %s", MonthsHelper::$monthList[$mes], $exercicio);
            $params['periodo'] = $mes;
            $params['dt_inicial'] = sprintf("01/%s/%s", $mes, $exercicio);
            $params['dt_final'] = sprintf("%s/%s/%s", date('t', strtotime("{$exercicio}-{$mes}-01")), $mes, $exercicio);
            $params['dt_final_restos'] = sprintf("01/01/%s", $exercicio + 1);
            $params['tipo_periodo'] = "Mês";
            $params['periodo_extenso'] = "Mês";
            $params['tipo_periodo_Maisc'] = "MÊS";

        } elseif (isset($params['cmbBimestre'])) {
            $bimestre = $params['cmbBimestre'];

            list($dataInicial, $dataFinal) = MonthsHelper::periodInitialFinalTwoMonths($bimestre, $exercicio);
            $params['dt_inicial'] = $dataInicial;
            $params['dt_final'] = $dataFinal;
            $params['dt_final_periodo'] = $dataFinal;

            $params['mes_anterior'] = MonthsHelper::getTwoMonthsName($bimestre);
            $mes = \DateTime::createFromFormat("d/m/Y", $dataFinal);
            $params['mes'] = $mes->format('m');
            $params['periodo_referencia'] = sprintf("%sº BIMESTRE DE %s", $bimestre, $exercicio);

            $params['periodo'] = $bimestre;
            $params['periodo_extenso'] = "Bimestre";
            $params['titulo_periodo'] =  sprintf("%s° bimestre de %s", $bimestre, $exercicio);
            $params['descricaoPeriodo'] = sprintf("%sº Bimestre de %s", $bimestre, $exercicio);
            $params['nome_periodo'] = sprintf("%sº Bimestre de %s", $bimestre, $exercicio);

            $params['bimestre'] =  $bimestre;
        }
        $params['dt_final_restos'] = sprintf("01/01/%s", $exercicio + 1);

        $params = $this->hasPacoteEducacao($params);
        $params = $this->isLastTwoMonths($params);
        $params['entidade'] = $params['cod_entidade'];

        unset($params['assinaturas']);

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    private function hasPacoteEducacao(array $params)
    {
        $multiplier = 100;
        if (isset($params['pct_educacao'])) {
            $pctEducacao = $params['pct_educacao'] * $multiplier;
            $params['pct_educacao'] = number_format((float)$pctEducacao, 2, '.', '');

            return $params;
        }

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    private function isLastTwoMonths(array $params)
    {
        if (isset($params['bo_ultimo_bimestre'])) {
            if (count(MonthsHelper::$twoMonthsNameList)  == (int) $params['cmbBimestre']) {
                $params['bo_ultimo_bimestre'] = "true";
            }

            return $params;
        }

        return $params;
    }
}
