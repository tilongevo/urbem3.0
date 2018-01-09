<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class TotaisFolhaEventosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_totais_folha_eventos';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/totais-folha-eventos';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConfiguracao');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codConfiguracao');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        if ($this->getAdminRequestId()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $assentamentoEventos = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos')->findByCodConfiguracaoFolha($id);

            $formMapper->add(
                'codEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_attr' => function ($evento, $key, $index) use ($assentamentoEventos) {

                        foreach ($assentamentoEventos as $assentamentoEvento) {
                            if ($assentamentoEvento->getCodEvento() == $evento) {
                                return ['selected' => 'selected'];
                            }
                        }
                        return ['selected' => false];
                    },
                    'label' => 'Eventos',
                    'multiple' => true,
                    'expanded' => false,
                    'mapped' => false,
                ]
            );
        } else {
            $formMapper->add(
                'codEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'Eventos',
                    'multiple' => true,
                    'expanded' => false,
                ]
            );
        };
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codConfiguracao');
    }
}
