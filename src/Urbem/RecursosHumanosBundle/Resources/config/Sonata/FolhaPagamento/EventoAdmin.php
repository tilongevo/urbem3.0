<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\VerbaRescisoriaMte;
use Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class EventoAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class EventoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_evento';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/evento';

    protected $exibirBotaoExcluir = false;

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/evento.js'
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(['list','show','edit','create'])
            ->add('consultar_descricao_sequencia_calculo', 'consultar-descricao-sequencia-calculo', array(), array(), array(), '', array(), array('POST'))
            ->add('carrega_texto_complementar', 'carrega-texto-complementar', array(), array(), array(), '', array(), array('POST','GET'))
            ->add('carrega_configuracao_contrato_manutencao', 'carrega-configuracao-contrato-manutencao', array(), array(), array(), '', array(), array('POST','GET'))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codigo',
                null,
                [
                    'label' => 'label.descricao'
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
     * @inheritdoc
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
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
                'codigo',
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
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $customFieldGenericTemplate = 'CoreBundle::Sonata/Form/field__generic_ajax.html.twig';

        $codigo = (new EventoModel($entityManager))
        ->getProximoCodigo('codigo', 'folhapagamento.evento');

        $fieldOptions = [];

        $fieldOptions['codigo'] = [
            'label' => 'label.codigo',
            'data' => str_pad($codigo, 5, '0', STR_PAD_LEFT)
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao'
        ];

        $fieldOptions['natureza'] = [
            'label' => 'label.evento.natureza',
            'required' => false,
            'choices' => [
                'label.evento.naturezaChoices.provento' => 'P',
                'label.evento.naturezaChoices.desconto' => 'D',
                'label.evento.naturezaChoices.informativo' => 'I',
                'label.evento.naturezaChoices.base' => 'B',
            ],
            'expanded' => true,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'data' => 'P',
            'placeholder' => false,
        ];

        $fieldOptions['apresentarContracheque'] = [
            'label' => 'label.evento.apresentarContracheque',
            'choices' => [
                'nao' => false,
                'sim' => true,
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'expanded' => true,
            'required' => false,
        ];

        $fieldOptions['tipo'] = [
            'label' => 'label.evento.tipo',
            'choices' => [
                'label.evento.tipoChoices.fixo' => 'F',
                'label.evento.tipoChoices.variavel' => 'V',
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'data' => 'F',
            'expanded' => true,
        ];

        $fieldOptions['fixado'] = [
            'label' => 'label.evento.fixado',
            'choices' => [
                'label.evento.fixadoChoices.valor' =>  'V',
                'label.evento.fixadoChoices.quantidade' => 'Q'
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'data' => 'V',
            'expanded' => true,
        ];

        $fieldOptions['valorQuantidade'] = [
            'label' => 'label.evento.valorQuantidade',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['unidadeQuantitativa'] = [
            'label' => 'label.evento.unidadeQuantitativa',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['limiteCalculo'] = [
            'label' => 'label.evento.limiteCalculo',
            'choices' => [
                'nao' => false,
                'sim' => true,
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'expanded' => true,
            'required' => false,
        ];

        $fieldOptions['apresentaParcela'] = [
            'label' => 'label.evento.apresentaParcela',
            'choices' => [
                'nao' => false,
                'sim' => true,
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'expanded' => true,
            'required' => false,
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.evento.observacao',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['eventoSistema'] = [
            'label' => 'label.evento.eventoSistema',
            'choices' => [
                'nao' => false,
                'sim' => true,
            ],
            'placeholder' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'expanded' => true,
            'required' => false,
        ];

        $fieldOptions['fkFolhapagamentoVerbaRescisoriaMte'] = [
            'class' => VerbaRescisoriaMte::class,
            'label' => 'label.evento.fkFolhapagamentoVerbaRescisoriaMte',
            'choice_label' => function ($verbaRescisoriaMte) {
                return $verbaRescisoriaMte->getCodVerba()
                . " - "
                . $verbaRescisoriaMte->getNomVerba();
            },
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->orderBy('v.nomVerba', 'ASC');
            },
        ];

        $fieldOptions['sigla'] = [
            'label' => 'label.evento.sigla',
            'attr' => ['maxlength' => 5],
            'required' => false
        ];

        $fieldOptions['codSequencia'] = [
            'class' => SequenciaCalculo::class,
            'label' => 'label.numero',
            'choice_label' => 'sequencia',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                ->orderBy('s.sequencia', 'ASC');
            },
            'mapped' => false
        ];

        $fieldOptions['stSequenciaDescricao'] = [
            'label' => false,
            'mapped' => false,
            'template' => $customFieldGenericTemplate,
            'data' => [
                'label' => 'label.descricao'
            ]
        ];

        $fieldOptions['stSequenciaComplemento'] = [
            'label' => false,
            'mapped' => false,
            'template' => $customFieldGenericTemplate,
            'data' => [
                'label' => 'label.complemento',
            ]
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codigo']['disabled'] = true;
            $fieldOptions['descricao']['disabled'] = true;
            $fieldOptions['natureza']['disabled'] = true;
            $fieldOptions['tipo']['disabled'] = true;
            $fieldOptions['fixado']['disabled'] = true;
            $fieldOptions['eventoSistema']['disabled'] = true;
            $fieldOptions['apresentarContracheque']['disabled'] = true;
            $fieldOptions['limiteCalculo']['disabled'] = true;
            $fieldOptions['apresentaParcela']['disabled'] = true;

            $fieldOptions['natureza']['data'] = $this->getSubject()->getNatureza();
            $fieldOptions['tipo']['data'] = $this->getSubject()->getTipo();
            $fieldOptions['fixado']['data'] = $this->getSubject()->getFixado();

            $eventoEvento = $this->getSubject()->getFkFolhapagamentoEventoEventos();
            if (! $eventoEvento->isEmpty()) {
                $fieldOptions['valorQuantidade']['data'] = $eventoEvento->last()->getValorQuantidade();
                $fieldOptions['unidadeQuantitativa']['data'] = $eventoEvento->last()->getUnidadeQuantitativa();
                $fieldOptions['observacao']['data'] = $eventoEvento->last()->getObservacao();
            }

            $fieldOptions['codSequencia']['data'] = $this->getSubject()->getFkFolhapagamentoSequenciaCalculoEventos()
            ->last()->getFkFolhapagamentoSequenciaCalculo();
        }

        $formMapper
            ->with('label.evento.dadosEvento')
                ->add(
                    'codigo',
                    'text',
                    $fieldOptions['codigo']
                )
                ->add(
                    'descricao',
                    'text',
                    $fieldOptions['descricao']
                )
                ->add(
                    'natureza',
                    'choice',
                    $fieldOptions['natureza']
                )
                ->add(
                    'apresentarContracheque',
                    'choice',
                    $fieldOptions['apresentarContracheque']
                )
                ->add(
                    'tipo',
                    'choice',
                    $fieldOptions['tipo']
                )
                ->add(
                    'fixado',
                    'choice',
                    $fieldOptions['fixado']
                )
                ->add(
                    'valorQuantidade',
                    'number',
                    $fieldOptions['valorQuantidade']
                )
                ->add(
                    'unidadeQuantitativa',
                    'number',
                    $fieldOptions['unidadeQuantitativa']
                )
                ->add(
                    'limiteCalculo',
                    'choice',
                    $fieldOptions['limiteCalculo']
                )
                ->add(
                    'apresentaParcela',
                    'choice',
                    $fieldOptions['apresentaParcela']
                )
                ->add(
                    'observacao',
                    'textarea',
                    $fieldOptions['observacao']
                )
                ->add(
                    'eventoSistema',
                    'choice',
                    $fieldOptions['eventoSistema']
                )
                ->add(
                    'fkFolhapagamentoVerbaRescisoriaMte',
                    'entity',
                    $fieldOptions['fkFolhapagamentoVerbaRescisoriaMte']
                )
                ->add(
                    'sigla',
                    'text',
                    $fieldOptions['sigla']
                )
            ->end()
            ->with('label.evento.sequenciaCalculo')
                ->add(
                    'codSequencia',
                    'entity',
                    $fieldOptions['codSequencia']
                )
                ->add(
                    'stSequenciaDescricao',
                    'customField',
                    $fieldOptions['stSequenciaDescricao']
                )
                ->add(
                    'stSequenciaComplemento',
                    'customField',
                    $fieldOptions['stSequenciaComplemento']
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
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codigo')
            ->add('descricao')
            ->add('natureza')
            ->add('tipo')
            ->add('fixado')
            ->add('limiteCalculo')
            ->add('apresentaParcela')
            ->add('eventoSistema')
            ->add('sigla')
            ->add('apresentarContracheque')
            ->add('codVerba')
        ;
    }

    /**
     * @param Urbem\CoreBundle\Entity\Folhapagamento\Evento $object
     */
    public function postPersist($object)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $eventoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento;
        $eventoEvento->setObservacao($this->getForm()->get('observacao')->getData());
        $eventoEvento->setValorQuantidade($this->getForm()->get('valorQuantidade')->getData());
        $eventoEvento->setUnidadeQuantitativa($this->getForm()->get('unidadeQuantitativa')->getData());
        $eventoEvento->setFkFolhapagamentoEvento($object);

        $sequenciaCalculoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento;
        $sequenciaCalculoEvento->setFkFolhapagamentoSequenciaCalculo($this->getForm()->get('codSequencia')->getData());
        $sequenciaCalculoEvento->setFkFolhapagamentoEvento($object);

        $entityManager->persist($eventoEvento);
        $entityManager->persist($sequenciaCalculoEvento);

        $entityManager->flush();
    }

    /**
     * @param Urbem\CoreBundle\Entity\Folhapagamento\Evento $object
     */
    public function postUpdate($object)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $eventoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento;
        $eventoEvento->setObservacao($this->getForm()->get('observacao')->getData());
        $eventoEvento->setValorQuantidade($this->getForm()->get('valorQuantidade')->getData());
        $eventoEvento->setUnidadeQuantitativa($this->getForm()->get('unidadeQuantitativa')->getData());
        $eventoEvento->setFkFolhapagamentoEvento($object);

        $sequenciaCalculoEvento = $object->getFkFolhapagamentoSequenciaCalculoEventos()->last();
        $sequenciaCalculoEvento->setFkFolhapagamentoSequenciaCalculo($this->getForm()->get('codSequencia')->getData());
        $sequenciaCalculoEvento->setFkFolhapagamentoEvento($object);

        $entityManager->persist($eventoEvento);
        $entityManager->persist($sequenciaCalculoEvento);

        $entityManager->flush();
    }
}
