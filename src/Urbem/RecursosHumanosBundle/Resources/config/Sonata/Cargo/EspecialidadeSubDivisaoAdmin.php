<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Pessoal;

class EspecialidadeSubDivisaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_especialidade_sub_divisao';

    protected $baseRoutePattern = 'recursos-humanos/cargo/especialidade-sub-divisao';

    protected $model = null;

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
        $formMapper
            ->add('codSubDivisao', 'entity', [
                'class' => 'CoreBundle:Pessoal\SubDivisao',
                'label' => 'label.cargo.subDivisao',
                'choice_label' => function ($codSubDivisao) {
                    $return = $codSubDivisao->getCodRegime()->getDescricao();
                    $return .= '/'.$codSubDivisao->getDescricao();
                    return $return;
                },
                'placeholder' => 'label.selecione',
                'attr' => ['class' => 'select2-parameters ']
            ])
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
