<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ChequeEmissaoReciboExtraAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_financeiro_tesouraria_cheque_emissao_recibo_extra';
    protected $baseRoutePattern = 'financeiro/tesouraria/cheque/emissao-despesa-extra';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoSalvar = false;
    const TIPORECIBO = 'D';

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

        $tipoRecibo = SELF::TIPORECIBO;
        $reciboExtra = $this->getAllReciboExtra($entidade, $tipoRecibo);

        $ids = new ArrayCollection();
        foreach ($reciboExtra as $codReciboExtra) {
            $ids->add($codReciboExtra['cod_recibo_extra']);
        }

        $query->andWhere(
            $query->expr()->in(current($query->getRootAliases()) . '.codReciboExtra', ':codReciboExtra'),
            $query->expr()->in(current($query->getRootAliases()) . '.exercicio', ':exercicio'),
            $query->expr()->in(current($query->getRootAliases()) . '.codEntidade', ':codEntidade'),
            $query->expr()->in(current($query->getRootAliases()) . '.tipoRecibo', ':tipoRecibo')
        );

        if (!$ids->isEmpty()) {
            $query->setParameter('codReciboExtra', $ids->toArray());
            $query->setParameter('exercicio', $this->getExercicio());
            $query->setParameter('codEntidade', $entidade);
            $query->setParameter('tipoRecibo', $tipoRecibo);
        } else {
            $query->setParameter('codReciboExtra', null);
            $query->setParameter('exercicio', $this->getExercicio());
            $query->setParameter('codEntidade', $entidade);
            $query->setParameter('tipoRecibo', $tipoRecibo);
        }

        return $query;
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

    protected function getAllReciboExtra($entidade, $tipoRecibo)
    {
        $repository = $this->getDoctrine()->getRepository(ChequeEmissaoReciboExtra::class);
        return $repository->findAllReciboExtraPorExercicioEntidadeTipo($entidade, $this->getExercicio(), $tipoRecibo);
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
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('getCodEntidadeComposto', null, ['label' => 'label.ordemPagamento.codEntidade'])
            ->add('getCodReciboExtraComposto', null, ['label' => 'label.reciboExtra.tipoRecibo'])
            ->add('fkTesourariaReciboExtraCredor', null, ['label' => 'label.reciboExtra.credor'])
            ->add('valor', 'currency', ['label' => 'label.reciboExtra.valor', 'currency' => 'BRL'])
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

        $form = [
            'label' => 'label.tesouraria.cheque.dataEmissao',
            'mapped' => false,
            'data' => $object->getTimestamp()->format('d/m/Y'),
            'attr' => ['readonly'=>'readonly']
        ];

        //Se o valor da ordem de pagamento for igual a zero, ele não exibe a opção para emitir cheques
        if ($object->getFkTesourariaChequeEmissaoReciboExtras()->isEmpty()) {
            $form['help'] = '<a href="/financeiro/tesouraria/cheque/emissao-despesa-extra/cheque/create?id='.$id.'" class="white-text blue darken-4 btn btn-success save gerar-verficador"><i class="material-icons left">input</i>Emitir cheque</a>';
        }

        $formMapper
            ->with('Dados da Emissão por Despesa Extra')
            ->add('exercicio', 'text', ['label' => 'exercicio', 'mapped' => false, 'data' => $object->getExercicio(), 'attr' => ['readonly'=>'readonly']])
            ->add('getCodEntidadeComposto', 'text', ['label' => 'label.ordemPagamento.codEntidade', 'mapped' => false, 'data' => $object->getCodEntidadeComposto(), 'attr' => ['readonly'=>'readonly']])
            ->add('fkTesourariaReciboExtraCredores', 'text', ['label' => 'label.ordemPagamento.credor', 'mapped' => false, 'data' => $object->getFkTesourariaReciboExtraCredor(),'attr' => ['readonly'=>'readonly']])
            ->add('valor', 'money', ['label' => 'label.ordemPagamento.valor', 'mapped' => false, 'data' => $object->getValor(),'currency' => 'BRL', 'attr' => ['readonly'=>'readonly']])
            ->add(
                'timestamp',
                'text',
                $form
            )
            ->end()
        ;
    }
}
