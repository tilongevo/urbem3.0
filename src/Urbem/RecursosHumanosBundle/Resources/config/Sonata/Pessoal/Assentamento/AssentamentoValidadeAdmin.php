<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AssentamentoValidadeAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('timestamp')
            ->add('dtInicial')
            ->add('dtFinal')
            ->add('cancelarDireito')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('timestamp')
            ->add('dtInicial')
            ->add('dtFinal')
            ->add('cancelarDireito')
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dtInicial', 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
                'label' => 'label.dtInicial'
            ])
            ->add('dtFinal', 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
                'label' => 'label.dtFinal',
                'required' => false
            ])
            ->add('cancelarDireito', 'checkbox', [
                'label' => 'label.assentamento.cancelarDireito',
                'required' => false
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('timestamp')
            ->add('dtInicial')
            ->add('dtFinal')
            ->add('cancelarDireito')
        ;
    }
}
