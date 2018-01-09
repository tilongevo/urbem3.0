<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FgtsCategoriaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_fgts_categoria';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/fgts-categoria';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create','edit'));
    }
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions['fkPessoalCategoria'] = [
            'label' => 'label.fgts.categoria',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];

        $fieldOptions['aliquotaDeposito'] = [
            'label' => 'label.fgts.aliquotaDeposito',
            'required' => true,
            'attr' => array(
                'class' => 'percent ',
                'maxlength' => 6
            ),
        ];

        $fieldOptions['aliquotaContribuicao'] = [
            'label' => 'label.fgts.aliquotaContribuicao',
            'required' => true,
            'attr' => array(
                'class' => 'percent ',
                'maxlength' => 6
            ),
        ];

        $formMapper
            ->add('fkPessoalCategoria', null, $fieldOptions['fkPessoalCategoria'])
            ->add('aliquotaDeposito', null, $fieldOptions['aliquotaDeposito'])
            ->add('aliquotaContribuicao', null, $fieldOptions['aliquotaContribuicao'])
        ;
    }
}
