<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoAnulacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItensAnulacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class RequisicaoAnulacaoAdmin
 */
class RequisicaoAnulacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_requisicao_anulacao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/requisicao';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clear();
        $collection->add('edit', '{id}/anular');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var Requisicao $requisicao */
        $requisicao = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['dadosRequisicao'] = [
            'data' => [
                'requisicao' => $requisicao
            ],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Requisicao/Anulacao/CRUD:field__dadosRequisicao.html.twig'
        ];

        $fieldOptions['motivo'] = [
            'attr' => [
                'maxlength' => 500
            ],
            'mapped' => false
        ];

        $fieldOptions['fkAlmoxarifadoRequisicaoItens'] = [
            'btn_add' => false,
            'label' => 'label.almoxarifado.requisicao.itens',
            'type_options' => [
                'delete' => false,
                'delete_options' => [
                    'type' => 'hidden',
                    'type_options' => [
                        'mapped' => false,
                        'required' => false,
                    ]
                ]
            ]
        ];

        $fieldDescription = [];
        $fieldDescription['fkAlmoxarifadoRequisicaoItens'] = [
            'admin_code' => 'patrimonial.admin.requisicao_anulacao_item',
            'edit' => 'inline',
            'sortable' => 'codItem'
        ];

        $formMapper
            ->with('label.almoxarifado.requisicao.requisicao')
                ->add('dadosRequisicao', 'customField', $fieldOptions['dadosRequisicao'])
                ->add('motivo', 'textarea', $fieldOptions['motivo'])
            ->end()
            ->with('label.almoxarifado.requisicao.itens')
                ->add(
                    'fkAlmoxarifadoRequisicaoItens',
                    'sonata_type_collection',
                    $fieldOptions['fkAlmoxarifadoRequisicaoItens'],
                    $fieldDescription['fkAlmoxarifadoRequisicaoItens']
                )
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $requisicao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        /** @var Form $fkAlmoxarifadoRequisicaoItensForm */
        foreach ($form->get('fkAlmoxarifadoRequisicaoItens') as $fkAlmoxarifadoRequisicaoItensForm) {
            $quantidadeAnular = $fkAlmoxarifadoRequisicaoItensForm->get('quantidadeAnular')->getData();

            /** @var RequisicaoItem $requisicaoItem */
            $requisicaoItem = $fkAlmoxarifadoRequisicaoItensForm->getData();

            $saldos = (new RequisicaoItemModel($entityManager))
                ->getSaldoEstoqueRequisitadoAtendido($requisicaoItem);

            if (abs($saldos['saldo_estoque']) < abs($quantidadeAnular)) {
                /** @var CatalogoItem $catalogoItem */
                $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());

                $message = $this->trans('requisicao_item.errors.quantidadeMaiorQueOSaldo', [
                    '%quantidade_anular%' => $quantidadeAnular,
                    '%saldo_estoque%' => $saldos['saldo_estoque'],
                    '%catalogo_item%' => (string) $catalogoItem
                ], 'validators');

                $errorElement->with('fkAlmoxarifadoRequisicaoItens')->addViolation($message)->end();
            }

            if (0 == abs($quantidadeAnular)) {
                /** @var CatalogoItem $catalogoItem */
                $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());

                $message = $this->trans('requisicao_item.errors.quantidadeIgualAZero', [
                    '%catalogo_item%' => (string) $catalogoItem
                ], 'validators');

                $errorElement->with('fkAlmoxarifadoRequisicaoItens')->addViolation($message)->end();
            }
        }
    }


    /**
     * @param Requisicao $requisicao
     * @return Response
     */
    public function postUpdate($requisicao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $motivo = $form->get('motivo')->getData();

        $requisicaoAnulacao = (new RequisicaoAnulacaoModel($entityManager))
            ->anularRequisicao($requisicao, $motivo);

        /** @var Form $fkAlmoxarifadoRequisicaoItensForm */
        foreach ($form->get('fkAlmoxarifadoRequisicaoItens') as $fkAlmoxarifadoRequisicaoItensForm) {
            $quantidadeAnular = $fkAlmoxarifadoRequisicaoItensForm->get('quantidadeAnular')->getData();

            /** @var RequisicaoItem $requisicaoItem */
            $requisicaoItem = $fkAlmoxarifadoRequisicaoItensForm->getData();
            (new RequisicaoItensAnulacaoModel($entityManager))
                ->anularItensRequisicao($requisicaoAnulacao, $requisicaoItem, $quantidadeAnular);
        }

        $routeName = 'urbem_patrimonial_almoxarifado_requisicao_show';
        return $this->redirectByRoute($routeName, [
            'id' => $this->id($requisicao)
        ]);
    }
}
