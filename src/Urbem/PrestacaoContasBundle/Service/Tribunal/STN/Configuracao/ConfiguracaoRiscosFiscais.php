<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Stn\RiscosFiscais;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoRiscosFiscais
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class ConfiguracaoRiscosFiscais extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/ConfiguracaoRiscosFiscais.js',
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
                $exercicio = $this->factory->getSession()->getExercicio();
                $riscosFicais = $entityManager->getRepository(RiscosFiscais::class)->findBy(['exercicio' => $exercicio]);

                foreach ($riscosFicais as $item) {
                    $entityManager->remove($item);
                }
                $entityManager->flush();
                if ($parameters) {
                    $parameters = array_shift($parameters);
                    $data = $parameters['dynamic_collection'];

                    foreach ($data as $riscoFiscal) {
                        $codRisco = $this->getCodRisco();
                        foreach ($riscoFiscal['entidade'] as $entidade) {
                            $entity = $this->getRiscosFiscais();
                            $entity->setCodRisco($codRisco);
                            $entity->setExercicio($exercicio);
                            $entity->setCodEntidade($this->getCodEntidade($entidade));
                            $entity->setValor($riscoFiscal['valor']);
                            $entity->setDescricao($riscoFiscal['descricao']);
                            $codIdentificador = empty($riscoFiscal['codIdentificador']) ? null : $riscoFiscal['codIdentificador'];
                            $entity->setCodIdentificador($codIdentificador);

                            $entityManager->persist($entity);
                            $entityManager->flush();
                        }
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
        $riscos = [];
        $entidades = [];
        $codRisco = '';
        $exercicio = $this->factory->getSession()->getExercicio();
        $em = $this->factory->getEntityManager();
        try {
            $qb = $em->getRepository(RiscosFiscais::class)->getAll($exercicio);
            $entities = $qb->getQuery()->getResult();
            /** @var RiscosFiscais $entity */
            foreach ($entities as $entity) {
                $entidades[$entity->getCodRisco()][] = $exercicio . "~" . $entity->getCodEntidade();
            }

            /** @var RiscosFiscais $entity */
            foreach ($entities as $entity) {
                if ($codRisco != $entity->getCodRisco()) {
                    $codRisco = $entity->getCodRisco();
                    $riscos[] = [
                        'exercicio' => $entity->getExercicio(),
                        'codRisco' => $entity->getCodRisco(),
                        'descricao' => $entity->getDescricao(),
                        'entidades' => $entidades[$entity->getCodRisco()],
                        'valor' => $entity->getValor(),
                        'codIdentificador' => $entity->getCodIdentificador(),
                    ];
                }
            }

            return [
                    'response' => true,
                    'riscos' => $riscos,
                ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return int
     */
    protected function getCodRisco()
    {
        $em = $this->factory->getEntityManager();
        $result = $em->getRepository(RiscosFiscais::class)->getLastCodRisco();

        return $result['cod_risco']  + 1;
    }

    /**
     * @return mixed
     */
    protected function getParameters()
    {
        $form = (array) $this->getFormSonata();
        $form = array_shift($form);

        return isset($form['stn_identificador_riscos_fiscais']) ? $form['stn_identificador_riscos_fiscais'] : false;
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
     * @return RiscosFiscais
     */
    public function getRiscosFiscais()
    {
        return new RiscosFiscais();
    }
}