<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CustoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_custo';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/custo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCusto')
            ->add('inicioVigencia')
            ->add('valor')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codCusto')
            ->add('inicioVigencia')
            ->add(
                'valor'
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('inicioVigencia', 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
                'label' => 'label.valetransporte.inicioVigencia',
                'required' => true
            ])
            ->add('valor', 'number', [
                'label' => 'label.valetransporte.valor',
                'attr' => [
                    'class' => 'money '
                ],
                'required' => true
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codCusto')
            ->add('inicioVigencia')
            ->add('valor')
        ;
    }
}
