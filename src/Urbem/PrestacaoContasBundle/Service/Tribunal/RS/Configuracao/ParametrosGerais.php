<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Exception\Error;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ParametrosGerais
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao
 */
class ParametrosGerais extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const ORGAO_UNIDADE_PREFEITURA = "orgao_unidade_prefeitura";
    const ORGAO_UNIDADE_CAMARA= "orgao_unidade_camara";
    const ORGAO_UNIDADE_RPPS = "orgao_unidade_rpps";
    const ORGAO_UNIDADE_OUTROS = "orgao_unidade_outros";

    const FIELD_COD_EXECUTIVO = "inCodExecutivo";
    const FIELD_COD_LEGISLATIVO = "inCodLegislativo";
    const FIELD_COD_RPPS = "inCodRPPS";
    const FIELD_COD_OUTROS = "inCodOutros";

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/ParametrosGerais.js'
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
        $parameters = $this->processParameters();

        $parametrosGerais = $this->searchConfiguracaoParametrosGerais();
        $inCodExecutivo = $parametrosGerais[self::FIELD_COD_EXECUTIVO];
        $inCodLegislativo = $parametrosGerais[self::FIELD_COD_LEGISLATIVO];
        $inCodRPPS = $parametrosGerais[self::FIELD_COD_RPPS];
        $inCodOutros = $parametrosGerais[self::FIELD_COD_OUTROS];

        $inCodExecutivo->setValor($parameters[self::FIELD_COD_EXECUTIVO]);
        $inCodLegislativo->setValor($parameters[self::FIELD_COD_LEGISLATIVO]);
        $inCodRPPS->setValor($parameters[self::FIELD_COD_RPPS]);
        $inCodOutros->setValor($parameters[self::FIELD_COD_OUTROS]);

        try {
            $em = $this->factory->getEntityManager();

            $em->persist($inCodExecutivo);
            $em->persist($inCodLegislativo);
            $em->persist($inCodRPPS);
            $em->persist($inCodOutros);
            $em->flush();

            return true;
        } catch (\Excetion $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     */
    public function validate(ErrorElement $errorElement)
    {
        $parameters = $this->processParameters();

        if (!array_key_exists(self::FIELD_COD_EXECUTIVO, $parameters) || !is_numeric($parameters[self::FIELD_COD_EXECUTIVO])) {
            $errorElement->with(self::FIELD_COD_EXECUTIVO)->addViolation(Error::INVALID_VALUE)->end();
        }

        if (!array_key_exists(self::FIELD_COD_LEGISLATIVO, $parameters) || !is_numeric($parameters[self::FIELD_COD_LEGISLATIVO])) {
            $errorElement->with(self::FIELD_COD_LEGISLATIVO)->addViolation(Error::INVALID_VALUE)->end();
        }

        if (!array_key_exists(self::FIELD_COD_RPPS, $parameters) || !is_numeric($parameters[self::FIELD_COD_RPPS])) {
            $errorElement->with(self::FIELD_COD_RPPS)->addViolation(Error::INVALID_VALUE)->end();
        }

        if (!array_key_exists(self::FIELD_COD_OUTROS, $parameters) || !is_numeric($parameters[self::FIELD_COD_OUTROS])) {
            $errorElement->with(self::FIELD_COD_OUTROS)->addViolation(Error::INVALID_VALUE)->end();
        }
    }

    /**
     * @return array
     */
    protected function searchConfiguracaoParametrosGerais()
    {
        $em = $this->factory->getEntityManager();
        $configuracaoModel = new ConfiguracaoModel($em);

        $modulo = $this->factory->getEntityManager()
            ->getRepository('CoreBundle:Administracao\Modulo')->findOneByCodModulo(Modulo::MODULO_TCE_RS);

        $configuracao = new Configuracao();
        $configuracao->setExercicio($this->factory->getSession()->getExercicio());
        $configuracao->setFkAdministracaoModulo($modulo);
        $configuracao->setParametro(self::ORGAO_UNIDADE_PREFEITURA);

        /*Executivo*/
        $inCodExecutivo = $configuracaoModel->getConfiguracaoByConfiguracao($configuracao);

        /*Legislativo*/
        $configuracao->setParametro(self::ORGAO_UNIDADE_CAMARA);
        $inCodLegislativo = $configuracaoModel->getConfiguracaoByConfiguracao($configuracao);

        /*RPPS*/
        $configuracao->setParametro(self::ORGAO_UNIDADE_RPPS);
        $inCodRPPS = $configuracaoModel->getConfiguracaoByConfiguracao($configuracao);

        /*Outros*/
        $configuracao->setParametro(self::ORGAO_UNIDADE_OUTROS);
        $inCodOutros = $configuracaoModel->getConfiguracaoByConfiguracao($configuracao);

        return [
            self::FIELD_COD_EXECUTIVO => $inCodExecutivo,
            self::FIELD_COD_LEGISLATIVO => $inCodLegislativo,
            self::FIELD_COD_RPPS => $inCodRPPS,
            self::FIELD_COD_OUTROS => $inCodOutros,
        ];
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        /*Recupera dados peculiares do banco com base em configuracoes pre-definidas*/
        $parametrosGerais = $this->searchConfiguracaoParametrosGerais();
        $inCodExecutivo = $parametrosGerais[self::FIELD_COD_EXECUTIVO];
        $inCodLegislativo = $parametrosGerais[self::FIELD_COD_LEGISLATIVO];
        $inCodRPPS = $parametrosGerais[self::FIELD_COD_RPPS];
        $inCodOutros = $parametrosGerais[self::FIELD_COD_OUTROS];

        return [
            'response' => true,
            self::FIELD_COD_EXECUTIVO => !empty($inCodExecutivo) ? $inCodExecutivo->getValor() : '',
            self::FIELD_COD_LEGISLATIVO => !empty($inCodLegislativo) ? $inCodLegislativo->getValor() : '',
            self::FIELD_COD_RPPS => !empty($inCodRPPS) ? $inCodRPPS->getValor() : '',
            self::FIELD_COD_OUTROS => !empty($inCodOutros) ? $inCodOutros->getValor() : '',
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
}
