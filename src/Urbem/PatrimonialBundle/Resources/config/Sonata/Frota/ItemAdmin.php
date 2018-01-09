<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\ItemRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;

/**
 * Class ItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class ItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_item';
    protected $baseRoutePattern = 'patrimonial/frota/item';
    protected $model = Model\Patrimonial\Frota\ItemModel::class;
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/patrimonial/javascripts/frota/item.js'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('info', '{id}/info', [
            '_controller' => 'PatrimonialBundle:Frota/Item:info'
        ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $fieldOptions['codItem'] = [
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_item_autocomplete'],
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['codTipo'] = [
            'class' => Frota\TipoItem::class,
            'label' => 'label.item.codTipo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $datagridMapper
            ->add(
                'codItem',
                null,
                [
                    'label' => 'label.item.codItem',
                ],
                'autocomplete',
                $fieldOptions['codItem']
            )
            ->add(
                'fkFrotaTipoItem',
                null,
                $fieldOptions['codTipo'],
                []
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions['codTipo'] = [
            'class' => Frota\TipoItem::class,
            'label' => 'label.item.codTipo',
        ];

        $fieldOptions['codItem'] = [
            'class' => Almoxarifado\CatalogoItem::class,
            'label' => 'label.item.codItem',
        ];

        $listMapper
            ->add(
                'fkAlmoxarifadoCatalogoItem',
                'text',
                $fieldOptions['codItem']
            )
            ->add(
                'fkFrotaTipoItem',
                'text',
                $fieldOptions['codTipo']
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['tipoCadastro'] = [
            'label' => false,
            'choices' => [
                'label.item.tipoCadastroItem' => Frota\Item::TIPOCADASTROITEM,
                'label.item.tipoCadastroLote' => Frota\Item::TIPOCADASTROLOTE
            ],
            'data' => 2,
            'expanded' => true,
            'multiple' => false,
            'mapped' => false
        ];

        $fieldOptions['codItem'] = [
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_item_autocomplete'],
            'label' => 'label.item.codItem',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'class' => Almoxarifado\CatalogoItem::class
        ];

        $fieldOptions['codTipo'] = [
            'class' => Frota\TipoItem::class,
            'label' => 'label.item.codTipo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codCombustivel'] = [
            'class' => Frota\Combustivel::class,
            'label' => 'label.item.combustivel',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codCatalogo'] = [
            'class' => 'CoreBundle:Almoxarifado\Catalogo',
            'placeholder' => 'Selecione...',
            'label' => 'label.catalogoClassificao.codCatalogo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false
        ];

        $fieldOptions['tipoCadastroWith'] = [
            'class' => 'tipoCadastro',
            'attr' => [
                'display' => 'none',
            ]
        ];

        if ($this->id($this->getSubject())) {
            /** @var Frota\Item $item */
            $item = $this->getSubject();

            $fieldOptions['tipoCadastroWith']['class'] = 'tipoCadastro tipoCadastroHide';

            // Processa CodCombustivel
            if ($item->getFkFrotaCombustivelItem()) {
                $fieldOptions['codCombustivel']['data'] = $item->getFkFrotaCombustivelItem()->getFkFrotaCombustivel();
            }

            $fieldOptions['tipoCadastro']['data'] = Frota\Item::TIPOCADASTROITEM;
        }
        
        $formMapper
            ->with(
                'label.item.tipoCad',
                $fieldOptions['tipoCadastroWith']
            )
                ->add(
                    'tipoCadastro',
                    'choice',
                    $fieldOptions['tipoCadastro']
                )
            ->end()
            ->with(
                'label.item.tipoCadastroItem',
                [
                    'class' => 'tipoCadastroItem'
                ]
            );
        if ($this->id($this->getSubject())) {
            /** @var Frota\Item $item */
            $item = $this->getSubject();

            // Processa catalogoItem
            $fieldOptions['codItem']['data'] = $item->getFkAlmoxarifadoCatalogoItem();
            $formMapper
                ->add(
                    'item',
                    'text',
                    [
                        'data' => $item->getFkAlmoxarifadoCatalogoItem(),
                        'label' => 'label.item.codItem',
                        'mapped' => false,
                        'attr' => [
                            'readonly' => 'readonly'
                        ]
                    ]
                )
                ->add(
                    'codItem',
                    'hidden',
                    ['data' => $item->getFkAlmoxarifadoCatalogoItem()->getCodItem()]
                );
        } else {
            $formMapper
                ->add(
                    'codItem',
                    'autocomplete',
                    $fieldOptions['codItem']
                );
        }
        $formMapper
            ->end()
            ->with(
                'label.item.tipoCadastroLote',
                [
                    'class' => 'tipoCadastroLote'
                ]
            )
                ->add(
                    'avisoLote',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'PatrimonialBundle::Frota/Item/avisoLote.html.twig',
                        'data' => []
                    ]
                )
                ->add(
                    'codCatalogo',
                    'entity',
                    $fieldOptions['codCatalogo']
                )
            ->end()
            ->with(
                'label.item.tipoCadastroLoteClassificacao',
                [
                    'class' => 'catalogoClassificacaoContainer'
                ]
            )
                ->add(
                    'catalogoClassificacaoPlaceholder',
                    'text',
                    [
                        'mapped' => false,
                        'required' => false
                    ]
                )
            ->end()
            ->with('label.item.tipoItem')
                ->add(
                    'fkFrotaTipoItem',
                    'entity',
                    $fieldOptions['codTipo']
                )
                ->add(
                    'codCombustivel',
                    'entity',
                    $fieldOptions['codCombustivel']
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions['codItem'] = [
            'class' => Almoxarifado\CatalogoItem::class,
            'label' => 'label.item.codItem',
        ];

        $fieldOptions['codTipo'] = [
            'class' => Frota\TipoItem::class,
            'label' => 'label.item.codTipo'
        ];

        $fieldOptions['codCombustivel'] = [
            'class' => Frota\CombustivelItem::class,
            'label' => 'label.item.combustivel',
            'associated_property' => function (Frota\CombustivelItem $combustivelItem) {
                return $combustivelItem->getFkFrotaCombustivel()->getCodCombustivel().' - '.
                    $combustivelItem->getFkFrotaCombustivel()->getNomCombustivel();
            }
        ];

        $showMapper
            ->add(
                'fkAlmoxarifadoCatalogoItem',
                'text',
                $fieldOptions['codItem']
            )
            ->add(
                'fkFrotaTipoItem',
                'text',
                $fieldOptions['codTipo']
            )
        ;

        /** @var Frota\Item $item */
        $item = $this->getSubject();
        if ($item->getFkFrotaTipoItem()->getCodTipo() == 1) {
            $this->data['fkFrotaCombustivelItens'] = $this->getSubject()->getFkFrotaCombustivelItem();
            $showMapper
                ->add('fkFrotaTipoItem.fkFrotaCombustivelItens', 'entity', [
                    'label' => 'label.item.combustivel',
                    'template' => 'PatrimonialBundle:Frota\Item:combustivel.html.twig'
                ])
            ;
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param Frota\Item $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $route = $this->getRequest()->get('_sonata_name');
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        if ($form->get('tipoCadastro')->getData() == 1) {
            if (!preg_match('/edit/', $route)) {
                if (strstr($form->get('codItem')->getData(), '-')) {
                    $codItem = explode(' - ', $form->get('codItem')->getData());
                    $codItem = $codItem[0];
                } else {
                    $codItem = $form->get('codItem')->getData();
                }
                $item = $em->getRepository($this->getClass())->findOneBy([
                    'codItem' => $codItem
                ]);
                if (!empty($item)) {
                    $message = $this->trans('frota.item.errors.codItemExiste', [], 'validators');
                    $errorElement->with('codItem')->addViolation($message)->end();
                }
            }
        }
    }

    /**
     * @param Frota\Item $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Se Único Item
        if ($form->get('tipoCadastro')->getData() == 1) {
            // Set fkAlmoxarifadoCatalogoItem
            if (strstr($form->get('codItem')->getData(), '-')) {
                $codItem = explode(' - ', $form->get('codItem')->getData());
                $codItem = $codItem[0];
            } else {
                $codItem = $form->get('codItem')->getData();
            }

            $catalogoItem = $em->getRepository(Almoxarifado\CatalogoItem::class)->findOneBy([
                'codItem' => $codItem
            ]);
            $object->setFkAlmoxarifadoCatalogoItem($catalogoItem);

            if ($form->get('codCombustivel')->getData()) {
                $combustivelItem = new Frota\CombustivelItem();
                $combustivelItem->setFkFrotaCombustivel($form->get('codCombustivel')->getData());
                $combustivelItem->setFkFrotaItem($object);
                $object->setFkFrotaCombustivelItem($combustivelItem);
            }
        } else {
            $catalogoClassificacaoComponent = $this->request->request->get('catalogoClassificacaoComponent');
            $infos = [
                'codEstrutural'     => end($catalogoClassificacaoComponent),
                'codCatalogo'       => $form->get('codCatalogo')->getData()->getCodCatalogo(),
                'codTipo'           => $form->get('fkFrotaTipoItem')->getData()->getCodTipo(),
                'codCombustivel'    => ($form->get('codCombustivel')->getData() ? $form->get('codCombustivel')->getData()->getCodCombustivel() : null)
            ];

            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            /** @var ItemRepository $itemRepository */
            $itemRepository = $em->getRepository($this->getClass());
            $result = $itemRepository->processaItens($infos);

            $container = $this->getConfigurationPool()->getContainer();
            if ($result) {
                $message = $this->trans('frotaItem.create', [], 'flashes');
                $container->get('session')->getFlashBag()->add('sonata_flash_success', $message);
                $this->redirectByRoute(
                    $this->baseRouteName . '_list'
                );
            } else {
                $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
                $this->redirectByRoute(
                    $this->baseRouteName . '_create'
                );
            }
        }
    }

    /**
     * @param Frota\Item $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->redirectByRoute(
                $this->baseRouteName . '_create'
            );
        }
    }

    /**
     * @param Frota\Item $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $id = $this->getAdminRequestId();
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Remove CodCombustivel
            if ($object->getFkFrotaCombustivelItem()) {
                $em->remove($object->getFkFrotaCombustivelItem());
            }
            $em->flush();

            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->redirectByRoute(
                $this->baseRouteName . '_edit',
                ['id' => $this->getAdminRequestId()]
            );
        }
    }
}
