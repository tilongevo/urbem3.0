<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tesouraria\Boletim;
use Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal;
use Urbem\CoreBundle\Model\Tesouraria\OrcamentariaEstornosModel;
use Urbem\CoreBundle\Model\Tesouraria\OrcamentariaPagamentosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrcamentariaEstornosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos';
    protected $baseRoutePattern = 'financeiro/tesouraria/pagamentos/orcamentaria-estornos';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/orcamentariaestornos.js');
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = false;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create'));
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'params' => $this->getRequest()->get('params'),
        );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere('1 = 0');
        } else {
            $this->exibirMensagemFiltro = false;
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codNota'));

        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'entidade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codEntidade',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => Entidade::class,
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.codEntidade', 'ASC');
                        return $qb;
                    },
                    'attr' => [
                        'required' => true
                    ]
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add('exercicioEmpenho', null, ['label' => 'label.orcamentariaEstornos.exercicioEmpenho'])
            ->add(
                'codEmpenhoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codEmpenhoDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'codEmpenhoAte',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codEmpenhoAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'codLiquidacaoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codLiquidacaoDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'codLiquidacaoAte',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codLiquidacaoAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'codOrdemPagamentoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codOrdemPagamentoDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number'
            )
            ->add(
                'codOrdemPagamentoAte',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codOrdemPagamentoAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number'
            )
            ->add(
                'codBarrasOP',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaEstornos.codBarrasOP',
                    'callback' => array($this, 'getSearchFilter')
                ]
            )
            ->add(
                'fkEmpenhoEmpenho.fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.orcamentariaEstornos.credor',
                    'callback' => array($this, 'getSearchFilter'),
                ],
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $cgm, $property) {
                        return (string) $cgm;
                    }
                ]
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!count($value['value'])) {
            return;
        }
        $em = $this->modelManager->getEntityManager($this->getClass());
        $notas = (new OrcamentariaEstornosModel($em))->listaEmpenhosEstornarTesouraria(
            $filter['entidade']['value'],
            $filter['codEmpenhoDe']['value'],
            $filter['codEmpenhoAte']['value'],
            $filter['codLiquidacaoDe']['value'],
            $filter['codLiquidacaoAte']['value'],
            $this->getExercicio(),
            $filter['exercicioEmpenho']['value'],
            ($filter['codOrdemPagamentoDe']['value'] != "") ? $filter['codOrdemPagamentoDe']['value'] : null,
            ($filter['codOrdemPagamentoAte']['value'] != "") ? $filter['codOrdemPagamentoAte']['value'] : null,
            ($filter['fkEmpenhoEmpenho__fkEmpenhoPreEmpenho__fkSwCgm']['value'] != "") ? $filter['fkEmpenhoEmpenho__fkEmpenhoPreEmpenho__fkSwCgm']['value'] : null
        );

        if (count($notas)) {
            $queryBuilder->andWhere("$alias.codNota in (:codNota)");
            $queryBuilder->andWhere("$alias.exercicio = :exercicio");
            $queryBuilder->andWhere("$alias.codEntidade = :codEntidade");
            $queryBuilder->setParameter('codNota', $notas);
            $queryBuilder->setParameter('exercicio', $this->getExercicio());
            $queryBuilder->setParameter('codEntidade', $filter['entidade']['value']);
        } else {
            $queryBuilder->andWhere('1 = 0');
        }
    }

    /**
     * @return NotaLiquidacao|null
     */
    public function getNotaLiquidacao()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        list($exercicio, $codNota, $codEntidade) = explode('~', $this->getPersistentParameter('params'));
        $notaLiquidacao = $em->getRepository(NotaLiquidacao::class)
            ->findOneBy(
                array(
                    'codNota' => $codNota,
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade
                )
            );
        return $notaLiquidacao;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $usuarioTerminal = $em->getRepository(UsuarioTerminal::class)
            ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/pagamentos/permissao');
        }

        $listMapper
            ->add('empenho', 'text', ['label' => 'label.orcamentariaEstornos.empenho'])
            ->add('notaLiquidacao', 'text', ['label' => 'label.orcamentariaEstornos.notaLiquidacao'])
            ->add('ordemPagamentoEstorno', 'text', ['label' => 'label.orcamentariaEstornos.ordemPagamento'])
            ->add('credor', 'text', ['label' => 'label.orcamentariaEstornos.credor'])
            ->add('vlNota', 'currency', ['label' => 'label.orcamentariaEstornos.vlPagoSemOP', 'currency' => 'BRL'])
            ->add('vlPago', 'currency', ['label' => 'label.orcamentariaEstornos.vlPagoComOP', 'currency' => 'BRL'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'estornar' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/OrcamentariaEstornos/CRUD:list__action_estornar.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $notaLiquidacao = $this->getNotaLiquidacao();

        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $usuarioTerminal = $em->getRepository(UsuarioTerminal::class)
            ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/pagamentos/permissao');
        }

        $boletins = (new OrcamentariaPagamentosModel($em))->listaBoletins($notaLiquidacao->getExercicio(), $notaLiquidacao->getCodEntidade());

        $fieldOptions['boletim'] = array(
            'label' => 'label.orcamentariaEstornos.boletim',
            'class' => Boletim::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($notaLiquidacao, $boletins) {
                $qb = $em->createQueryBuilder('o');
                if (count($boletins)) {
                    $qb->where('o.exercicio = :exercicio');
                    $qb->andWhere('o.codEntidade = :codEntidade');
                    $qb->andWhere('o.codBoletim IN (:codBoletim)');
                    $qb->setParameter('exercicio', $notaLiquidacao->getExercicio());
                    $qb->setParameter('codEntidade', $notaLiquidacao->getCodEntidade());
                    $qb->setParameter('codBoletim', $boletins);
                } else {
                    $qb->where('1 = 0');
                }
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters',
            )
        );

        $fieldOptions['dadosPagamento'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/OrcamentariaEstornos/dadosPagamento.html.twig',
            'data' => $notaLiquidacao
        );

        $fieldOptions['registros'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/OrcamentariaEstornos/registros.html.twig',
            'data' => $notaLiquidacao
        );

        $fieldOptions['data'] = array(
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'format' => 'dd/MM/yyyy',
            'label' => 'label.orcamentariaEstornos.data'
        );

        $fieldOptions['motivoEstorno'] = array(
            'label' => 'label.orcamentariaEstornos.motivoEstorno',
            'required' => false,
            'mapped' => false
        );

        $fieldOptions['exercicio'] = array(
            'data' => $notaLiquidacao->getExercicio(),
            'mapped' => false
        );

        $formMapper->with('label.orcamentariaEstornos.dadosBoletim');
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('boletim', 'entity', $fieldOptions['boletim']);
        $formMapper->end();
        $formMapper->with('label.orcamentariaEstornos.dadosPagamento');
        $formMapper->add('dadosPagamento', 'customField', $fieldOptions['dadosPagamento']);
        $formMapper->end();
        $formMapper->with('label.orcamentariaEstornos.registros');
        $formMapper->add('registros', 'customField', $fieldOptions['registros']);
        $formMapper->add('data', 'sonata_type_date_picker', $fieldOptions['data']);
        $formMapper->add('motivoEstorno', 'textarea', $fieldOptions['motivoEstorno']);
        $formMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $estornos = $this->request->get('vlEstorno');

        if (empty($estornos)) {
            $errorElement->with('vlEstornar')->addViolation($this->getContainer()->get('translator')->transChoice('label.orcamentariaEstornos.msgNaoValorEstorno', 0, [], 'messages'))->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $this->getContainer()->get('translator')->transChoice('label.orcamentariaEstornos.msgNaoValorEstorno', 0, [], 'messages'));
            return false;
        }

        $countZero = 0;
        $contRegistros = 0;
        foreach ($estornos as $params => $estorno) {
            list($codEntidade, $codNota, $exercicio, $timestamp) = explode('~', $params);
            $notaLiquidacaoPaga = $em->getRepository(NotaLiquidacaoPaga::class)
                ->findOneBy(
                    array(
                        'codEntidade' => $codEntidade,
                        'codNota' => $codNota,
                        'exercicio' => $exercicio,
                        'timestamp' => $timestamp
                    )
                );

            if ((float) $estorno > $notaLiquidacaoPaga->getVlPago()) {
                $mensagem = $this
                    ->getTranslator()
                    ->trans(
                        'label.orcamentariaEstornos.erroVlNotaSuperior',
                        array(
                            '%codNota%' => $notaLiquidacaoPaga->getCodNota(),
                            '%vlAPagar%' => number_format($notaLiquidacaoPaga->getVlPago(), 2, ',', '.')
                        )
                    );
                $errorElement->with('vlEstornar[' . $params . ']')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }

            if ((float) $estorno == 0) {
                $countZero++;
            }
            $contRegistros++;
        }

        if ($countZero == $contRegistros) {
            $mensagem = $this->getTranslator()->trans('label.orcamentariaEstornos.erroVlZero');
            $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $notaLiquidacao = $this->getNotaLiquidacao();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $estorno = (new OrcamentariaEstornosModel($em))
            ->realizaEstorno(
                $notaLiquidacao,
                $this->getForm(),
                $currentUser,
                $this->request->get('vlEstorno'),
                $this->getTranslator()
            );

        if ($estorno === true) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.orcamentariaEstornos.msgSucesso', array('%ordemPagamento%' => (string) $notaLiquidacao->getOrdemPagamento())));
            $this->forceRedirect($this->generateUrl('list'));
        } else {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $estorno->getMessage());
        }
        $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getDtLiquidacao())
            ? (string) $object
            : $this->getTranslator()->trans('label.orcamentariaEstornos.modulo');
    }
}
