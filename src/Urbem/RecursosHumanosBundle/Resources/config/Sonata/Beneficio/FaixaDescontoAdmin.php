<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class FaixaDescontoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_faixa_desconto';

    protected $baseRoutePattern = 'recursos-humanos/beneficio/faixa-desconto';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(array('create', 'edit'));
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $fieldOptions = [];
        
        $fieldOptions['vlInicial'] = [
            'label' => 'label.valorInicial',
            'grouping' => false,
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL'
        ];
        
        $fieldOptions['vlFinal'] = [
            'label' => 'label.valorFinal',
            'grouping' => false,
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL'
        ];
        
        $fieldOptions['percentualDesconto'] = [
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.percentualDesconto'
        ];
        
        $formMapper
            ->add(
                'vlInicial',
                'money',
                $fieldOptions['vlInicial']
            )
            ->add(
                'vlFinal',
                'money',
                $fieldOptions['vlFinal']
            )
            ->add(
                'percentualDesconto',
                'percent',
                $fieldOptions['percentualDesconto']
            )
        ;
    }
}
