<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura;
use Urbem\CoreBundle\Entity\Tcemg\ContaBancaria;
use Urbem\CoreBundle\Entity\Tcemg\PlanoContas;
use Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;

/**
 * Class VincularPlanoConta
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class VincularPlanoConta extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_COD_CONTA = 'codConta';

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMVincularPlanoContas.php:63
     */
    const UF_COD_MG = 11;

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMVincularPlanoContas.php:68
     */
    const IN_COD_PLANO = 1;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/VincularPlanoConta.js',
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
                $codContas = $formData[self::FIELD_COD_CONTA];

                $repository = $entityManager->getRepository(PlanoContas::class);
                foreach ($codContas as $codConta => $codigoEstrutural) {
                    $entity = $repository->findOneBy(["codConta" => (int)$codConta, "exercicio" => $exercicio, "codUf" => self::UF_COD_MG, "codPlano" => self::IN_COD_PLANO]);
                    if (!empty($codigoEstrutural)) {
                        if ($entity instanceof PlanoContas) {
                            $entity->setCodigoEstrutural($codigoEstrutural);
                        } else {
                            $entity = $this->getTcmegPlanoContas();
                            $entity->setCodConta((int)$codConta);
                            $entity->setExercicio($exercicio);
                            $entity->setCodUf(self::UF_COD_MG);
                            $entity->setCodPlano(self::IN_COD_PLANO);
                            $entity->setCodigoEstrutural($codigoEstrutural);
                        }
                        $entityManager->persist($entity);
                    } elseif ($entity instanceof PlanoContas) {
                        $entityManager->remove($entity);
                    }
                }

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
        $formData = (object) $this->getFormSonata();
        $result = [];
        $planoContasEstrutura = [];
        $exercicio = $this->factory->getSession()->getExercicio();

        if (!empty($formData->entidade) && !empty($formData->codGrupo)) {
            $codEntidade = $this->getCodEntidade($formData->entidade);
            $result = $this->factory->getEntityManager()->getRepository(PlanoConta::class)->findVincularPlanoContaMG($exercicio, $codEntidade, $formData->codGrupo);
            $qb = $this->factory->getEntityManager()->getRepository(PlanoContaEstrutura::class)->findPlanoContasEstrutura($formData->codGrupo);
            $planoContasEstrutura = $qb->getQuery()->getArrayResult();
        }

        return [
            'content' => $result,
            'planoContasEstrutura' => $planoContasEstrutura
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/VincularPlanoConta/list.html.twig");
    }

    /**
     * @return PlanoContas
     */
    protected function getTcmegPlanoContas()
    {
        return new PlanoContas();
    }
}
