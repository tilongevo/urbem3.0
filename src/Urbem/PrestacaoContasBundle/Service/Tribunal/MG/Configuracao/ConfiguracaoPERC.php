<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoPerc as ConfiguracaoPercEntity;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoPercModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoPERC
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoPERC extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_ST_PLANEJAMENTO_ANUAL = 'stPlanejamentoAnual';
    const FIELD_FL_PERCENTUAL_ANUAL = 'flPercentualAnual';

    const MULTIPLIER = 100;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoPERC.js',
        ];
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
        $params = parent::processParameters();
        return $params;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $em = $this->factory->getEntityManager();
        $em->beginTransaction();
        $exercicio = $this->factory->getSession()->getExercicio();
        try {
            $collectionData = $this->processParametersCollection();
            $planejamentoAnual = $collectionData->findObjectByName(self::FIELD_ST_PLANEJAMENTO_ANUAL);
            $percentualAnual = $collectionData->findObjectByName(self::FIELD_FL_PERCENTUAL_ANUAL);

            $configuracaoPerc = $this->getConfiguracaoPercModel()->findByExercicio($exercicio);

            if (!$configuracaoPerc instanceof ConfiguracaoPercEntity) {
                $configuracaoPerc = $this->getConfiguracaoPerc();
            }
            
            $configuracaoPerc->setPlanejamentoAnual($planejamentoAnual->getValue());
            $configuracaoPerc->setPorcentualAnual(number_format( (float) ($percentualAnual->getValue() * self::MULTIPLIER), 2, '.', ''));
            $configuracaoPerc->setExercicio($exercicio);

            $em->persist($configuracaoPerc);
            $em->flush();
            $em->commit();

            return $this;
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());

            return false;
        }
    }

    /**
     * @return array
     */
    protected function searchConfiguracaoPerc()
    {
        $entity = $this->getConfiguracaoPercModel()->findByExercicio($this->factory->getSession()->getExercicio());

        if ($entity InstanceOf ConfiguracaoPercEntity) {

            return [
                self::FIELD_ST_PLANEJAMENTO_ANUAL => $entity->getPlanejamentoAnual(),
                self::FIELD_FL_PERCENTUAL_ANUAL => number_format($entity->getPorcentualAnual(), 2, ',', ' '),
            ];
        }

        return [
            self::FIELD_ST_PLANEJAMENTO_ANUAL => '',
            self::FIELD_FL_PERCENTUAL_ANUAL => '',
        ];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $configuracaoPercParameters = $this->searchConfiguracaoPerc();
        $stPlanejamentoAnual = $configuracaoPercParameters[self::FIELD_ST_PLANEJAMENTO_ANUAL];
        $flPercentualAnual = $configuracaoPercParameters[self::FIELD_FL_PERCENTUAL_ANUAL];

        return [
            'response' => true,
            self::FIELD_ST_PLANEJAMENTO_ANUAL => $stPlanejamentoAnual,
            self::FIELD_FL_PERCENTUAL_ANUAL => $flPercentualAnual,
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);
    }

    /**
     * @return ConfiguracaoPercModel
     */
    protected function getConfiguracaoPercModel()
    {
        return new ConfiguracaoPercModel($this->factory->getEntityManager());
    }

    /**
     * @return ConfiguracaoPercEntity
     */
    protected function getConfiguracaoPerc()
    {
        return new ConfiguracaoPercEntity();
    }
}
