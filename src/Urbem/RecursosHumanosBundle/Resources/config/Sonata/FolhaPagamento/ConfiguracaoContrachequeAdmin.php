<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\RecursosHumanosBundle\Helper\Constants\Folhapagamento\ConfiguracaoContracheque;
use Sonata\CoreBundle\Validator\ErrorElement;

/**
 * Class ConfiguracaoContracheque
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class ConfiguracaoContrachequeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao-contracheque';

    /**
     * Retorna a lista de valores para o campo 'nomCampo'
     * @return array
     */
    public function getNomCampoChoices()
    {
        $choices = [];

        foreach (ConfiguracaoContracheque::CAMPOS as $campo) {
            $choices['label.configuracaoContracheque.choices.' . $campo] = $campo;
        }
        asort($choices);
        return $choices;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomCampo',
                null,
                [
                    'label' => 'label.configuracaoContracheque.nomCampo'
                ],
                'choice',
                [
                    'choices' => $this->getNomCampoChoices()
                ]
            )
            ->add('linha')
            ->add('coluna')
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
                'nomCampoDescricao',
                'trans',
                [
                    'label' => 'label.configuracaoContracheque.nomCampo'
                ]
            )
            ->add('coluna')
            ->add('linha')
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

        $fieldOptions = [];

        $fieldOptions['nomCampo'] = [
            'label' => 'label.configuracaoContracheque.nomCampo',
            'choices' => $this->getNomCampoChoices(),
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $formMapper
            ->add(
                'nomCampo',
                'choice',
                $fieldOptions['nomCampo']
            )
            ->add(
                'coluna',
                'number'
            )
            ->add(
                'linha',
                'number'
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add(
                'nomCampoDescricao',
                'trans',
                [
                    'label' => 'label.configuracaoContracheque.nomCampo'
                ]
            )
            ->add('coluna')
            ->add('linha')
        ;
    }

    /**
     * @inheritdoc
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();

        $linha = $this->getForm()->get('linha')->getData();

        if (($linha % ConfiguracaoContracheque::MULTIPLE) !== 0) {
            $errorElement->with('linha')->addViolation(
                $this->trans('label.configuracaoContracheque.validacao.linha')
            )->end();
        }
    }

    /**
     * @inheritdoc
     */
    public function toString($object)
    {
        return $this->trans('label.configuracaoContracheque.choices.' . $object->getNomCampo());
    }
}
