<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel;

class PadraoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_padrao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/padrao';
    protected $model = null;
    protected $includeJs = array(
        '/recursoshumanos/javascripts/folhapagamento/padrao.js',
    );
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codPadrao',
    );
    
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("export");
        $collection->remove("batch");
        $collection->add('get_normas_tipo_norma', 'get-normas-tipo-norma', array(), array(), array(), '', array(), array('POST'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codPadrao',
                null,
                [
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
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
                'codPadrao',
                null,
                [
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
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
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        
        $formOptions = array();
        
        $formOptions['descricao'] = array(
            'label' => 'label.padraoSalario.descricao'
        );
        
        $formOptions['horasMensais'] = array(
            'label' => 'label.padraoSalario.horasMensais'
        );
        
        $formOptions['horasSemanais'] = array(
            'label' => 'label.padraoSalario.horasSemanais'
        );
        
        $formOptions['valor'] = array(
            'label' => 'label.padraoSalario.valor',
            'grouping' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
            'mapped' => false,
        );
        
        $formOptions['codTipoNorma'] = array(
            'label' => 'label.padraoSalario.codTipoNorma',
            'class' => 'CoreBundle:Normas\TipoNorma',
            'choice_label' => function ($tipoNorma) {
                return $tipoNorma->getCodTipoNorma() . " - " . $tipoNorma->getNomTipoNorma();
            },
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'mapped' => false,
        );
        
        $formOptions['codNorma'] = array(
            'label' => 'label.padraoSalario.codNorma',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'mapped' => false,
        );
        
        $formOptions['vigencia'] = array(
            'label' => 'label.padraoSalario.vigencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );
        
        $formOptions['fkFolhapagamentoNivelPadraoNiveis'] = array(
            'by_reference' => false,
            'label' => false
        );
        
        if ($this->id($this->getSubject())) {
            if ($this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()) {
                $formOptions['valor']['data'] = $this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()
                ->getValor();
                
                $formOptions['codTipoNorma']['data'] = $this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()
                ->getFkNormasNorma()
                ->getFkNormasTipoNorma();
                
                $formOptions['codNorma']['choices'] = (new \Urbem\CoreBundle\Model\Normas\NormaModel($entityManager))
                ->findAllNormasPorTipo(
                    $this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()
                    ->getFkNormasNorma()->getCodTipoNorma(),
                    true
                );
                $formOptions['codNorma']['data'] = $this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()
                ->getCodNorma();
                
                $formOptions['vigencia']['data'] = $this->getSubject()->getFkFolhapagamentoPadraoPadroes()->last()
                ->getVigencia();
            }
        }
        
        $formMapper
            ->with('label.padraoSalario.dadosPadrao')
                ->add(
                    'descricao',
                    null,
                    $formOptions['descricao']
                )
                ->add(
                    'horasMensais',
                    null,
                    $formOptions['horasMensais']
                )
                ->add(
                    'horasSemanais',
                    null,
                    $formOptions['horasSemanais']
                )
                ->add(
                    'valor',
                    'money',
                    $formOptions['valor']
                )
                ->add(
                    'codTipoNorma',
                    'entity',
                    $formOptions['codTipoNorma']
                )
                ->add(
                    'codNorma',
                    'choice',
                    $formOptions['codNorma']
                )
                ->add(
                    'vigencia',
                    'sonata_type_date_picker',
                    $formOptions['vigencia']
                )
            ->end()
            ->with('label.padraoSalario.progressao')
                ->add(
                    'fkFolhapagamentoNivelPadraoNiveis',
                    'sonata_type_collection',
                    $formOptions['fkFolhapagamentoNivelPadraoNiveis'],
                    array(
                        'by_reference' => false,
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable'  => 'position'
                    )
                )
            ->end()
        ;
        
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('codNorma')) {
                    $form->remove('codNorma');
                }

                if (isset($data['codNorma']) && $data['codTipoNorma'] != "") {
                    $formOptions['codNorma']['auto_initialize'] = false;
                    $formOptions['codNorma']['choices'] = (new \Urbem\CoreBundle\Model\Normas\NormaModel($entityManager))
                    ->findAllNormasPorTipo(
                        $data['codTipoNorma'],
                        true
                    );
                        
                    $codNorma = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codNorma',
                        'choice',
                        null,
                        $formOptions['codNorma']
                    );

                    $form->add($codNorma);
                }
            }
        );
    }
    
    /**
     * Remonta o relacionamento
     * @param  object $object
     */
    public function saveRelationships($object)
    {
        $this->checkSelectedDeleteInListCollecion(
            $object,
            'fkFolhapagamentoNivelPadraoNiveis',
            'setFkFolhapagamentoPadrao'
        );
    }
    
    /**
     * Prepara o objeto a ser gravado
     * @param  object $object
     */
    public function prePersist($object)
    {
        foreach ($object->getFkFolhapagamentoNivelPadraoNiveis() as $nivelPadraoNivel) {
            $object->removeFkFolhapagamentoNivelPadraoNiveis($nivelPadraoNivel);
        }
        
        $this->saveRelationships($object);
    }
    
    /**
     * Executa ações após a gravação
     * @param  object $object
     */
    public function postPersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $fkNormasNorma = $entityManager->getRepository("CoreBundle:Normas\Norma")
        ->findOneByCodNorma($this->getForm()->get('codNorma')->getData());
        
        $fkFolhapagamentoPadraoPadroes = new \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao();
        $fkFolhapagamentoPadraoPadroes->setFkFolhapagamentoPadrao($object);
        $fkFolhapagamentoPadraoPadroes->setValor($this->getForm()->get('valor')->getData());
        $fkFolhapagamentoPadraoPadroes->setVigencia($this->getForm()->get('vigencia')->getData());
        $fkFolhapagamentoPadraoPadroes->setFkNormasNorma($fkNormasNorma);
        $entityManager->persist($fkFolhapagamentoPadraoPadroes);
        $entityManager->flush();
        
        $object->addFkFolhapagamentoPadraoPadroes($fkFolhapagamentoPadraoPadroes);
        
        $nivelPadraoNiveisForms = $this->getForm()->get('fkFolhapagamentoNivelPadraoNiveis');
        
        foreach ($nivelPadraoNiveisForms as $nivelPadraoNivelForm) {
            $codNivelPadrao = (new \Urbem\CoreBundle\Model\Folhapagamento\NivelPadraoNivelModel($entityManager))
            ->getUltimoNivelPadraoNivel($object->getCodPadrao());
            
            /** NivelPadraoNivel @nivelPadraoNivel **/
            $nivelPadraoNivel = $nivelPadraoNivelForm->getData();
            
            $nivelPadraoNivel->setCodNivelPadrao($codNivelPadrao);
            $nivelPadraoNivel->setFkFolhapagamentoPadrao($object);
            $entityManager->persist($nivelPadraoNivel);
            $entityManager->flush();
        }
    }
    
    public function preUpdate($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        foreach ($this->getForm()->get('fkFolhapagamentoNivelPadraoNiveis') as $nivelPadraoNivelForm) {
            if ($nivelPadraoNivelForm->get('_delete')->getData()) {
                $object->removeFkFolhapagamentoNivelPadraoNiveis($nivelPadraoNivelForm->getData());
                $entityManager->remove($nivelPadraoNivelForm->getData());
            }
        }
        
        foreach ($object->getFkFolhapagamentoNivelPadraoNiveis() as $nivelPadraoNivel) {
            if (null === $nivelPadraoNivel->getCodNivelPadrao()) {
                $codNivelPadrao = (new \Urbem\CoreBundle\Model\Folhapagamento\NivelPadraoNivelModel($entityManager))
                ->getUltimoNivelPadraoNivel($object->getCodPadrao());
                
                $nivelPadraoNivel->setCodNivelPadrao($codNivelPadrao);
                $nivelPadraoNivel->setFkFolhapagamentoPadrao($object);
                $entityManager->persist($nivelPadraoNivel);
                $entityManager->flush();
            }
        }
    }
}
