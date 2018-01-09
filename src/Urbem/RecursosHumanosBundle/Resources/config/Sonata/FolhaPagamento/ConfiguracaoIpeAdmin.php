<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoIpeModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\FolhaPagamento\ConfiguracaoIpers;

class ConfiguracaoIpeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_ipe';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/ipers';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codConfiguracao',
                null,
                [
                    'label' => 'label.codConfiguracao'
                ]
            )
            ->add(
                'vigencia',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_date_picker',
                    'label' => 'label.vigencia',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ]
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConfiguracao', null, [
                'label' => 'label.codConfiguracao'
            ])
            ->add(
                'vigencia',
                'date',
                [
                    'label' => 'label.vigencia',
                    'format' => 'd/m/Y'
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

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];

        $fieldOptions['atributoMat'] = [
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->where('v.codModulo = 22')
                    ->andWhere('v.codCadastro = 5');
            },
            'choice_label' => function ($atributoMat) {
                return $atributoMat->getCodAtributo() . " - " . $atributoMat->getNomAtributo();
            },
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Número da Matricula IPE/RS',
            'attr' => [
                'class' => 'select2-parameters ',
            ],

        ];

        $fieldOptions['atributoData'] = [
            'class' => AtributoDinamico::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->where('v.codModulo = 22')
                    ->andWhere('v.codCadastro = 5');
            },
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Data de Ingresso'
        ];

        $fieldOptions['atributoPensionistaMat'] = [
            'class' => AtributoDinamico::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->where('v.codModulo = 22')
                    ->andWhere('v.codCadastro = 7');
            },
            'choice_label' => function ($atributoMat) {
                return $atributoMat->getCodAtributo() . " - " . $atributoMat->getNomAtributo();
            },
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Número da Matricula IPE/RS',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'mapped' => false,
        ];

        $fieldOptions['atributoPensionistaData'] = [
            'class' => AtributoDinamico::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('v')
                    ->where('v.codModulo = 22')
                    ->andWhere('v.codCadastro = 7');
            },
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Data de Ingresso',
            'mapped' => false,
        ];

        $fieldOptions['codEventoBase'] = [
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')
                    ->where('e.natureza = :natureza')
                    ->setParameter(':natureza', 'B');
            },
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Evento Base da Remuneração do IPE/RS'
        ];

        $fieldOptions['codEventoAutomatico'] = [
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')
                    ->where('e.natureza = :natureza')->setParameter(':natureza', 'D');
            },
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'required' => true,
            'placeholder' => 'label.selecione',
            'label' => 'Evento Automático de Desconto do IPE/RS'
        ];

        if ($this->id($this->getSubject())) {
            /** @var ConfiguracaoIpe $confIpe */
            $confIpe = $this->getSubject();
            $fieldOptions['codEventoBase']['data'] = $confIpe->getFkFolhapagamentoEvento();
            $fieldOptions['codEventoAutomatico']['data'] = $confIpe->getFkFolhapagamentoEvento1();
            $fieldOptions['atributoPensionistaMat']['data'] = $confIpe->getFkFolhapagamentoConfiguracaoIpePensionista()->getFkAdministracaoAtributoDinamico();
            $fieldOptions['atributoPensionistaData']['data'] = $confIpe->getFkFolhapagamentoConfiguracaoIpePensionista()->getFkAdministracaoAtributoDinamico1();
        }

        $fieldOptions['vigencia'] = [
            'label' => 'Vigência',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'required' => true,
        ];

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $formMapper
            ->with('Atributo Dinâmico Cadastro do Pensionista')
            ->add(
                'codModuloData',
                'entity',
                $fieldOptions['atributoPensionistaMat'],
                ['admin_code' => 'administrativo.admin.atributo_dinamico']
            )
            ->add(
                'codAtributoData',
                'entity',
                $fieldOptions['atributoPensionistaData'],
                ['admin_code' => 'administrativo.admin.atributo_dinamico']
            )
            ->end()
            ->with('Atributo Dinâmico Cadastro do Servidor')
            ->add(
                'fkAdministracaoAtributoDinamico',
                null,
                $fieldOptions['atributoMat'],
                ['admin_code' => 'administrativo.admin.atributo_dinamico']
            )
            ->add(
                'fkAdministracaoAtributoDinamico1',
                null,
                $fieldOptions['atributoData'],
                ['admin_code' => 'administrativo.admin.atributo_dinamico']
            )
            ->end()
            ->with('Dados da Remuneração')
            ->add(
                'fkFolhapagamentoEvento',
                null,
                $fieldOptions['codEventoBase']
            )
            ->add(
                'fkFolhapagamentoEvento1',
                null,
                $fieldOptions['codEventoAutomatico']
            )
            ->end()
            ->with('Dados Gerais')
            ->add(
                'codigoOrgao',
                'number',
                [
                    'required' => true,
                    'label' => 'Código do Órgão',
                    'attr' => [
                        'class' => 'numeric '
                    ]
                ]
            )
            ->add(
                'contribuicaoPat',
                'percent',
                [
                    'required' => true,
                    'label' => '% Percentual de Contribuição Patronal',
                    'attr' => [
                        'class' => 'percent ',
                        'maxlength' => 5
                    ]
                ]
            )
            ->add(
                'contibuicaoServ',
                'percent',
                [
                    'required' => true,
                    'label' => '% Percentual de Contribuição do Servidor',
                    'attr' => [
                        'class' => 'percent ',
                        'maxlength' => 5
                    ]
                ]
            )
            ->add(
                'vigencia',
                'datepkpicker',
                $fieldOptions['vigencia']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $configuracaoIpe = $this->getSubject();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $configIpe = $em->getRepository('CoreBundle:Folhapagamento\\Evento');
        $attrDinamico = $em->getRepository('CoreBundle:Administracao\\AtributoDinamico')->findOneByCodAtributo($configuracaoIpe->getCodAtributoData());
        $fieldOptions['atributoPensionistaData'] = [
            'class' => AtributoDinamico::class,
            'associated_property' => function ($codAtributoData) {
                return $codAtributoData;
            },
            'label' => 'Data de Ingresso Pensionista',
            'admin_code' => 'administrativo.admin.atributo_dinamico'
        ];
        $fieldOptions['atributoPensionistaMat'] = [
            'class' => AtributoDinamico::class,
            'associated_property' => function ($codModuloData) {
                return $codModuloData;
            },
            'label' => 'Número da Matricula IPE/RS Pensionista',
            'admin_code' => 'administrativo.admin.atributo_dinamico'
        ];
        $showMapper
            ->add(
                'vigencia',
                'date',
                [
                    'label' => 'Vigência',
                    'format' => 'd/m/Y'
                ]
            )
            ->add(
                'fkFolhapagamentoConfiguracaoIpePensionista.fkAdministracaoAtributoDinamico',
                'entity',
                $fieldOptions['atributoPensionistaMat']
            )
            ->add(
                'fkFolhapagamentoConfiguracaoIpePensionista.fkAdministracaoAtributoDinamico1',
                'entity',
                $fieldOptions['atributoPensionistaData']
            )
            ->add(
                'fkAdministracaoAtributoDinamico',
                'entity',
                [
                    'class' => 'CoreBundle:Administracao\\AtributoDinamico',
                    'associated_property' => function ($codAtributoData) {
                        return $codAtributoData;
                    },
                    'label' => 'Número da Matricula IPE/RS',
                    'admin_code' => 'administrativo.admin.atributo_dinamico'
                ]
            )
            ->add(
                'fkAdministracaoAtributoDinamico1',
                'entity',
                [
                    'class' => 'CoreBundle:Administracao\\AtributoDinamico',
                    'associated_property' => function ($codAtributoData) {
                        return $codAtributoData;
                    },
                    'label' => 'Data de Ingresso',
                    'admin_code' => 'administrativo.admin.atributo_dinamico'
                ]
            )
            ->add(
                'fkFolhapagamentoEvento',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\\Evento',
                    'associated_property' => function ($codAtributoData) {

                        return $codAtributoData;
                    },
                    'label' => 'Evento Base da Remuneração do IPE/RS ',
                ]
            )
            ->add(
                'fkFolhapagamentoEvento1',
                'entity',
                [
                'class' => 'CoreBundle:Folhapagamento\\Evento',
                'associated_property' => function ($codAtributoData) {

                    return $codAtributoData;
                },
                'label' => 'Evento Automático de Desconto do IPE/RS'
                ]
            )
            ->add(
                'codigoOrgao',
                null,
                ['label' => 'Código do Orgão']
            )
            ->add(
                'contribuicaoPat',
                null,
                ['label' => 'Percentual de Contribuição Patronal']
            )
            ->add(
                'contibuicaoServ',
                null,
                ['label' => 'Percentual de Contribuicao Servidor']
            );
    }

    /**
     * @param ConfiguracaoIpe $configuracaoIpe
     */
    public function prePersist($configuracaoIpe)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $configuracaoIpeModel = new ConfiguracaoIpeModel($em);
        $configuracaoIpe->setCodConfiguracao($configuracaoIpeModel->getNextCodConfiguracao($configuracaoIpe->getVigencia()));
    }

    /**
     * @param ConfiguracaoIpe $configuracaoIpe
     */
    public function preUpdate($configuracaoIpe)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $configuracaoIpeModel = new ConfiguracaoIpeModel($em);
        /** @var ConfiguracaoIpePensionista $pensionista */
        $pensionista = $configuracaoIpe->getFkFolhapagamentoConfiguracaoIpePensionista();
        $configuracaoIpeModel->removeIpePensionista($pensionista->getCodConfiguracao(), $pensionista->getVigencia());
        $this->postPersist($configuracaoIpe);
    }

    /**
     * @param ConfiguracaoIpe $configuracaoIpe
     */
    public function postPersist($configuracaoIpe)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $configuracaoIpeModel = new ConfiguracaoIpeModel($em);
        $form = $this->getForm();
        $configuracaoIpePensionista = new ConfiguracaoIpePensionista();
        $configuracaoIpePensionista->setFkAdministracaoAtributoDinamico($form->get('codModuloData')->getData());
        $configuracaoIpePensionista->setFkAdministracaoAtributoDinamico1($form->get('codAtributoData')->getData());
        $configuracaoIpePensionista->setFkFolhapagamentoConfiguracaoIpe($configuracaoIpe);
        $configuracaoIpeModel->save($configuracaoIpePensionista);
        $configuracaoIpe->setFkFolhapagamentoConfiguracaoIpePensionista($configuracaoIpePensionista);
    }
}
