<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\InventarioItensModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\InventarioModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\AlmoxarifadoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class InventarioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class InventarioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_inventario';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/inventario';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/inventario.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'processar_inventario',
            '{id}/processar-inventario'
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $datagridMapperOptions = [];

        $datagridMapperOptions['codAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.inventario.codAlmoxarifado',
            'placeholder' => 'label.selecione',
            'query_builder' => function (AlmoxarifadoRepository $almoxarifadoRepository) use ($entityManager) {
                $inventarioModel = new InventarioModel($entityManager);

                return $inventarioModel->getAlmoxarifadosAlreadyInUse($almoxarifadoRepository);
            }
        ];

        $datagridMapper
            ->add('exercicio', null, ['label' => 'exercicio'])
            ->add('codInventario', null, ['label' => 'label.inventario.codInventario'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.inventario.codAlmoxarifado'], null, $datagridMapperOptions['codAlmoxarifado'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codInventarioExercicio', null, ['label' => 'label.inventario.codInventario'])
            ->add('fkAlmoxarifadoAlmoxarifado', 'text', ['label' => 'label.inventario.codAlmoxarifado'])
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

        $formMapperOptions = [];

        $formMapperOptions['exercicio'] = [
            'attr' => [
                'class' => 'init-readonly '
            ],
            'data' => $this->getExercicio(),
            'label' => 'exercicio',
        ];

        $formMapperOptions['codAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.inventario.codAlmoxarifado',
            'placeholder' => 'label.selecione'
        ];

        $formMapperOptions['observacao'] = [
            'label' => 'label.observacao',
            'required' => false
        ];

        $formMapper
            ->with('label.inventario.dadosDoInventario')
                ->add('exercicio', null, $formMapperOptions['exercicio'])
                ->add('fkAlmoxarifadoAlmoxarifado', null, $formMapperOptions['codAlmoxarifado'])
                ->add('observacao', 'textarea', $formMapperOptions['observacao'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
            ->add('codInventario')
            ->add('dtInventario')
            ->add('observacao')
            ->add('processado')
        ;

        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $inventarioItemModel = new InventarioItensModel($entityManager);

        /**
         * @var Almoxarifado\Inventario $inventario
         */
        $inventario = $this->getObject($id);

        /**
         * @var Almoxarifado\InventarioItens $inventarioItem
         */
        foreach ($inventario->getFkAlmoxarifadoInventarioItens() as $inventarioItem) {
            $catalogoItem = $this->modelManager->find(Almoxarifado\CatalogoItem::class, $inventarioItem->getCodItem());
            $centroCusto = $this->modelManager->find(Almoxarifado\CentroCusto::class, $inventarioItem->getCodCentro());
            $marca = $this->modelManager->find(Almoxarifado\Marca::class, $inventarioItem->getCodMarca());

            $inventarioItem->fkAlmoxarifadoCatalogoItem = $catalogoItem;
            $inventarioItem->fkAlmoxarifadoCentroCusto = $centroCusto;
            $inventarioItem->fkAlmoxarifadoMarca = $marca;

            $inventarioItemModel->getItemSaldo($inventarioItem);
        }
    }

    /**
     * @var Almoxarifado\Inventario $inventario
     */
    public function prePersist($inventario)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $inventarioModel = new InventarioModel($entityManager);
        $inventario = $inventarioModel->applyCodInventario($inventario);
        $inventario->setDtInventario(new \DateTime());

        parent::prePersist($inventario);
    }

    public function redirect(Almoxarifado\Inventario $inventario)
    {
        $this->forceRedirect("/patrimonial/almoxarifado/inventario/{$this->getObjectKey($inventario)}/show");
    }

    /**
     * @param Almoxarifado\Inventario $inventario
     */
    public function postPersist($inventario)
    {
        $this->redirect($inventario);
    }

    /**
     * @param Almoxarifado\Inventario $inventario
     */
    public function postUpdate($inventario)
    {
        $this->redirect($inventario);
    }
}
