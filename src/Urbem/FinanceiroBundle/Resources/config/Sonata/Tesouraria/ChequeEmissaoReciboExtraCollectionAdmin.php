<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Helper\ArrayHelper;

class ChequeEmissaoReciboExtraCollectionAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_cheque';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-despesa-extra/cheque';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Emitir cheque'];
    protected $includeJs = [
        '/financeiro/javascripts/tesouraria/cheque/configChequeEmissaoReciboExtra.js',
        '/financeiro/javascripts/tesouraria/cheque/defaultCheque.js',
        '/financeiro/javascripts/tesouraria/cheque/chequeEmissao.js'
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if (empty($this->getAdminRequestId())) {
            $id = $this->getRequest()->query->get('defaultObjectId');
        } else {
            $id = $this->getAdminRequestId();
        }

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (empty($this->getAdminRequestId())) {
            $uniqid =  $this->getRequest()->query->get('uniqid');
            $params = $this->getRequest()->request->get($uniqid);
            $codReciboExtra = $params['codReciboExtra'];
            $exercicio = $params['exercicio'];
            $codEntidade = $params['codEntidade'];
            $tipoRecibo = $params['tipoRecibo'];
        } else {
            $id = $this->getAdminRequestId();
            list($codReciboExtra, $exercicio, $codEntidade, $tipoRecibo) = explode("~", $id);
        }

        $repositoryReciboExtra = $this->getDoctrine()->getRepository(ReciboExtra::class);
        $reciboExtra = $repositoryReciboExtra->findOneBy(['codReciboExtra' => $codReciboExtra, 'exercicio' => $exercicio, 'codEntidade' => $codEntidade, 'tipoRecibo' => $tipoRecibo]);

        $repository = $this->getDoctrine()->getRepository(Cheque::class);
        $bancos = ArrayHelper::parseArrayToChoice($repository->findBancosPorExercicio($this->getExercicio()), 'nom_banco', 'cod_banco');
        $agencias = ArrayHelper::parseArrayToChoice($repository->findAllAgencias(), 'nom_agencia', 'cod_agencia');
        $contasCorrente = ArrayHelper::parseArrayToChoice($repository->findAllContasCorrente(), 'num_conta_corrente', 'cod_conta_corrente');
        $cheques = ArrayHelper::parseArrayToChoice($repository->findAllCheques(), 'numCheque', 'numCheque');
        $formMapper
            ->with('label.tesouraria.cheque.chequeEmissaoPorDespesaExtra')
                ->add('codReciboExtra', 'hidden', ['data' => $reciboExtra->getCodReciboExtra()])
                ->add('exercicio', 'hidden', ['data' => $reciboExtra->getExercicio()])
                ->add('tipoRecibo', 'hidden', ['data' => $reciboExtra->getTipoRecibo()])
                ->add('codEntidade', 'hidden', ['data' => $reciboExtra->getCodEntidade()])
                ->add(
                    'codBanco',
                    'choice',
                    [
                        'required' => true,
                        'choices' => $bancos,
                        'label' => 'label.tesouraria.cheque.bancos',
                        'placeholder' => 'label.selecione',
                        'choice_value' => function ($value) {
                            return $value;
                        },
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
                        'choices' => $agencias,
                        'label' => 'label.tesouraria.cheque.agencia',
                        'placeholder' => 'label.selecione',
                        'choice_value' => function ($value) {
                            return $value;
                        },
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
                        'choices' => $contasCorrente,
                        'label' => 'label.tesouraria.cheque.cc',
                        'placeholder' => 'label.selecione',
                        'choice_value' => function ($value) {
                            return $value;
                        },
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'numCheque',
                    'choice',
                    [
                        'required' => true,
                        'choices' => $cheques,
                        'label' => 'label.tesouraria.cheque.numeroCheque',
                        'placeholder' => 'label.selecione',
                        'choice_value' => function ($value) {
                            return $value;
                        },
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
                        'data' => $reciboExtra->getValor(),
                        'attr' => [
                            'class' => 'money ',
                            'readonly'=>'readonly'
                        ]
                    ]
                )
                ->add('observacao', 'textarea', ['mapped' => false])
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if (empty($object->getNumCheque())) {
            $this->validateEmissao(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmissaoReciboExtra.validacoes.naoTemValorEmitirCheque', 0, [], 'messages')
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
        $contaCorrente = $repositoryContaCorrente->findOneBy(
            [
                'codBanco' => $object->getCodBanco(),
                'codAgencia' => $object->getCodAgencia(),
                'codContaCorrente' => $object->getCodContaCorrente()
            ]
        );

        $emitido = $repositoryCheque->dadosCheque(
            $contaCorrente->getFkMonetarioAgencia()->getfkMonetarioBanco()->getNumBanco(),
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
        $repositoryCheque = $this->getDoctrine()->getRepository(Cheque::class);
        $cheque = $repositoryCheque->findOneBy(
            [
                'codBanco' => $object->getCodBanco(),
                'codAgencia' => $object->getCodAgencia(),
                'codContaCorrente' => $object->getCodContaCorrente(),
                'numCheque' => $object->getNumCheque()
            ]
        );

        $repositoryReciboExtra = $this->getDoctrine()->getRepository(ReciboExtra::class);
        $reciboExtra = $repositoryReciboExtra->findOneBy(
            [
                'codReciboExtra' => $object->getCodReciboExtra(),
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $object->getCodEntidade(),
                'tipoRecibo' => $object->getTipoRecibo()
            ]
        );

        $chequeEmissao = new ChequeEmissao();
        $chequeEmissao->setFkTesourariaCheque($cheque);
        $chequeEmissao->addFkTesourariaChequeEmissaoReciboExtras($object);
        $chequeEmissao->setValor((float) $reciboExtra->getValor());
        $chequeEmissao->setDescricao($params['observacao']->getViewData());
        $object->setFkTesourariaReciboExtra($reciboExtra);
        $object->setFkTesourariaChequeEmissao($chequeEmissao);
        $reciboExtra->addFkTesourariaChequeEmissaoReciboExtras($object);

        try {
            $this->getDoctrine()->persist($reciboExtra);
            $this->getDoctrine()->flush();
            $this->getFlashBag()->add('success', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.chequeEmitidoSucesso', 0, [], 'messages'));
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $this->getContainer()->get('translator')->transChoice('label.tesouraria.cheque.erroEmitirCheque', 0, ['numCheque' => $object->getNumCheque()], 'messages'));
        }

        return $this->redirectByRoute('urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_edit', ['id' => "{$reciboExtra->getCodReciboExtra()}~{$reciboExtra->getExercicio()}~{$reciboExtra->getCodEntidade()}~{$reciboExtra->getTipoRecibo()}"]);
    }
}
