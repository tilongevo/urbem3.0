<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Empenho\OrdemPagamento;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ChequeEmissaoOrdemPagamentoCollectionAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_cheque';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-ordem-pagamento/cheque';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Emitir cheque'];
    protected $includeJs = [
        '/financeiro/javascripts/tesouraria/cheque/configChequeEmissaoOrdemPagamento.js',
        '/financeiro/javascripts/tesouraria/cheque/defaultCheque.js',
        '/financeiro/javascripts/tesouraria/cheque/chequeEmissao.js'
    ];

    public function validate(ErrorElement $errorElement, $object)
    {
        $params = $this->getForm()->all();

        $object->setCodOrdem($params['fkOrdemPagamento__codOrdem']->getViewData());
        $object->setExercicio($params['fkOrdemPagamento__exercicio']->getViewData());
        $object->setCodEntidade($params['fkOrdemPagamento__codEntidade']->getViewData());
        $object->setCodAgencia($params['codAgencia']->getViewData());
        $object->setCodContaCorrente($params['codContaCorrente']->getViewData());
        $valor = $this
                ->getContainer()
                ->get('urbem.coreBundle.tesouraria.cheque')
                ->getValorChequeEmissao($object->getCodOrdem(), $object->getExercicio(), $object->getCodEntidade());

        if (empty($valor)) {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.naoTemValorEmitirCheque', 0, [], 'messages')
            );
        }

        //Valor do cheque não pode ser superior ao valor do cheque
        if (($valor - $params['valorCheque']->getViewData()) < 0) {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.valorChequeMaiorOrdemPagamento', 0, [], 'messages')
            );
        }

        if (empty($object->getNumCheque())) {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.chequeInvalido', 0, [], 'messages')
            );
        }

        //Verifica se o cheque existe
        $repositoryCheque = $this->getDoctrine()->getRepository(Cheque::class);
        $cheque = $repositoryCheque->findOneBy(
            [
                    'codBanco' => $object->getCodBanco(),
                    'codAgencia' => $object->getCodAgencia(),
                    'codContaCorrente' => $object->getCodContaCorrente(),
                    'numCheque' => $object->getNumCheque()
                ]
        );

        //verifica se o cheque existe
        if (empty($cheque)) {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.chequeNaoExiste', 0, [], 'messages')
            );
        }

        $repositoryContaCorrente = $this->getDoctrine()->getRepository(ContaCorrente::class);
        $contaCorrente = $repositoryContaCorrente->findOneBy(['codBanco' => $object->getCodBanco(), 'codAgencia' => $object->getCodAgencia(), 'codContaCorrente' => $object->getCodContaCorrente()]);

        $emitido = $repositoryCheque->dadosCheque(
            $contaCorrente->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNumBanco(),
            $contaCorrente->getFkMonetarioAgencia()->getNumAgencia(),
            $contaCorrente->getNumContaCorrente(),
            $object->getNumCheque()
        );

        //Verifica se o cheque já foi emitido
        if ($emitido == "Sim") {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.chequeJaEmitido', 0, [], 'messages')
            );
        }
    }

    public function validateEmissao(ErrorElement $errorElement, $error)
    {
        $errorElement->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    public function prePersist($object)
    {
        $params = $this->getForm()->all();
        $ordermPagCheque = $this->getDoctrine()->getRepository(OrdemPagamento::class);

        $ordemPag = $ordermPagCheque->findOneBy(
            [
                'codOrdem' => $object->getCodOrdem(),
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $object->getCodEntidade()
            ]
        );

        $id = "{$object->getCodOrdem()}~{$object->getExercicio()}~{$object->getCodEntidade()}";

        $repositoryCheque = $this->getDoctrine()->getRepository(Cheque::class);
        $cheque = $repositoryCheque->findOneBy(
            [
                'codBanco' => $object->getCodBanco(),
                'codAgencia' => $object->getCodAgencia(),
                'codContaCorrente' => $object->getCodContaCorrente(),
                'numCheque' => $object->getNumCheque()
            ]
        );

        $chequeEmissao = new ChequeEmissao();
        $chequeEmissao->setValor((float) $params['valorCheque']->getViewData());
        $chequeEmissao->setDescricao($params['observacao']->getViewData());
        $chequeEmissao->setFkTesourariaCheque($cheque);
        $object->setFkEmpenhoOrdemPagamento($ordemPag);
        $object->setFkTesourariaChequeEmissao($chequeEmissao);
        $chequeEmissao->addFkTesourariaChequeEmissaoOrdemPagamentos($object);

        try {
            $this->getDoctrine()->persist($chequeEmissao);
            $this->getDoctrine()->flush($chequeEmissao);
            $this->getFlashBag()->add('success', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmitidoSucesso', 0, [], 'messages'));
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.erroEmitirCheque', 0, ['numCheque' => $object->getNumCheque()], 'messages'));
        }

        return $this->redirectByRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_edit', ['id' => $id]);
    }

    /**
     * @param FormMapper $formMapper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb([]);

        if (empty($this->getAdminRequestId())) {
            $uniqid =  $this->getRequest()->query->get('uniqid');
            $params = $this->getRequest()->request->get($uniqid);
            $codOrdem = $params['fkOrdemPagamento__codOrdem'];
            $exercicio = $params['fkOrdemPagamento__exercicio'];
            $entidade = $params['fkOrdemPagamento__codEntidade'];
        } else {
            $id = $this->getAdminRequestId();
            list($codOrdem, $exercicio, $entidade) = explode("~", $id);
        }


        $valor = $this
            ->getContainer()
            ->get('urbem.coreBundle.tesouraria.cheque')
            ->getValorChequeEmissao($codOrdem, $exercicio, $entidade);


        if (empty($valor)) {
            $this->getFlashBag()->add('error', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.naoTemValorEmitirCheque', 0, [], 'messages'));
            return $this->redirectByRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_list');
        }

        $repositoryOrdemPag = $this->getDoctrine()->getRepository(OrdemPagamento::class);
        $ordemPagamento = $repositoryOrdemPag->findOneBy(['codOrdem' => $codOrdem, 'exercicio' => $exercicio, 'codEntidade' => $entidade]);

        $repository = $this->getDoctrine()->getRepository(Cheque::class);
        $bancos = ArrayHelper::parseArrayToChoice($repository->findBancosPorExercicio($this->getExercicio()), 'nom_banco', 'cod_banco');
        $agencias = ArrayHelper::parseArrayToChoice($repository->findAllAgencias(), 'nom_agencia', 'cod_agencia');
        $contasCorrente = ArrayHelper::parseArrayToChoice($repository->findAllContasCorrente(), 'num_conta_corrente', 'cod_conta_corrente');
        $cheques = ArrayHelper::parseArrayToChoice($repository->findAllCheques(), 'numCheque', 'numCheque');

        $valor = $this
            ->getContainer()
            ->get('urbem.coreBundle.tesouraria.cheque')
            ->getValorChequeEmissao($ordemPagamento->getCodOrdem(), $ordemPagamento->getExercicio(), $ordemPagamento->getCodEntidade());

        $formMapper
            ->with('label.tesouraria.cheque.dadosChequeEmissaoOrdemPagamento')
                ->add(
                    'fkOrdemPagamento.getValor',
                    'money',
                    [
                        'label' => 'label.tesouraria.cheque.valorOrdemPagamento',
                        'mapped' => false,
                        'data' => $valor,
                        'currency' => 'BRL',
                        'attr' => [
                            'readonly'=>'readonly'
                        ]
                    ]
                )
                ->add('fkOrdemPagamento.codOrdem', 'hidden', ['data' => $codOrdem, 'mapped' => false])
                ->add('fkOrdemPagamento.exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
                ->add('fkOrdemPagamento.codEntidade', 'hidden', ['data' => $entidade, 'mapped' => false])
                ->add(
                    'codBanco',
                    'choice',
                    [
                        'required' => true,
                        'choices' => $bancos,
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
                    'numCheque',
                    'choice',
                    [
                        'required' => false,
                        'choices' => $cheques,
                        'label' => 'label.tesouraria.cheque.numeroCheque',
                        'placeholder' => 'label.selecione',
                        'choice_value' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'valorCheque',
                    'money',
                    [
                        'label' => 'label.ordemPagamento.valor',
                        'currency' => 'BRL',
                        'mapped'=> false,
                        'attr' => [
                            'class' => 'money '
                        ]
                    ]
                )
                ->add('observacao', 'textarea', ['mapped'=> false])
            ->end()
        ;
    }
}
