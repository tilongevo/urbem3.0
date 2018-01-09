<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Contabilidade;
use Urbem\CoreBundle\Entity\Monetario;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\AssinaturaModel;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;
use Urbem\CoreBundle\Model\Tesouraria\BorderoModel;
use Urbem\CoreBundle\Model\Tesouraria\TransacoesPagamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class BorderoAdmin
 * @package Urbem\FinanceiroBundle\Admin
 */
class BorderoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_pagamento_bordero';
    protected $baseRoutePattern = 'financeiro/tesouraria/pagamentos/bordero';

    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'list', 'show']);

        $collection->add('relatorio', '{id}/relatorio', [
            '_controller' => 'FinanceiroBundle:Tesouraria/BorderoAdmin:relatorio'
        ]);

        $collection->add('busca_conta', "{_id}/busca-conta/", [
            '_controller' => 'FinanceiroBundle:Tesouraria/BorderoAdmin:getContaPorEntidadeAndExercicio'
        ]);

        $collection->add('busca_ordem_pag', "busca-ordem-pagamento/", [
            '_controller' => 'FinanceiroBundle:Tesouraria/BorderoAdmin:getOrdemPagamento'
        ]);

        $collection->add('busca_valores_ordem_pag', "busca-valores-ordem-pagamento/", [
            '_controller' => 'FinanceiroBundle:Tesouraria/BorderoAdmin:getValoresOrdemPagamento'
        ]);

        $collection->add('busca_agencias', "busca-agencias/", [
            '_controller' => 'FinanceiroBundle:Tesouraria/BorderoAdmin:getAgenciasPorBanco'
        ]);
    }

    /**
     * @param FormMapper $formMapper
     * @param integer $qtdeCampos
     */
    private function buildAssinaturaFields(FormMapper $formMapper, $qtdeCampos)
    {
        $formMapperOptions['ordemNonMapped'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'label' => 'label.bordero.ordem'
        ];

        $formMapperOptions['numMatriculaNonMapped'] = [
            'label' => 'label.bordero.numeroMatricula',
            'mapped' => false,
            'required' => false
        ];

        $formMapperOptions['cargoNonMapped'] = [
            'label' => 'label.bordero.cargo',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['numcgmNonMapped'] = [
            [
                'property' => 'nomCgm',
                'placeholder' => $this->trans('label.selecione'),
                'label' => 'label.autorizacao.responsavel',
                'mapped' => false,
                'required' => false
            ],
            [
                'admin_code' => 'core.admin.filter.sw_cgm'

            ]
        ];

        for ($count = 1; $count <= $qtdeCampos; $count++) {
            $formMapper
                ->with('label.bordero.assinantesBordero'.$count);
            $formMapperOptions['ordemNonMapped']['data'] = $count;
            $formMapper->add(sprintf('ordemNonMapped_%s', $count), 'number', $formMapperOptions['ordemNonMapped']);
            $formMapper->add(
                sprintf('numcgmNonMapped_%s', $count),
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        return $repo->createQueryBuilder('o')
                            ->where('o.nomCgm LIKE :nomCgm')
                            ->setParameter('nomCgm', "%{$term}%");
                    },
                    'label' => 'label.bordero.cgm',
                    'required' => false, // debug purpose
                    'mapped' => false, // debug purpose
                ]
            );
            $formMapper->add(sprintf('numMatriculaNonMapped_%s', $count), 'text', $formMapperOptions['numMatriculaNonMapped']);
            $formMapper->add(sprintf('cargoNonMapped_%s', $count), 'text', $formMapperOptions['cargoNonMapped']);
            $formMapper
            ->end();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();
            $this->setIncludeJs(['/financeiro/javascripts/tesouraria/bordero.js']);

        $formMapperOptions = [];
        $formMapperOptions['entidadeNonMapped'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Orcamento\Entidade::class,
            'choice_label' => function (Orcamento\Entidade $entidade) {
                return strtoupper($entidade->getFkSwCgm()->getNomCgm());
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $this->getExercicio());
                $qb->orderBy('o.codEntidade', 'ASC');
                return $qb;
            },
            'placeholder' => 'Selecione',
            'choice_value' =>  'cod_entidade',
            'label' => 'label.bordero.entidade',
            'mapped' => false
        ];

        $formMapperOptions['fkTesourariaBoletim'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => function (Tesouraria\Boletim $boletim) {
                $codigo = $boletim->getCodBoletim();
                $data = $boletim->getDtBoletim()->format('d/m/Y');

                return sprintf('%d - %s', $codigo, $data);
            },
            'label' => 'label.bordero.boletim',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $formMapperOptions['exercicio'] = [
            'data' => $this->getExercicio(),
            'label' => 'label.bordero.exercicio'
        ];

        $formMapperOptions['fkConciliacaoPlanoBanco'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Contabilidade\PlanoBanco::class,
            'choice_label' => function (Contabilidade\PlanoBanco $planoBanco) {
                $codigo = $planoBanco->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getCodEstrutural();
                $descricao = $planoBanco->getFkMonetarioContaCorrente()->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNomBanco();
                return sprintf('%s - %s', $codigo, $descricao);
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $this->getExercicio());
                $qb->orderBy('o.codEntidade', 'ASC');
                return $qb;
            },
            'choice_value' =>  'cod_plano',
            'label' => 'label.bordero.planoConta',
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $formMapper
            ->with('Dados para Borderô')
            ->add('entidadeNonMapped', 'entity', $formMapperOptions['entidadeNonMapped'])
            ->add('fkTesourariaBoletim', null, $formMapperOptions['fkTesourariaBoletim'])
            ->add('exercicio', null, $formMapperOptions['exercicio'])
            ->add('fkContabilidadePlanoBanco', null, $formMapperOptions['fkConciliacaoPlanoBanco'])
            ->end();

        $model = new BorderoModel($this->getDoctrine());

        $formMapperOptions['codTipo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [
                "label.bordero.labelsCodTipo.naoInformado" => $model::NAO_INFORMADO,
                "label.bordero.labelsCodTipo.transferenciaCCorrente" => $model::TRANSFERENCIA_CC,
                "label.bordero.labelsCodTipo.transferenciaPoupanca" => $model::TRANSFERENCIA_PO,
                "label.bordero.labelsCodTipo.doc" => $model::DOC,
                "label.bordero.labelsCodTipo.ted" => $model::TED
            ],
            'label' => 'label.bordero.tipo',
            'mapped' => false,
            'required' => false
        ];

        $formMapperOptions['codOrdemPagamento'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [],
            'label' => 'label.bordero.nrOrdemPagamento',
            'mapped' => false,
            'required' => false
        ];

        $formMapperOptions['banco'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Monetario\Banco::class,
            'choice_label' => function (Monetario\Banco $banco) {
                return $banco->getNomBanco();
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.codBanco', 'ASC');
                return $qb;
            },
            'placeholder' => 'Selecione',
            'choice_value' =>  'cod_banco',
            'label' => 'label.bordero.banco',
            'required' => false,
            'mapped' => false
        ];

        $formMapperOptions['agencia'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [],
            'label' => 'label.bordero.agencia',
            'placeholder' => 'Selecione',
            'required' => false,
            'mapped' => false
        ];

        $formMapper
            ->with('Dados para Transações de Borderô')
                ->add('codTipo', 'choice', $formMapperOptions['codTipo'])
                ->add('codOrdemPagamento', 'choice', $formMapperOptions['codOrdemPagamento'])
                ->add('valor', 'text', ['label' => 'valor', 'mapped' => false, 'required' => false, 'attr' => ['readonly' => true]])
                ->add('valorPago', 'text', ['label' => 'label.bordero.valorPago', 'required' => false, 'mapped' => false, 'attr' => ['readonly' => true]])
                ->add('valorLiquido', 'text', ['label' => 'label.bordero.valorLiquido', 'required' => false, 'mapped' => false, 'attr' => ['readonly' => true]])
                ->add('credor', 'text', ['label' => 'label.bordero.credor', 'mapped' => false, 'required' => false, 'attr' => ['readonly' => true]])
                ->add('banco', 'entity', $formMapperOptions['banco'])
                ->add('agencia', 'choice', $formMapperOptions['agencia'])
                ->add('contaCorrente', 'text', ['label' => 'label.bordero.contaCorrente', 'required' => false, 'mapped' => false])
                ->add(
                    'observacao',
                    'textarea',
                    [
                        'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                        'label' => 'label.bordero.observacao',
                        'required' => false,
                        'mapped' => false,
                        'attr' => [
                            'class' => 'mensagem-inicial '
                        ]
                    ]
                )
            ->end();

        $formMapper
            ->with('label.bordero.registros')
            ->add(
                'registros',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'FinanceiroBundle::Tesouraria/Bordero/registros.html.twig',
                    'data' => [
                        'dados' => null,
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            )
            ->end();
        ;

        $this->buildAssinaturaFields($formMapper, 3);
    }

    /**
     * @param ErrorElement $errorElement
     * @param Tesouraria\Bordero $bordero
     */
    public function validate(ErrorElement $errorElement, $bordero)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $params = $form->all();

        if (!empty($params['entidadeNonMapped']->getViewData()) || !empty($params['fkTesourariaBoletim']->getViewData())) {
            $boletimModel = new BoletimModel($em);
            $boletimArray = current($boletimModel->getBoletins([
                sprintf('cod_entidade = %s', $params['entidadeNonMapped']->getViewData()),
                sprintf('cod_boletim = %s', $params['fkTesourariaBoletim']->getViewData()),
                "exercicio = '{$bordero->getExercicio()}'"
            ]));

            list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletimArray->dt_boletim);

            $arrecadacaoModel = new ArrecadacaoModel($em);
            if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
                $mensagem = $this->getContainer()->get('translator')->transChoice('label.bordero.msgBordero.mesAtualEcerrado', 0, [], 'messages');
                $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if (empty($this->getRequest()->request->get('registros'))) {
                $mensagem = $this->getContainer()->get('translator')->transChoice('label.bordero.msgBordero.requiredTransacao', 0, [], 'messages');
                $errorElement->with('fkTesourariaTransacoesPagamentos')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            $boletim = $boletimModel->findOneBy([
                'codBoletim' => $params['fkTesourariaBoletim']->getViewData(),
                'codEntidade' => $params['entidadeNonMapped']->getViewData(),
                'exercicio' => $bordero->getExercicio()
            ]);


            $entidade = $this->getDoctrine()->getRepository(Orcamento\Entidade::class)->findOneBy(['exercicio' => $params['entidadeNonMapped']->getViewData(), 'exercicio' => $params['exercicio']->getViewData()]);
            $planoBanco = $this->getDoctrine()->getRepository(Contabilidade\PlanoBanco::class)->findOneBy(['codPlano' => $params['fkContabilidadePlanoBanco']->getViewData(), 'exercicio' => $params['exercicio']->getViewData()]);

            $bordero->setFkTesourariaBoletim($boletim);
            $bordero->setFkOrcamentoEntidade($entidade);
            $bordero->setFkContabilidadePlanoBanco($planoBanco);
            $bordero->setFkTesourariaUsuarioTerminal($boletim->getFkTesourariaUsuarioTerminal());
        }
    }

    /**
     * @param Tesouraria\Bordero $bordero
     */
    public function prePersist($bordero)
    {

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $borderoModel = new BorderoModel($em);
        $borderoModel->buildBordero($bordero);

        $entidadeModel = new EntidadeModel($em);
        $entidade = $entidadeModel->find([
            'exercicio' => $bordero->getExercicio(),
            'codEntidade' => $bordero->getCodEntidade()
        ]);

        $transacoesPagamentoModel = new TransacoesPagamentoModel($em);
        if (!empty($this->getRequest()->request->get('registros'))) {
            $transacoesPagamentoModel->populaTransacoesPagamento(
                $this->getRequest()->request->get('registros'),
                $bordero
            );
        }

        $assinaturaModel = new AssinaturaModel($em);
        for ($count = 1; $count <= 3; $count++) {
            $cargo = $form->get(sprintf('cargoNonMapped_%s', $count))->getData();
            $numcgm = $form->get(sprintf('numcgmNonMapped_%s', $count))->getData();
            $numMatricula = $form->get(sprintf('numMatriculaNonMapped_%s', $count))->getData();

            if (!is_null($numcgm)) {
                $assinaturaModel
                    ->saveAssinatura($entidade, $numMatricula, $cargo, $numcgm, $bordero->getExercicio(), 'BR');
            }
        }
    }

    public function postPersist($object)
    {
        $this->redirectByRoute($this->baseRouteName . "_create");
    }


    /**
     * @param DatagridMapper $filterMapper
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('fkTesourariaBoletim', null, [
                'label' => 'label.bordero.entidade'
            ], null, [
                'choice_label' => 'fkEntidade.numcgm.nomCgm'
            ]);
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codBordero', null, ['label' => 'label.bordero.codigo'])
            ->add('fkTesourariaBoletim', null, [
                'label' => 'label.bordero.entidade',
                'associated_property' => function (Tesouraria\Boletim $boletim) {
                    return $boletim->getFkEntidade()->getNumcgm()->getNomCgm();
                }
            ])
            ->add('fkConciliacaoPlanoBanco.codAgencia', null, [
                'label' => 'label.bordero.agencia',
                'associated_property' => function (Monetario\Agencia $agencia) {
                    return $agencia->getNomAgencia();
                }
            ])
            ->add('fkConciliacaoPlanoBanco.codBanco', null, [
                'label' => 'label.bordero.banco',
                'associated_property' => function (Monetario\Banco $banco) {
                    return $banco->getNomBanco();
                }
            ])
            ->add('fkConciliacaoPlanoBanco.contaCorrente', null, [
                'label' => 'label.bordero.contaCorrente',
                'associated_property' => function (Monetario\ContaCorrente $contaCorrente) {
                    return $contaCorrente->getNumContaCorrente();
                }
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $adminRequestId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $adminRequestId]);

        $this->customHeader = 'FinanceiroBundle::Tesouraria\Bordero\header.html.twig';


        $showMapper
            ->add('codBordero', null, ['label' => 'label.bordero.codigo'])
            ->add('exercicio', null, ['label' => 'label.bordero.exercicio'])
            ->add('fkTesourariaBoletim.fkEntidade.numcgm.nomCgm', null, ['label' => 'label.bordero.entidade'])
            ->add('fkTesourariaBoletim', null, [
                'label' => 'label.bordero.boletim',
                'associated_property' => function (Tesouraria\Boletim $boletim) {
                    return sprintf('%d/%s', $boletim->getCodBoletim(), $boletim->getExercicio());
                }
            ])
            ->add('fkConciliacaoPlanoBanco.codAgencia.nomAgencia', null, ['label' => 'label.bordero.agencia'])
            ->add('fkConciliacaoPlanoBanco.codBanco.nomBanco', null, ['label' => 'label.bordero.banco'])
            ->add('fkConciliacaoPlanoBanco.contaCorrente', null, ['label' => 'label.bordero.contaCorrente']);
    }
}
