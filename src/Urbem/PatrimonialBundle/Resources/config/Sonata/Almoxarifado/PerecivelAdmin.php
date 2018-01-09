<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class PerecivelAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_perecivel';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/perecivel';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('search', 'search/{almoxarifado}/{catalogo_item}/{marca}/{centro_custo}');
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lote')
            ->add('codItem')
            ->add('codMarca')
            ->add('codAlmoxarifado')
            ->add('codCentro')
            ->add('dtFabricacao')
            ->add('dtValidade')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('lote')
            ->add('codItem')
            ->add('codMarca')
            ->add('codAlmoxarifado')
            ->add('codCentro')
            ->add('dtFabricacao')
            ->add('dtValidade')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param Perecivel $object
     */
    public function postRemove($object)
    {
        $this->forceRedirect("/patrimonial/almoxarifado/processar-implantacao/{$this->getObjectKey($object->getFkAlmoxarifadoLancamentoPereciveis()->last()->getFkAlmoxarifadoLancamentoMaterial())}/show");
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lote')
            ->add('codItem')
            ->add('codMarca')
            ->add('codAlmoxarifado')
            ->add('codCentro')
            ->add('dtFabricacao')
            ->add('dtValidade')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('lote')
            ->add('codItem')
            ->add('codMarca')
            ->add('codAlmoxarifado')
            ->add('codCentro')
            ->add('dtFabricacao')
            ->add('dtValidade')
        ;
    }
}
