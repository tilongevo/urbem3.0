<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ConfigurarIde;
use Urbem\CoreBundle\Model\Tcemg\ConfigurarIdeModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoIDE
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoIDE extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_COD_MUNICIPIO = "inCodMunicipio";
    const FIELD_OPCAO_SEMESTRALIDADE = "inOpcaoSemestralidade";

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoIDE.js',
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
        try {
            $exercicio = $this->factory->getSession()->getExercicio();
            $configurarIdeModel = $this->getConfigurarIdeModel();

            $collectionData = $this->processParametersCollection();
            $codMunicipio = $collectionData->findObjectByName(self::FIELD_COD_MUNICIPIO);
            $opcaoSemestralidade = $collectionData->findObjectByName(self::FIELD_OPCAO_SEMESTRALIDADE);

            $configurarIde = $configurarIdeModel->findByExercicio($exercicio);

            if (!$configurarIde instanceof ConfigurarIde) {
                $configurarIde = $this->getConfigurarIde();
                $configurarIde->setCodMunicipio($codMunicipio->getValue());
            }

            $configurarIde->setOpcaoSemestralidade($opcaoSemestralidade->getValue());
            $configurarIde->setExercicio($exercicio);

            $em->persist($configurarIde);
            $em->flush();
            $em->commit();

            return $this;
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            $em->rollback();

            return false;
        }
    }

    /**
     * @return array
     */
    protected function searchConfiguracaoIde()
    {
         /** @var ConfigurarIde $configuracaoIde */
        $configurarIde = $this->getConfigurarIdeModel()->findByExercicio($this->factory->getSession()->getExercicio());

        /** @var ConfigurarIde $configurarIde */
        if ($configurarIde InstanceOf ConfigurarIde) {
            return [
                self::FIELD_COD_MUNICIPIO => $configurarIde->getCodMunicipio(),
                self::FIELD_OPCAO_SEMESTRALIDADE => $configurarIde->getOpcaoSemestralidade(),
            ];
        }

        return [
            self::FIELD_COD_MUNICIPIO => '',
            self::FIELD_OPCAO_SEMESTRALIDADE => '',
        ];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
   public function buildServiceProvider(TwigEngine $templating = null)
    {
        $configurarIdeParameters = $this->searchConfiguracaoIde();
        $inCodMunicipio = $configurarIdeParameters[self::FIELD_COD_MUNICIPIO];
        $inOpcaoSemestralidade = $configurarIdeParameters[self::FIELD_OPCAO_SEMESTRALIDADE];

        return [
            'response' => true,
            self::FIELD_COD_MUNICIPIO => $inCodMunicipio,
            self::FIELD_OPCAO_SEMESTRALIDADE => $inOpcaoSemestralidade,
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
     * @return ConfigurarIdeModel
     */
    protected function getConfigurarIdeModel()
    {
        return new ConfigurarIdeModel($this->factory->getEntityManager());

    }

    /**
     * @return ConfigurarIde
     */
    protected function getConfigurarIde()
    {
        return new ConfigurarIde();
    }
}
