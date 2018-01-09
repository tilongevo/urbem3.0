<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaModel;

class PrevidenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_previdencia';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/previdencia-custom';

    protected $model = PrevidenciaModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codPrevidencia', null, ['label' => 'label.codPrevidencia'])
            ->add('codVinculo', null, ['label' => 'label.vinculo'])
            ->add('codRegimePrevidencia', null, ['label' => 'label.regimePrevidencia'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->add('codPrevidencia', null, ['label' => 'label.codPrevidencia'])
            ->add('codVinculo', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\Vinculo',
                'choice_label' => 'descricao',
                'label' => 'Vínculo',
            ))
            ->add('codRegimePrevidencia', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\RegimePrevidencia',
                'choice_label' => 'descricao',
                'label' => 'Regime Previdência'
            ))
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();


        $formMapper
            ->add('fkFolhapagamentoVinculo', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\Vinculo',
                'choice_label' => 'descricao',
                'label' => 'Vínculo',
                'attr' => ['class' => 'select2-parameters'],
                'placeholder' => 'label.selecione',
                'required' => 'true'
            ))
            ->add('fkFolhapagamentoRegimePrevidencia', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\RegimePrevidencia',
                'choice_label' => 'descricao',
                'attr' => ['class' => 'select2-parameters'],
                'label' => 'Regime Previdência',
                'placeholder' => 'label.selecione',
                'required' => 'true'
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codPrevidencia', null, ['label' => 'label.codPrevidencia'])
            ->add('codVinculo', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\Vinculo',
                'choice_label' => 'descricao',
                'label' => 'Vínculo'
            ))
            ->add('codRegimePrevidencia', 'entity', array(
                'class' => 'CoreBundle:Folhapagamento\RegimePrevidencia',
                'choice_label' => 'descricao',
                'label' => 'Regime Previdência'
            ))
        ;
    }
}
