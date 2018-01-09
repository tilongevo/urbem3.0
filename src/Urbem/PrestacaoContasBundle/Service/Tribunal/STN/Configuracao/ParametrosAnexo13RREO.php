<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Stn\RreoAnexo13;
use Urbem\CoreBundle\Entity\Stn\VinculoRecurso;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;

/**
 * Class ParametrosAnexo13RREO
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class ParametrosAnexo13RREO extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/ParametrosAnexo13RREO.js',
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
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $parameters = array_shift($formData);
                list($exercicio, $codEntidade) = explode("~", $parameters['entidade']);

                $entity = $entityManager->getRepository(RreoAnexo13::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'ano' => $parameters['ano'],
                ]);
                if ($entity instanceof RreoAnexo13) {
                    throw new \Exception('Este exercício já está na lista.');
                }
                $entity = $this->getRREOAnexo13();
                $entity->setExercicio($exercicio);
                $entity->setCodEntidade($codEntidade);
                $entity->setAno($parameters['ano']);
                $entity->setVlReceitaPrevidenciaria($parameters['vlReceitaPrevidenciaria']);
                $entity->setVlDespesaPrevidenciaria($parameters['vlDespesaPrevidenciaria']);
                $entity->setVlSaldoFinanceiro($parameters['vlSaldoFinanceiro']);

                $entityManager->persist($entity);
                $entityManager->flush();

                return true;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionDelete()
    {
        $em = $this->factory->getEntityManager();
        $exercicio = $this->getRequest()->get('exercicio');
        $codEntidade = $this->getRequest()->get('codEntidade');
        $ano = $this->getRequest()->get('ano');

        if (empty($exercicio) && empty($codEntidade) && empty($ano)) {
            throw new \Exception('Parametros inválidos.');
        }

        $entity = $this->factory->getEntityManager()->getRepository(RreoAnexo13::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'ano' => $ano,
        ]);
        if (!$entity instanceof RreoAnexo13) {
            throw new \Exception('Erro ao Apagar Dados.');
        }

        $em->remove($entity);
        $em->flush();

        return [
            'message' => 'Recurso Removido com Sucesso!',
        ];
    }

    /**
     * @return array
     */
    protected function actionLoadValores()
    {
        try {
            $em = $this->factory->getEntityManager();

            list($exercicio, $codEntidade) = explode('~', $this->getRequest()->get('entidade'));
            $qb = $em->getRepository(RreoAnexo13::class)->findValores($exercicio, $codEntidade);
            $valores = $qb->getQuery()->getArrayResult();

            return [
                'response' => true,
                'valores' => $valores,
            ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $action = (string)$this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {

            return [
                    'response' => true,
                ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return RreoAnexo13
     */
    protected function getRREOAnexo13()
    {
        return new RreoAnexo13();
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/STN/Configuracao/ParametrosAnexo13RREO/list.html.twig");
    }
}