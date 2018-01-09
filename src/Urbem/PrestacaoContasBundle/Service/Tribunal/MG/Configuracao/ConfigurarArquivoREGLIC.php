<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoArquivoDclrf;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoReglic;
use Urbem\CoreBundle\Entity\Tcemg\TipoDecreto;
use Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoArquivoDclrfModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;

/**
 * Class ConfigurarArquivoREGLIC
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarArquivoREGLIC extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_ENTIDADE = 'entidade';
    const FIELD_DT_ASSINATURA = 'dtAssinatura';
    const FIELD_DT_PUBLICACAO = 'dtPublicacao';
    const FIELD_NUM_NORMA = 'numNorma';
    const FIELD_PERCENTUAL_CONTRATACAO = 'percentualContratacao';
    const FIELD_PERCENTUAL_SUB_CONTRATACAO = 'percentualSubContratacao';
    const FIELD_VALOR_LIMITE_REG_EXCLUSIVA = 'valorLimiteRegExclusiva';
    const FIELD_REGULAMENTO_ART_47 = 'regulamentoArt47';
    const FIELD_COD_NORMA = 'codNorma';
    const FIELD_REG_EXCLUSIVA = 'regExclusiva';
    const FIELD_ARTIGO_REG_EXCLUSIVA = 'artigoRegExclusiva';
    const FIELD_PROC_SUB_CONTRATACAO = 'procSubContratacao';
    const FIELD_ARTIGO_PROC_SUB_CONTRATACAO = 'artigoProcSubContratacao';
    const FIELD_CRITERIO_EMPENHO_PAGAMENTO = 'criterioEmpenhoPagamento';
    const FIELD_ARTIGO_EMPENHO_PAGAMENTO = 'artigoEmpenhoPagamento';
    const FIELD_ESTABELECEU_PERC_CONTRATACAO = 'estabeleceuPercContratacao';
    const FEILD_ARTIGO_PERC_CONTRATACAO = 'artigoPercContratacao';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ToolTips.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarArquivoREGLIC.js',
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
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $reglic = array_shift($formData);
                $decreto = array_shift($formData);
                $entidade = $this->getCodEntidade($reglic[self::FIELD_ENTIDADE]);

                $repositoryTipoRegPreco = $entityManager->getRepository(TipoRegistroPreco::class);
                $repositoryReglic = $entityManager->getRepository(ConfiguracaoReglic::class);

                foreach ($decreto as $codNorma => $tipoDecreto) {
                    $entityTipoRegPreco = $repositoryTipoRegPreco->findOneBy(["exercicio" => $exercicio, "codEntidade" => $entidade, "codNorma" => $codNorma]);
                    $tipoDecreto = empty($tipoDecreto) ? null : $tipoDecreto;

                    if (!$entityTipoRegPreco instanceof TipoRegistroPreco) {
                        $entityTipoRegPreco = $this->getTipoRegistroPreco();
                        $entityTipoRegPreco->setExercicio($exercicio);
                        $entityTipoRegPreco->setCodNorma($codNorma);
                        $entityTipoRegPreco->setCodEntidade($entidade);
                    }
                    $entityTipoRegPreco->setCodTipoDecreto($tipoDecreto);
                    $entityManager->persist($entityTipoRegPreco);
                }

                $entityReglic = $repositoryReglic->findOneBy(["exercicio" => $exercicio, "codEntidade" => $entidade]);
                if (!$entityReglic instanceof ConfiguracaoReglic) {
                    $entityReglic = $this->getConfiguracaoReglic();
                    $entityReglic->setCodEntidade($entidade);
                    $entityReglic->setExercicio($exercicio);
                }
                $entityReglic->setCodNorma($reglic[self::FIELD_COD_NORMA]);
                $entityReglic->setRegulamentoArt47($reglic[self::FIELD_REGULAMENTO_ART_47]);
                $entityReglic->setRegExclusiva($reglic[self::FIELD_REG_EXCLUSIVA]);
                $entityReglic->setArtigoRegExclusiva($reglic[self::FIELD_ARTIGO_REG_EXCLUSIVA]);
                $entityReglic->setValorLimiteRegExclusiva($reglic[self::FIELD_VALOR_LIMITE_REG_EXCLUSIVA]);
                $entityReglic->setProcSubContratacao($reglic[self::FIELD_PROC_SUB_CONTRATACAO]);
                $entityReglic->setArtigoProcSubContratacao($reglic[self::FIELD_ARTIGO_PROC_SUB_CONTRATACAO]);
                $entityReglic->setPercentualSubContratacao($this->formatPercentForPersist($reglic[self::FIELD_PERCENTUAL_SUB_CONTRATACAO]));
                $entityReglic->setCriterioEmpenhoPagamento($reglic[self::FIELD_CRITERIO_EMPENHO_PAGAMENTO]);
                $entityReglic->setArtigoEmpenhoPagamento($reglic[self::FIELD_ARTIGO_EMPENHO_PAGAMENTO]);
                $entityReglic->setEstabeleceuPercContratacao($reglic[self::FIELD_ESTABELECEU_PERC_CONTRATACAO]);
                $entityReglic->setArtigoPercContratacao($reglic[self::FEILD_ARTIGO_PERC_CONTRATACAO]);
                $entityReglic->setPercentualContratacao($this->formatPercentForPersist($reglic[self::FIELD_PERCENTUAL_CONTRATACAO]));

                $entityManager->persist($entityReglic);
                $entityManager->flush();
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $exercicio = $this->factory->getSession()->getExercicio();
        $formData = (object) $this->getFormSonata();
        $entidade = $this->getCodEntidade($formData->entidade);

        $tipoDecreto = $this->factory->getEntityManager()->getRepository(TipoDecreto::class)->findAllToArray();
        $qbReglic = $this->factory->getEntityManager()->getRepository(ConfiguracaoReglic::class)->findByEntidadeAndExercicio($entidade, $exercicio);
        $decreto = $this->getNormaModel()->findDecretoToArray($exercicio, $entidade);

        $reglic = $qbReglic->getQuery()->getArrayResult();

        foreach ($decreto as $key => $value)
        {
            $decreto[$key][self::FIELD_DT_ASSINATURA] = $this->formatDate($value[self::FIELD_DT_ASSINATURA]);
            $decreto[$key][self::FIELD_DT_PUBLICACAO] = $this->formatDate($value[self::FIELD_DT_PUBLICACAO]);
            $decreto[$key][self::FIELD_NUM_NORMA] = str_pad($value[self::FIELD_NUM_NORMA], 6,"0",STR_PAD_LEFT);
        }

        foreach ($reglic as $key => $value)
        {
            $reglic[$key][self::FIELD_PERCENTUAL_CONTRATACAO] = $this->formatPercentage($value[self::FIELD_PERCENTUAL_CONTRATACAO]);
            $reglic[$key][self::FIELD_PERCENTUAL_SUB_CONTRATACAO] = $this->formatPercentage($value[self::FIELD_PERCENTUAL_SUB_CONTRATACAO]);
            $reglic[$key][self::FIELD_VALOR_LIMITE_REG_EXCLUSIVA] = $this->formatCurrency($value[self::FIELD_VALOR_LIMITE_REG_EXCLUSIVA]);

        }

        return [
            'decreto' => $decreto,
            'tipoDecreto' => $tipoDecreto,
            'reglic' => (count($reglic)) ? array_shift($reglic) : [],
        ];
    }

    /**
     * @param $value
     * @return string
     */
    protected function formatPercentage($value)
    {
        if (is_numeric($value)) {

            return number_format($value, 2, ',', ' ');
        }

        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    protected function formatCurrency($value)
    {
        if ($value) {

            return number_format($value, 2, ',', '.');
        }

        return $value;
    }

    /**
     * @param string $value
     * @return null|float
     */
    protected function formatPercentForPersist($value)
    {
        return  str_replace(",", ".", $value);
    }

    /**
     * @param $value
     * @return string
     */
    protected function formatDate($value)
    {
        if ($value instanceof \DateTime) {

            return $value->format('d/m/Y'); 
        }

        return $value;
    }
    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarArquivoREGLIC/list.html.twig");
    }

    /**
     * @return ConfiguracaoReglic
     */
    protected function getConfiguracaoReglic()
    {
        return new ConfiguracaoReglic();
    }

    /**
     * @return TipoRegistroPreco
     */
    protected function getTipoRegistroPreco()
    {
        return new TipoRegistroPreco();
    }

    /**
     * @return NormaModel
     */
    protected function getNormaModel()
    {
        return new NormaModel($this->factory->getEntityManager());
    }
}