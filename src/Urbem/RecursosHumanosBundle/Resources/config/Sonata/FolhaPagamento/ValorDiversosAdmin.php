<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ValorDiversosAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class ValorDiversosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_valores_diversos';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $now = new \DateTime();

        $datagridMapper
            ->add('codValor', null, ['label' => 'label.valoresDiversos.codValor'])
            ->add(
                'dataVigencia',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_date_picker',
                    'label' => 'label.vigencia',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ]
                ],
                'sonata_type_date_picker',
                [
                    'required'        => false,
                    'format'          => 'dd/MM/yyyy',
                    'label'           => 'label.dtVigencia',
                ]
            )
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('valor')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codValor',
                'integer',
                [
                    'label' => 'label.valoresDiversos.codValor'
                ]
            )
            ->add(
                'dataVigencia',
                'date',
                [
                    'label' => 'label.dtVigencia',
                    'pattern' => 'dd MMM y G',
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'valor',
                'integer',
                [
                    'label' => 'Valor'
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $now = new \DateTime();

        $formMapper
            ->with('Valores Diversos')
            ->add(
                'codValor',
                null,
                [
                    'label' => 'label.valoresDiversos.codValor',
                    'attr' => [
                        'autocomplete' => 'off'
                    ]
                ]
            )
            ->add(
                'dataVigencia',
                'datepkpicker',
                [
                    'format' => 'dd/MM/yyyy',
                    'pk_class' => DatePK::class,
                    'required' => true,
                    'label' => 'label.dtVigencia'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'valor',
                'money',
                array(
                    'currency' => 'BRL',
                    'attr' => array(
                        'class' => 'money '
                    ),
                )
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $id]);

        $showMapper
            ->with('Valores Diversos')
            ->add(
                'codValor',
                'integer',
                [
                    "label" => 'Código Valor'
                ]
            )
            ->add(
                'dataVigencia',
                'date',
                [
                    'label' => 'label.dtVigencia',
                    'pattern' => 'dd MMM y G',
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add('valor')
            ->end()
        ;
    }
}
