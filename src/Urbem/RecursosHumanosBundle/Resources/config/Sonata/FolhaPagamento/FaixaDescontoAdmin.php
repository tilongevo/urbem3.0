<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FaixaDescontoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_faixa_desconto';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/faixa-desconto';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('timestampPrevidencia')
            ->add('valorInicial')
            ->add('valorFinal')
            ->add('percentualDesconto')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('timestampPrevidencia')
            ->add('valorInicial')
            ->add('valorFinal')
            ->add('percentualDesconto')
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
                'valorInicial',
                'money',
                [
                    'attr' => [
                        'class' => 'money '
                    ],
                    'currency' => 'BRL',
                    'label' => 'label.valorInicial'
                ]
            )
            ->add(
                'valorFinal',
                'money',
                [
                    'attr' => [
                        'class' => 'money '
                    ],
                    'currency' => 'BRL',
                    'label' => 'label.valorFinal'
                ]
            )
            ->add(
                'percentualDesconto',
                'number',
                [
                    'attr' => [
                        'class' => 'percent '
                    ]
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('timestampPrevidencia')
            ->add('valorInicial')
            ->add('valorFinal')
            ->add('percentualDesconto')
        ;
    }
}
