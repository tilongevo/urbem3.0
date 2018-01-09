<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OrdemPagamentoAnuladaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_ordem_pagamento_anulada';
    protected $baseRoutePattern = 'financeiro/empenho/ordem-pagamento/anulada';
    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'create']);
    }

    public function createQuery($context = 'list')
    {
        $codOrdem = $this->getRequest()->query->get('codOrdem');
        $exercicio = $this->getRequest()->query->get('exercicio');
        $codEntidade = $this->getRequest()->query->get('codEntidade');

        $query = parent::createQuery($context);
        $query->where('o.codOrdem = :codOrdem');
        $query->andWhere('o.exercicio = :exercicio');
        $query->andWhere('o.codEntidade = :codEntidade');
        $query->setParameters([
            'codOrdem' => $codOrdem,
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade
        ]);
        $query->orderBy('codOrdem', 'DESC');
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEntidade', null, [
                'label' => 'label.ordemPagamento.codEntidade'
            ])
            ->add('getCodOrdemComposto', null, [
                'label' => 'label.ordemPagamento.nrop'
            ])

            ->add('getDtAnulacao', null, [
                'label' => 'label.ordemPagamento.dtAnulacao',
            ])
            ->add('getCredor', null, [
                'label' => 'label.ordemPagamento.credor',
            ])
            ->add('getVlAnulacao', 'currency', [
                'label' => 'label.ordemPagamento.valor',
                'currency' => 'BRL'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'print' => array('template' => 'FinanceiroBundle:Sonata/Empenho/OrdemPagamento/CRUD:list__action_reemitir.html.twig')
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
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('timestamp')
            ->add('motivo')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('timestamp')
            ->add('motivo')
        ;
    }
}
