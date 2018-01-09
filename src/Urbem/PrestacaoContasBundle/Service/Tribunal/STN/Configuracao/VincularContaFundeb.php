<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Stn\VinculoFundeb;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class VincularContaFundeb
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularContaFundeb extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularContaFundeb.js',
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
        $parameters = $this->getParameters();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($parameters) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $contas = $entityManager->getRepository(VinculoFundeb::class)->findBy(['exercicio' => $exercicio]);

                foreach ($contas as $conta) {
                    $entityManager->remove($conta);
                }
                $entityManager->flush();

                if ($parameters) {
                    $parameters = array_shift($parameters);
                    $data = $parameters['dynamic_collection'];

                    $this->validateConta($data);
                    foreach ($data as $item) {
                        $entity = $this->getVinculoFundeb();
                        list($codPlano, $exercicio) = explode("~", $item['codPlano']);
                        $codEntidade = $this->getCodEntidade($item['entidade']);
                        $entity->setExercicio($exercicio);
                        $entity->setCodPlano($codPlano);
                        $entity->setCodEntidade($codEntidade);

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
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCVincularContaFundeb.php:204
     * @param array $data
     * @throws \Exception
     */
    protected function validateConta(array $data)
    {
        foreach ($data as $key => $item) {
            unset($data[$key]);
            if (in_array($item['codPlano'], array_column($data, 'codPlano'))) {
                throw new \Exception('Existe conta que já esta configurada na lista!');
            }
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
            $qb = $em->getRepository(VinculoFundeb::class)->findByExercicio($exercicio);
            $entities = $qb->getQuery()->getResult();
            /** @var VinculoFundeb $entity */
            foreach ($entities as $entity) {
                $data[]= [
                    'codPlano' => $entity->getCodPlano() . "~" . $exercicio,
                    'entidade' => $exercicio . "~" . $entity->getCodEntidade(),
                    'descricao' => $entity->getCodPlano() . "/{$exercicio} - " . $entity->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getNomConta(),
                ];
            }

            return [
                'response' => true,
                'contas' => $data,
            ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return VinculoFundeb
     */
    protected function getVinculoFundeb()
    {
        return new VinculoFundeb();
    }

    /**
     * @return mixed
     */
    protected function getParameters()
    {
        $form = (array)$this->getFormSonata();
        $form = array_shift($form);

        return isset($form['stn_vincular_conta_fundeb']) ? $form['stn_vincular_conta_fundeb'] : false;
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