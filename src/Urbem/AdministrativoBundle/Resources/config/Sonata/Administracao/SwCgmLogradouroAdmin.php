<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SwCgmLogradouroAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codLogradouro')
            ->add('cep')
            ->add('codBairro')
            ->add('codMunicipio')
            ->add('codUf')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codLogradouro')
            ->add('cep')
            ->add('codBairro')
            ->add('codMunicipio')
            ->add('codUf')
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
            ->add('codLogradouro')
            ->add('cep')
            ->add('codBairro')
            ->add('codMunicipio')
            ->add('codUf')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codLogradouro')
            ->add('cep')
            ->add('codBairro')
            ->add('codMunicipio')
            ->add('codUf')
        ;
    }
}
