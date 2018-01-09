<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\Form\Form;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\Compras\Ordem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemBarrasModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoPerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Exception\Error;

class EstoqueMaterialAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_estoque_material';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/estoque-material';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $itemModel = new CatalogoItemModel($entityManager);
        $item = $itemModel->getOneByCodItem($formData['codItem']);

        $catalogoItemMarcaModel = new Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel($entityManager);
        //Insere na Catalogo Item Marca
        $itemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($item, $object->getCodMarca());

        $object->setFkAlmoxarifadoCatalogoItem($itemMarca);
    }

    public function postPersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $itemModel = new CatalogoItemModel($entityManager);
        $item = $itemModel->getOneByCodItem($formData['codItem']);

        $marcaModel = new Model\Patrimonial\Almoxarifado\MarcaModel($entityManager);
        $marca = $marcaModel->getOneByCodMarca($object->getCodMarca());

        $catalogoItemMarcaModel = new Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel($entityManager);
        //Insere na Catalogo Item Marca
        $itemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($item, $marca);

        $ordem = \GuzzleHttp\json_decode($formData['params']);
        if(isset($ordem->ordem)){
            list($exercicio,$codEntidade,$codOrdem,$tipo) = explode("~", $ordem->ordem);
            $ordemObject = $entityManager->getRepository(Ordem::class)
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'tipo' => $tipo,
                    'codEntidade' => $codEntidade,
                    'codOrdem' => $codOrdem,
                ]);

            $fornecedorOrdemModel = new Model\Patrimonial\Compras\NotaFiscalFornecedorOrdemModel($entityManager);
            $fornecedorOrdem = $fornecedorOrdemModel->getOneByOrdem($ordemObject);

            $naturezaLancamento = $fornecedorOrdem->getJoinCgmFornecedor()->getFkAlmoxarifadoNaturezaLancamento();
            $url = '/patrimonial/compras/entrada-compras-ordem/perfil?id='.$ordem->ordem;
        }

        //verificar se o item é perecivel
        if($item->getCodTipo()->getCodTipo()== 2){
            $perecivelModel = new PerecivelModel($entityManager);
            //Insere na Catalogo Item Marca
            $perecivel = $perecivelModel->savePerecivel($object, $formData);

            $lancamentoMaterialModel = new Model\Patrimonial\Almoxarifado\LancamentoMaterialModel($entityManager);
            $lancamentoMaterial = $lancamentoMaterialModel->buildOneBasedLancamentoPerecivel($item, $naturezaLancamento, $formData);

            $lancamentoPerecivelModel = new LancamentoPerecivelModel($entityManager);
            $lancamentoPerecivelModel->saveLancamentoPerecivel($perecivel, $formData, $lancamentoMaterial);
        }

        if(isset($formData['codBarras'])){
            $catalogoItemBarras = new CatalogoItemBarrasModel($entityManager);
            $catalogoItemBarras->findOrCreateCatalogoItemBarras($itemMarca, $formData['codBarras']);
        }

        $message = $this->trans('patrimonial.licitacao.homologacao.success', [], 'flashes');

        $this->redirect($message, 'success', $url);
    }

    public function redirect($message, $type = 'success', $url)
    {

        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect($url);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codItem')
            ->add('codMarca');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codItem')
            ->add('codMarca')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $params = \GuzzleHttp\json_encode($this->getRequest()->query->all());

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $params = \GuzzleHttp\json_decode($formData['params']);
        }else{
            $params = \GuzzleHttp\json_decode($params);
        }

        if ($params->codItem) {
            $catalogoItem = $entityManager
                ->getRepository(CatalogoItem::class)
                ->findBy(['codItem' => $params->codItem]);

            $arrItens = array();
            foreach ($catalogoItem as $item) {
                $arrItens[$item->getCodItem() . ' - ' . $item->getDescricao()] =
                    $item->getCodItem();
            }

            $fieldOptions['codItem'] = [
                'choices' => $arrItens,
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'label' => 'label.cotacaoFornItem.codItem',
                'required' => true
            ];
        }

        $fieldOptions['codAlmoxarifado'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'choice_label' => function ($codAlmoxarifado) {
                return $codAlmoxarifado->getCodAlmoxarifado().' - '.
                $codAlmoxarifado->getCgmAlmoxarifado()->getNumCgm()->getNomCgm();
            },
            'label' => 'label.cotacaoFornItem.codAlmoxarifado',
            'required' => true
        ];
        $fieldOptions['codCentro'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.almoxarifado.codCentro',
            'required' => true
        ];

        $fieldOptions['codMarca'] = [
            'class' => 'CoreBundle:Almoxarifado\Marca',
            'choice_label' => function ($codMarca) {
                return $codMarca->getCodMarca().' - '.
                $codMarca->getDescricao();
            },
            'label' => 'label.cotacaoFornItem.codMarca',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];

        $fieldOptions['codBarras'] = [
            'label' => 'label.cotacaoFornItem.codBarras',
            'mapped' => false
        ];

        $fieldOptions['quantidade'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.quantidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'quantity '
            ),
        ];

        $fieldOptions['valorMercado'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.valorMercado',
            'mapped' => false,
            'attr' => array(
                'class' => 'money '
            ),

        ];
        $fieldOptions['params']['data'] = json_encode($params);
        $fieldOptions['params']['mapped'] = false;

        $fieldOptions['lote'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.lote',
            'mapped' => false,
            'attr' => array(
                'readonly' => 'readonly '
            ),
        ];

        $fieldOptions['dtFabricacao'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.dtFabricacao',
            'mapped' => false,
            'attr' => array(
                'readonly' => 'readonly '
            ),
        ];

        $fieldOptions['dtValidade'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.dtValidade',
            'mapped' => false,
            'attr' => array(
                'readonly' => 'readonly '
            ),
        ];

        $formMapper
            ->with('Almoxarifado Estoque')
            ->add('codAlmoxarifado', null, $fieldOptions['codAlmoxarifado'])
            ->add('codCentro', null, $fieldOptions['codCentro'])
            ->add('codItem', 'choice', $fieldOptions['codItem'])
            ->add('codMarca', 'entity', $fieldOptions['codMarca'])
            ->add('codBarras', 'text', $fieldOptions['codBarras'])
            ->add('quantidade', 'text', $fieldOptions['quantidade'])
            ->add('valorMercado', 'text', $fieldOptions['valorMercado'])
            ->add('params', 'hidden', $fieldOptions['params'])
            ->end()
            ->with('Perecível')
            ->add('lote', 'number', $fieldOptions['lote'])
            ->add('dtFabricacao', 'sonata_type_date_picker', $fieldOptions['dtFabricacao'])
            ->add('dtValidade', 'sonata_type_date_picker', $fieldOptions['dtValidade'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codItem')
            ->add('codMarca');
    }
}
