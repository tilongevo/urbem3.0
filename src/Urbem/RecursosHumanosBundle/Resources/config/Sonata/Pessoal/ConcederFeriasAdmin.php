<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Ferias;
use Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;
use Sonata\AdminBundle\Route\RouteCollection;

class ConcederFeriasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_ferias_conceder';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/ferias/conceder';
    protected $exibirBotaoIncluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('preencher_quant_dias_gozo', 'preencher-quant-dias-gozo/', [], [], [], '', [], ['POST']);
        ;
    }

    /**
     * @return array
     */
    public function getMesCompetencia()
    {
        $entityManager = $this->getEntityManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno <= (int) $this->getExercicio()) {
                if ($mes->getCodMes() >= $inCodMes) {
                    $options[trim($mes->getDescricao())] = $mes->getCodMes();
                }
            }
        }

        return $options;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/ferias/form--filter.js',
        ]));

        $filter = $this->getRequest()->query->get('filter');

        $mes = '';
        if ($filter) {
            if (array_key_exists('value', $filter['mes'])) {
                $mes = $filter['mes']['value'];
            }
        }

        $datagridMapper
            ->add(
                'feriasVencidas',
                'doctrine_orm_callback',
                [
                    'label' => 'label.ferias.feriasVencidas',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter'],
                    'field_type' => 'checkbox'
                ]
            )
            ->add(
                'ano',
                'doctrine_orm_callback',
                [
                    'label' => 'label.ferias.ano',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter'],
                ],
                'number',
                [
                    'attr' => [
                        'value' => $this->getExercicio(),
                        'class' => 'numero '
                    ],
                ]
            )
            ->add(
                'mes',
                'doctrine_orm_callback',
                [
                    'label' => 'label.ferias.mes',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter'],
                ],
                'choice',
                [
                    'placeholder' => 'label.selecione',
                    'choices' => $this->getMesCompetencia(),
                    'attr' => [
                        'data-mes' => $mes,
                    ],
                ]
            )
        ;
    }

    /**
     * @param null|string $dtFinal
     * @return null|array
     */
    public function consultaUltimoPeriodoMovimentacao($dtFinal = null)
    {
        $entityManager = $this->getDoctrine();

        $periodoMovimentacao = null;

        if ($dtFinal) {
            $periodoMovimentacao = $entityManager->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtFinal);
        }

        if (! $periodoMovimentacao) {
            return $entityManager->getRepository(PeriodoMovimentacao::class)
            ->montaRecuperaUltimaMovimentacao();
        }

        return $periodoMovimentacao;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->getDoctrine();

        $query = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');

        if ($filter) {
            $stValoresFiltro = '';
            $boFeriasVencidas = false;
            if (array_key_exists('value', $filter['feriasVencidas'])) {
                $boFeriasVencidas = true;
                $query->andWhere($query->expr()->eq('o.situacao', "'Vencida'"));
            }

            if (array_key_exists('value', $filter['codContrato']) && $filter['codContrato']['value'] != "") {
                $stValoresFiltro = implode(',', $filter['codContrato']['value']);
            }

            if (array_key_exists('value', $filter['lotacao']) && $filter['lotacao']['value'] != "") {
                $stValoresFiltro = implode(',', $filter['lotacao']['value']);
            }

            if (array_key_exists('value', $filter['local']) && $filter['local']['value'] != "") {
                $stValoresFiltro = implode(',', $filter['local']['value']);
            }

            if (array_key_exists('value', $filter['funcao']) && $filter['funcao']['value'] != "") {
                $stValoresFiltro = implode(',', $filter['funcao']['value']);
            }

            $dtFinal = '0/';
            if (array_key_exists('value', $filter['mes']) && $filter['mes']['value'] != "") {
                $dtFinal = $filter['mes']['value'] . "/";
            }

            if (array_key_exists('value', $filter['ano']) && $filter['ano']['value'] != "") {
                $dtFinal .= $filter['ano']['value'];
            }

            $periodoMovimentacao = $this->consultaUltimoPeriodoMovimentacao($dtFinal);

            $contratos = $entityManager->getRepository(Ferias::class)
            ->concederFerias(
                $filter['tipo']['value'],
                $stValoresFiltro,
                $periodoMovimentacao['cod_periodo_movimentacao'],
                $this->getExercicio(),
                'incluir',
                '',
                $boFeriasVencidas
            );

            $arCodContrato = [];
            foreach ($contratos as $contrato) {
                $arCodContrato[] = $contrato->cod_contrato;
            }

            $query->andWhere($query->expr()->in('o.codContrato', array_unique($arCodContrato)));
        } else {
            $query->andWhere('1 = 0');
        }

        return $query;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'create' => array('template' => 'RecursosHumanosBundle:Sonata/Pessoal/Ferias/CRUD:list__concederFerias.html.twig'),
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
                'registro',
                null,
                [
                    'label' => 'label.pessoal.servidor.matricula'
                ]
            )
            ->add(
                'nomCgm',
                null,
                [
                    'label' => 'label.servidor.modulo'
                ]
            )
            ->add(
                'lotacao',
                'text',
                [
                    'label' => 'lotacao',
                ]
            )
            ->add(
                'periodoAquisitivo',
                'text',
                [
                    'label' => 'label.ferias.periodoAquisitivo',
                ]
            )
            ->add(
                'situacao',
                'text',
                [
                    'label' => 'label.ferias.situacao',
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
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getDoctrine();

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/ferias/form--ferias.js',
        ]));

        $request = $this->getRequest();

        $fieldOptions = [];

        $fieldOptions['codContrato'] = [
            'mapped' => false
        ];

        if ($request->query->get('codContrato')) {
            $fieldOptions['dtInicial']['data'] = $request->query->get('codContrato');
        }

        $periodoMovimentacao = $this->consultaUltimoPeriodoMovimentacao();

        $dadosMatricula = $entityManager->getRepository(Ferias::class)
        ->concederFerias(
            'contrato',
            "'{$request->query->get('codContrato')}'",
            $periodoMovimentacao['cod_periodo_movimentacao'],
            $this->getExercicio(),
            'incluir'
        );

        $fieldOptions['dadosMatricula'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::Sonata/Pessoal/Ferias/field__dadosMatricula.html.twig',
            'data' => reset($dadosMatricula)
        ];

        $situacaoFeriasAnterior = $entityManager->getRepository(Ferias::class)->findOneBy(
            ['codContrato' => $request->query->get('codContrato')],
            ['dtFinalAquisitivo' => 'DESC']
        );

        $fieldOptions['situacaoFeriasAnterior'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::Sonata/Pessoal/Ferias/field__situacaoFeriasAnterior.html.twig',
            'data' => $situacaoFeriasAnterior
        ];

        $fieldOptions['dtInicial'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ferias.dtInicial',
            'mapped' => false
        ];

        if ($request->query->get('dtInicial')) {
            $fieldOptions['dtInicial']['data'] = (new \DateTime())->createFromFormat('d/m/Y', $request->query->get('dtInicial'));
        }

        $fieldOptions['dtFinal'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ferias.dtFinal',
            'mapped' => false
        ];

        if ($request->query->get('dtFinal')) {
            $fieldOptions['dtFinal']['data'] = (new \DateTime())->createFromFormat('d/m/Y', $request->query->get('dtFinal'));
        }

        $fieldOptions['faltas'] = [
            'label' => 'label.ferias.faltas',
            'mapped' => false,
            'required' => false,
            'data' => 0
        ];

        $fieldOptions['codForma'] = [
            'class' => FormaPagamentoFerias::class,
            'choice_label' => function ($formaPagamentoFerias) {
                return $this->trans(
                    'label.ferias.codFormaChoiceLabel',
                    [
                        '%codForma%' => $formaPagamentoFerias->getCodForma(),
                        '%dias%' => $formaPagamentoFerias->getDias(),
                        '%abono%' => $formaPagamentoFerias->getAbono(),
                    ]
                );
            },
            'choice_attr' => function ($val, $key, $index) {
                return [
                    'data-dias' => $val->getDias(),
                    'data-abono' => $val->getAbono()
                ];
            },
            'label' => 'label.ferias.codForma',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['diasFerias'] = [
            'label' => 'label.ferias.diasFerias',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['diasAbono'] = [
            'label' => 'label.ferias.diasAbono',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'readonly '
            ]
        ];

        $fieldOptions['dtInicialFerias'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ferias.dtInicialFerias',
            'mapped' => false,
        ];

        $fieldOptions['dtTerminoFerias'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ferias.dtTerminoFerias',
            'mapped' => false,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'readonly '
            ]
        ];

        $fieldOptions['dtRetornoFerias'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ferias.dtRetornoFerias',
            'mapped' => false,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'readonly '
            ]
        ];

        $fieldOptions['ano'] = [
            'label' => 'label.ferias.ano',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        ];

        $fieldOptions['mes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $this->getMesCompetencia(),
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codTipo'] = [
            'class' => TipoFolha::class,
            'choice_label' => 'descricao',
            'label' => 'label.ferias.codTipo',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['pagar13'] = [
            'label' => 'label.ferias.pagar13',
            'mapped' => false,
            'required' => false,
        ];

        $formMapper
            ->with('label.ferias.dadosMatricula')
                ->add(
                    'dadosMatricula',
                    'customField',
                    $fieldOptions['dadosMatricula']
                )
            ->end()
            ->with('label.ferias.situacaoFeriasAnterior')
                ->add(
                    'situacaoFeriasAnterior',
                    'customField',
                    $fieldOptions['situacaoFeriasAnterior']
                )
            ->end()
            ->with('label.ferias.periodoAquisitivo')
                ->add(
                    'codContrato',
                    'hidden',
                    $fieldOptions['codContrato']
                )
                ->add(
                    'dtInicial',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicial']
                )
                ->add(
                    'dtFinal',
                    'sonata_type_date_picker',
                    $fieldOptions['dtFinal']
                )
            ->end()
            ->with('label.ferias.pagamento')
                ->add(
                    'faltas',
                    'text',
                    $fieldOptions['faltas']
                )
                ->add(
                    'codForma',
                    'entity',
                    $fieldOptions['codForma']
                )
                ->add(
                    'diasFerias',
                    'text',
                    $fieldOptions['diasFerias']
                )
                ->add(
                    'diasAbono',
                    'text',
                    $fieldOptions['diasAbono']
                )
                ->add(
                    'dtInicialFerias',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicialFerias']
                )
                ->add(
                    'dtTerminoFerias',
                    'date',
                    $fieldOptions['dtTerminoFerias']
                )
                ->add(
                    'dtRetornoFerias',
                    'date',
                    $fieldOptions['dtRetornoFerias']
                )
                ->add(
                    'ano',
                    'number',
                    $fieldOptions['ano']
                )
                ->add(
                    'mes',
                    'choice',
                    $fieldOptions['mes']
                )
                ->add(
                    'codTipo',
                    'entity',
                    $fieldOptions['codTipo']
                )
                ->add(
                    'pagar13',
                    'checkbox',
                    $fieldOptions['pagar13']
                )
            ->end()
        ;
    }
}
