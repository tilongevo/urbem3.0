<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Economico;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ResponsavelTecnicoAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numcgm')
            ->add('sequencia')
            ->add('codProfissao')
            ->add('codUf')
            ->add('numRegistro')
            ->add('fkSwCgm.nomCgm');
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numcgm')
            ->add('sequencia')
            ->add('codProfissao')
            ->add('codUf')
            ->add('numRegistro')
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
            ->add('numcgm')
            ->add('sequencia')
            ->add('codProfissao')
            ->add('codUf')
            ->add('numRegistro')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numcgm')
            ->add('sequencia')
            ->add('codProfissao')
            ->add('codUf')
            ->add('numRegistro')
        ;
    }
}
