<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ChequeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'numCheque',
    );

    protected $includeJs = [
            '/financeiro/javascripts/tesouraria/cheque/configCheque.js',
            '/financeiro/javascripts/tesouraria/cheque/defaultCheque.js',
            '/financeiro/javascripts/tesouraria/cheque/cheque.js'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('agencias_por_banco', "agencias-por-banco/");
        $collection->add('cc_por_agencia', "cc-por-agencia/");
        $collection->add('ultimo_cheque', "ultimo-cheque/");
        $collection->add('cheques_por_cc', "cheques-por-cc/");
        $collection->add('emissao_baixar', "{$this->getRouterIdParameter()}/emissao-baixar/");
        $collection->add('emissao_anular_baixa', "{$this->getRouterIdParameter()}/emissao-anular-baixa/");
        $collection->add('anular_emissao', "{$this->getRouterIdParameter()}/anular-emissao/");
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'FinanceiroBundle:Tesouraria/Cheque:base_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numCheque', null, ['label' => 'label.tesouraria.cheque.numeroCheque'])
            ->add('dataEntrada', null, ['label' => ''], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add('fkMonetarioContaCorrente.numContaCorrente', null, ['label' => 'label.tesouraria.cheque.cc'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numCheque', null, ['label' => 'label.tesouraria.cheque.numeroCheque'])
            ->add('dataEntrada', null, ['label' => ''])
            ->add('fkMonetarioContaCorrente.numContaCorrente', null, ['label' => 'label.tesouraria.cheque.cc'])
            ->add(
                'codBanco',
                'string',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:banco.html.twig',
                    'label' => 'label.tesouraria.cheque.banco'
                ]
            )
            ->add(
                'codAgencia',
                'string',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:agencia.html.twig',
                    'label' => 'label.tesouraria.cheque.agencia'
                ]
            )
            ->add(
                'emitido',
                'string',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:emitido.html.twig',
                    'label' => 'label.tesouraria.cheque.emitido'
                ]
            )
            ->add(
                'tipoEmissao',
                'string',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:tipo_emissao.html.twig',
                    'label' => 'label.tesouraria.cheque.tipoEmissao'
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }


    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'FinanceiroBundle:Tesouraria/Cheque:list__action_delete.html.twig'),
                    'anular' => array('template' => 'FinanceiroBundle:Tesouraria/Cheque:anular_emissao_action.html.twig')
                )
            ))
        ;
    }


    public function validate(ErrorElement $errorElement, $object)
    {
        try {
            $object->setCodAgencia($this->getForm()->get('codAgencia')->getViewData());
        } catch (\Exception $e) {
            $this->validateCheque($errorElement, "Por favor, selecione uma agencia.", "codAgencia");
        }

        try {
            $object->setCodContaCorrente($this->getForm()->get('codContaCorrente')->getViewData());
        } catch (\Exception $e) {
            $this->validateCheque($errorElement, "Por favor, selecione uma conta corrente.", "codContaCorrente");
        }

        $repository = $this->getDoctrine()->getRepository($this->getClass());
        if (!empty($repository->findOneBy(
            [
                    'numCheque' => $object->getNumCheque(),
                    'codAgencia' => $object->getCodAgencia(),
                    'codBanco' => $object->getCodBanco(),
                    'codContaCorrente' => $object->getCodContaCorrente()
                ]
        ))) {
            $this->validateCheque($errorElement, "Esse cheque já esta cadastrado!", "numCheque");
        }
    }

    public function prePersist($object)
    {
        $repositoryAgencia = $this->getDoctrine()->getRepository(Agencia::class);
        $agencia = $repositoryAgencia->findOneBy(['codAgencia' => $object->getCodAgencia()]);
        $object->setCodAgencia($agencia->getCodAgencia());

        $repositoryCc = $this->getDoctrine()->getRepository(ContaCorrente::class);
        $contaCorrente = $repositoryCc->findOneBy(['codContaCorrente' => $object->getCodContaCorrente()]);
        $object->setFkMonetarioContaCorrente($contaCorrente);

        $object->setDataEntrada(new \DateTime());

        $childrens = $this->getForm()->all();
        if ($childrens['opcaoTalao']->getViewData() == "talao") {
            $talao = $this->cloneCheques($object, $childrens['opcaoTalaoNumCheque']->getViewData());
            $chequesCadastrados = $this->saveTalao($talao);
            $this->getFlashBag()->add('success', 'Talão de cheques cadastrado com sucesso!');

            if (!empty($chequesCadastrados)) {
                $this->getFlashBag()->add('error', "Cheques que já estavam cadastrados: {$chequesCadastrados}");
            }

            return $this->redirectByRoute($this->baseRouteName.'_list');
        }
    }

    /**
     * Clona os cheques e insere o numero
     * @param $object
     * @param $opcaoTalaoNumCheque
     * @return ArrayCollection
     */
    protected function cloneCheques($object, $opcaoTalaoNumCheque)
    {
        $talao = new ArrayCollection();
        foreach (range($object->getNumCheque(), $opcaoTalaoNumCheque) as $number) {
            $entity = clone $object;
            $entity->setNumCheque($number);
            $talao->add($entity);
        }
        return $talao;
    }

    /**
     * Salva o talão de cheques
     * Verifica se no range de talões, tem algum que já esteja cadastrado
     *
     * @param $talao
     * @return string
     */
    protected function saveTalao($talao)
    {
        $chequesCadastrados = [];
        foreach ($talao as $cheque) {
            $repository = $this->getDoctrine()->getRepository($this->getClass());
            $dadosConsulta = ['codAgencia' => $cheque->getCodAgencia(), 'codBanco' => $cheque->getCodBanco(), 'codContaCorrente' => $cheque->getCodContaCorrente(), 'numCheque' => $cheque->getNumCheque()];

            if (!empty($repository->findOneBy($dadosConsulta))) {
                $chequesCadastrados[] = $cheque->getNumCheque();
            } else {
                $this->getDoctrine()->persist($cheque);
                $this->getDoctrine()->flush($cheque);
            }
        }

        return implode(", ", $chequesCadastrados);
    }

    /**
     * @param ErrorElement $errorElement
     * @param $error
     */
    public function validateCheque(ErrorElement $errorElement, $error, $with)
    {
        $errorElement->with($with)->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    /**
     * @param FormMapper $formMapper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();
        if (!empty($this->getAdminRequestId())) {
            return $this->redirectByRoute($this->baseRouteName.'_list');
        }

        $repository = $this->getDoctrine()->getRepository($this->getClass());
        $bancos = ArrayHelper::parseArrayToChoice($repository->findBancosPorExercicio($this->getExercicio()), 'nom_banco', 'cod_banco');
        $agencias = ArrayHelper::parseArrayToChoice($repository->findAllAgencias(), 'nom_agencia', 'cod_agencia');
        $contasCorrente = $this->parseArrayToChoice($repository->findAllContasCorrente(), 'num_conta_corrente', 'cod_conta_corrente');

        $formMapper
            ->add(
                'codBanco',
                'choice',
                [
                    'required' => true,
                    'choices' => $bancos,
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'label' => 'label.tesouraria.cheque.bancos',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'codAgencia',
                'choice',
                [
                    'required' => true,
                    'mapped' => false,
                    'choices' => $agencias,
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'label' => 'label.tesouraria.cheque.agencia',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'codContaCorrente',
                'choice',
                [
                    'required' => true,
                    'mapped' => false,
                    'choices' => $contasCorrente,
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'label' => 'label.tesouraria.cheque.cc',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'lastNumCheque',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.tesouraria.cheque.ultimoNumeroCheque',
                    'attr' => ['readonly'=>'readonly']

                ]
            )
            ->add(
                'opcaoTalao',
                'choice',
                [
                    'label' => 'label.tesouraria.cheque.talaoDeCheque',
                    'choices' => ['Cheque' => 'cheque', 'Talão' => 'talao'],
                    'required' => false,
                    'mapped' => false,
                    'data' => 'cheque',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add('numCheque', null, ['label' => 'label.tesouraria.cheque.numeroCheque'])
            ->add('opcaoTalaoNumCheque', 'text', ['label' => 'label.tesouraria.cheque.numeroChequeAte', 'mapped' => false, 'required' => false])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $cheque = $this->getObject($id);

        $repository = $this->getDoctrine()->getRepository('CoreBundle:Monetario\Agencia');
        $agencia = $repository->findOneBy(['codAgencia' => $cheque->getCodAgencia()]);

        $repository = $this->getDoctrine()->getRepository('CoreBundle:Monetario\Banco');
        $banco = $repository->findOneBy(['codBanco' => $cheque->getCodBanco()]);

        $repository = $this->getDoctrine()->getRepository('CoreBundle:Tesouraria\Cheque');
        $dadosCheque =  $repository->dadosCheque($banco->getNumBanco(), $agencia->getNumAgencia(), $cheque->getFkMonetarioContaCorrente()->getNumContaCorrente(), $cheque->getNumCheque());

        $this->dados = $dadosCheque;

        $showMapper
            ->with('label.tesouraria.cheque.dadosCheque')
                ->add('numCheque', null, ['label' => 'label.tesouraria.cheque.numeroCheque'])
                ->add('dataEntrada', null, ['label' => ''])
                ->add('fkMonetarioContaCorrente.numContaCorrente', null, ['label' => 'label.tesouraria.cheque.cc'])
                ->add(
                    'codBanco',
                    'entity',
                    [
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:banco.html.twig',
                        'label' => 'label.tesouraria.cheque.banco'
                     ]
                )
                ->add(
                    'codAgencia',
                    'entity',
                    [
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:agencia.html.twig',
                        'label' => 'label.tesouraria.cheque.agencia'
                    ]
                )
                ->add(
                    'emitido',
                    'entity',
                    [
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:emitido.html.twig',
                        'label' => 'label.tesouraria.cheque.emitido'
                    ]
                )
            ->end()
        ;

        if (!empty($dadosCheque['data_emissao'])) {
            $showMapper
                ->with('label.tesouraria.cheque.dadosEmissao')
                ->add(
                    'dadosEmissao',
                    'customField',
                    [
                        'label' => 'label.tesouraria.cheque.dadosEmissao',
                        'mapped' => false,
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:dados_emissao.html.twig'
                    ]
                )
                ->end();

            if ($dadosCheque['tipo_emissao'] == "ordem_pagamento") {
                $showMapper
                    ->with('label.tesouraria.cheque.dadosOrdemPagamento')
                    ->add(
                        'dadosOrdemPagamento',
                        'customField',
                        [
                            'label' => 'label.tesouraria.cheque.dadosOrdemPagamento',
                            'mapped' => false,
                            'template' => 'FinanceiroBundle:Tesouraria/Cheque:dados_ordem_pagamento.html.twig'
                        ]
                    )
                    ->end();
            }

            if ($dadosCheque['tipo_emissao'] == "despesa_extra") {
                $showMapper
                    ->with('label.tesouraria.cheque.dadosDespesaExtra')
                    ->add(
                        'dadosOrdemPagamento',
                        'customField',
                        [
                            'label' => 'label.tesouraria.cheque.dadosOrdemPagamento',
                            'mapped' => false,
                            'template' => 'FinanceiroBundle:Tesouraria/Cheque:dados_recibo_extra.html.twig'
                        ]
                    )
                    ->end();
            }

            if ($dadosCheque['tipo_emissao'] == "transferencia") {
                $showMapper
                    ->with('label.tesouraria.cheque.dadosTransferencia')
                    ->add(
                        'dadosOrdemPagamento',
                        'customField',
                        [
                            'label' => 'label.tesouraria.cheque.dadosTransferencia',
                            'mapped' => false,
                            'template' => 'FinanceiroBundle:Tesouraria/Cheque:dados_transferencia.html.twig'
                        ]
                    )
                    ->end();
            }
        }

        if (!empty($dadosCheque['data_anulacao'])) {
            $showMapper
                ->with('label.tesouraria.cheque.dadosAnulacao')
                    ->add(
                        'dadosEmissaoAnulacao',
                        'customField',
                        [
                            'label' => 'label.tesouraria.cheque.dadosAnulacao',
                            'mapped' => false,
                            'template' => 'FinanceiroBundle:Tesouraria/Cheque:dados_anulacao.html.twig',
                            'attr' => [
                                'class' => ''
                            ]
                        ]
                    )
                ->end()
            ;
        }
    }


    /**
     * Helper para esse admin
     * Concatena a key para não repetir
     * @param $array
     * @param $campoChave
     * @param $campoValor
     * @return array
     */
    public function parseArrayToChoice($array, $campoChave, $campoValor)
    {
        if (empty($array)) {
            return $array;
        }

        $result = [];
        foreach ($array as $key) {
            $result[$key[$campoChave] . '/' . $key[$campoValor]] = $key[$campoValor];
        }

        return $result;
    }
}
