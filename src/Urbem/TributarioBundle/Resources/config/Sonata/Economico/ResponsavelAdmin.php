<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * Class ResponsavelAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class ResponsavelAdmin extends AbstractSonataAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkSwCgm',
                null,
                [
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Economico\Responsavel',
                    'placeholder' => 'label.selecione',
                ]
            )
            ->add('sequencia')
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
        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return sprintf('%s - %s', $object->getNumCgm(), $object->getFkSwCgm()->getNomCgm());
    }
}
