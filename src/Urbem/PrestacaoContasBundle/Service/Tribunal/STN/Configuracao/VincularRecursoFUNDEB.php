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
 * Class VincularRecursoFUNDEB
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularRecursoFUNDEB extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_VINCULO_FUNDEB = 1;
    const COD_TIPO_RECURSOS_PAGAMENTO_PROFISSIONAIS_MAGISTERIO = 1;
    const COD_TIPO_RECURSOS_OUTRAS_DESPESAS = 2;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularRecursoFUNDEB.js',
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
                $codTipo = $formData['tipoRecurso'];
                $codRecurso = $formData['recurso'];
                $codAcao = $formData['acao'];
                $codTipoEducacao = $formData['tipoEducacaoInfantil'];

                $entityVinculoRecursoAcao = $this->getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo, $codAcao, $codTipoEducacao);
                $entityVinculoRecurso = $this->getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo);

                if (!$entityVinculoRecursoAcao instanceof VinculoRecursoAcao) {
                    $entityVinculoRecursoAcao = $this->getVincularRecursoAcao();
                }
                $entityVinculoRecursoAcao->setExercicio($exercicio);
                $entityVinculoRecursoAcao->setCodEntidade($codEntidade);
                $entityVinculoRecursoAcao->setNumOrgao($numOrgao);
                $entityVinculoRecursoAcao->setNumUnidade($numUnidade);
                $entityVinculoRecursoAcao->setCodRecurso($codRecurso);
                $entityVinculoRecursoAcao->setCodVinculo(self::COD_VINCULO_FUNDEB);
                $entityVinculoRecursoAcao->setCodTipo($codTipo);
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
                $entityVinculoRecurso->setCodVinculo(self::COD_VINCULO_FUNDEB);
                $entityVinculoRecurso->setCodTipo($codTipo);

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
    protected function actionLoadPagamentosDespesas()
    {
        $pagamentos = [];
        $despesas = [];

        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();

        $data = $em->getRepository(Recurso::class)->getRecursosByCodVinculo($exercicio, ['cod_vinculo' => self::COD_VINCULO_FUNDEB]);

        if (count($data)) {
            foreach ($data as $item) {
                if ($item['cod_tipo'] == self::COD_TIPO_RECURSOS_PAGAMENTO_PROFISSIONAIS_MAGISTERIO) {
                    $pagamentos[] = $item;
                }
                if ($item['cod_tipo'] == self::COD_TIPO_RECURSOS_OUTRAS_DESPESAS) {
                    $despesas[] = $item;
                }
            }
        }

        return [
            'pagamentos' => $pagamentos,
            'despesas' => $despesas
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
        $codTipo = $this->getRequest()->get('codTipo');
        $codTipoEducacao = $this->getRequest()->get('codTipoEducacao');
        $codAcao = $this->getRequest()->get('codAcao');

        $entityVinculoRecursoAcao = $this->getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo, $codAcao, $codTipoEducacao);
        $entityVinculoRecurso = $this->getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo);

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
     * @param $codTipo
     * @param $codAcao
     * @param $codTipoEducacao
     * @return null|object
     */
    protected function getEntityVinculoRecursoAcao($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo, $codAcao, $codTipoEducacao)
    {
        $entityManager = $this->factory->getEntityManager();
        $entity = $entityManager->getRepository(VinculoRecursoAcao::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'numOrgao' => $numOrgao,
            'numUnidade' => $numUnidade,
            'codRecurso' => $codRecurso,
            'codVinculo' => self::COD_VINCULO_FUNDEB,
            'codTipo' => $codTipo,
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
     * @param $codTipo
     * @return null|object
     */
    protected function getEntityVinculoRecurso($exercicio, $codEntidade, $numOrgao, $numUnidade, $codRecurso, $codTipo)
    {
        $entityManager = $this->factory->getEntityManager();
        $entity = $entityManager->getRepository(VinculoRecurso::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'numOrgao' => $numOrgao,
            'numUnidade' => $numUnidade,
            'codRecurso' => $codRecurso,
            'codVinculo' => self::COD_VINCULO_FUNDEB,
            'codTipo' => $codTipo,
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/STN/Configuracao/VincularRecursoFUNDEB/fundebList.html.twig");
    }
}