<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;

class Rgf extends StnAbstract implements StnInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/stn-rgf.js'
        ];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return "$(document).ready(function() {" .
        "$('#' + UrbemSonata.uniqId + '_assinaturas').removeAttr(\"required\");" .
        "});";
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();

        $params = $this->setDatesAndPeriod($params);
        $entidadeParameters = $this->getParametersForEntidades($params['entidade']);
        if (is_array($entidadeParameters)) {
            $params = array_merge($params, $this->getParametersForEntidades($params['entidade']));
        }
        $params = $this->checkEntidadeRpps($params);
        $params['entidade'] = $params['cod_entidade'];

        // Limpa o que não precisa
        unset($params['assinaturas']);

        return $params;
    }

    /**
     * @param array $entidades
     * @return array
     */
    private function getParametersForEntidades(array $entidades)
    {
        $entidadeModel = new EntidadeModel($this->factory->getEntityManager());
        $entidadesName = '';
        $result = [];
        foreach ($entidades as $entidade) {
            list($exercicioEntidade, $codEntidade) = explode('~', $entidade);
            $objEntidade = $entidadeModel->findOneByCodEntidadeAndExercicio($codEntidade, $exercicioEntidade);
            if (empty($objEntidade)) {
                continue;
            }
            $entidadesName .= strtolower($objEntidade->getFkSwCgm()->getNomCgm()) . " - ";
        }
        if (preg_match("/prefeitura.*/i", $entidadesName) || count($entidades) > 1) {
            $result['poder'] = 'Executivo';
            $result['limite_maximo'] = '54%';
            $result['limite_prudencial'] = '51,3%';
            $result['limite_alerta'] = '48,6%';
        }
        elseif (preg_match("/c(â|a)mara.*/i", $entidadesName)) {
            $result['poder'] = 'Legislativo';
            $result['limite_maximo'] = '6%';
            $result['limite_prudencial'] = '5,7%';
            $result['limite_alerta'] = '5,4%';
        }
        else {
            $result['poder'] = 'Executivo';
            $result['limite_maximo'] = '0%';
            $result['limite_prudencial'] = '0%';
            $result['limite_alerta'] = '0%';
        }

        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    private function setDatesAndPeriod(array $params)
    {
        $exercicio = $this->factory->getSession()->getExercicio();
        $initialDate = '';
        $finalDate = '';
        $params['tipo_periodo'] = $params['tipoRelatorio'];
        switch ($params['tipo_periodo']) {
            case "Mes":
                $params['periodo'] = $params['cmbBimestre'];
                break;
            case "Bimestre":
                list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalTwoMonths($params['cmbBimestre'], $exercicio);
                $params['show_emp'] = ($params['cmbBimestre'] == 6) ? false : true;
                $params['periodo'] = $params['cmbBimestre'];
                break;
            case "Quadrimestre":
                list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalFourMonth($params['cmbQuadrimestre'], $exercicio);
                $params['show_emp'] = ($params['cmbQuadrimestre'] == 3) ? false : true;
                $params['intervalo'] = sprintf("%sº %s de %s", $params['cmbQuadrimestre'], $params['tipo_periodo'], $exercicio);
                $params['periodo'] = $params['cmbQuadrimestre'];
                break;
            case "Semestre":
                list($initialDate, $finalDate) = MonthsHelper::periodInitialFinalSemester($params['cmbSemestre'], $exercicio);
                $params['show_emp'] = ($params['cmbSemestre'] == 2) ? false : true;
                $params['intervalo'] = sprintf("%sº %s de %s", $params['cmbSemestre'], $params['tipo_periodo'], $exercicio);
                $params['periodo'] = $params['cmbSemestre'];
                break;
        }

        $params['data_ini'] = $initialDate;
        $params['data_fim'] = $finalDate;

        //Anexo 6
        $params['data_inicio'] = $initialDate;

        return $params;
    }

    /**
     * @param array $params
     * @return array
     */
    private function checkEntidadeRpps(array $params)
    {
        $codEntidade = $params['cod_entidade'];
        $entidadeRpps = '';
        if (isset($params['entidade_rpps'])) {
            $configuracaoModel = new ConfiguracaoModel($this->factory->getEntityManager());
            $data = $configuracaoModel->getConfiguracao('cod_entidade_rpps', ConfiguracaoModel::MODULO_FINANCEIRO_ORCAMENTO);
            if (is_array($data)) {
                foreach ($data as $field) {
                    $entidadeRpps = $field['valor'];
                }
                if ($codEntidade == $entidadeRpps) {
                    $entidadeRpps = $codEntidade;
                }
            }
            $params['entidade_rpps'] = $entidadeRpps;
        }

        return $params;
    }
}