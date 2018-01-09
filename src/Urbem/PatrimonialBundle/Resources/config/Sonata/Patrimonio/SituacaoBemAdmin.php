<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class SituacaoBemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_situacao';

    protected $baseRoutePattern = 'patrimonial/patrimonio/situacao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codSituacao',
                null,
                [
                    'label' => 'Código da situação'
                ]
            )
            ->add(
                'nomSituacao',
                null,
                [
                    'label' => 'Descrição da situação'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codSituacao', 'number', ['label' => 'Código da situação', 'sortable' => false])
            ->add('nomSituacao', 'text', ['label' => 'Descrição da situação', 'sortable' => false])
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
            ->add(
                'nomSituacao',
                null,
                [
                    'label' => 'Descrição da situação'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'codSituacao',
                null,
                [
                    'label' => 'Código da situação'
                ]
            )
            ->add(
                'nomSituacao',
                null,
                [
                    'label' => 'Descrição da situação'
                ]
            )
        ;
    }
}
