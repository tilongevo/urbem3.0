<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ReajustesSalariaisReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_reajustes_salariais';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/reajustes-salariais';
    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/ReajusteSalarialReport.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFake')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFake')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions["codTipoNorma"] = [
            'class' => 'CoreBundle:Normas\TipoNorma',
            'choice_label' => 'nom_tipo_norma',
            'label' => 'label.orgao.codTipoNorma',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $formMapper
            ->with('label.processo.Dados para filtro')
                ->add(
                    'tiposCadastros',
                    'choice',
                    ['choices' => [
                        'label.ativos' => 'a',
                        'label.aposentados' => 'o',
                        'label.pensionistas' => 'p',
                    ],
                        'label' => 'label.cadastro',
                        'attr' => ['class' => 'select2-parameters']
                    ]
                )
                ->add(
                    'filtrar',
                    'choice',
                    [
                        'required' => true,
                        'choices' => [
                            'cgm' => 'contrato',
                            'label.matricula' => 'cgm_contrato',
                            'label.lotacao' => 'lotacao',
                            'label.local' => 'local',
                            'label.atributoDinamicoServidor' => 'atributo_servidor',
                            'label.atributoDinamicoPensionista' => 'atributo_pensionista',
                            'label.regime/subdivisao/funcao/especialidade' => 'reg_sub_fun_esp',
                            'label.geral' => 'geral',
                        ],
                        'placeholder' => 'label.selecione',
                        'label' => 'label.filtrar',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'matricula',
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgm',
                        'choice_label' => 'nomCgm',
                        'label' => 'label.cgm',
                        'multiple' => false,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'matriculaCgm',
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgm',
                        'choice_label' => 'numcgm',
                        'label' => 'label.matriculaCgm',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'lotacao',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Folhapagamento\ConfiguracaoEmpenhoLlaLotacao',
                        'choice_label' => 'numcgm',
                        'label' => 'label.lotacao',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'local',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Administracao\Local',
                        'choice_label' => 'nomLocal',
                        'label' => 'label.local',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'atributoDinamicoServidor',
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwAtributoDinamico',
                        'choice_label' => 'nomAtributo',
                        'label' => 'label.atributoDinamicoServidor',
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'atributoDinamicoPensionista',
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwAtributoDinamico',
                        'choice_label' => 'nomAtributo',
                        'label' => 'label.atributoDinamicoPensionista',
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'regime',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Pessoal\Regime',
                        'choice_label' => 'descricao',
                        'label' => 'label.regime',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'subdivisao',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Pessoal\SubDivisao',
                        'choice_label' => 'descricao',
                        'label' => 'label.subdivisao',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'funcao',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Administracao\Funcao',
                        'choice_label' => 'nomFuncao',
                        'label' => 'label.funcao.modulo',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'especialidade',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Pessoal\Especialidade',
                        'choice_label' => 'descricao',
                        'label' => 'label.especialidade.modulo',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
            ->end()

            ->with('label.reajustesalarial.informacoesparareajustar')
                ->add(
                    'valoresReajustar',
                    'choice',
                    ['choices' => [
                        'label.reajustesalarial.padroes' => 'p',
                        'label.reajustesalarial.eventos' => 'e'
                    ],
                        'label' => 'label.reajustesalarial.valoresreajustar',
                        'attr' => ['class' => 'select2-parameters'],
                        'placeholder' => 'label.selecione'
                    ]
                )
                ->add(
                    'tipoCalculo',
                    'choice',
                    ['choices' => [
                        'label.reajustesalarial.complementar' => 'complementar',
                        'label.salario' => 'salario',
                        'label.reajustesalarial.ferias' => 'ferias',
                        'label.reajustesalarial.13salario' => '13salario',
                        'label.reajustesalarial.rescisao' => 'rescisao',
                    ],
                        'label' => 'label.reajustesalarial.tiposcalculo',
                        'attr' => ['class' => 'select2-parameters']
                    ]
                )
                ->add(
                    'evento',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Folhapagamento\Evento',
                        'choice_label' => 'descricao',
                        'label' => 'label.reajustesalarial.evento',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'placeholder' => 'label.selecione',
                    )
                )
                ->add(
                    'padrao',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Folhapagamento\Padrao',
                        'choice_label' => 'descricao',
                        'label' => 'label.reajustesalarial.padrao',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'placeholder' => 'label.selecione',
                    )
                )
                ->add(
                    'tiporeajuste',
                    'choice',
                    ['choices' => [
                        'label.percentual' => 'p',
                        'valor' => 'v'
                    ],
                        'label' => 'label.reajustesalarial.tiporeajuste',
                        'placeholder' => 'label.selecione',
                        'attr' => ['class' => 'select2-parameters']
                    ]
                )
                ->add(
                    'reajustePercentualValor',
                    'percent',
                    [
                        'label' => 'label.reajustesalarial.percentualreajuste'
                    ]
                )
                ->add(
                    'valor',
                    'money',
                    [
                        'label' => 'label.reajustesalarial.valorreajuste',
                        'currency' => 'BRL',
                        'attr' => [
                            'class' => 'money '
                        ]
                    ]
                )
                ->add(
                    'faixaValores',
                    'number',
                    [
                    'label' => 'label.reajustesalarial.fixavaloresareajustarde'
                    ]
                )
//                ->add('faixaValores',
//                    'number',
//                    [
//                        'label' => 'label.ate'
//                    ]
//                )
                ->add(
                    'vigencia',
                    'sonata_type_date_picker',
                    [
                        'format' => 'dd/MM/yyyy',
                        'label' => 'label.vigencia'
                    ]
                )
                ->add(
                    'tipoNorma',
                    'entity',
                    $fieldOptions["codTipoNorma"]
                )
                ->add(
                    'norma',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Normas\Norma',
                        'choice_label' => 'nom_norma',
                        'label' => 'label.orgao.codNorma',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'placeholder' => 'label.selecione',
                    )
                )
                ->add(
                    'observacao',
                    'textarea',
                    [
                        'label' => 'label.observacoes'
                    ]
                )
            ->end()
        ;
    }
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codFake')
        ;
    }
}
