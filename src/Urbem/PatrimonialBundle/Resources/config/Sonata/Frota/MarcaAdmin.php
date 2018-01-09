<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class MarcaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_marca';

    protected $baseRoutePattern = 'patrimonial/frota/marca';

    protected $model = Model\Patrimonial\Frota\MarcaModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomMarca', null, ['label' => 'label.marcaVeiculo.nomMarca'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codMarca', 'number', ['label' => 'label.codigo', 'sortable' => false])
            ->add('nomMarca', 'text', ['label' => 'label.marcaVeiculo.nomMarca', 'sortable' => false])
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

        $formMapper
            ->with('label.marcaVeiculo.modulo')
            ->add('nomMarca', null, ['label' => 'label.marcaVeiculo.nomMarca'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codMarca', null, ['label' => 'label.codigo'])
            ->add('nomMarca', null, ['label' => 'label.marcaVeiculo.nomMarca'])
        ;
    }
}
