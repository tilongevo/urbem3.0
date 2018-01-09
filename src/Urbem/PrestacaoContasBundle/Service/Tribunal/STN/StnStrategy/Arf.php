<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

class Arf extends StnAbstract implements StnInterface
{
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
        return "";
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
        $params['exercicio_risco'] = $params['stExercicio'];

        return $params;
    }
}
