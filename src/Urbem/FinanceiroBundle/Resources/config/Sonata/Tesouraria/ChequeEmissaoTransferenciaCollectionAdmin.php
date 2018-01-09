<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ChequeEmissaoTransferenciaCollectionAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_transferencia_cheque';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-transferencia/cheque';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Emitir cheque'];


    public function validate(ErrorElement $errorElement, $object)
    {
        $params = $this->getForm()->all();

        $object->setCodBanco($params['fkTransferencia__codBanco']->getViewData());
        $object->setCodAgencia($params['fkTransferencia__codAgencia']->getViewData());
        $object->setCodContaCorrente($params['fkTransferencia__contaCorrente']->getViewData());
        $object->setCodLote($params['fkTransferencia__codLote']->getViewData());
        $object->setExercicio($params['fkTransferencia__exercicio']->getViewData());
        $object->setCodEntidade($params['fkTransferencia__codEntidade']->getViewData());
        $object->setTipo($params['fkTransferencia__tipo']->getViewData());

        $valor = $this
            ->getContainer()
            ->get('urbem.coreBundle.tesouraria.cheque')
            ->getValorChequeEmissaoTransferencia($object->getCodLote(), $object->getExercicio(), $object->getCodEntidade(), $object->getTipo());


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
        $id = "{$object->getCodLote()}~{$object->getExercicio()}~{$object->getCodEntidade()}~{$object->getTipo()}";
        $params = $this->getForm()->all();
        $repositoryTransferencia = $this->getDoctrine()->getRepository(Transferencia::class);
        $transferencia = $repositoryTransferencia->findOneBy(
            [
                'codLote' => $object->getCodLote(),
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $object->getCodEntidade(),
                'tipo' => $object->getTipo()
            ]
        );

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
        $chequeEmissao->setFkTesourariaCheque($cheque);
        $chequeEmissao->setValor((float) $params['valorCheque']->getViewData());
        $chequeEmissao->setDescricao($params['observacao']->getViewData());

        $object->setFkTesourariaTransferencia($transferencia);
        $object->setFkTesourariaChequeEmissao($chequeEmissao);
        $chequeEmissao->addFkTesourariaChequeEmissaoTransferencias($object);

        try {
            $this->getDoctrine()->persist($chequeEmissao);
            $this->getDoctrine()->flush($chequeEmissao);
            $this->getFlashBag()->add('success', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmitidoSucesso', 0, [], 'messages'));
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.erroEmitirCheque', 0, ['numCheque' => $object->getNumCheque()], 'messages'));
        }

        return $this->redirectByRoute('urbem_financeiro_tesouraria_cheque_emissao_transferencia_edit', ['id' => $id]);
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
            $codLote = $params['fkTransferencia__codLote'];
            $exercicio = $params['fkTransferencia__exercicio'];
            $codEntidade = $params['fkTransferencia__codEntidade'];
            $tipo = $params['fkTransferencia__tipo'];
        } else {
            $id = $this->getAdminRequestId();
            list($codLote, $exercicio, $codEntidade, $tipo) = explode("~", $id);
        }

        $valor = $this
            ->getContainer()
            ->get('urbem.coreBundle.tesouraria.cheque')
            ->getValorChequeEmissaoTransferencia($codLote, $exercicio, $codEntidade, $tipo);

        if (empty($valor)) {
            $this->getFlashBag()->add('error', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoOrdemPagamento.validacoes.naoTemValorEmitirCheque', 0, [], 'messages'));
            return $this->redirectByRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_list');
        }

        $transferencia = $this->getDoctrine()->getRepository(Transferencia::class)->findOneBy(['codLote' => $codLote, 'exercicio' => $exercicio, 'codEntidade' => $codEntidade, 'tipo' => $tipo]);
        $planoBanco = $transferencia->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoBanco();

        $arrayBanco = new ArrayCollection();
        $arrayAgencia = clone $arrayBanco;
        $arrayContaCorrente = clone $arrayBanco;
        if (!empty($planoBanco)) {
            $contaCorrente = $planoBanco->getFkMonetarioContaCorrente();
            $banco = $contaCorrente->getFkMonetarioAgencia()->getFkMonetarioBanco();
            $agencia = $contaCorrente->getFkMonetarioAgencia();

            $arrayBanco->set('codBanco', $banco->getCodbanco());
            $arrayBanco->set('nomBanco', "{$banco->getNumBanco()} - {$banco->getNomBanco()}");
            $arrayAgencia->set('codAgencia', $agencia->getCodAgencia());
            $arrayAgencia->set('nomAgencia', "{$agencia->getNumAgencia()} - {$agencia->getNomAgencia()}");
            $arrayContaCorrente->set('codContaCorrente', $contaCorrente->getCodContaCorrente());
            $arrayContaCorrente->set('numContaCorrente', $contaCorrente->getNumContaCorrente());
        }

        $cheques = [];
        if (!empty($planoBanco)) {
            $repositoryCheque = $this->getDoctrine()->getRepository(Cheque::class);
            $cheques = ArrayHelper::parseArrayToChoice($repositoryCheque->findByCheques($arrayBanco->get('codBanco'), $arrayAgencia->get('codAgencia'), $arrayContaCorrente->get('codContaCorrente')), 'numCheque', 'numCheque');
        }

        $formMapper
            ->with('label.tesouraria.cheque.dadosChequeEmissaoTransferencia')
            ->add(
                'fkTransferencia.getValor',
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
            ->add('fkTransferencia.codLote', 'hidden', ['data' => $codLote, 'mapped' => false])
            ->add('fkTransferencia.exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
            ->add('fkTransferencia.codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('fkTransferencia.tipo', 'hidden', ['data' => $tipo, 'mapped' => false])
            ->add('fkTransferencia.codBanco', 'hidden', ['data' => $arrayBanco->get('codBanco'), 'mapped' => false])
            ->add('fkTransferencia.codAgencia', 'hidden', ['data' => $arrayAgencia->get('codAgencia'), 'mapped' => false])
            ->add('fkTransferencia.contaCorrente', 'hidden', ['data' =>  $arrayContaCorrente->get('codContaCorrente'), 'mapped' => false])
            ->add(
                'codBanco',
                'text',
                [
                    'required' => true,
                    'data' => $arrayBanco->get('nomBanco'),
                    'label' => 'label.tesouraria.cheque.banco',
                    'attr' => [
                        'readonly'=>'readonly'
                    ]
                ]
            )
            ->add(
                'codAgencia',
                'text',
                [
                    'required' => true,
                    'data' => $arrayAgencia->get('nomAgencia'),
                    'label' => 'label.tesouraria.cheque.agencia',
                    'attr' => [
                        'readonly'=>'readonly'
                    ]
                ]
            )
            ->add(
                'codContaCorrente',
                'text',
                [
                    'required' => true,
                    'data' => $arrayContaCorrente->get('numContaCorrente'),
                    'label' => 'label.tesouraria.cheque.cc',
                    'attr' => [
                        'readonly'=>'readonly'
                    ]
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
                    'mapped' => false,
                    'attr' => [
                        'class' => 'money '
                    ]
                ]
            )
            ->add('observacao', 'textarea', ['mapped' => false])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codLote')
            ->add('codEntidade')
            ->add('exercicio')
            ->add('tipo')
            ->add('codBanco')
            ->add('codAgencia')
            ->add('codContaCorrente')
            ->add('numCheque')
            ->add('timestampEmissao')
        ;
    }
}
