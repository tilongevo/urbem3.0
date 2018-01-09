<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Stn\VinculoRecurso;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;

/**
 * Class VincularRecursoTranferenciasSUS
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularRecursoTranferenciasSUS extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_VINCULO_RECURSO_TRANSFERENCIA_SUS = 7;
    const COD_TIPO_RECURSOS_OUTRAS_DESPESAS = 2;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularRecursos.js',
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
                $parameters = array_shift($formData);
                $exercicio = $this->factory->getSession()->getExercicio();
                $numOrgao = $parameters['orgao'];
                $codEntidade = $this->getCodEntidade($parameters['entidade']);
                $numUnidade = $formData['unidade'];
                $recursos = isset($formData['recursos']) ? $formData['recursos'] : false;

                $entities = $this->getEntitiesVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade);
                foreach ($entities as $entity) {
                    $entityManager->remove($entity);
                }
                $entityManager->flush();
                if ($recursos) {
                    foreach ($recursos as $recurso) {
                        $entityVinculoRecurso = $this->getVincularRecurso();
                        $entityVinculoRecurso->setExercicio($exercicio);
                        $entityVinculoRecurso->setCodEntidade($codEntidade);
                        $entityVinculoRecurso->setNumOrgao($numOrgao);
                        $entityVinculoRecurso->setNumUnidade($numUnidade);
                        $entityVinculoRecurso->setCodRecurso($recurso);
                        $entityVinculoRecurso->setCodVinculo(self::COD_VINCULO_RECURSO_TRANSFERENCIA_SUS);
                        $entityVinculoRecurso->setCodTipo(self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS);
                        $entityManager->persist($entityVinculoRecurso);
                    }
                    $entityManager->flush();
                }

                return true;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @return array
     */
    protected function actionLoadUnidade()
    {
        $data = [];

        $exercicio = $this->factory->getSession()->getExercicio();
        $em = $this->factory->getEntityManager();
        $orgao = $this->getRequest()->get('orgao');

        $qb = $em->getRepository(Unidade::class)->findUnidadeByExercicioAndOrgao($exercicio, (int)$orgao);
        $unidades = $qb->getQuery()->getResult();

        /** @var Unidade $unidade */
        foreach ($unidades as $unidade) {
            $data[$unidade->getNumUnidade()] = $unidade->getNumUnidade() . ' - ' . $unidade->getNomUnidade();
        }

        return [
            'content' => $data
        ];
    }

    /**
     * @return array
     */
    protected function actionLoadRecursos()
    {
        $dataRecursosSelect = [];
        $dataRecursosSelected = [];
        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();
        $codEntidade = $this->getCodEntidade($this->getRequest()->get('entidade'));
        $orgao = $this->getRequest()->get('orgao');
        $unidade = $this->getRequest()->get('unidade');

        $recursosSelect = $em->getRepository(Recurso::class)->findRecursoFundeb($exercicio, $codEntidade, $unidade, $orgao);
        if (count($recursosSelect)) {
            foreach ($recursosSelect as $recurso) {
                $key = $recurso['cod_recurso'];
                $dataRecursosSelect[$key] = $recurso['cod_recurso'] . ' - ' . $recurso['nom_recurso'];
            }
        }

        $recursosSelected = $em->getRepository(Recurso::class)->getRecursosByCodVinculo($exercicio, [
            'cod_vinculo' => self::COD_VINCULO_RECURSO_TRANSFERENCIA_SUS,
            'cod_entidade' => $codEntidade,
            'num_orgao' => $orgao,
            'num_unidade' => $unidade,
            'cod_tipo' => self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS,
        ]);

        if (count($recursosSelected)) {
            foreach ($recursosSelected as $item)
            $dataRecursosSelected[] = $item['cod_recurso'];
        }

        return [
            'recursosSelect' => $dataRecursosSelect,
            'recursosSelected' => $dataRecursosSelected,
        ];
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
     * @param $exercicio
     * @param $codEntidade
     * @param $numOrgao
     * @param $numUnidade
     * @return array
     */
    protected function getEntitiesVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade)
    {
        $entityManager = $this->factory->getEntityManager();
        $entity = $entityManager->getRepository(VinculoRecurso::class)->findBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'numOrgao' => $numOrgao,
            'numUnidade' => $numUnidade,
            'codVinculo' => self::COD_VINCULO_RECURSO_TRANSFERENCIA_SUS,
            'codTipo' => self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS,
        ]);

        return $entity;
    }

    /**
     * @return VinculoRecurso
     */
    protected function getVincularRecurso()
    {
        return new VinculoRecurso();
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