<?php

namespace Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class ControleItensAdmin
 * @package Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata\Requisicao
 */

class ControleItensAdmin extends AbstractAdmin
{
    const AUTORIZACAO_LIST = [
        Requisicao::STATUS_AUTORIZADA_TOTAL => 'Total',
        Requisicao::STATUS_AUTORIZADA_PARCIAL => 'Parcial',
    ];

    protected $baseRouteName = 'urbem_compras_governamentais_controle_itens';
    protected $baseRoutePattern = 'compras-governamentais/controle-itens';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'codRequisicao',
    ];
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Autorizar'];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $includeJs = ['/comprasgovernamentais/javascripts/controle-itens.js'];

    /**
     * @param $code
     * @param $class
     * @param $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Requisicao::class, $baseControllerName);

        $this->datagridValues['status'] = [
            'value' => Requisicao::STATUS_PENDENTE_AUTORIZACAO,
        ];
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->isCurrentRoute('autorizar_requisicao')) {
            return true;
        }

        if ($this->isCurrentRoute('autorizar_solicitacao_compra')) {
            return true;
        }
    }

    public function update($object)
    {
        $result = $this->getModelManager()->update($object);

        return $object;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->join(sprintf('%s.fkAlmoxarifadoRequisicaoHomologadas', $qb->getRootAlias()), 'rh');

        $qb->andWhere(sprintf('%s.status NOT IN (\'%s\')', $qb->getRootAlias(), Requisicao::STATUS_PENDENTE_HOMOLOGACAO));

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('autorizar_requisicao', sprintf('autorizar-requisicao/%s', $this->getRouterIdParameter()));
        $collection->add('autorizar_solicitacao_compra', sprintf('autorizar-solicitacao-compra/%s', $this->getRouterIdParameter()));
        $collection->add('recusar_requisicao', sprintf('recusar-requisicao/%s', $this->getRouterIdParameter()));

        $collection->clearExcept(
            [
                'list',
                'edit',
                'autorizar_requisicao',
                'autorizar_solicitacao_compra',
                'recusar_requisicao',
            ]
        );
    }

    /**
     * @param Requisicao $object
     * @return void
     */
    public function setCatalogoItem($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $catalogoItem = new CatalogoItem();

        $requisicaoItem = $object->getFkAlmoxarifadoRequisicaoItens()->last();
        if (!$requisicaoItem) {
            return new CatalogoItem();
        }

        $catalogoItem = $em->getRepository(CatalogoItem::class)->findOneByCodItem($requisicaoItem->getCodItem());
        if (!$catalogoItem) {
            return new CatalogoItem();
        }

        return $catalogoItem;
    }

    /**
     * @param RequisicaoItem $params
     * @return int
     */
    public function getSaldoEstoque(RequisicaoItem $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new RequisicaoItemModel($em))->getSaldoEstoqueByRequisicaoItem($object);
    }

    /**
     * @param Requisicao $object
     * @return void
     */
    public function autorizarRequisicao($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        (new RequisicaoModel($em))->autorizarRequisicao(
            $object,
            $form->get('tipoAutorizacao')->getData(),
            $form->get('qtdAprovada')->getData(),
            $form->get('recusarPendente')->getData()
        );

        $this->update($object);
    }

    /**
     * @param Requisicao $object
     * @return void
     */
    public function recusarRequisicao($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new RequisicaoModel($em))->recusarRequisicao($object);

        $this->update($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $statusList = array_slice(Requisicao::STATUS_LIST, 2);

        $datagridMapper
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add(
                'dtRequisicao',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->andWhere(sprintf('DATE(%s.dtRequisicao) = :dtRequisicao', $alias));
                        $qb->setParameter('dtRequisicao', $value['value']->format('Y-m-d'));

                        return true;
                    },
                    'label' => 'label.almoxarifado.requisicao.dtRequisicao',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'status',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->andWhere(sprintf('%s.status = :status', $alias));
                        $qb->setParameter('status', $value['value']);

                        return true;
                    },
                    'label' => 'label.almoxarifado.requisicao.status',
                ],
                'choice',
                [
                    'choices' => array_flip($statusList),
                    'placeholder' => 'Todos',
                ]
            )
            ->add(
                'prioridade',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->join(sprintf('%s.fkAlmoxarifadoRequisicaoItens', $alias), 'pri');
                        $qb->join(CatalogoItem::class, 'pci', 'WITH', 'pci.codItem = pri.codItem');

                        $qb->andWhere('pci.prioridade = :prioridade');
                        $qb->setParameter(':prioridade', $value['value']);

                        return true;
                    },
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.prioridade',
                ],
                'choice',
                [
                    'choices' => array_flip(CatalogoItem::PRIORIDADES_LIST),
                    'placeholder' => 'Todas',
                ]
            )
            ->add(
                'item',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->join(sprintf('%s.fkAlmoxarifadoRequisicaoItens', $alias), 'iri');

                        $qb->andWhere(
                            sprintf(
                                'iri.codItem IN (%s)',
                                implode(',', $value['value'])
                            )
                        );

                        return true;
                    },
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.item',
                ],
                'autocomplete',
                [
                    'route' => ['name' => 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico_api_item'],
                    'multiple' => true,
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            )
            ->add(
                'codTipo',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->join(sprintf('%s.fkAlmoxarifadoRequisicaoItens', $alias), 'ctri');
                        $qb->join(CatalogoItem::class, 'ctci', 'WITH', 'ctci.codItem = ctri.codItem');
                        $qb->join('ctci.fkAlmoxarifadoTipoItem', 'ctti');

                        $qb->andWhere('ctti.codTipo = :codTipo');
                        $qb->setParameter(':codTipo', $value['value']);

                        return true;
                    },
                    'label' => 'label.catalogoItem.codTipo',
                ],
                'entity',
                [
                    'class' => TipoItem::class,
                    'query_builder' => (new TipoItemModel($em))->getTiposItem(),
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ],
                ]
            )
            ->add(
                'requisitante',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere(
                            sprintf('%s.cgmRequisitante = :cgmRequisitante', $alias)
                        );

                        $qb->setParameter('cgmRequisitante', $value['value']);

                        return true;
                    },
                    'label' => 'label.comprasGovernamentaisControleItens.requisitante',
                ],
                'autocomplete',
                [
                    'class' => Usuario::class,
                    'route' => ['name' => 'urbem_compras_governamentais_requisicao_api_requisitante'],
                    'placeholder' => 'Selecione',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ],
                ],
                [
                    'admin' => 'core.admin.filter.sw_cgm',
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
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add(
                'prioridade',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__prioridade.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.prioridade',
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__descricao.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.descricao',
                ]
            )
            ->add(
                'tipo',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__tipo.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.tipoItem',
                ]
            )
            ->add(
                'qtdEstoque',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__qtd_estoque.html.twig',
                    'label' => 'label.comprasGovernamentaisControleItens.qtdEstoque',
                ]
            )
            ->add(
                'qtdRequerida',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__qtd_requerida.html.twig',
                    'label' => 'label.comprasGovernamentaisControleItens.qtdRequerida',
                ]
            )
            ->add(
                'requisitante',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\ControleItens\CRUD:list__requisitante.html.twig',
                    'label' => 'label.comprasGovernamentaisControleItens.requisitante',
                ]
            )
            ->add(
                'dtRequisicao',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\Requisicao\CRUD:list__dtRequisicao.html.twig',
                    'label' => 'label.almoxarifado.requisicao.dtRequisicao',
                ]
            )
            ->add(
                'status',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\Requisicao\CRUD:list__status.html.twig',
                    'label' => 'label.almoxarifado.requisicao.status',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'autorizar_requisicao' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/ControleItens/CRUD:list__action_autorizar_requisicao.html.twig'
                        ],
                        'autorizar_solicitacao_compra' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/ControleItens/CRUD:list__action_autorizar_solicitacao_compra.html.twig'
                        ],
                        'recusar_requisicao' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/ControleItens/CRUD:list__action_recusar.html.twig',
                        ],
                    ],
                ]
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $request = $this->getRequest();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisicao = $this->getSubject();
        $requisicaoItem = $requisicao->getFkAlmoxarifadoRequisicaoItens()->last();
        $catalogoItem = $em->getRepository(CatalogoItem::class)->findOneByCodItem($requisicaoItem->getCodItem());
        $qtdRequerida = $requisicaoItem->getQuantidadePendente();
        $saldoEstoque = $this->getSaldoEstoque($requisicaoItem);
        $qtdAprovada = min($qtdRequerida, $saldoEstoque);

        $fieldOptions = [];
        $fieldOptions['item'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => (string) $catalogoItem,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.comprasGovernamentaisRequisicao.item'
        ];

        $fieldOptions['saldoEstoque'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $saldoEstoque,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.comprasGovernamentaisControleItens.qtdEstoque'
        ];

        $fieldOptions['qtdRequerida'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => number_format($qtdRequerida, 4, ',', '.'),
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.comprasGovernamentaisControleItens.qtdRequerida'
        ];

        $fieldOptions['tipoAutorizacao'] = [
            'mapped' => false,
            'choices' => array_flip($this::AUTORIZACAO_LIST),
            'disabled' => $saldoEstoque < $qtdRequerida,
            'expanded' => true,
            'multiple' => false,
            'data' => $saldoEstoque >= $qtdRequerida ? Requisicao::STATUS_AUTORIZADA_TOTAL : Requisicao::STATUS_AUTORIZADA_PARCIAL,
            'attr' => [
                'class' => 'checkbox-sonata js-tipo-autorizacao ',
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'label' => 'label.comprasGovernamentaisControleItens.tipoAutorizacao',
        ];

        $fieldOptions['qtdAprovada'] = [
            'mapped' => false,
            'required' => false,
            'data' => $qtdAprovada,
            'attr' => [
                'class' => 'js-qtd-aprovada ',
                'min' => 1,
                'max' => $qtdAprovada,
            ],
            'label' => 'label.comprasGovernamentaisControleItens.qtdAprovada'
        ];

        $fieldOptions['recusarPendente'] = [
            'mapped' => false,
            'choices' => [
                'Recusar' => Requisicao::STATUS_RECUSADA,
                'Pendente' => Requisicao::STATUS_PENDENTE_AUTORIZACAO,
            ],
            'expanded' => true,
            'multiple' => false,
            'data' => Requisicao::STATUS_PENDENTE_AUTORIZACAO,
            'attr' => [
                'class' => 'checkbox-sonata ',
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'label' => 'label.comprasGovernamentaisControleItens.recusarPendente',
        ];

        $formMapper
            ->with('label.comprasGovernamentaisRequisicao.cabecalhoRequisicao')
                ->add('item', 'text', $fieldOptions['item'])
                ->add('saldoEstoque', 'text', $fieldOptions['saldoEstoque'])
                ->add('qtdRequerida', 'text', $fieldOptions['qtdRequerida'])
                ->add('tipoAutorizacao', 'choice', $fieldOptions['tipoAutorizacao'])
                ->add('qtdAprovada', 'integer', $fieldOptions['qtdAprovada'])
                ->add('recusarPendente', 'choice', $fieldOptions['recusarPendente'])
            ->end()
            ->getFormBuilder()->setAction('autorizar_requisicao');
    }
}
