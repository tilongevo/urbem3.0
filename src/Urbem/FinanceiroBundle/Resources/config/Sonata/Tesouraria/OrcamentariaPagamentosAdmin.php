<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcemg\TipoDocumento;
use Urbem\CoreBundle\Entity\Tesouraria\Boletim;
use Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal;
use Urbem\CoreBundle\Model\Tesouraria\OrcamentariaPagamentosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrcamentariaPagamentosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos';
    protected $baseRoutePattern = 'financeiro/tesouraria/pagamentos/orcamentaria-pagamentos';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/orcamentariapagamentos.js');
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = false;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('saldo_conta', 'saldo-conta', array(), array(), array(), '', array(), array('POST'));
        $collection->clearExcept(array('list', 'create', 'saldo_conta'));
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
                    'label' => 'label.orcamentariaPagamentos.codEntidade',
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
            ->add('exercicioEmpenho', null, ['label' => 'label.orcamentariaPagamentos.exercicioEmpenho'])
            ->add(
                'codEmpenhoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaPagamentos.codEmpenhoDe',
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
                    'label' => 'label.orcamentariaPagamentos.codEmpenhoAte',
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
                    'label' => 'label.orcamentariaPagamentos.codLiquidacaoDe',
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
                    'label' => 'label.orcamentariaPagamentos.codLiquidacaoAte',
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
                    'label' => 'label.orcamentariaPagamentos.codOrdemPagamentoDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number'
            )
            ->add(
                'codOrdemPagamentoAte',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaPagamentos.codOrdemPagamentoAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'number'
            )
            ->add(
                'codBarrasOP',
                'doctrine_orm_callback',
                [
                    'label' => 'label.orcamentariaPagamentos.codBarrasOP',
                    'callback' => array($this, 'getSearchFilter')
                ]
            )
            ->add(
                'fkEmpenhoEmpenho.fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.orcamentariaPagamentos.credor',
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
        $notas = (new OrcamentariaPagamentosModel($em))->listaEmpenhosPagarTesouraria(
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
            ->add('empenho', 'text', ['label' => 'label.orcamentariaPagamentos.empenho'])
            ->add('notaLiquidacao', 'text', ['label' => 'label.orcamentariaPagamentos.notaLiquidacao'])
            ->add('ordemPagamento', 'text', ['label' => 'label.orcamentariaPagamentos.ordemPagamento'])
            ->add('credor', 'text', ['label' => 'label.orcamentariaPagamentos.credor'])
            ->add('vlNota', 'currency', ['label' => 'label.orcamentariaPagamentos.vlPagamentoSemOP', 'currency' => 'BRL'])
            ->add('vlOrdemPagamento', 'currency', ['label' => 'label.orcamentariaPagamentos.vlPagamentoComOP', 'currency' => 'BRL'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'pagar' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/OrcamentariaPagamentos/CRUD:list__action_pagar.html.twig')
                )
            ))
        ;
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
            'label' => 'label.orcamentariaPagamentos.boletim',
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
            'template' => 'FinanceiroBundle::Tesouraria/OrcamentariaPagamentos/dadosPagamento.html.twig',
            'data' => $notaLiquidacao
        );

        $fieldOptions['registros'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/OrcamentariaPagamentos/registros.html.twig',
            'data' => $notaLiquidacao
        );

        $fieldOptions['contaPagadora'] = array(
            'label' => 'label.orcamentariaPagamentos.contaPagadora',
            'mapped' => false,
            'route' => ['name' => 'urbem_financeiro_contabilidade_lote_autocomplete_plano_analitica'],
            'req_params' => [
                'codEntidade' => $notaLiquidacao->getCodEntidade(),
                'exercicio' => $notaLiquidacao->getExercicio(),
                'codEstrutural' => "'1.1.1.%'~'1.1.4.%'"
            ]
        );

        $fieldOptions['tipoDocumento'] = array(
            'label' => 'label.orcamentariaPagamentos.tipoDocumento',
            'class' => TipoDocumento::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters',
            )
        );

        $fieldOptions['numero'] = array(
            'label' => 'label.orcamentariaPagamentos.numero',
            'mapped' => false
        );

        $fieldOptions['pagarOutra'] = array(
            'label' => 'label.orcamentariaPagamentos.pagarOutra',
            'mapped' => false,
            'required' => false
        );

        $fieldOptions['observacao'] = array(
            'label' => 'label.orcamentariaPagamentos.observacao',
            'mapped' => false,
        );

        $fieldOptions['exercicio'] = array(
            'data' => $notaLiquidacao->getExercicio(),
            'mapped' => false,
        );

        $formMapper->with('label.orcamentariaPagamentos.dadosBoletim');
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('boletim', 'entity', $fieldOptions['boletim']);
        $formMapper->end();
        $formMapper->with('label.orcamentariaPagamentos.dadosPagamento');
        $formMapper->add('dadosPagamento', 'customField', $fieldOptions['dadosPagamento']);
        $formMapper->end();
        $formMapper->with('label.orcamentariaPagamentos.registros');
        $formMapper->add('registros', 'customField', $fieldOptions['registros']);
        $formMapper->add('contaPagadora', 'autocomplete', $fieldOptions['contaPagadora']);
        $formMapper->add('tipoDocumento', 'entity', $fieldOptions['tipoDocumento']);
        $formMapper->add('numero', 'number', $fieldOptions['numero']);
        $formMapper->add('pagarOutra', 'checkbox', $fieldOptions['pagarOutra']);
        $formMapper->add('observacao', 'textarea', $fieldOptions['observacao']);
        $formMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $notaLiquidacao = $this->getNotaLiquidacao();
        $pagamentos = $this->request->get('vlPagamento');

        foreach ($pagamentos as $params => $pagamento) {
            if (!$notaLiquidacao->getVlNota()) {
                list($codOrdem, $exercicio, $codEntidade, $exercicioLiquidacao, $codNota) = explode('~', $params);
                $pagamentoLiquidacao = $em->getRepository(PagamentoLiquidacao::class)
                    ->findOneBy(
                        array(
                            'codOrdem' => $codOrdem,
                            'exercicio' => $exercicio,
                            'codEntidade' => $codEntidade,
                            'exercicioLiquidacao' => $exercicioLiquidacao,
                            'codNota' => $codNota
                        )
                    );

                if ((float) $pagamento > $pagamentoLiquidacao->getVlLiquido()) {
                    $mensagem = $this
                        ->getTranslator()
                        ->trans(
                            'label.orcamentariaPagamentos.erroVlNotaSuperior',
                            array(
                                '%codNota%' => $pagamentoLiquidacao->getCodNota(),
                                '%vlAPagar%' => number_format($pagamentoLiquidacao->getVlLiquido(), 2, ',', '.')
                            )
                        );
                    $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
                }
            } else {
                if ((float) $pagamento > $notaLiquidacao->getVlNota()) {
                    $mensagem = $this
                        ->getTranslator()
                        ->trans(
                            'label.orcamentariaPagamentos.erroVlNotaSuperior',
                            array(
                                '%codNota%' => $notaLiquidacao->getCodNota(),
                                '%vlAPagar%' => number_format($notaLiquidacao->getVlLiquido(), 2, ',', '.')
                            )
                        );
                    $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
                }
            }


            if ((float) $pagamento == 0) {
                $mensagem = $this->getTranslator()->trans('label.orcamentariaPagamentos.erroVlZero');
                $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }

        $planoRecurso = $em->getRepository(PlanoRecurso::class)
            ->findOneBy(
                array(
                    'codPlano' => $this->getForm()->get('contaPagadora')->getData(),
                    'exercicio' => $this->getExercicio(),
                    'codRecurso' => $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getCodRecurso()
                )
            );

        if (!$planoRecurso) {
            $mensagem = $this->getTranslator()->trans('label.orcamentariaPagamentos.erroContaPagadora');
            $errorElement->with('contaPagadora')->addViolation($mensagem)->end();
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

        $pagamento = (new OrcamentariaPagamentosModel($em))
            ->realizaPagamento(
                $notaLiquidacao,
                $this->getForm(),
                $currentUser,
                $this->request->get('vlPagamento'),
                $this->getTranslator()
            );

        if ($pagamento === true) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.orcamentariaPagamentos.msgSucesso', array('%ordemPagamento%' => (string) $notaLiquidacao->getOrdemPagamento())));
            $this->forceRedirect($this->generateUrl('create', array('params' => $this->getPersistentParameter('params'))));
        } elseif ($pagamento === false) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.orcamentariaPagamentos.msgSucesso', array('%ordemPagamento%' => (string) $notaLiquidacao->getOrdemPagamento())));
            $this->forceRedirect($this->generateUrl('list'));
        } else {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $pagamento->getMessage());
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getDtLiquidacao())
            ? (string) $object
            : $this->getTranslator()->trans('label.orcamentariaPagamentos.modulo');
    }
}
