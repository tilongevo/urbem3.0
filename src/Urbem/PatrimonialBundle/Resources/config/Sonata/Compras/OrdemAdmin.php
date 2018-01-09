<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Compras;

use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;

/**
 * Class OrdemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class OrdemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_ordem';
    protected $baseRoutePattern = 'patrimonial/compras/ordem';
    protected $includeJs = [
        '/patrimonial/javascripts/compras/ordem.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_empenho_info',
            'get-empenho-info/' . $this->getRouterIdParameter()
        );
    }

    /**
     * @param string $context
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Ordem');
        $OrdemModel = new OrdemModel($em);
        $query = parent::createQuery($context);

        $exercicio = $this->getExercicio();

        $return = $OrdemModel->listaOrdensAtivas($query, $exercicio);

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }

        return $return;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codOrdem', 'codEntidade', 'tipo', 'exercicio'));

        $datagridMapper
            ->add('exercicio')
            ->add('codOrdem', null, ['label' => 'label.ordem.codOrdem'], 'text', [])
            ->add(
                'fkEmpenhoEmpenho.fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.ordem.entidade',
                    'admin_code' => 'financeiro.admin.entidade'
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_label' => function (Entity\Orcamento\Entidade $codEntidade) {
                        return $codEntidade->getCodEntidade() . ' - ' . $codEntidade->getFkSwCgm()->getNomCgm();
                    },
                    'query_builder' => function ($entityManager) use ($exercicio) {
                        return $entityManager
                            ->createQueryBuilder('entidade')
                            ->where('entidade.exercicio = :exercicio')
                            ->setParameter(':exercicio', $exercicio);
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add('codEmpenho', null, ['label' => 'label.ordem.codEmpenho',], 'text', []);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('fkEmpenhoEmpenho', null, ['label' => 'label.ordem.codEmpenho', 'admin_code' => 'financeiro.admin.consultar_empenho'])
            ->add('codOrdem', null, ['label' => 'label.ordem.codOrdem'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.ordem.numcgmEntrega'])
            ->add('fkEmpenhoEmpenho.fkOrcamentoEntidade', null, ['label' => 'label.ordem.entidade', 'admin_code' => 'financeiro.admin.entidade'])
            ->add('nomTipo', null, ['label' => 'label.ordem.tipo'])
            ->add(
                'timestamp',
                'date',
                [
                    'label' => 'label.ordem.dtOrdem',
                    'format' => 'd/m/Y'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'anular' => ['template' => 'PatrimonialBundle:Sonata/Compras/Ordem/CRUD:list__action_anular.html.twig'],
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        /** @var Compras\Ordem $objOrdem */
        $objOrdem = $this->getSubject();


        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $arrTipos = array('Compras' => 'C', 'Serviço' => 'S');

        // Dados Ordem
        $fieldOptions['entidade'] = [
            'label' => 'label.ordem.entidade',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => 'readonly',
            ]
        ];
        $fieldOptions['fornecedor'] = [
            'label' => 'label.ordem.fornecedor',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => 'readonly',
            ]
        ];
        $fieldOptions['observacao'] = [
            'label' => 'label.ordem.observacao'
        ];
        $fieldOptions['incluirAssinatura'] = [
            'label' => 'label.ordem.incluirAssinatura',
            'mapped' => false,
            'required' => false
        ];
        $fieldOptions['incluirAssinaturaUsuario'] = [
            'label' => 'label.ordem.incluirAssinaturaUsuario',
            'mapped' => false,
            'required' => false
        ];

        // Item
        $fieldOptions['item'] = [
            'label' => 'label.ordem.item',
            'mapped' => false,
            'required' => false,
        ];
        $fieldOptions['qtdEmpenho'] = [
            'label' => 'label.ordem.qtdEmpenho',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => [
                'class' => 'quantity '
            ]
        ];
        $fieldOptions['qtdOrdem'] = [
            'label' => 'label.ordem.qtdOrdem',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => [
                'class' => 'quantity '
            ]
        ];
        $fieldOptions['qtdDisponivel'] = [
            'label' => 'label.ordem.qtdDisponivel',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => [
                'class' => 'quantity '
            ]
        ];
        $fieldOptions['valorUnit'] = [
            'label' => 'label.ordem.valorUnit',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];
        $fieldOptions['qtdOrdemAtual'] = [
            'label' => 'label.ordem.qtdOrdemAtual',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => array(
                'class' => 'quantity '
            )
        ];
        $fieldOptions['vlTotal'] = [
            'label' => 'label.ordem.vlTotal',
            'mapped' => false,
            'data' => 0,
            'required' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];
        $fieldOptions['exercicioEmpenho'] = [];

        $fieldOptions['codEntidade'] = [];
        $fieldOptions['numItem'] = [
            'mapped' => false
        ];
        $fieldOptions['codPreEmpenho'] = [
            'mapped' => false
        ];
        $fieldOptions['exercicioPreEmpenho'] = [
            'mapped' => false
        ];

        // Assinaturas
        $fieldOptions['incluirAssinatura'] = [
            'label' => 'label.ordem.incluirAssinatura',
            'required' => false,
            'mapped' => false
        ];
        $fieldOptions['codAssinaturas'] = [
            'route' => ['name' => 'carrega_administracao_assinatura'],
            'req_params' => [
                'codEntidade' => 'varJsCodEntidade'
            ],
            'label' => 'label.ordem.codAssinaturas',
            'multiple' => true,
            'required' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];
        $fieldOptions['incluirAssinaturaUsuario'] = [
            'label' => 'label.ordem.incluirAssinaturaUsuario',
            'required' => false,
            'mapped' => false
        ];


        if (!is_null($id)) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa codEmpenho
            $fieldOptions['codEmpenho'] = [
                'label' => 'label.ordem.codEmpenho',
                'attr' => array(
                    'readonly' => true
                ),
                'data' => (string) $objOrdem->getFkEmpenhoEmpenho()
            ];

            // Processa Tipo
            $fieldOptions['tipo'] = [
                'label' => 'label.ordem.tipo',
                'attr' => array(
                    'readonly' => 'readonly'
                ),
                'data' => $objOrdem->getNomTipo()
            ];

            // Processa numcgmEntrega
            $fieldOptions['numcgmEntrega'] = [
                'label' => 'label.ordem.numcgmEntrega',
                'attr' => array(
                    'readonly' => 'readonly'
                ),
                'data' => $objOrdem->getFkSwCgm()
            ];

            // Dados Ordem
            $fieldOptions['exercicioEmpenho']['data'] = $objOrdem->getFkEmpenhoEmpenho()->getExercicio();
            $fieldOptions['entidade']['data'] = $objOrdem->getCodEntidade() . ' - ' . $objOrdem->getFkEmpenhoEmpenho()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
            $fieldOptions['codEntidade']['data'] = $objOrdem->getFkEmpenhoEmpenho()->getFkOrcamentoEntidade()->getCodEntidade();
            $fieldOptions['numcgmEntrega']['attr'] = array(
                'class' => 'select2-parameters ',
                'readonly' => 'readonly'
            );

            $ordemItem = $objOrdem->getFkComprasOrdemItens()->last();
            $fieldOptions['fornecedor']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()
                    ->getFkSwCgm()->getNumcgm() . ' - ' .
                $ordemItem->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()
                    ->getFkSwCgm()->getNomCgm();

            $fieldOptions['numItem']['data'] = $ordemItem->getNumItem();
            $fieldOptions['codPreEmpenho']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getCodPreEmpenho();
            $fieldOptions['exercicioEmpenho']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getExercicio();
            $fieldOptions['item']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getNomItem();
            $fieldOptions['exercicioPreEmpenho']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getExercicio();
            $fieldOptions['qtdEmpenho']['data'] = $ordemItem->getFkEmpenhoItemPreEmpenho()->getQuantidade();
            $fieldOptions['qtdOrdem']['data'] = $ordemItem->getQuantidade();
            $fieldOptions['qtdDisponivel']['data'] = ($fieldOptions['qtdEmpenho']['data'] - $fieldOptions['qtdOrdem']['data']);
            $fieldOptions['valorUnit']['data'] = number_format(($ordemItem->getFkEmpenhoItemPreEmpenho()->getVlTotal() / $ordemItem->getFkEmpenhoItemPreEmpenho()->getQuantidade()), 2);
            $fieldOptions['qtdOrdemAtual']['data'] = $ordemItem->getQuantidade();
            $fieldOptions['vlTotal']['data'] = $ordemItem->getVlTotal();
        } else {
            $fieldOptions['codEmpenho'] = [
                'route' => ['name' => 'busca_empenho_empenho_ativos'],
                'label' => 'label.ordem.codEmpenho',
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            ];

            $fieldOptions['tipo'] = [
                'choices' => $arrTipos,
                'label' => 'label.ordem.tipo',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'mapped' => false
            ];

            $fieldOptions['numcgmEntrega'] = [
                'route' => ['name' => 'carrega_sw_cgm'],
                'label' => 'label.ordem.numcgmEntrega',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
            ];
        }

        $formMapper
            ->with('label.ordem.dadosOrdem')
            ->add('codEmpenho', ((!is_null($id)) ? 'text' : 'autocomplete'), $fieldOptions['codEmpenho'])
            ->add('codEntidade', 'hidden', $fieldOptions['codEntidade'])
            ->add('entidade', 'text', $fieldOptions['entidade'])
            ->add('exercicioEmpenho', 'hidden', $fieldOptions['exercicioEmpenho'])
            ->add('fornecedor', 'text', $fieldOptions['fornecedor'])
            ->add('observacao', 'text', $fieldOptions['observacao'])
            ->add('numcgmEntrega', ((!is_null($id)) ? 'text' : 'autocomplete'), $fieldOptions['numcgmEntrega'])
            ->add('tipo', ((!is_null($id)) ? 'text' : 'choice'), $fieldOptions['tipo'])
            ->end()
            ->with('label.ordem.itemOrdem')
            ->add('item', 'text', $fieldOptions['item'])
            ->add('numItem', 'hidden', $fieldOptions['numItem'])
            ->add('codPreEmpenho', 'hidden', $fieldOptions['codPreEmpenho'])
            ->add('exercicioPreEmpenho', 'hidden', $fieldOptions['exercicioPreEmpenho'])
            ->add('qtdEmpenho', 'number', $fieldOptions['qtdEmpenho'])
            ->add('qtdOrdem', 'number', $fieldOptions['qtdOrdem'])
            ->add('qtdDisponivel', 'number', $fieldOptions['qtdDisponivel'])
            ->add('valorUnit', 'text', $fieldOptions['valorUnit'])
            ->add('qtdOrdemAtual', 'number', $fieldOptions['qtdOrdemAtual'])
            ->add('vlTotal', 'number', $fieldOptions['vlTotal'])
            ->end();

        $formMapper
            ->with('label.ordem.assinaturas')
            ->add('incluirAssinatura', 'checkbox', $fieldOptions['incluirAssinatura'])
            ->add('codAssinaturas', 'autocomplete', $fieldOptions['codAssinaturas'])
            ->add('incluirAssinaturaUsuario', 'checkbox', $fieldOptions['incluirAssinaturaUsuario'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codOrdem', null, ['label' => 'label.ordem.codOrdem'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.ordem.numcgmEntrega'])
            ->add('exercicio')
            ->add('nomTipo', null, ['label' => 'label.ordem.tipo'])
            ->add('exercicioEmpenho')
            ->add('fkEmpenhoEmpenho', null, ['label' => 'label.ordem.codEmpenho', 'admin_code' => 'financeiro.admin.consultar_empenho'])
            ->add(
                'timestamp',
                'date',
                [
                    'label' => 'label.ordem.dtOrdem',
                    'format' => 'd/m/Y'
                ]
            )
            ->add('observacao');
    }

    /**
     * @param Compras\Ordem $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {

        $exercicio = ($object->getExercicio()) ? $object->getExercicio() : $this->getExercicio();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Setar exercicio
        $object->setExercicio($exercicio);
        // Setar codEmpenho
        $paramsEmpenho = [];
        if ($this->getAdminRequestId()) {
            list($codEmpenho, $exercicioEmpenho) = explode('/', $object->getCodEmpenho());
            $paramsEmpenho['codEmpenho'] = $codEmpenho;
            $paramsEmpenho['exercicio'] = $exercicioEmpenho;
            $paramsEmpenho['codEntidade'] = $object->getFkEmpenhoEmpenho()->getCodEntidade();
        } else {
            list($codEmpenho, $exercicioEmpenho, $codEntidadeEmpenho) = explode('~', $object->getCodEmpenho());
            $paramsEmpenho['codEmpenho'] = $codEmpenho;
            $paramsEmpenho['exercicio'] = $exercicioEmpenho;
            $paramsEmpenho['codEntidade'] = $codEntidadeEmpenho;
        }

        $empenho = $em->getRepository('CoreBundle:Empenho\Empenho')->findOneBy($paramsEmpenho);
        $object->setFkEmpenhoEmpenho($empenho);

        // Setar NumcgmEntrega
        $paramsEntrega = [];
        if ($this->getAdminRequestId()) {
            $NumcgmEntrega = explode(' - ', $object->getNumcgmEntrega());
            $paramsEntrega['numcgm'] = $NumcgmEntrega[0];
        } else {
            $paramsEntrega['numcgm'] = $object->getNumcgmEntrega();
        }

        $cgm = $em->getRepository('CoreBundle:SwCgm')->findOneBy($paramsEntrega);
        $object->setFkSwCgm($cgm);

        // Setar Tipo
        if ($this->getAdminRequestId()) {
            $object->setTipo(($form->get('tipo')->getData() == 'Serviço' ? 'S' : ($form->get('tipo')->getData() == 'Compra' ? 'C' : '')));
        } else {
            $object->setTipo($form->get('tipo')->getData());
            $ordemModel = new OrdemModel($em);
            $codOrdem = $ordemModel->getAvailableIdentifier($object);
            $object->setCodOrdem($codOrdem);
        }

        if ($this->getAdminRequestId()) {
            // Remove OrdemItem
            $ordemItemModel = new OrdemItemModel($em);
            $ordemItem = $object->getFkComprasOrdemItens()->last();
            if (is_object($ordemItem)) {
                $ordemItemModel->remove($ordemItem);
            }
        }

        // Persist OrdemItem
        $ordemItem = new Compras\OrdemItem();
        $ordemItem->setExercicio($exercicio);

        $paramsItemPreEmpenho = [];
        $paramsItemPreEmpenho['codPreEmpenho'] = $form->get('codPreEmpenho')->getData();
        $paramsItemPreEmpenho['exercicio'] = $exercicioEmpenho;
        $paramsItemPreEmpenho['numItem'] = $form->get('numItem')->getData();
        $itemPreEmpenho = $em->getRepository('CoreBundle:Empenho\ItemPreEmpenho')->findOneBy($paramsItemPreEmpenho);

        $ordemItem->setFkEmpenhoItemPreEmpenho($itemPreEmpenho);
        $ordemItem->setFkAlmoxarifadoCentroCusto($itemPreEmpenho->getFkAlmoxarifadoCentroCusto());

        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($em);
        $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca(
            $itemPreEmpenho->getCodItem(),
            $itemPreEmpenho->getCodMarca()
        );

        $ordemItem->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);

        $ordemItem->setQuantidade($form->get('qtdOrdemAtual')->getData());
        $ordemItem->setVlTotal($form->get('vlTotal')->getData());

        $object->addFkComprasOrdemItens($ordemItem);
    }

    /**
     * @param Compras\Ordem $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/compras/ordem/create");
        }
    }

    /**
     * @param Compras\Ordem $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/compras/ordem/{$this->getObjectKey($object)}/edit");
        }
    }

    //  TODO: PostPersist -> Mandar para tela de relatório
}
