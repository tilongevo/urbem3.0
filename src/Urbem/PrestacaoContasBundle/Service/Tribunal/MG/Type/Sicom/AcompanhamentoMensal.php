<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Type\Sicom;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\PrestacaoContasBundle\Admin\RelatorioConfiguracaoAdmin;
use Urbem\PrestacaoContasBundle\Helper\ExportAdjustmentHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class AcompanhamentoMensal
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Type\Sicom
 */
class AcompanhamentoMensal extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return parent::dynamicBlockJs();
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParametersCollection();

        $exercicio = $this->factory->getSession()->getExercicio();

        ExportAdjustmentHelper::setFinancialYear($params, $exercicio);
        ExportAdjustmentHelper::setFirstDayAndLastDayMonth($params, $exercicio);

        $this->processInformationByData($params, parent::PROCESS_ENTIDADE);
        $this->processInformationByData($params, parent::PROCESS_FILES);
        $this->processInformationByData($params, parent::PROCESS_MONTH);

        return $params->exportDataAndValueToArray();
    }

    /**
     * @return bool
     */
    public function save()
    {
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        return [
            'response' => true
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        parent::view($formMapper, $objectAdmin);
    }
}