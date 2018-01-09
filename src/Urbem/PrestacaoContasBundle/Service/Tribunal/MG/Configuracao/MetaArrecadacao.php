<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ObsMetaArrecadacao;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class MetaArrecadacao
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class MetaArrecadacao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/MetaArrecadacao.js',
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
        $formData = $this->processParameters();
        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($em) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();

                $repository = $this->factory->getEntityManager()->getRepository(ObsMetaArrecadacao::class);
                /** @var ObsMetaArrecadacao $entity */
                $entity = $repository->findOneBy(['mes' => $formData['mes'], 'exercicio' => $exercicio]);

                if (!$entity instanceof ObsMetaArrecadacao) {
                    $entity = new ObsMetaArrecadacao();
                    $entity->setExercicio($exercicio);
                }
                $entity->setMes($formData['mes']);
                $entity->setObservacao($formData['observacao']);

                $em->persist($entity);
                $em->flush();
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
        $exercicio = $this->factory->getSession()->getExercicio();
        $observacao = '';

        $repository = $this->factory->getEntityManager()->getRepository(ObsMetaArrecadacao::class);
        $result = $repository->findOneBy(['mes' => $formData->mes, 'exercicio' => $exercicio]);

        if ($result instanceof ObsMetaArrecadacao) {
            $observacao = $result->getObservacao();
        }

        return [
            'response' => true,
            'observacao' => $observacao
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