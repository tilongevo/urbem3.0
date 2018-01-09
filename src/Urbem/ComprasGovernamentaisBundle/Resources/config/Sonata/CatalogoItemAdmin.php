<?php

namespace Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CatalogoItemAdmin
 * @package Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata
 */

class CatalogoItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_compras_governamentais_catalogo_item';
    protected $baseRoutePattern = 'compras-governamentais/catalogo-item';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'codItem',
    ];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoSalvar = false;

    /**
     * @param $code
     * @param $class
     * @param $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, CatalogoItem::class, $baseControllerName);
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['codCatalogo'] = [
            'class' => Catalogo::class ,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('catalogo');

                $qb->join(CatalogoItem::class, 'catalogoItem', 'WITH', 'catalogo.codCatalogo = catalogoItem.codCatalogo')
                   ->where('catalogo.permiteManutencao = true');

                return $qb;
            },
            'choice_label' => 'descricao',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['codClassificacao'] = [
            'class' => CatalogoClassificacao::class ,
            'route' => [
                'name' => 'urbem_patrimonial_almoxarifado_catalogo_classificacao_search',
            ],
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $tipoItemModel = new TipoItemModel($em);
        $fieldOptions['codTipo'] = [
            'class' => TipoItem::class ,
            'query_builder' => $tipoItemModel->getTiposItem(),
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.codTipo',
        ];

        $datagridMapper
            ->add(
                'codCatalogo',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere(
                            sprintf('%s.codCatalogo = :catalogo', $qb->getRootAlias())
                        );

                        $qb->setParameter('catalogo', $value['value']);

                        return true;
                    },
                    'label' => 'label.catalogoItem.codCatalogo',
                ],
                'entity',
                $fieldOptions['codCatalogo']
            )
            ->add(
                'descricao',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere(
                            sprintf(
                                '(LOWER(%1$s.descricao) LIKE :descricao OR LOWER(%1$s.descricaoResumida) LIKE :descricao)',
                                $qb->getRootAlias()
                            )
                        );

                        $qb->setParameter('descricao', sprintf('%%%s%%', strtolower($value['value'])));

                        return true;
                    },
                    'label' => 'label.catalogoItem.descricao',
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

                        $qb->andWhere(
                            sprintf('%s.codTipo = :tipo', $qb->getRootAlias())
                        );

                        $qb->setParameter('tipo', $value['value']);

                        return true;
                    },
                    'label' => 'label.catalogoItem.codTipo',
                ],
                'entity',
                $fieldOptions['codTipo']
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkAlmoxarifadoCatalogoClassificacao.fkAlmoxarifadoCatalogo',
                'text',
                [
                    'label' => 'label.catalogoItem.codCatalogo'
                ]
            )
            ->add('codClassificacao', null, ['label' => 'label.catalogoItem.codClassificacao'])
            ->add('codItem', null, ['label' => 'label.catalogoItem.codigo'])
            ->add('fkAlmoxarifadoTipoItem.descricao', null, ['label' => 'label.catalogoItem.codTipo'])
            ->add(
                'descricao',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__descricao.html.twig',
                    'label' => 'label.catalogoItem.descricao',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => [
                            'template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig',
                        ],
                        'requisitar' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/CatalogoItem/CRUD:list__action_requisitar.html.twig',
                        ],
                    ],
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $catalogoItem = $this->getSubject();

        $fkAlmoxarifadoControleEstoquesTemplate = 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:show__fkAlmoxarifadoControleEstoques.html.twig';

        $paths = $this->getContainer()->getParameter('patrimonialbundle');
        $descricaoCompletaFilePath = sprintf('%s/%s', $paths['catalogoItemDescricao'], $catalogoItem->getDescricaoCompletaNomeArquivo());

        $this->descricaoCompletaDownload = false;
        if ($catalogoItem->getDescricaoCompletaNomeArquivo() && file_exists($descricaoCompletaFilePath)) {
            $this->descricaoCompletaDownload = true;
        }

        $this->lancamentosMaterial = $this->fetchLancamentos($catalogoItem->getCodItem());

        $this->requisicaoItemModel = new RequisicaoItemModel($em);

        $showMapper
            ->with('label.catalogoItem.cabecalhoClassificacao')
                ->add(
                    'fkAlmoxarifadoCatalogoClassificacao.fkAlmoxarifadoCatalogo',
                    null,
                    [
                        'label' => 'label.catalogoItem.codCatalogo',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoCatalogoClassificacao',
                    null,
                    [
                        'label' => 'label.catalogoItem.codClassificacao',
                    ]
                )
            ->end()
            ->with('label.catalogoItem.cabecalhoItem')
                ->add('ativo')
                ->add(
                    'fkAlmoxarifadoTipoItem.descricao',
                    null,
                    [
                        'label' => 'label.catalogoItem.codTipo'
                    ]
                )
                ->add(
                    'descricao',
                    null,
                    [
                        'label' => 'label.catalogoItem.descricao'
                    ]
                )
                ->add(
                    'descricaoResumida',
                    'text',
                    [
                        'label' => 'label.catalogoItem.descricaoResumida'
                    ]
                )
                ->add(
                    'descricaoCompleta',
                    null,
                    [
                        'mapped' => false,
                        'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:show__descricao_completa.html.twig',
                        'label' => 'label.catalogoItem.descricaoCompleta',
                    ]
                )
            ->end()
            ->with('label.catalogoItem.cabecalhoEstoque')
                ->add(
                    'fkAdministracaoUnidadeMedida.nomUnidade',
                    null,
                    [
                        'label' => 'label.catalogoItem.unidadeMedidaEntrega'
                    ]
                )
                ->add(
                    'fkAlmoxarifadoAtributoCatalogoItens',
                    null,
                    [
                        'associated_property' => 'fkAdministracaoAtributoDinamico.nomAtributo',
                        'label' => 'label.catalogoItem.codAtributo',
                    ]
                )
                ->add(
                    'detalhes',
                    null,
                    [
                        'mapped' => false,
                        'template' => 'ComprasGovernamentaisBundle:Sonata\CatalogoItem\CRUD:show__detalhes.html.twig',
                    ]
                )
            ->end();
    }

    /**
     * @param int $codItem
     * @return array
     */
    protected function fetchLancamentos($codItem)
    {
        if (!$codItem) {
            return [];
        }

        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(LancamentoMaterial::class)->createQueryBuilder('lm');

        $qb->join('lm.fkAlmoxarifadoEstoqueMaterial', 'em');
        $qb->join('em.fkAlmoxarifadoAlmoxarifado', 'a');
        $qb->join('a.fkSwCgm', 'acgm');
        $qb->join('em.fkAlmoxarifadoCatalogoItemMarca', 'cim');
        $qb->join('cim.fkAlmoxarifadoMarca', 'm');
        $qb->join('em.fkAlmoxarifadoCentroCusto', 'cc');

        $qb->where('lm.codItem = :codItem');
        $qb->setParameter('codItem', $codItem);

        $qb->resetDqlPart('select');
        $qb->addSelect(
            [
                'lm.codAlmoxarifado',
                'lm.codItem',
                'lm.codMarca',
                'lm.codCentro',
                'SUM(lm.quantidade) AS quantidade',
                'MAX(acgm.nomCgm) AS almoxarifado',
                'MAX(m.descricao) AS marca',
                'MAX(cc.descricao) AS centroCusto',
            ]
        );

        $qb->addGroupBy('lm.codAlmoxarifado');
        $qb->addGroupBy('lm.codItem');
        $qb->addGroupBy('lm.codMarca');
        $qb->addGroupBy('lm.codCentro');

        return $qb->getQuery()->getResult();
    }
}
