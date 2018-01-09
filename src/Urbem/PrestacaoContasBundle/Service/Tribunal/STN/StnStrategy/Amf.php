<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Ppa\PpaModel;

class Amf extends StnAbstract implements StnInterface
{
    const DEMONSTRATIVO_II = "AMF_demonstrativoII";

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/stn-amf.js'
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
     * @param array $parameters
     * @param array|null $form
     * @return array
     */
    public function preBuildForm(array $parameters, array $form = null)
    {
        if (!empty($form)) {
            $exercicio = $form['stExercicio'];
            $key = array_search('stExercicio', array_column($parameters, 'name'));
            if ($key !== false) {
                $parameters[$key]['choices'] = [
                    [
                        "value" => $exercicio,
                        "label" => $exercicio
                    ]
                ];
            }
        }

        return $parameters;
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();
        $params['ano_referencia'] = $params['stExercicio'];
        $params['exercicio_referencia'] = $params['stExercicio'];
        $params['ano_ldo'] = $params['stExercicio'];

        if ($params['reportName'] == self::DEMONSTRATIVO_II) {
            $stExercicioAnterior = $params['stExercicio'] - 2;
            $params['stExercicio'] = $stExercicioAnterior;
        }

        if (isset($params['entidade'])) {
            $params = $this->getPoder($params);
        }
        $params['entidade'] = $params['cod_entidade'];

        if (isset($params['inCodPPATxt'])) {
            $ppa = $this->getAnoPpa($params['ano_referencia']);

            $params['cod_ppa'] = $params['inCodPPATxt'];
            $params['ano'] = !empty($ppa) ? $ppa->getCodPpa() : null;
        }

        return $params;
    }

    /**
     * @param array $value
     * @return array
     */
    private function getPoder(array $value)
    {
        $entidadeModel = new EntidadeModel($this->factory->getEntityManager());
        $entidadesName = '';
        $entidades = $value['entidade'];
        foreach ($entidades as $entidade) {
            list($exercicioEntidade, $codEntidade) = explode('~', $entidade);
            $objEntidade = $entidadeModel->findOneByCodEntidadeAndExercicio($codEntidade, $exercicioEntidade);
            if (empty($objEntidade)) {

                return $value;
            }
            $entidadesName .= strtolower($objEntidade->getFkSwCgm()->getNomCgm()) . " - ";
        }

        if (preg_match("/prefeitura.*/i", $entidadesName) || count($entidades) > 1) {
            $value['poder'] = 'Executivo';

            return $value;
        }
        $value['poder'] = 'Legislativo';

        return $value;
    }

    /**
     * @param $exercicio
     * @return array
     */
    private function getAnoPpa($exercicio)
    {
        $ppaModel = new PpaModel($this->factory->getEntityManager());
        return $ppaModel->getPpaExercicio($exercicio);
    }
}
