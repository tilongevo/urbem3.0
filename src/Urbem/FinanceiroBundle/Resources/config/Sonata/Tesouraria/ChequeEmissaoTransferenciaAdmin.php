<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ChequeEmissaoTransferenciaAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_transferencia';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-transferencia';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;
    protected $exibirBotaoVoltar = false;
    protected $exibirBotaoIncluir = false;

    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();

        $entidades = [];
        if (!empty($request->query->get('filter')['codEntidade']['value'])) {
            $entidades[] = $request->query->get('filter')['codEntidade']['value'];
        } else {
            $entidades = $this->entidades();
        }

        $entidade = (!empty($entidades) ? current($entidades) : null);
        $request = [
            'filter' => [
                'codEntidade' => [
                    'value' => $entidade
                ]
            ]
        ];

        $this->getRequest()->query->add($request);

        $ids = new ArrayCollection();
        if (!empty($entidade)) {
            $transferencias = $this->getAllTransferencias($entidade);
            foreach ($transferencias as $transferencia) {
                $ids->add($transferencia['cod_lote']);
            }
        }

        $query = parent::createQuery($context);

        $query->andWhere(
            $query->expr()->in(current($query->getRootAliases()) . '.codLote', ':codLote'),
            $query->expr()->in(current($query->getRootAliases()) . '.exercicio', ':exercicio'),
            $query->expr()->in(current($query->getRootAliases()). '.codEntidade', ':codEntidade')
        );

        if (!$ids->isEmpty()) {
            $query->setParameter('codLote', $ids->toArray());
            $query->setParameter('exercicio', $this->getExercicio());
            $query->setParameter('codEntidade', $entidade);
        } else {
            $query->setParameter('codLote', null);
            $query->setParameter('exercicio', $this->getExercicio());
            $query->setParameter('codEntidade', $entidade);
        }

        return $query;
    }

    protected function getAllTransferencias($entidade)
    {
        $repository = $this->getDoctrine()->getRepository(ChequeEmissaoTransferencia::class);
        return $repository->findAllTransferenciasPorEntidade($entidade);
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
            )
        ;
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
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('getCodPlanoContaCredito', null, ['label' => 'label.transferencia.contaCredito'])
            ->add('getCodPlanoContaDebito', null, ['label' => 'label.transferencia.contaDebito'])
            ->add(
                'valor',
                'currency',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Cheque:valor_descontado.html.twig',
                    'label' => 'label.tesouraria.cheque.valor',
                    'currency' => 'BRL'
                ]
            )
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
            ->getValorChequeEmissaoTransferencia($object->getCodLote(), $object->getExercicio(), $object->getCodEntidade(), $object->getTipo());

        $form = [
            'label' => 'label.tesouraria.cheque.dataEmissao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'data' => $object->getTimestampTransferencia(),
            'attr' => ['readonly'=>'readonly']
        ];

        //Se o valor da ordem de pagamento for igual a zero, ele não exibe a opção para emitir cheques
        if (!empty($valor)) {
            $form['help'] = '<a href="/financeiro/tesouraria/cheque/emissao-transferencia/cheque/create?id='.$id.'" class="white-text blue darken-4 btn btn-success save gerar-verficador"><i class="material-icons left">input</i>Emitir cheque</a>';
        }

        $credor = null;
        if ($object->getFkTesourariaTransferenciaCredor()) {
            $credor = $object->getFkTesourariaTransferenciaCredor()->getFkSwCgm()->getNomCgm();
        }

        $entidade = null;
        if (!empty($object->getCodEntidade())) {
            $repositoryEntidade = $this->getDoctrine()->getRepository(Entidade::class);
            $entidade = $repositoryEntidade->findOneBy(['codEntidade' => $object->getCodEntidade(), 'exercicio' => $object->getExercicio()]);
            $entidade = $object->getCodEntidade() . ' -  ' . $entidade->getFkSwCgm()->getNomCgm();
        }

        $formMapper
            ->with('Dados da Emissão por Transferência')
            ->add('codLote', 'hidden')
            ->add('exercicio', 'hidden')
            ->add('codEntidade', 'hidden')
            ->add('tipo', 'hidden')
            ->add('codEntidade', 'text', ['label' => 'entidade', 'mapped' => false, 'data' => $entidade, 'attr' => ['readonly'=>'readonly']])
            ->add('getCodPlanoContaCredito', 'text', ['label' => 'label.transferencia.contaCredito', 'mapped' => false, 'data' => $object->getCodPlanoContaCredito(), 'attr' => ['readonly'=>'readonly']])
            ->add('getCodPlanoContaDebito', 'text', ['label' => 'label.transferencia.contaDebito', 'mapped' => false, 'data' => $object->getCodPlanoContaCredito(), 'attr' => ['readonly'=>'readonly']])
            ->add('fkTesourariaTransferenciaCredor', 'text', ['label' => 'label.transferencia.credor', 'mapped' => false, 'data' => $credor,'attr' => ['readonly'=>'readonly']])
            ->add('valor', 'money', ['label' => 'label.ordemPagamento.valor', 'mapped' => false, 'data' => $valor,'currency' => 'BRL', 'attr' => ['readonly'=>'readonly']])
            ->add(
                'timestampTransferencia',
                'sonata_type_date_picker',
                $form
            )
            ->end()
        ;
        if (!$object->getFkTesourariaChequeEmissaoTransferencias()->isEmpty()) {
            $currentEmissao = $object->getFkTesourariaChequeEmissaoTransferencias()->current();
            $repositoryContaCorrente = $this->getDoctrine()->getRepository(ContaCorrente::class);
            $dadosBusca =  ['codBanco' => $currentEmissao->getCodBanco(), 'codAgencia' => $currentEmissao->getCodAgencia(), 'codContaCorrente' => $currentEmissao->getCodContaCorrente()];
            $contaCorrente = $repositoryContaCorrente->findOneBy($dadosBusca);

            $formMapper
                ->with('Cheques emitidos para essa transferência')
                ->add(
                    'dadosEmissao',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'FinanceiroBundle:Tesouraria/Cheque:cheques_emitidos.html.twig',
                        'data' => [
                            'chequeEmissao' => $object->getFkTesourariaChequeEmissaoTransferencias(),
                            'contaCorrente' => $contaCorrente
                        ]
                    ]
                )
                ->end()
            ;
        }
    }
}
