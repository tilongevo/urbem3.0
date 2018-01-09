<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\UnidadeMedida;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Model\Administracao\UnidadeMedidaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AtributoCatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\ControleEstoqueModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CatalogoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class CatalogoItemAdmin extends AbstractAdmin
{
    const PRIORIDADE_IMPRESCINDIVEL = 'imprescindivel';
    const PRIORIDADE_IMPORTANTE = 'importante';
    const PRIORIDADE_INTERMEDIARIA = 'intermediaria';
    const PRIORIDADE_MODERADA = 'moderada';
    const PRIORIDADE_POUCA_IMPORTANCIA = 'pouca-importancia';
    const PRIORIDADES = [
        self::PRIORIDADE_IMPRESCINDIVEL => 'Imprescindível',
        self::PRIORIDADE_IMPORTANTE => 'Importante',
        self::PRIORIDADE_INTERMEDIARIA => 'Importância Intermediária',
        self::PRIORIDADE_MODERADA => 'Moderada',
        self::PRIORIDADE_POUCA_IMPORTANCIA => 'Pouca Importância',
    ];

    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_catalogo_item';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/catalogo-item';
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/patrimonial/javascripts/almoxarifado/catalogoItem.js',
    ];
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'codItem',
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_classificacao_atributo', 'get-classificacao-atributo/');
        $collection->add('autocomplete', 'autocomplete');
        $collection->add('autocomplete_ex_servicos', 'autocomplete-ex-servicos');
        $collection->add(
            'get_catalogo_classificacao',
            sprintf('get-catalogo-classificacao/%s', $this->getRouterIdParameter())
        );
        $collection->add(
            'info',
            sprintf('%s/info', $this->getRouterIdParameter())
        );
        $collection->add(
            'descricao_completa_download',
            sprintf('descricao-completa/%s', $this->getRouterIdParameter())
        );
        $collection->add(
            'foto',
            sprintf('foto/%s', $this->getRouterIdParameter())
        );
    }

    /**
     * @param ErrorElement $errorElement
     * @param Almoxarifado\CatalogoItem $catalogoItem
     */
    public function validate(ErrorElement $errorElement, $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager(TipoItem::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $tipo = $em->getRepository(TipoItem::class)
            ->find($catalogoItem->getCodTipo());

        $catalogoItem->setFkAlmoxarifadoTipoItem($tipo);

        if (!$this->getAdminRequestId()) {
            if (!empty($formData['codClassificacao'])) {
                list($param['codClassificacao'], $param['codCatalogo']) = explode('~', $formData['codClassificacao']);

                $catalogoClassificacao = $em->getRepository(Almoxarifado\CatalogoClassificacao::class)
                    ->find($param);

                $catalogoItem->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);
            }
        }
    }

    /**
     * @param CatalogoItem $catalogoItem
     */
    public function prePersist($catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $catalogoClassificacaoComponent = $this->request->request->get('catalogoClassificacaoComponent');
        $params = [
            'codEstrutural' => end($catalogoClassificacaoComponent),
            'codCatalogo' => $this->getForm()->get('codCatalogo')->getData()->getCodCatalogo(),
        ];

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($em);
        $catalogoClassificacao = $catalogoClassificacaoModel->findOneBy($params);

        $catalogoItem->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);

        $unidadeMedidaCompra = $this->getForm()->get('fkAdministracaoUnidadeMedidaCompra')->getData();
        if (!$this->getForm()->get('fkAdministracaoUnidadeMedida')->getData()) {
            $catalogoItem->setFkAdministracaoUnidadeMedida($unidadeMedidaCompra);
        }
    }

    /**
     * @param CatalogoItem $catalogoItem
     */
    public function postPersist($catalogoItem)
    {
        $em = $this->modelManager->getEntityManager(TipoItem::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $container = $this->getConfigurationPool()->getContainer();

        $controleEstoqueModel = new ControleEstoqueModel($em);
        $controleEstoqueModel->createOrUpdateWithCatalogoItem($catalogoItem, $formData);

        $atributosDinamicos = $this->request->request->get('atributoDinamico');
        $catalogoItemModel = new CatalogoItemModel($em);
        $catalogoItemModel->saveAlmoxarifadoAtributoCatalogoClassificacaoItemValores($catalogoItem, $atributosDinamicos);

        $atributoCatalogoItemModel = new AtributoCatalogoItemModel($em);
        $atributosDinamicos = $this->getForm()->get('codAtributo')->getData();

        foreach ($atributosDinamicos as $atributoDinamico) {
            $atributoCatalogoItemModel->buildWithCatalogoItem($catalogoItem, $atributoDinamico);
        }

        if ($descricaoCompletaFile = $this->getForm()->get('descricaoCompleta')->getData()) {
            $this->uploadDescricaoCompleta($descricaoCompletaFile, $catalogoItem);
        }
    }

    /**
     * @param CatalogoItem $catalogoItem
     */
    public function preUpdate($catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $catalogoClassificacaoComponent = $this->request->request->get('catalogoClassificacaoComponent');
        $params = [
            'codEstrutural' => end($catalogoClassificacaoComponent),
            'codCatalogo' => $this->getForm()->get('codCatalogo')->getData()->getCodCatalogo()
        ];

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($em);
        $catalogoClassificacao = $catalogoClassificacaoModel->findOneBy($params);

        $catalogoItem->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);

        $unidadeMedidaCompra = $this->getForm()->get('fkAdministracaoUnidadeMedidaCompra')->getData();
        if (!$this->getForm()->get('fkAdministracaoUnidadeMedida')->getData()) {
            $catalogoItem->setFkAdministracaoUnidadeMedida($unidadeMedidaCompra);
        }

        $atributosDinamicos = $this->request->request->get('atributoDinamico');
        $catalogoItemModel = new CatalogoItemModel($em);
        $catalogoItemModel->saveAlmoxarifadoAtributoCatalogoClassificacaoItemValores($catalogoItem, $atributosDinamicos);
    }

    /**
     * @param CatalogoItem $catalogoItem
     */
    public function postUpdate($catalogoItem)
    {
        $em = $this->modelManager->getEntityManager(TipoItem::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $controleEstoqueModel = new ControleEstoqueModel($em);
        $controleEstoqueModel->createOrUpdateWithCatalogoItem($catalogoItem, $formData);

        $atributosDinamicos = $this->getForm()->get('codAtributo')->getData();

        $atributoCatalogoItemModel = new AtributoCatalogoItemModel($em);
        $atributoCatalogoItemModel->clearAllExcept($catalogoItem, $atributosDinamicos);

        if ($descricaoCompletaFile = $this->getForm()->get('descricaoCompleta')->getData()) {
            $this->uploadDescricaoCompleta($descricaoCompletaFile, $catalogoItem);
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['codCatalogo'] = [
            'class' => Catalogo::class,
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
            'class' => CatalogoClassificacao::class,
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
            'class' => TipoItem::class,
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
                    'label' => 'label.catalogoItem.descricao',
                    'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:list__descricao.html.twig'
                ]
            )
            ->add('_action', 'actions', array(
            'actions' => array(
                'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                'foto' => array('template' => 'PatrimonialBundle:Sonata/Almoxarifado/CatalogoItem/CRUD:list_action_foto.html.twig')
            )));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $catalogoItem = $this->getSubject();

        $edicao = false;

        $fieldOptions['codCatalogo'] = [
            'class' => Catalogo::class,
            'choice_value' => 'codCatalogo',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.codCatalogo',
        ];

        $fieldOptions['codClassificacao'] = [
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_classificacao_search'],
            'req_params' => [
                'codCatalogo' => 'varJsCodCatalogo',
            ],
            'placeholder' => 'Selecione o Catálogo',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.codClassificacao',
        ];

        $fieldOptions['fkAlmoxarifadoTipoItem'] = [
            'class' => TipoItem::class,
            'query_builder' => (new TipoItemModel($em))->getTiposItem(),
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.codTipo',
        ];

        $fieldOptions['descricaoResumida'] = [
            'label' => 'label.catalogoItem.descricaoResumida',
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.catalogoItem.descricao',
        ];

        $fieldOptions['prioridade'] = [
            'choices' => array_flip($this::PRIORIDADES),
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.prioridade',
        ];

        $fieldOptions['divisivel'] = [
            'required' => false,
            'label' => 'label.catalogoItem.divisivel',
        ];

        $fieldOptions['fkAdministracaoUnidadeMedidaCompra'] = [
            'class' => UnidadeMedida::class,
            'query_builder' => (new UnidadeMedidaModel($em))->getUnidadesMedidas(),
            'choice_label' => 'nomUnidade',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.unidadeMedidaCompra',
        ];

        $fieldOptions['desmembravel'] = [
            'required' => false,
            'label' => 'label.catalogoItem.desmembravel',
        ];

        $fieldOptions['fkAdministracaoUnidadeMedidaEntrega'] = [
            'class' => UnidadeMedida::class,
            'query_builder' => (new UnidadeMedidaModel($em))->getUnidadesMedidas(),
            'choice_label' => 'nomUnidade',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.unidadeMedidaEntrega',
        ];

        $fieldOptions['estoqueMinimoCompra'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.estoqueMinimoCompra',
        ];

        $fieldOptions['pontoPedidoCompra'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.pontoPedidoCompra',
        ];

        $fieldOptions['estoqueMaximoCompra'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.estoqueMaximoCompra',
        ];

        $fieldOptions['estoqueMinimoEntrega'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.estoqueMinimoEntrega',
        ];

        $fieldOptions['pontoPedidoEntrega'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.pontoPedidoEntrega',
        ];

        $fieldOptions['estoqueMaximoEntrega'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
            ],
            'label' => 'label.catalogoItem.estoqueMaximoEntrega',
        ];

        $fieldOptions['codAtributo'] = [
            'class' => AtributoDinamico::class,
            'mapped' => false,
            'query_builder' => (new CatalogoItemModel($em))->getAtributoDinamicoQuery(),
            'choice_label' => function (AtributoDinamico $atributo) {
                return sprintf('%d - %s', $atributo->getCodAtributo(), $atributo->getNomAtributo());
            },
            'multiple' => true,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.catalogoItem.codAtributo',
        ];

        $fieldOptions['codEstrutural'] = [
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codItem'] = [
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false,
        ];

        $availableMimeTypes = [
            '.txt' => 'text/*',
            '.doc' => 'application/msword',
            '.docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            '.odt' => 'application/vnd.oasis.opendocument.text',
            '.pdf' => 'application/pdf',
        ];

        $descricaoCompletaRules = [
            'mimeTypes'        => $availableMimeTypes,
            'maxSize'          => '10m',
            'mimeTypesMessage' => $this->trans(
                'catalogoItem.errors.invalidFileType',
                [
                    '%file_types%' => implode(', ', $availableMimeTypes),
                ],
                'validators'
            ),
            'maxSizeMessage'   => $this->trans(
                'catalogoItem.errors.uploadedFileSizeNotAllowed',
                [
                    '%size%' => '10Mb',
                ],
                'validators'
            ),
        ];

        $helpContent = $this->getContainer()
            ->get('twig')
            ->render(
                '@Patrimonial/Almoxarifado/CatalogoItem/descricao_completa_help.html.twig',
                [
                    'rules' => $descricaoCompletaRules,
                ]
            );

        $fieldOptions['descricaoCompleta'] = [
            'mapped'      => false,
            'required'    => false,
            'help'        => $helpContent,
            'constraints' => [new FileConstraint($descricaoCompletaRules)],
            'label'       => 'label.catalogoItem.descricaoCompleta',
        ];

        $fieldOptions['descricaoCompletaLink'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'PatrimonialBundle::Almoxarifado/CatalogoItem/descricao_completa_link.html.twig',
            'data' => [],
        ];

        if ($this->isCurrentRoute('edit')) {
            $catalogoClassificacao = $catalogoItem->getFkAlmoxarifadoCatalogoClassificacao();
            $controleEstoque = $catalogoItem->getFkAlmoxarifadoControleEstoque();

            $fieldOptions['codItem']['data'] = $catalogoItem->getCodItem();
            $fieldOptions['codCatalogo']['data'] = $catalogoClassificacao->getFkAlmoxarifadoCatalogo();
            $fieldOptions['codEstrutural']['data'] = $catalogoClassificacao->getCodEstrutural();

            if ($controleEstoque) {
                $fieldOptions['estoqueMinimoCompra']['data'] = $controleEstoque->getEstoqueMinimoCompra();
                $fieldOptions['estoqueMaximoCompra']['data'] = $controleEstoque->getEstoqueMaximoCompra();
                $fieldOptions['pontoPedidoCompra']['data'] = $controleEstoque->getPontoPedidoCompra();
                $fieldOptions['estoqueMinimoEntrega']['data'] = $controleEstoque->getEstoqueMinimo();
                $fieldOptions['estoqueMaximoEntrega']['data'] = $controleEstoque->getEstoqueMaximo();
                $fieldOptions['pontoPedidoEntrega']['data'] = $controleEstoque->getPontoPedido();
            }

            $paths = $this->getContainer()->getParameter('patrimonialbundle');
            $descricaoCompletaFilePath = sprintf('%s/%s', $paths['catalogoItemDescricao'], $catalogoItem->getDescricaoCompletaNomeArquivo());

            if ($catalogoItem->getDescricaoCompletaNomeArquivo() && file_exists($descricaoCompletaFilePath)) {
                $fieldOptions['descricaoCompletaLink']['data'] = ['catalogoItem' => $catalogoItem];
            }

            $boPermiteManutencao = $catalogoClassificacao->getFkAlmoxarifadoCatalogo()->getPermiteManutencao();

            $boTemMovimentacao = $em
                ->getRepository(EstoqueMaterial::class)
                ->findOneBy([
                    'codItem' => $catalogoItem->getCodItem(),
                ]);

            if (!$boPermiteManutencao && !$boTemMovimentacao) {
                $fieldOptions['descricao']['attr'] = [
                    'readonly' => 'readonly',
                ];

                $fieldOptions['descricaoResumida']['attr'] = [
                    'readonly' => 'readonly',
                ];

                $fieldOptions['fkAdministracaoUnidadeMedidaCompra']['data'] = $catalogoItem->getFkAdministracaoUnidadeMedida();

                $fieldOptions['fkAlmoxarifadoTipoItem']['data'] = $catalogoItem->getFkAlmoxarifadoTipoItem();

                $edicao = true;
            }

            if ($boPermiteManutencao && $boTemMovimentacao) {
                $fieldOptions['codCatalogo']['query_builder'] = function ($repository) {
                    $qb = $repository->createQueryBuilder('c');

                    $qb->where('c.permiteManutencao = true');

                    return $qb;
                };
            }

            $arrAtributos = [];
            foreach ($catalogoItem->getFkAlmoxarifadoAtributoCatalogoItens() as $atributoCatalogoItem) {
                $arrAtributos[] = $atributoCatalogoItem->getFkAdministracaoAtributoDinamico();
            }

            $fieldOptions['codAtributo']['data'] = $arrAtributos;
        }

        $formMapper
            ->with('label.catalogoItem.cabecalhoCatalogo')
                ->add('codCatalogo', 'entity', $fieldOptions['codCatalogo'])
                ->add(
                    'edicao',
                    'hidden',
                    [
                        'mapped' => false,
                        'data' => $edicao,
                    ]
                )
            ->end()
            ->with(
                'label.catalogoItem.cabecalhoClassificacao',
                [
                    'class' => 'catalogoClassificacaoContainer'
                ]
            )
                ->add(
                    'catalogoClassificacaoPlaceholder',
                    'text',
                    [
                        'mapped' => false,
                        'required' => false,
                    ]
                )
            ->end()
            ->with('label.catalogoItem.cabecalhoAtributos', ['class' => 'atributoDinamicoWith'])
                ->add(
                    'atributosDinamicos',
                    'text',
                    $fieldOptions['atributosDinamicos']
                )
                ->add(
                    'codEstrutural',
                    'hidden',
                    $fieldOptions['codEstrutural']
                )
                ->add('codItem', 'hidden', $fieldOptions['codItem'])
            ->end()
            ->with('label.catalogoItem.cabecalhoItem')
                ->add('ativo');

        if ($this->isCurrentRoute('edit') && (!$boPermiteManutencao && !$boTemMovimentacao)) {
            $formMapper
                ->add('ativo', 'hidden', ['data' => $catalogoItem->getAtivo()])
                ->add(
                    'textAtivo',
                    'text',
                    [
                        'mapped' => false,
                        'data' => $catalogoItem->getAtivo() ? 'Ativo' : 'Inativo',
                        'attr' => [
                            'readonly' => 'readonly',
                        ],
                        'label' => 'label.catalogoItem.status',
                    ]
                );
        }

        $formMapper
                ->add('fkAlmoxarifadoTipoItem', 'entity', $fieldOptions['fkAlmoxarifadoTipoItem'])
                ->add('descricao', 'text', $fieldOptions['descricao'])
                ->add('descricaoResumida', 'text', $fieldOptions['descricaoResumida'])
                ->add('prioridade', 'choice', $fieldOptions['prioridade'])
            ->end()
            ->with('label.catalogoItem.cabecalhoCompras')
                ->add('descricaoCompleta', 'file', $fieldOptions['descricaoCompleta']);

        if ($this->isCurrentRoute('edit') && $fieldOptions['descricaoCompletaLink']['data']) {
            $formMapper
                ->add('descricaoCompletaLink', 'customField', $fieldOptions['descricaoCompletaLink']);
        }

        $formMapper
                ->add('divisivel', 'checkbox', $fieldOptions['divisivel'])
                ->add('fkAdministracaoUnidadeMedidaCompra', 'entity', $fieldOptions['fkAdministracaoUnidadeMedidaCompra'])
            ->end()
            ->with('label.catalogoItem.cabecalhoEstoque')
                ->add('desmembravel', 'checkbox', $fieldOptions['desmembravel'])
                ->add('fkAdministracaoUnidadeMedida', 'entity', $fieldOptions['fkAdministracaoUnidadeMedidaEntrega'])
                ->add('estoqueMinimoCompra', 'number', $fieldOptions['estoqueMinimoCompra'])
                ->add('pontoPedidoCompra', 'number', $fieldOptions['pontoPedidoCompra'])
                ->add('estoqueMaximoCompra', 'number', $fieldOptions['estoqueMaximoCompra'])
                ->add('estoqueMinimo', 'number', $fieldOptions['estoqueMinimoEntrega'])
                ->add('pontoPedido', 'number', $fieldOptions['pontoPedidoEntrega'])
                ->add('estoqueMaximo', 'number', $fieldOptions['estoqueMaximoEntrega'])
            ->end()
            ->with('label.catalogoItem.cabecalhoAtributoEntrada')
                ->add('codAtributo', 'entity', $fieldOptions['codAtributo'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $catalogoItem = $this->getSubject();

        $fkAlmoxarifadoControleEstoquesTemplate =
            'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:show__fkAlmoxarifadoControleEstoques.html.twig';

        $fieldOptions['codAtributo'] = [];

        $this->prioridades = $this::PRIORIDADES;

        $paths = $this->getContainer()->getParameter('patrimonialbundle');
        $descricaoCompletaFilePath = sprintf('%s/%s', $paths['catalogoItemDescricao'], $catalogoItem->getDescricaoCompletaNomeArquivo());

        $this->descricaoCompletaDownload = false;
        if ($catalogoItem->getDescricaoCompletaNomeArquivo() && file_exists($descricaoCompletaFilePath)) {
            $this->descricaoCompletaDownload = true;
        }

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
                    'prioridade',
                    null,
                    [
                        'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:show__prioridade.html.twig',
                        'label' => 'label.catalogoItem.prioridade',
                    ]
                )
            ->end()
            ->with('label.catalogoItem.cabecalhoCompras')
                ->add(
                    'descricaoCompleta',
                    null,
                    [
                        'mapped' => false,
                        'template' => 'PatrimonialBundle:Sonata\Almoxarifado\CatalogoItem\CRUD:show__descricao_completa.html.twig',
                        'label' => 'label.catalogoItem.descricaoCompleta'
                    ]
                )
                ->add(
                    'divisivel',
                    null,
                    [
                        'label' => 'label.catalogoItem.divisivel'
                    ]
                )
                ->add(
                    'fkAdministracaoUnidadeMedidaCompra.nomUnidade',
                    null,
                    [
                        'label' => 'label.catalogoItem.unidadeMedidaCompra'
                    ]
                )
            ->end()
            ->with('label.catalogoItem.cabecalhoEstoque')
                ->add(
                    'desmembravel',
                    null,
                    [
                        'label' => 'label.catalogoItem.desmembravel'
                    ]
                )
                ->add(
                    'fkAdministracaoUnidadeMedida.nomUnidade',
                    null,
                    [
                        'label' => 'label.catalogoItem.unidadeMedidaEntrega'
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.estoqueMinimoCompra',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.estoqueMinimoCompra',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.pontoPedidoCompra',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.pontoPedidoCompra',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.estoqueMaximoCompra',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.estoqueMaximoCompra',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.estoqueMinimo',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.estoqueMinimoEntrega',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.pontoPedido',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.pontoPedidoEntrega',
                    ]
                )
                ->add(
                    'fkAlmoxarifadoControleEstoques.estoqueMaximo',
                    null,
                    [
                        'template' => $fkAlmoxarifadoControleEstoquesTemplate,
                        'label' => 'label.catalogoItem.estoqueMaximoEntrega',
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
            ->end();
    }

    /**
    * @param UploadedFile $descricaoCompletaFile
    * @return void
    */
    protected function uploadDescricaoCompleta(UploadedFile $descricaoCompletaFile, CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $paths = $this->getContainer()->getParameter('patrimonialbundle');
        $descricaoCompletaPath = $paths['catalogoItemDescricao'];

        if (!file_exists($descricaoCompletaPath)
            && !mkdir($descricaoCompletaPath, 0755, true)) {
            return;
        }

        $fileName = sprintf('%s.%s', $catalogoItem->getCodItem(), $descricaoCompletaFile->getClientOriginalExtension());

        try {
            $descricaoCompletaFile->move($descricaoCompletaPath, $fileName);
            $catalogoItem->setDescricaoCompletaNomeArquivo($fileName);

            $em->merge($catalogoItem);
            $em->flush();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * @return mixed|null|object
     */
    public function getCatalogoItem()
    {
        return $this->getSubject();
    }
}
