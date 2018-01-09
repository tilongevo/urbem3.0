<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Pessoal;

class CargoSubDivisaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_cargo_sub_divisao';

    protected $baseRoutePattern = 'recursos-humanos/cargo/cargo-sub-divisao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('timestamp')
            ->add('nroVagaCriada')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('timestamp')
            ->add('nroVagaCriada')
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

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $totalSubDivisoes = 1;
        if ($this->getSubject() && $this->id($this->getSubject())) {
            $totalSubDivisoes = $entityManager->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();
        }

        $formMapper
            ->add('nroVagaCriada', 'number', [
                'label' => 'label.cargo.nroVagaCriada'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('timestamp')
            ->add('nroVagaCriada')
        ;
    }
}
