<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NotaLiquidacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_nota_liquidacao';
    protected $baseRoutePattern = 'financeiro/empenho/nota-liquidacao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('codNota')
            ->add('codEntidade')
            ->add('exercicioEmpenho')
            ->add('codEmpenho')
            ->add('dtVencimento')
            ->add('dtLiquidacao')
            ->add('observacao')
            ->add('hora')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('codNota')
            ->add('codEntidade')
            ->add('exercicioEmpenho')
            ->add('codEmpenho')
            ->add('dtVencimento')
            ->add('dtLiquidacao')
            ->add('observacao')
            ->add('hora')
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
            ->add('exercicio')
            ->add('codNota')
            ->add('codEntidade')
            ->add('exercicioEmpenho')
            ->add('codEmpenho')
            ->add('dtVencimento')
            ->add('dtLiquidacao')
            ->add('observacao')
            ->add('hora')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codNota')
            ->add('codEntidade')
            ->add('exercicioEmpenho')
            ->add('codEmpenho')
            ->add('dtVencimento')
            ->add('dtLiquidacao')
            ->add('observacao')
            ->add('hora')
        ;
    }
}
