<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Model\Orcamento\PaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoEmpenhoLlaLotacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_empenho_lla_lotacao';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/configuracao-empenho-lla-lotacao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('exercicio')
            ->add('timestamp')
            ->add('numPao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('exercicio')
            ->add('timestamp')
            ->add('numPao')
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
                'codOrgao',
                'entity',
                [
                    'class' => 'CoreBundle:Organograma\Orgao',
                    'choice_label' => 'siglaOrgao',
                    'label' => 'label.lotacao',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ]
                ]
            )
            ->add(
                'numPao',
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\Pao',
                    'choice_label' => 'nom_pao',
                    'label' => 'label.configuracaoEmpenho.numPao',
                    'query_builder' => $this->getListaOrcamentoPao(),
                    'attr' => [
                        'class' => 'select2-parameters'
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
            ->add('id')
            ->add('exercicio')
            ->add('timestamp')
            ->add('numPao')
        ;
    }

    private function getListaOrcamentoPao()
    {
        $now = new \DateTime();
        $exercicio = $now->format('Y');

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Pao');

        $model = new PaoModel($em);
        return $model->getListaOrcamentoPao($exercicio);
    }
}
