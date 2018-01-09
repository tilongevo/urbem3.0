<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoFornecedorItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaCotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Compras;

class CotacaoFornecedorItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_cotacao_fornecedor_item';

    protected $baseRoutePattern = 'patrimonial/compras/cotacao-fornecedor-item';

    protected $exibirBotaoIncluir = false;

    protected $includeJs = [
        '/patrimonial/javascripts/compras/cotacao-fornecedor-item.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_item_info',
            'get-item-info/'
        );
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $route = $this->getRequest()->get('_sonata_name');
        if (sprintf("%s_create", $this->baseRouteName) == $route) {
            $em = $this->modelManager
                ->getEntityManager($this->getClass());

            $exercicioCotacao = $this->getForm()->get('exercicioCotacao')->getData();
            $codCotacao = $this->getForm()->get('codCotacao')->getData();

            $cotacaoModel = new CotacaoModel($em);
            /** @var Compras\Cotacao $cotacao */
            $cotacao = $cotacaoModel->getCotacao($codCotacao, $exercicioCotacao);

            $item = $this->getForm()->get('fkComprasCotacaoItem')->getData();

            $fornecedorData = $this->getForm()->get('fkComprasFornecedor')->getData();

            $fornecedorModel = new FornecedorModel($em);
            /** @var Compras\Fornecedor $fornecedor */
            $fornecedor = $fornecedorModel->getFornecedor($fornecedorData);

            /** @var FornecedorModel $catacaoFornecedorItemModel */
            $cotacaoFornecedorItemModel = new CotacaoFornecedorItemModel($em);
            $findFornecedorItem = $cotacaoFornecedorItemModel->findExists(
                $cotacao->getExercicio(),
                $cotacao->getCodCotacao(),
                $fornecedor->getCgmFornecedor(),
                $item
            );

            if (!is_null($findFornecedorItem)) {
                $message = $this->trans('cotacao.errors.fornecedorItem.fornecedorRepetido', [], 'validators');
                $errorElement->with('fkComprasFornecedor')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $codCotacao = $this->getRequest()->get('codCotacao');
        $exercicioCotacao = $this->getRequest()->get('exercicioCotacao');

        $formData = $this->getRequest()->request->get($this->getUniqid());
        if (!$this->getRequest()->isMethod('GET')) { // post
            $codCotacao = $formData['codCotacao'];
            $exercicioCotacao = $formData['exercicioCotacao'];
        }

        $fieldOptions['codCotacao'] = [
            'data' => $codCotacao,
            'mapped' => false,
        ];

        $fieldOptions['exercicioCotacao'] = [
            'data' => $exercicioCotacao,
            'mapped' => false,
        ];

        $fieldOptions['qtdItem'] = [
            'label' => 'label.cotacaoFornItem.qtdItem',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'quantity ',
                'readonly' => 'readonly',
            ]
        ];

        $fieldOptions['vlReferencia'] = [
            'label' => 'label.cotacaoFornItem.vlReferencia',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly',
            ]
        ];

        $fieldOptions['dtValidade'] = [
            'label' => 'label.cotacaoFornItem.dtValidade',
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['codMarca'] = [
            'class' => 'CoreBundle:Almoxarifado\Marca',
            'choice_label' => function ($codMarca) {
                return $codMarca->getCodMarca() . ' - ' .
                    $codMarca->getDescricao();
            },
            'label' => 'label.cotacaoFornItem.codMarca',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];

        $fieldOptions['vlUnit'] = [
            'label' => 'label.cotacaoFornItem.vlUnit',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['vlCotacao'] = [
            'label' => 'label.cotacaoFornItem.vlCotacao',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['cgmFornecedor'] = [
            'class' => 'CoreBundle:Compras\Fornecedor',
            'choice_label' => function ($cgmFornecedor) {
                return $cgmFornecedor->getFkSwCgm()->getNumcgm() . ' - ' .
                    $cgmFornecedor->getFkSwCgm()->getNomCgm();
            },
            'label' => 'label.cotacaoFornItem.cgmFornecedor',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione...'
        ];

        $fornecedorModel = new FornecedorModel($entityManager);
        $fornecedores = $fornecedorModel->getFornecedoresAtivos();
        $cgmFornecedor = [];
        foreach ($fornecedores as $fornecedor) {
            $cgmFornecedor[] = $fornecedor->cgm_fornecedor;
        }
        $cgmFornecedor = (empty($cgmFornecedor)) ? 0 : $cgmFornecedor;

        $fieldOptions['cgmFornecedor'] = [
            'class' => Compras\Fornecedor::class,
            'query_builder' => function (EntityRepository $repo) use ($cgmFornecedor) {
                return $repo->createQueryBuilder('o');
                $repo->add('where', $repo->expr()->in('o.cgmFornecedor', $cgmFornecedor));
            },
            'label' => 'label.cotacaoFornItem.cgmFornecedor',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione...'
        ];

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        if ($this->id($this->getSubject())) {
            $fieldOptions['codItem'] = [
                'label' => 'label.cotacaoFornItem.codItem',
                'mapped' => false,
                'attr' => array(
                    'readonly' => 'readonly'
                ),
                'data' => $this->getSubject()->getFkComprasCotacaoItem()->getFkAlmoxarifadoCatalogoItem()->getCodItem() . ' - ' . $this->getSubject()->getFkComprasCotacaoItem()->getFkAlmoxarifadoCatalogoItem()->getDescricao()
            ];
            $marcaEscolhida = $this->getSubject()->getFkAlmoxarifadoCatalogoItemMarca()->getCodMarca();

            $fieldOptions['codMarca'] = [
                'class' => 'CoreBundle:Almoxarifado\Marca',
                'choice_label' => function ($codMarca) {
                    return $codMarca->getCodMarca() . ' - ' .
                        $codMarca->getDescricao();
                },
                'label' => 'label.cotacaoFornItem.codMarca',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'choice_attr' => function ($codMarca, $key, $index) use ($marcaEscolhida) {
                    if ($index == $marcaEscolhida) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                }
            ];

            $fieldOptions['cgmFornecedor'] = [
                'label' => 'label.cotacaoFornItem.cgmFornecedor',
                'mapped' => false,
                'attr' => array(
                    'readonly' => 'readonly'
                ),
                'data' => $this->getSubject()->getFkComprasFornecedor()->getFkSwCgm()->getNumcgm() . ' - ' .
                    $this->getSubject()->getFkComprasFornecedor()->getFkSwCgm()->getNomCgm()
            ];
            $fieldOptions['qtdItem']['data'] = $this->getSubject()->getFkComprasCotacaoItem()->getQuantidade();

            /** @var  $mapaCotacao Compras\MapaCotacao */
            $mapaCotacao = $entityManager
                ->getRepository(Compras\MapaCotacao::class)
                ->findOneBy(['codCotacao' => $this->getSubject()->getCodCotacao(), 'exercicioCotacao' => $this->getSubject()->getExercicio()]);
            $mapaItem = $entityManager
                ->getRepository(Compras\MapaItem::class)
                ->findBy([
                    'exercicio' => $mapaCotacao->getExercicioMapa(),
                    'codMapa' => $mapaCotacao->getCodMapa(),
                    'codItem' => $this->getSubject()->getCodItem(),
                    'lote' => $this->getSubject()->getLote()

                ]);
            $fieldOptions['vlReferencia']['data'] = $mapaItem[0]->getVlTotal() / $mapaItem[0]->getQuantidade();

            $fieldOptions['vlUnit']['data'] = $this->getSubject()->getVlCotacao() / $this->getSubject()->getFkComprasCotacaoItem()->getQuantidade();

            $fieldOptions['codCotacao']['data'] = $this->getSubject()->getCodCotacao();

            $fieldOptions['exercicioCotacao']['data'] = $this->getSubject()->getExercicio();
        } else {
            /** @var  $mapaCotacao Compras\MapaCotacao */
            $mapaCotacao = $entityManager
                ->getRepository(Compras\MapaCotacao::class)
                ->findOneBy(['codCotacao' => $codCotacao, 'exercicioCotacao' => $exercicioCotacao]);
            $mapaItem = $entityManager
                ->getRepository(Compras\MapaItem::class)
                ->findBy([
                    'exercicio' => $mapaCotacao->getExercicioMapa(),
                    'codMapa' => $mapaCotacao->getCodMapa()
                ]);
            $arrItens = array();
            foreach ($mapaItem as $item) {
                $arrItens[$item->getFkComprasSolicitacaoItem()->getFkAlmoxarifadoCatalogoItem()->getCodItem() . ' - ' . $item->getFkComprasSolicitacaoItem()->getFkAlmoxarifadoCatalogoItem()->getDescricao()] =
                    $item->getFkComprasSolicitacaoItem()->getFkAlmoxarifadoCatalogoItem()->getCodItem();
            }

            $fieldOptions['codItem'] = [
                'choices' => $arrItens,
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'label' => 'label.cotacaoFornItem.codItem',
                'mapped' => false,
                'placeholder' => 'Selecione...',
            ];

            $fieldOptions['codMarca'] = [
                'class' => 'CoreBundle:Almoxarifado\Marca',
                'choice_label' => function ($codMarca) {
                    return $codMarca->getCodMarca() . ' - ' .
                        $codMarca->getDescricao();
                },
                'label' => 'label.cotacaoFornItem.codMarca',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
            ];
        }

        $formMapper
            ->add(
                'fkComprasCotacaoItem',
                ($this->id($this->getSubject()) ? 'text' : 'choice'),
                $fieldOptions['codItem']
            )
            ->add(
                'fkComprasFornecedor',
                ($this->id($this->getSubject()) ? 'text' : 'entity'),
                $fieldOptions['cgmFornecedor'],
                ['admin_code' => 'core.admin.filter.fornecedor']
            )
            ->add(
                'codCotacao',
                'hidden',
                $fieldOptions['codCotacao']
            )
            ->add(
                'exercicioCotacao',
                'hidden',
                $fieldOptions['exercicioCotacao']
            )
            ->add(
                'qtdItem',
                'number',
                $fieldOptions['qtdItem']
            )
            ->add(
                'vlReferencia',
                'number',
                $fieldOptions['vlReferencia']
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                $fieldOptions['dtValidade']
            )
            ->add(
                'codMarca',
                'entity',
                $fieldOptions['codMarca']
            )
            ->add(
                'vlUnit',
                'number',
                $fieldOptions['vlUnit']
            )
            ->add(
                'vlCotacao',
                'number',
                $fieldOptions['vlCotacao']
            );
    }

    /**
     * @param Compras\CotacaoFornecedorItem $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codCotacao = (!is_null($object->getCodCotacao())) ?  $object->getCodCotacao() : $form->get('codCotacao')->getData();
        $exercicioCotacao = (!is_null($object->getExercicio())) ?  $object->getExercicio() : $form->get('exercicioCotacao')->getData();
        $qtdItem = $form->get('qtdItem')->getData();
        $route = $this->getRequest()->get('_sonata_name');


        $cotacaoModel = new CotacaoModel($em);
        $cotacao = $cotacaoModel->getCotacao($codCotacao, $exercicioCotacao);

        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($em);

        if (sprintf("%s_create", $this->baseRouteName) == $route) {
            $item = $form->get('fkComprasCotacaoItem')->getData();
        } else {
            $item = $object->getFkComprasCotacaoItem()->getFkAlmoxarifadoCatalogoItem();
        }
        $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($item, $object->getCodMarca()->getCodMarca());
        $object->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);

        $catalogoItemModel = new CatalogoItemModel($em);
        $catalogoItem = $catalogoItemModel->getOneByCodItem($item);

        $mapaCotacaoModel = new MapaCotacaoModel($em);
        $mapaCotacao = $mapaCotacaoModel->getOneMapaCotacaoByCodCotacaoAndExercicioCotacao($codCotacao, $exercicioCotacao);

        $mapaItemModel = new MapaItemModel($em);
        $mapaItem = $mapaItemModel->getOneMapaItem($mapaCotacao->getCodMapa(), $mapaCotacao->getExercicioMapa());

        /** @var CotacaoItemModel $cotacaoItemModel */
        $cotacaoItemModel = new CotacaoItemModel($em);
        $findOrCreateCotacaoItem = $cotacaoItemModel->findOrCreateCotacaoItem(
            $exercicioCotacao,
            $cotacao,
            $mapaItem->getLote(),
            $catalogoItem,
            $qtdItem
        );

        $object->setFkComprasCotacaoItem($findOrCreateCotacaoItem);
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    public function preUpdate($object)
    {

        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('CoreBundle:Compras\Fornecedor');
            $this->saveRelationships($object, $this->getForm());
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    public function redirect($object)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Compras\MapaCotacao');
        $mapaCotacao = $em->getRepository('CoreBundle:Compras\MapaCotacao')->findOneBy([
            'codCotacao' => $this->getForm()->get('codCotacao')->getData(),
            'exercicioCotacao' => $this->getForm()->get('exercicioCotacao')->getData()
        ]);

        $compraDireta = implode('~', $this->getDoctrine()->getClassMetadata('CoreBundle:Compras\CompraDireta')
            ->getIdentifierValues($mapaCotacao->getFkComprasMapa()->getFkComprasCompraDiretas()->last()));

        $this->forceRedirect("/patrimonial/compras/manutencao-proposta/" . $compraDireta . "/show");
    }

    public function postPersist($object)
    {
        $this->redirect($object, $this->trans('patrimonial.cotacaoFornecedorItem.persist', [], 'flashes'));
    }

    public function postUpdate($object)
    {
        $this->redirect($object, $this->trans('patrimonial.cotacaoFornecedorItem.update', [], 'flashes'));
    }

    public function preRemove($object)
    {
        $this->redirect($object, $this->trans('patrimonial.cotacaoFornecedorItem.delete', [], 'flashes'));
    }
}
