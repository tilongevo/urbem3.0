<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Patrimonio;

class ReavaliacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_reavaliacao';

    protected $baseRoutePattern = 'patrimonial/patrimonio/reavaliacao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codReavaliacao')
            ->add('dtReavaliacao')
            ->add('vidaUtil')
            ->add('vlReavaliacao')
            ->add('motivo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codReavaliacao')
            ->add('dtReavaliacao')
            ->add('vidaUtil')
            ->add('vlReavaliacao')
            ->add('motivo')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'dtReavaliacao',
                'sonata_type_date_picker',
                [
                    'label' => 'label.reavaliacao.dtReavaliacao',
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'vidaUtil',
                'number',
                [
                    'label' => 'label.reavaliacao.vidaUtil'
                ]
            )
            ->add(
                'vlReavaliacao',
                'number',
                [
                    'label' => 'label.reavaliacao.vlReavaliacao',
                    'attr' => array(
                        'class' => 'money '
                    )
                ]
            )
            ->add(
                'motivo',
                'text',
                [
                    'label' => 'label.reavaliacao.motivo',
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
            ->add('codReavaliacao')
            ->add('dtReavaliacao')
            ->add('vidaUtil')
            ->add('vlReavaliacao')
            ->add('motivo')
        ;
    }
}
