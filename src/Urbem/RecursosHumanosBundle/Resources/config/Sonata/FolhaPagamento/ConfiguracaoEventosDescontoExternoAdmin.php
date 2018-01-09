<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEventosDescontoExternoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ConfiguracaoEventosDescontoExternoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_eventos_desconto_externo';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao-eventos-desconto-externo';

    protected $customHeader = 'RecursosHumanosBundle:FolhaPagamento:Configuracao/cabecalhoEventoDescontoExterno.html.twig';

    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('delete')
            ->remove('show')
        ;
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

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno');

        $configuracoes = $em->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEventosDescontoExterno')->findAll();

        $this->exibirBotaoIncluir = (count($configuracoes) >= 1) ? false : true;

        $listMapper
            ->add(
                'fkFolhapagamentoEvento2',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'label' => 'Evento Informativo Base de Previdência'
                ]
            )
            ->add(
                'fkFolhapagamentoEvento3',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'label' => 'Evento Informativo Desconto Previdencia'
                ]
            )
            ->add(
                'fkFolhapagamentoEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'label' => 'Evento Informativo Desconto IRRF'
                ]
            )
            ->add(
                'fkFolhapagamentoEvento1',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'label' => 'Evento Informativo Base de IRRF'
                ]
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('Eventos Previdência')
            ->add(
                'fkFolhapagamentoEvento2',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'Evento Informativo Base de Previdência',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'fkFolhapagamentoEvento3',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'Evento Informativo Desconto Previdencia',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->end()
            ->with('Eventos IRRF')
            ->add(
                'fkFolhapagamentoEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'Evento Informativo Desconto IRRF',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'fkFolhapagamentoEvento1',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'Evento Informativo Base de IRRF',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codConfiguracao')
            ->add('timestamp');
    }

    /**
     * @param ConfiguracaoEventosDescontoExterno $configuracaoEventosDescontoExterno
     */
    public function prePersist($configuracaoEventosDescontoExterno)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $configuracaoEventosDescontoExternoModel = new ConfiguracaoEventosDescontoExternoModel($em);

        $configuracaoEventosDescontoExterno->setCodConfiguracao($configuracaoEventosDescontoExternoModel->getNextCodConfiguracao());
    }
}
