<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;

/**
 * Class ConfiguracaoFornecedorSoftware
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoFornecedorSoftware extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_MODULO = 55;
    const PARAMETRO = 'fornecedor_software';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoFornecedorSoftware.js',
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
                $parameters = array_shift($formData);
                $cgm = $parameters['cgm'];

                $configuracao = $this->getConfiguracao($exercicio);
                $configuracao->setValor($cgm);

                $entityManager->persist($configuracao);
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
        $numcgm = '';
        $nomCgm = '';
        $configuracao = $this->getConfiguracao($exercicio);
        if ($configuracao->getValor()) {
            $swcgm = $this->factory->getEntityManager()->getRepository(SwCgm::class)->findOneBy(['numcgm' => $configuracao->getValor()]);
            $numcgm = ($swcgm instanceof SwCgm) ? $swcgm->getNumcgm() : '';
            $nomCgm = ($swcgm instanceof SwCgm) ? $swcgm->getNomCgm() : '';
        }

        return [
            'response' => true,
            'numcgm' => $numcgm,
            'nomCgm' => $nomCgm,
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
     * @param $exercicio
     * @return Configuracao
     */
    protected function getConfiguracao($exercicio)
    {
        $configuracao = $this->factory->getEntityManager()->getRepository(Configuracao::class)->findOneBy(['exercicio' => $exercicio, 'codModulo' => self::COD_MODULO, 'parametro' => self::PARAMETRO]);
        if ($configuracao instanceof Configuracao) {

            return $configuracao;
        }

        return new Configuracao();
    }
}