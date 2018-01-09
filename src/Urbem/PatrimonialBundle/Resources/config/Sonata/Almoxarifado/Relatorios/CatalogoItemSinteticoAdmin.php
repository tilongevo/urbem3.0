<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios;

use DateInterval;
use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios\CatalogoItemAdmin;

/**
 * Class CatalogoItemSinteticoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios
 */
class CatalogoItemSinteticoAdmin extends CatalogoItemAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/relatorios/catalogo-item/sintetico';
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado//relatorios/catalogo-item-sintetico.js',
    ];
    protected $datagridValues = [
        'categoria' => [
            'value' => self::CATEGORIA_TODOS,
        ],
        'prioridade' => null,
        'fkAlmoxarifadoTipoItem' => null,
        'periodo' => null,
        'periodoInicial' => null,
        'periodoFinal' => null,
        'item' => null,
    ];

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $qb->where(sprintf('%s.codItem IS NULL', $qb->getRootAlias()));
        }

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('api_item', 'api/item');

        $collection->clearExcept(['list', 'export', 'api_item']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $fieldOptions = [];
        $fieldOptions['categoria'] = [
            'choices' => array_flip($this::CATEGORIAS),
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['prioridade'] = [
            'choices' => array_flip(CatalogoItemAdmin::PRIORIDADES),
            'placeholder' => 'Todas',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['tipoItem'] = [
            'class' => TipoItem::class,
            'query_builder' => $this->getTiposItem(),
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['periodo'] = [
            'choices' => array_flip($this::PERIODOS),
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['periodoInicial'] = [
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
        ];

        $fieldOptions['item'] = [
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico_api_item'],
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $datagridMapper
            ->add(
                'categoria',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterCategoria'],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.categoria',
                ],
                'choice',
                $fieldOptions['categoria']
            )
            ->add(
                'prioridade',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterPrioridade'],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.prioridade',
                ],
                'choice',
                $fieldOptions['prioridade']
            )
            ->add(
                'fkAlmoxarifadoTipoItem',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterTipoItem'],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.tipoItem',
                ],
                'entity',
                $fieldOptions['tipoItem']
            )
            ->add(
                'periodo',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterPeriodo'],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodo',
                ],
                'choice',
                $fieldOptions['periodo']
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                [
                    'callback' => function () {
                    },
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodoInicial',
                ],
                'datepkpicker',
                $fieldOptions['periodoInicial']
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                [
                    'callback' => function () {
                    },
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodoFinal',
                ],
                'datepkpicker',
                $fieldOptions['periodoInicial']
            )
            ->add(
                'item',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterItem'],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.item',
                ],
                'autocomplete',
                $fieldOptions['item']
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $this->prioridades = CatalogoItemAdmin::PRIORIDADES;

        $listMapper
            ->add(
                'prioridade',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__prioridade.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.prioridade',
                ]
            )
            ->add(
                'descricao',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__descricao.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.descricao',
                ]
            )
            ->add(
                'fkAdministracaoUnidadeMedida.nomUnidade',
                'text',
                [
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.unidadeMedida'
                ]
            )
            ->add(
                'fkAlmoxarifadoTipoItem.descricao',
                'text',
                [
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.tipoItem'
                ]
            )
            ->add(
                'jaIngressado',
                'text',
                [
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__ja_ingressado.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.ingressado'
                ]
            )
            ->add(
                'fkAlmoxarifadoControleEstoque.estoqueMinimo',
                'text',
                [
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.estoqueMinimo'
                ]
            )
            ->add(
                'fkAlmoxarifadoControleEstoque.pontoPedido',
                'text',
                [
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.pontoPedido',
                ]
            )
            ->add(
                'fkAlmoxarifadoControleEstoque.estoqueMaximo',
                'text',
                [
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.estoqueMaximo'
                ]
            )
            ->add(
                'qtdSaida',
                'text',
                [
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__qtd_saida.html.twig',
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.qtdSaida'
                ]
            );
    }
}
