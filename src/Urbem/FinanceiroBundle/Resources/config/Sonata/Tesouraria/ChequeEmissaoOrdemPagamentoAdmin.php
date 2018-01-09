<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ChequeEmissaoOrdemPagamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-ordem-pagamento';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;
    protected $exibirBotaoIncluir = false;

    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();
        $requestCodEntidade = $request->query->get('filter')['codEntidade']['value'];

        $entidades = [];
        if (!empty($requestCodEntidade)) {
            $entidades[] = $requestCodEntidade;
        } else {
            $entidades = $this->entidades();
        }
        $entidade = current($entidades);

        $request = [
            'filter' => [
                'codEntidade' => [
                    'value' => $entidade
                ]
            ]
        ];

        $this->getRequest()->query->add($request);
        $query = parent::createQuery($context);
        $ordensPagamento = null;
        if (!empty($entidade)) {
            $ordensPagamento = $this->getAllOrdemPagamento($entidade);
        }

        $ids = new ArrayCollection();
        if (!empty($ordensPagamento)) {
            foreach ($ordensPagamento as $codOrdem) {
                $ids->add($codOrdem['cod_ordem']);
            }
        }

        $query->andWhere(
            $query->expr()->in($query->getRootAliases()[0] . '.codOrdem', ':codOrdem')
        );
        if (!$ids->isEmpty()) {
            $query->setParameter('codOrdem', $ids->toArray());
        } else {
            $query->setParameter('codOrdem', null);
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entidades = $this->entidades();

        $datagridMapper
            ->add(
                'codEntidade',
                null,
                [
                    'label' => 'label.listaEntidades',
                ],
                'choice',
                [
                    'choices' => $entidades
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('getCodEntidadeComposto', null, ['label' => 'label.ordemPagamento.codEntidade'])
            ->add('getCodOrdemComposto', null, ['label' => 'label.ordemPagamento.nrop'])
            ->add('getCredor', null, ['label' => 'label.ordemPagamento.credor'])

            ->add(
                'getValor',
                'currency',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:valor_descontado.html.twig',
                    'label' => 'label.tesouraria.cheque.valor',
                    'currency' => 'BRL'
                ]
            )
            ->add('getValorAnulado', 'currency', ['label' => 'label.ordemPagamento.valorAnulado', 'currency' => 'BRL'])
            ->add('getStatus', null, ['label' => 'label.ordemPagamento.status'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'emitir' => ['template' => 'FinanceiroBundle:Tesouraria/Cheque:list__action_edit.html.twig'],
                )
            ))
        ;
    }


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
        $object = $this->getObject($id);

        $valor = $this
            ->getContainer()
            ->get('urbem.coreBundle.tesouraria.cheque')
            ->getValorChequeEmissao($object->getCodOrdem(), $object->getExercicio(), $object->getCodEntidade());

        $form = [
            'label' => 'label.tesouraria.cheque.dataEmissao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'data' => $object->getDtEmissao(),
            'dp_default_date' => date('d/m/Y'),
            'attr' => ['readonly'=>'readonly']
        ];

        //Se o valor da ordem de pagamento for igual a zero, ele não exibe a opção para emitir cheques
        if (!empty($valor)) {
            $form['help'] = '<a href="/financeiro/tesouraria/cheque/emissao-ordem-pagamento/cheque/create?id='.$id.'" class="white-text blue darken-4 btn btn-success save gerar-verficador"><i class="material-icons left">input</i>Emitir cheque</a>';
        }

        $formMapper
            ->with('Dados da Emissão por Ordem de Pagamento')
                ->add('codOrdem', 'hidden')
                ->add('exercicio', 'hidden')
                ->add('codEntidade', 'hidden')
                ->add('getCodEntidadeComposto', 'text', ['label' => 'label.ordemPagamento.codEntidade', 'mapped' => false, 'data' => $object->getCodEntidadeComposto(), 'attr' => ['readonly'=>'readonly']])
                ->add('getCodOrdemComposto', 'text', ['label' => 'label.ordemPagamento.nrop', 'mapped' => false, 'data' => $object->getCodOrdemComposto(),'attr' => ['readonly'=>'readonly']])
                ->add('getCredor', 'text', ['label' => 'label.ordemPagamento.credor', 'mapped' => false, 'data' => $object->getCredor(),'attr' => ['readonly'=>'readonly']])
                ->add('getValor', 'money', ['label' => 'label.ordemPagamento.valor', 'mapped' => false, 'data' => $valor,'currency' => 'BRL', 'attr' => ['readonly'=>'readonly']])
                ->add('getValorAnulado', 'money', ['label' => 'label.ordemPagamento.valorAnulado', 'mapped' => false, 'data' => $object->getValorAnulado(),'currency' => 'BRL', 'attr' => ['readonly'=>'readonly']])
                ->add('getStatus', 'text', ['label' => 'label.ordemPagamento.status', 'mapped' => false, 'data' => $object->getStatus(),'attr' => ['readonly'=>'readonly']])
                ->add(
                    'dtEmissao',
                    'sonata_type_date_picker',
                    $form
                )
            ->end()
        ;

        if (!$object->getFkTesourariaChequeEmissaoOrdemPagamentos()->isEmpty()) {
            $currentEmissao = $object->getFkTesourariaChequeEmissaoOrdemPagamentos()->current();
            $repositoryContaCorrente = $this->getDoctrine()->getRepository(ContaCorrente::class);
            $dadosBusca =  ['codBanco' => $currentEmissao->getCodBanco(), 'codAgencia' => $currentEmissao->getCodAgencia(), 'codContaCorrente' => $currentEmissao->getFkTesourariaChequeEmissao()->getFkTesourariaCheque()->getFkMonetarioContaCorrente()->getCodContaCorrente()];
            $contaCorrente = $repositoryContaCorrente->findOneBy($dadosBusca);

            $repositoryCheque = $this->getDoctrine()->getRepository(Cheque::class);
            //Remove do objeto se o status for Anulado
            foreach ($object->getFkTesourariaChequeEmissaoOrdemPagamentos() as $key => $chequeEmissao) :
                $statusCheque =  $repositoryCheque->statusCheque(
                    $contaCorrente->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNumBanco(),
                    $contaCorrente->getFkMonetarioAgencia()->getNumAgencia(),
                    $contaCorrente->getNumContaCorrente(),
                    $chequeEmissao->getNumCheque()
                )
                ;
                if ($statusCheque['emitido'] == "Anulado") {
                    $object->getFkTesourariaChequeEmissaoOrdemPagamentos()->remove($key);
                }
            endforeach;

            $formMapper
                ->with('label.tesouraria.cheque.ChequeEmititdosParaOrdemPagamento')
                ->add(
                    'dadosEmissao',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:cheques_emitidos.html.twig',
                        'data' => [
                            'chequeEmissao' => $object->getFkTesourariaChequeEmissaoOrdemPagamentos(),
                            'contaCorrente' => $contaCorrente
                        ]
                    ]
                )
                ->end()
            ;
        }
    }

    /**
     * @return array
     */
    protected function entidades()
    {
        $repository = $this->getDoctrine()->getRepository(ChequeEmissao::class);
        $entidades = ArrayHelper::parseArrayToChoice($repository->findAllEntidadesPorExercicioUsuario($this->getExercicio(), $this->getCurrentUser()->getId()), 'nom_cgm', 'cod_entidade');
        return $entidades;
    }

    /**
     * @param $entidade
     * @return ArrayCollection
     */
    protected function getAllOrdemPagamento($entidade)
    {
        $filtro1 = ' AND EE.exercicio  = CAST(\'' . $this->getExercicio() . '\' as varchar)  AND EE.cod_entidade in (\'' . $entidade . '\') ';
        $filtro2 = ' AND EPL.exercicio_empenho = CAST(\'' . $this->getExercicio() . '\' as varchar)  AND EPL.cod_entidade IN(\'' . $entidade . '\') ';
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Tesouraria\ChequeEmissaoOrdemPagamento');
        return $repository->findAllOrdemPagamentoPorExercicioEntidade($filtro1, $filtro2);
    }
}
