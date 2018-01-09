<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NivelAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_nivel';
    protected $baseRoutePattern = 'administrativo/organograma/nivel';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codNivel')
            ->add('descricao')
            ->add('mascaracodigo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codNivel')
            ->add('descricao')
            ->add('mascaracodigo')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('mascaracodigo', null, [
                'label' => 'label.organograma.mascaracodigo',
                'attr' => [
                    'maxlength' => 5
                ]
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codNivel')
            ->add('descricao')
            ->add('mascaracodigo')
        ;
    }
}
