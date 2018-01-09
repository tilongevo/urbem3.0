<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Stn\VinculoRecurso;
use Urbem\CoreBundle\Entity\Stn\VinculoRecursoAcao;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;

/**
 * Class VincularRecursoMDE
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularRecursoMDE extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_VINCULO_MDE = 2;
    const COD_TIPO_RECURSOS_OUTRAS_DESPESAS = 2;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularRecursoMDE.js',
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
                $codRecurso = $formData['recurso'];
                $codAcao = $formData['acao'];
                $codTipoEducacao = $formData['tipoEducacaoInfantil'];

                $entityVinculoRecursoAcao = $this->getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codAcao, $codTipoEducacao);
                $entityVinculoRecurso = $this->getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso);

                if (!$entityVinculoRecursoAcao instanceof VinculoRecursoAcao) {
                    $entityVinculoRecursoAcao = $this->getVincularRecursoAcao();
                }
                $entityVinculoRecursoAcao->setExercicio($exercicio);
                $entityVinculoRecursoAcao->setCodEntidade($codEntidade);
                $entityVinculoRecursoAcao->setNumOrgao($numOrgao);
                $entityVinculoRecursoAcao->setNumUnidade($numUnidade);
                $entityVinculoRecursoAcao->setCodRecurso($codRecurso);
                $entityVinculoRecursoAcao->setCodVinculo(self::COD_VINCULO_MDE);
                /** @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/PRManterRecurso.php:71 */
                $entityVinculoRecursoAcao->setCodTipo(self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS);
                $entityVinculoRecursoAcao->setCodAcao($codAcao);
                $entityVinculoRecursoAcao->setCodTipoEducacao($codTipoEducacao);

                if (!$entityVinculoRecurso instanceof VinculoRecurso) {
                    $entityVinculoRecurso = $this->getVincularRecurso();
                }
                $entityVinculoRecurso->setExercicio($exercicio);
                $entityVinculoRecurso->setCodEntidade($codEntidade);
                $entityVinculoRecurso->setNumOrgao($numOrgao);
                $entityVinculoRecurso->setNumUnidade($numUnidade);
                $entityVinculoRecurso->setCodRecurso($codRecurso);
                $entityVinculoRecurso->setCodVinculo(self::COD_VINCULO_MDE);
                /** @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/PRManterRecurso.php:71 */
                $entityVinculoRecurso->setCodTipo(self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS);

                $entityManager->persist($entityVinculoRecursoAcao);
                $entityManager->persist($entityVinculoRecurso);
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
    protected function actionLoadRecurso()
    {
        $data = [];
        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();
        $codEntidade = $this->getCodEntidade($this->getRequest()->get('entidade'));
        $orgao = $this->getRequest()->get('orgao');
        $unidade = $this->getRequest()->get('unidade');

        $recursos = $em->getRepository(Recurso::class)->findRecursoFundeb($exercicio, $codEntidade, $unidade, $orgao);
        if (count($recursos)) {
            foreach ($recursos as $recurso) {
                $key = $recurso['cod_recurso'];
                $data[$key] = $recurso['cod_recurso'] . ' - ' . $recurso['nom_recurso'];
            }
        }

        return [
            'content' => $data
        ];
    }

    /**
     * @return array
     */
    protected function actionLoadAcao()
    {
        $data = [];
        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();
        $codEntidade = $this->getCodEntidade($this->getRequest()->get('entidade'));
        $orgao = $this->getRequest()->get('orgao');
        $unidade = $this->getRequest()->get('unidade');
        $recurso = $this->getRequest()->get('recurso');

        $acao = $em->getRepository(Recurso::class)->findAcao($exercicio, $codEntidade, $unidade, $orgao, $recurso);

        if (count($acao)) {
            foreach ($acao as $item) {
                $key = $item['codAcao'];
                $data[$key] = $item['codAcao'] . ' - ' . $item['titulo'];
            }
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
        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();

        $data = $em->getRepository(Recurso::class)->getRecursosByCodVinculo($exercicio, ['cod_vinculo' => self::COD_VINCULO_MDE]);

        return [
            'content' => $data
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionDelete()
    {
        $entityManager = $this->factory->getEntityManager();
        $exercicio = $this->getRequest()->get('exercicio');
        $codEntidade = $this->getRequest()->get('codEntidade');
        $numOrgao = $this->getRequest()->get('numOrgao');
        $numUnidade = $this->getRequest()->get('numUnidade');
        $codRecurso = $this->getRequest()->get('codRecurso');
        $codTipoEducacao = $this->getRequest()->get('codTipoEducacao');
        $codAcao = $this->getRequest()->get('codAcao');

        $entityVinculoRecursoAcao = $this->getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codAcao, $codTipoEducacao);
        $entityVinculoRecurso = $this->getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso);

        if ((!$entityVinculoRecursoAcao instanceof VinculoRecursoAcao) || (!$entityVinculoRecurso instanceof VinculoRecurso)) {
            throw new \Exception('Erro ao Remover Recurso com FUNDEB');
        }
        $entityManager->remove($entityVinculoRecursoAcao);
        $entityManager->remove($entityVinculoRecurso);
        $entityManager->flush();

        return [
            'message' => 'Recurso Removido com Sucesso!',
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
     * @param $codRecurso
     * @param $codAcao
     * @param $codTipoEducacao
     * @return null|object
     */
    protected function getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codAcao, $codTipoEducacao)
    {
        $entityManager = $this->factory->getEntityManager();
        $entity = $entityManager->getRepository(VinculoRecursoAcao::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'numOrgao' => $numOrgao,
            'numUnidade' => $numUnidade,
            'codRecurso' => $codRecurso,
            'codVinculo' => self::COD_VINCULO_MDE,
            'codTipo' => self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS,
            'codAcao' => $codAcao,
            'codTipoEducacao' => $codTipoEducacao,
        ]);

        return $entity;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $numOrgao
     * @param $numUnidade
     * @param $codRecurso
     * @return null|object
     */
    protected function getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso)
    {
        $entityManager = $this->factory->getEntityManager();
        $entity = $entityManager->getRepository(VinculoRecurso::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'numOrgao' => $numOrgao,
            'numUnidade' => $numUnidade,
            'codRecurso' => $codRecurso,
            'codVinculo' => self::COD_VINCULO_MDE,
            'codTipo' => self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS,
        ]);

        return $entity;
    }

    /**
     * @return VinculoRecursoAcao
     */
    protected function getVincularRecursoAcao()
    {
        return new VinculoRecursoAcao();
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/STN/Configuracao/VincularRecursoMDE/list.html.twig");
    }
}