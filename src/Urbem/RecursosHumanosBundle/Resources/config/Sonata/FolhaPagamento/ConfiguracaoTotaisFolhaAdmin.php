<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos;
use Urbem\CoreBundle\Model\Folhapagamento\TotaisFolhaEventosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConfiguracaoTotaisFolhaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_totais_folha';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/totais-folha';

    public function prePersist($object)
    {
        $eventos = $this->getForm()->get('codEvento')->getData();

        $container = $this->getConfigurationPool()->getContainer();
        if ($object->getDescricao() == null) {
            $container->get('session')->getFlashBag()->add('error', 'O campo descrição é obrigatório!');
            (new RedirectResponse($this->generateUrl('create')))->send();
        }
        if (count($eventos) == 0) {
            $container->get('session')->getFlashBag()->add('error', 'O campo eventos é obrigatório!');
            (new RedirectResponse($this->generateUrl('create')))->send();
        }
    }

    public function postPersist($object)
    {
        $eventos = $this->getForm()->get('codEvento')->getData();

        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoTotaisFolha');
        try {
            foreach ($eventos as $key => $folha) {
                $this->salvaConfiguracaoEventosFolha($folha, $object);
            }

            $container->get('session')->getFlashBag()->add('success', 'Configuração adicionada com sucesso');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
        (new RedirectResponse($this->generateUrl('list')))->send();
    }

    public function preUpdate($object)
    {
        $eventos = $this->getForm()->get('codEvento')->getData();

        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoTotaisFolha');
        $emEvento = $this->modelManager->getEntityManager($this->getClass());

        try {
            $this->consultaTotaisFolhaEventos($object->getCodConfiguracao());
            foreach ($eventos as $codEvento) {
                $codEventoObject = $emEvento->getRepository('CoreBundle:Folhapagamento\Evento')->findByCodEvento($codEvento);
                $this->salvaConfiguracaoEventosFolha($codEventoObject[0], $object);
            }
            $container->get('session')->getFlashBag()->add('success', 'Configuração adicionada com sucesso');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
        (new RedirectResponse($this->generateUrl('list')))->send();
    }

    private function consultaTotaisFolhaEventos($id)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos');
        $totaisModel = new TotaisFolhaEventosModel($em);

        $totaisModel->consultaTotaisFolhaEventos($id);
    }

    private function salvaConfiguracaoEventosFolha($evento, $id)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos');
        $totaisModel = new TotaisFolhaEventosModel($em);

        $totais = new TotaisFolhaEventos();
        $totais->setFkFolhapagamentoEvento($evento);
        $totais->setCodConfiguracao($id->getCodConfiguracao());

        $totaisModel->save($totais);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao');
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
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
            ->add(
                'descricao',
                null,
                [
                    'required' => true,
                    'label' => 'label.descricao'
                ]
            );
        if ($this->getAdminRequestId()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $assentamentoEventos = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos')->findByCodConfiguracao($id);
            $eventosList = $em->getRepository('CoreBundle:Folhapagamento\Evento')->findAll(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            $options = [];

            foreach ($assentamentoEventos as $dataEvento) {
                $options[] = $dataEvento->getCodEvento();
            }

            $eventoListConverted = [];
            foreach ($eventosList as $convertData) {
                    $eventoListConverted[$convertData->getDescricao()] = $convertData->getCodEvento();
            }

            $formMapper
                ->add(
                    'codEvento',
                    'choice',
                    [
                        'choices' => $eventoListConverted,
                        'data' => $options,
                        'mapped' => false,
                        'multiple' => true,
                        'attr' => ['class' => 'select2-parameters '],
                        'label' => 'label.recursosHumanos.configuracao.totaisFolha.codEvento'
                    ]
                );
        } else {
            $formMapper->add(
                'codEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'label' => 'label.recursosHumanos.configuracao.totaisFolha.codEvento',
                    'required' => true,
                    'multiple' => true,
                    'expanded' => false,
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            );
        };
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
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            );
    }
}
