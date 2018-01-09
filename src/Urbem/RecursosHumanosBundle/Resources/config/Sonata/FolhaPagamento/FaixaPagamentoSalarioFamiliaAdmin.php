<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FaixaPagamentoSalarioFamiliaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_faixa_salario_familia';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/faixa-salario-familia';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFaixa')
            ->add('timestamp')
            ->add('codRegimePrevidencia')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('vlPagamento')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFaixa')
            ->add('timestamp')
            ->add('codRegimePrevidencia')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('vlPagamento')
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
                'vlInicial',
                'money',
                [
                    'label' => 'label.faixaPagamentoSalarioFamilia.valorInicial',
                    'grouping' => true,
                    'currency' => 'BRL',
                    'attr' => ['class' => 'money '],
                ]
            )
            ->add(
                'vlFinal',
                'money',
                [
                    'label' => 'label.faixaPagamentoSalarioFamilia.valorFinal',
                    'grouping' => true,
                    'currency' => 'BRL',
                    'attr' => ['class' => 'money '],
                ]
            )
            ->add(
                'vlPagamento',
                'money',
                [
                    'label' => 'label.faixaPagamentoSalarioFamilia.valorPagamento',
                    'grouping' => true,
                    'currency' => 'BRL',
                    'attr' => ['class' => 'money '],
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
            ->add('codFaixa')
            ->add('timestamp')
            ->add('codRegimePrevidencia')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('vlPagamento')
        ;
    }
}
