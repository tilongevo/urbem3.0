<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;

class FolhaPagamentoConfiguracaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao';

    const PARAMETROS = [
        'mascara' => 'mascara_evento',
        'apresentaBase' => 'apresenta_aba_base',
        'mensagemAniversariantes' => 'aniversariantes'
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getDoctrine();

        $configuracaoModel = new ConfiguracaoModel($entityManager);

        $fieldOptions = [];

        $fieldOptions['mascara'] = [
            'label' => 'label.folhaPagamentoConfiguracao.mascara',
            'mapped' => false,
            'data' => $configuracaoModel->pegaConfiguracao(
                self::PARAMETROS['mascara'],
                ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
                $this->getExercicio(),
                true
            )
        ];

        $fieldOptions['apresentaBase'] = [
            'label' => 'label.folhaPagamentoConfiguracao.apresentaBase',
            'mapped' => false,
            'choices' => [
                'sim' => 'true',
                'nao' => 'false',
            ],
            'expanded' => true,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'data' => $configuracaoModel->pegaConfiguracao(
                self::PARAMETROS['apresentaBase'],
                ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
                $this->getExercicio(),
                true
            )
        ];

        $fieldOptions['mensagemAniversariantes'] = [
            'label' => 'label.folhaPagamentoConfiguracao.mensagemAniversariantes',
            'mapped' => false,
            'data' => $configuracaoModel->pegaConfiguracao(
                self::PARAMETROS['mensagemAniversariantes'],
                ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
                $this->getExercicio(),
                true
            )
        ];

        $eventos = $entityManager->getRepository("CoreBundle:Folhapagamento\Evento")
        ->montaRecuperaEventosFormatado();

        if (count($eventos) > 0) {
            $fieldOptions['mascara']['attr']['class'] = 'readonly ';
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add(
                'error',
                $this->trans('label.folhaPagamentoConfiguracao.erroMascara')
            );
        }

        $formMapper
            ->with('label.folhaPagamentoConfiguracao.dadosConfiguracao')
                ->add(
                    'mascara',
                    'text',
                    $fieldOptions['mascara']
                )
                ->add(
                    'apresentaBase',
                    'choice',
                    $fieldOptions['apresentaBase']
                )
            ->end()
            ->with('label.folhaPagamentoConfiguracao.dadosEmissaoContracheque')
                ->add(
                    'mensagemAniversariantes',
                    'textarea',
                    $fieldOptions['mensagemAniversariantes']
                )
            ->end()
        ;
    }
}
