<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Stn\VinculoStnReceita;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoAnexo3RCL
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class ConfiguracaoAnexo3RCL extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/ConfiguracaoAnexo3RCL.js',
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
     * @return bool
     */
    public function save()
    {
        $parameters = $this->getParameters();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($parameters) {
                $receitas = $entityManager->getRepository(VinculoStnReceita::class)->findAll();

                foreach ($receitas as $receita) {
                    $entityManager->remove($receita);
                }
                $entityManager->flush();

                if ($parameters) {
                    $parameters = array_shift($parameters);
                    $data = $parameters['dynamic_collection'];

                    foreach ($data as $item) {
                        if (!is_numeric($item['exercicio'])) {
                            throw new \Exception('Exercício inválido.');
                        }
                        $entity = $this->getVinculoStnReceita();
                        list($exercicio, $codReceita) = explode("~", $item['codReceita']);
                        $entity->setExercicio($item['exercicio']);
                        $entity->setCodReceita($codReceita);
                        $entity->setCodTipo($item['codTipo']);

                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }
                }

                return true;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param TwigEngine|null $templating
     * @return array|mixed
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $data = [];
        $em = $this->factory->getEntityManager();
        $exercicio = $this->factory->getSession()->getExercicio();
        try {
            $qb = $em->getRepository(VinculoStnReceita::class)->getAll();
            $entities = $qb->getQuery()->getResult();
            /** @var VinculoStnReceita $entity */
            foreach ($entities as $entity) {
                $data[]= [
                    'exercicio' => $entity->getExercicio(),
                    'codReceita' => $exercicio . "~" . $entity->getCodReceita(),
                    'codTipo' => (string) $entity->getCodTipo(),
                    'descricao' => $entity->getCodReceita() . " - " . $entity->getFkOrcamentoReceita()->getFkOrcamentoContaReceita()->getDescricao(),
                ];
            }

            return [
                    'response' => true,
                    'receita' => $data,
                ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return mixed
     */
    protected function getParameters()
    {
        $form = (array) $this->getFormSonata();
        $form = array_shift($form);

        return isset($form['stn_configuracao_anexo_3_rcl']) ? $form['stn_configuracao_anexo_3_rcl'] : false;
    }

    /**
     * @return VinculoStnReceita
     */
    protected function getVinculoStnReceita()
    {
        return new VinculoStnReceita();
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