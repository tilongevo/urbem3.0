<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\Bases;
use Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BasesAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_bases';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/bases';
    protected $model = Model\Folhapagamento\BasesModel::class;

     /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add(
                'nomBase',
                null,
                array(
                    'label' => 'label.bases.nomBase'
                )
            );
    }
    
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ))
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
                'nomBase',
                null,
                array(
                    'label' => 'label.bases.nomBase'
                )
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
        $valorBaseFin  = '';
        $insAutomatica = '';

        /** @var Bases $bases */
        $bases = $this->getSubject();

        $valorCodEvento = '';
        $eventosAll = '';
        $em = $this->modelManager->getEntityManager($this->getClass());
        $eventoModel = new Model\Folhapagamento\EventoModel($em);
        $codEvento = $eventoModel->getProximoCodigo('cod_evento', 'folhapagamento.evento');
        $eventos = $eventoModel->montaRecuperaEventosFormatado();

        $arrayEventos = array();
        foreach ($eventos as $key => $evento) {
            $chave = str_pad($evento->cod_evento, 5, "0", STR_PAD_LEFT)
            . ' - ' . $evento->descricao
            . ' - ' . $evento->sequencia
            . ' - ' . $evento->fixado
            . ' - ' . $evento->tipo
            . ' - ' . $evento->natureza;
            $arrayEventos[$chave] = $evento->cod_evento;
        }

        $stDescricao = '';
        $eventoSistema = 'false';

        $sequenciaCalculo = new SequenciaCalculoEvento();

        if ($this->id($this->getSubject())) {
            $basesRepository = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\Bases')
            ->findOneByCodBase($id);
            $valorBaseFin = ($basesRepository->getApresentacaoValor()) ? 'true' : 'false';
            $insAutomatica = ($basesRepository->getInsercaoAutomatica()) ? 'true' : 'false';

            $seqCalculo = new Model\Folhapagamento\SequenciaCalculoModel($em);
            $bEventoCriado = $seqCalculo->selectBasesEventoCriado($id);

            $sequenciaCalculo = $this->getDoctrine()
                ->getRepository(SequenciaCalculoEvento::class)
                ->findOneBy([
                    'codEvento' => $bEventoCriado->cod_evento
                ]);

            $eventoRepository = $em->getRepository('CoreBundle:Folhapagamento\Evento')
            ->findOneByCodEvento($bEventoCriado->cod_evento);
            $valorCodEvento = $eventoRepository;

            $stDescricao = $valorCodEvento->getDescricao();
            $codEvento = $valorCodEvento->getCodEvento();
            $eventoSistema = ($valorCodEvento->getEventoSistema())? 'true' : 'false';

            $eventosAll = (new \Urbem\CoreBundle\Model\Folhapagamento\BasesEventoModel($em))
            ->getBasesEventoByCodBase($id);
        }

        $fieldOptions = array();
        
        $fieldOptions['nomBase'] = array(
            'label' => 'label.bases.nomBase'
        );
        
        $fieldOptions['apresentacaoValor'] = array(
            'choices' => array(
                'Sim' => 'true',
                'Não' => 'false',
            ),
            'data' => $valorBaseFin,
            'expanded' => true,
            'multiple' => false,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'label' => 'label.bases.apresentacaoValor'
        );

        $fieldOptions['insercaoAutomatica'] = array(
            'choices' => array(
                'Sim' => 'true',
                'Não' => 'false',
            ),
            'data' => $insAutomatica,
            'expanded' => true,
            'multiple' => false,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'label' => 'label.bases.insercaoAutomatica'
        );

        $fieldOptions['tipoBase'] = array(
            'choices' => array(
                'Valor' => 'V',
                'Quantidade' => 'Q',
            ),
            'expanded' => true,
            'multiple' => false,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'label' => 'label.bases.tipoBase'
        );

        $fieldOptions['codigoEvento'] = array(
            'label' => 'label.bases.codigoEvento',
            'data' => $codEvento,
            'mapped' => false,
            'attr' => array(
                'readonly' => 'true',
            )
        );

        $fieldOptions['descricaoEvento'] = array(
            'label' => 'label.bases.descricaoEvento',
            'data' => $stDescricao,
            'mapped' => false,
        );

        $fieldOptions['eventoSistema'] = array(
            'choices' => array(
                'Sim' => 'true',
                'Não' => 'false'
            ),
            'data' => $eventoSistema,
            'mapped' => false,
            'expanded' => true,
            'multiple' => false,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'label' => 'label.bases.eventoSistema'
        );

        $fieldOptions['codSequencia'] = array(
            'class' => 'CoreBundle:Folhapagamento\SequenciaCalculo',
            'data' => $sequenciaCalculo->getFkFolhapagamentoSequenciaCalculo(),
            'choice_label' => 'descricao',
            'label' => 'label.bases.codSequencia',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );
        
        $formOptions['eventos'] = array(
            'choices' => $arrayEventos,
            'label' => 'label.bases.eventos',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'expanded' => false,
            'multiple' => true
        );
        
        if ($this->id($this->getSubject())) {
            $formOptions['eventos']['data'] = $eventosAll;
            $fieldOptions['nomBase']['attr']['readonly'] = 'readonly';
            $fieldOptions['descricaoEvento']['attr']['readonly'] = 'readonly';
            $fieldOptions['apresentacaoValor']['attr']['disabled'] = 'disabled';
            $fieldOptions['apresentacaoValor']['attr']['class'] = 'disabled';
            $fieldOptions['insercaoAutomatica']['attr']['disabled'] = 'disabled';
            $fieldOptions['tipoBase']['attr']['disabled'] = 'disabled';
            $fieldOptions['eventoSistema']['attr']['disabled'] = 'disabled';
        }
        
        $formMapper
            ->with('label.bases.basesCalculo')
                ->add(
                    'nomBase',
                    null,
                    $fieldOptions['nomBase']
                )
                ->add(
                    'apresentacaoValor',
                    'choice',
                    $fieldOptions['apresentacaoValor']
                )
                ->add(
                    'insercaoAutomatica',
                    'choice',
                    $fieldOptions['insercaoAutomatica']
                )
                ->add(
                    'tipoBase',
                    'choice',
                    $fieldOptions['tipoBase']
                )
            ->end()
            ->with('label.bases.informacoesEventoBaseCalculo')
                ->add(
                    'codigoEvento',
                    'text',
                    $fieldOptions['codigoEvento']
                )
                ->add(
                    'descricaoEvento',
                    'text',
                    $fieldOptions['descricaoEvento']
                )
                ->add(
                    'eventoSistema',
                    'choice',
                    $fieldOptions['eventoSistema']
                )
                ->add(
                    'codSequencia',
                    'entity',
                    $fieldOptions['codSequencia']
                )
            ->end()
            ->with('label.bases.listaEventosCalculoBase')
                ->add(
                    'eventos',
                    'choice',
                    $formOptions['eventos']
                )
            ->end()
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codBase')
            ->add('nomBase')
            ->add('tipoBase')
            ->add('apresentacaoValor')
            ->add('insercaoAutomatica')
           ;
    }

    public function prePersist($object)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        
        $basesEvento = new Model\Folhapagamento\BasesModel($entityManager);
        if (! $basesEvento->saveBases($object, $this->getLogger())) {
            $this->getConfigurationPool()->getContainer()->get('session')
            ->getFlashBag()->add('error', $this->trans('contactSupport'));
            (new RedirectResponse($this->generateUrl('list')))->send();
        }
    }

    public function preUpdate($object)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $basesEvento = new Model\Folhapagamento\BasesModel($entityManager);
        $basesEvento->beforeUpdateBases($object);
    }

    public function postPersist($object)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $base = $this->getRequest()->request->get($this->getUniqid());
        
        $basesEvento = new Model\Folhapagamento\BasesModel($entityManager);
        if (! $basesEvento->afterSaveBases($object, $base, $this->getLogger())) {
            $this->getConfigurationPool()->getContainer()->get('session')
            ->getFlashBag()->add('error', $this->trans('contactSupport'));
            (new RedirectResponse($this->generateUrl('list')))->send();
        }
    }

    /**
     * @param Bases $object
     */
    public function postUpdate($object)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $form = $this->getForm();

        $basesEvento = new Model\Folhapagamento\BasesModel($entityManager);
        if (! $basesEvento->afterUpdateBases($object, $form, $this->getLogger())) {
            $this->getConfigurationPool()->getContainer()->get('session')
            ->getFlashBag()->add('error', $this->trans('contactSupport'));
            (new RedirectResponse($this->generateUrl('list')))->send();
        }
    }
}
