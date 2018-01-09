<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Divida\Parcela as dividaParcela;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\Pagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use DateInterval;

class BaixaManualDebitoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_baixa_manual_debito';
    protected $baseRoutePattern = 'tributario/arrecadacao/baixa-debitos/baixa-manual';
    protected $includeJs = ['/tributario/javascripts/arrecadacao/baixa-debitos-manual.js', '/core/javascripts/sw-processo.js'];

    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    public $creditosChoices = [
        'label.cgm' => 'cgm',
        'label.imobiliarioImovel.inscricaoImobiliaria' => 'ii',
        'label.economicoCadastroEconomico.modulo' => 'ie',
        'label.baixaDebitos.dividaAtiva' => 'da'
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('carrega_lotes', 'carrega-lotes', array(), array(), array(), '', array(), array('GET'));
        $collection->add('carrega_inscricoes_municipais', 'carrega-inscricoes-municipais', array(), array(), array(), '', array(), array('GET'));
        $collection->add('carrega_cobrancas', 'carrega-cobrancas', array(), array(), array(), '', array(), array('POST'));
        $collection->add('carrega_agencias', 'carrega-agencias', array(), array(), array(), '', array(), array('POST'));
        $collection->add('calcula_valores', 'calcula-valores', array(), array(), array(), '', array(), array('GET'));
        $collection->add('alterar', $this->getRouterIdParameter() . '/edit');
        $collection->add('estornar', $this->getRouterIdParameter() . '/estornar');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');

        if (!$filter) {
            $qb->andWhere('1 = 0');
            return $qb;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $carne = $em->getRepository('CoreBundle:Arrecadacao\Carne');

        $filtered = false;

        if ('cgm' == $filter['creditos']['value'] && !$filtered) {
            $baixaManualDebitos = $carne->getBaixaManualByContribuinte($filter);
            $filtered = true;
        }

        if ('ii' == $filter['creditos']['value'] && !$filtered) {
            $baixaManualDebitos = $carne->getBaixaManualByImobiliario($filter);
            $filtered = true;
        }

        if ('da' == $filter['creditos']['value'] && !$filtered) {
            $baixaManualDebitos = $carne->getBaixaManualByDividaAtiva($filter);
            $filtered = true;
        }

        if ('ie' == $filter['creditos']['value'] && !$filtered) {
            $baixaManualDebitos = $carne->getBaixaManualByEconomico($filter);
            $filtered = true;
        }

        $carnes = ['0'];
        foreach ($baixaManualDebitos as $item) {
            $carnes[] = $item->numeracao .'_'. $item->cod_convenio;
        }

        $qb->Where($qb->expr()->in('concat(o.numeracao,\'_\',o.codConvenio)', $carnes));

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'numeracao',
                null,
                [
                    'label' => 'label.baixaDebitos.numeroCarne'
                ]
            )
            ->add(
                'fkArrecadacaoPagamentos.fkArrecadacaoPagamentoCalculos.calculo.fkArrecadacaoCalculoGrupoCredito.fkArrecadacaoGrupoCredito',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.baixaDebitos.grupoCreditos',
                ),
                'entity',
                [
                    'class' => GrupoCredito::class,
                    'mapped' => false,
                    'choice_value' => function ($grupoCreditos) {
                        if (!empty($grupoCreditos)) {
                            return sprintf('%d~%s', $grupoCreditos->getCodGrupo(), $grupoCreditos->getAnoExercicio());
                        }
                    }

                ]
            )
            ->add(
                'fkMonetarioConvenio.fkMonetarioCreditos',
                'doctrine_orm_choice',
                [
                    'label' => 'label.definirDesoneracao.credito'
                ],
                'entity',
                [
                    'class' => Credito::class,
                    'mapped' => false,
                    'choice_value' => function ($credito) {
                        if (!empty($credito)) {
                            return sprintf(
                                '%d~%d~%d~%d',
                                $credito->getCodCredito(),
                                $credito->getCodNatureza(),
                                $credito->getCodGenero(),
                                $credito->getCodEspecie()
                            );
                        }
                    }

                ]
            )
            ->add(
                'fkArrecadacaoCarneMigracao.numeracaoMigracao',
                null,
                [
                    'label' => 'label.baixaDebitos.carneMigrado'
                ]
            )
            ->add(
                'creditos',
                'doctrine_orm_choice',
                [
                    'label' => 'label.baixaDebitos.creditosReferentes',
                ],
                'choice',
                [
                    'choices' => $this->creditosChoices,
                    'placeholder' => false,
                    'mapped' => false,
                    'expanded' => true,
                    'label_attr' => ['class' => 'checkbox-sonata'],
                    'attr' => [
                        'class' => 'checkbox-sonata js-creditos',
                        'required' => 'required'
                    ]
                ]
            )
            ->add(
                'contribuinte',
                'doctrine_orm_choice',
                [
                    'label' => 'label.arrecadacaoImovelVVenal.contribuinte'
                ],
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'js-contribuinte ',
                    ),
                )
            )
            ->add(
                'codLocalizacao',
                'doctrine_orm_choice',
                [
                    'label' => 'label.imobiliarioLote.localizacao'
                ],
                'entity',
                [
                    'class' => Localizacao::class,
                    'attr' => array(
                        'class' => 'select2-parameters js-localizacao'
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'fkArrecadacaoPagamentos.fkArrecadacaoPagamentoLotes.codLote',
                'doctrine_orm_choice',
                [
                    'mapped' => false,
                    'label' => 'label.imobiliarioLote.lote',
                ],
                'autocomplete',
                [
                    'class' => Lote::class,
                    'attr' => [
                        'class' => 'js-lote'
                    ],
                    'route' => [
                        'name' => 'urbem_tributario_arrecadacao_baixa_manual_debito_carrega_lotes'
                    ],
                    'req_params' => [
                        'codLocalizacao' => 'varJsLocalizacao',
                    ],
                ]
            )
            ->add(
                'inscricaoMunicipal',
                'doctrine_orm_choice',
                [
                    'label' => 'label.baixaDebitos.inscricaoMunicipal',
                ],
                'autocomplete',
                [
                    'class' => Imovel::class,
                    'route' => [
                        'name' => 'urbem_tributario_arrecadacao_baixa_manual_debito_carrega_inscricoes_municipais'
                    ],
                    'req_params' => [
                        'codLote' => 'varJsLote',
                    ],
                    'mapped' => false,
                ]
            )
            ->add(
                'fkArrecadacaoParcela.fkArrecadacaoLancamento.fkArrecadacaoLancamentoCalculos.fkArrecadacaoCalculo.fkArrecadacaoCadastroEconomicoCalculo.fkArrecadacaoCadastroEconomicoFaturamento.fkEconomicoCadastroEconomico',
                'doctrine_orm_choice',
                [
                    'label' => 'label.configuracaoEconomico.inscricaoEconomica',
                ],
                'entity',
                [
                'class' => CadastroEconomico::class,
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('ce');

                        return $qb;
                    },

                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ],
                [
                    'admin_code' => 'tributario.admin.economico_cadastro_economico_autonomo'
                ]
            )
            ->add(
                'cgm',
                'doctrine_orm_choice',
                [
                    'label' => 'label.cgm'
                ],
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'js-cgm ',
                        'required' => 'required'
                    ),
                )
            )
            ->add(
                'parcelamento',
                'doctrine_orm_choice',
                [
                    'label' => 'label.baixaDebitos.cobrancaAno',
                ],
                'choice',
                [
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'mapped' => false,
                ]
            )
            ->add(
                'exercicio',
                null,
                [
                    'label' => 'label.exercicio',
                ],
                null,
                [
                    'attr' => [
                        'required' => 'required'
                    ],
                    'mapped' => false,
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
                'numeracao',
                'customField',
                [
                    'label' => 'label.baixaDebitos.formLabel.numeracao',
                    'template' => 'TributarioBundle::Arrecadacao/BaixaDebitos/BaixaManual/numeracao.html.twig',
                ]
            )
            ->add('fkArrecadacaoCarneMigracao.getNumeracaoMigracao()', null, ['label' => 'label.baixaDebitos.numeracaoMigrada'])
            ->add(
                'nomcgm',
                'customField',
                [
                    'label' => 'label.baixaDebitos.contribuinte',
                    'template' => 'TributarioBundle::Arrecadacao/BaixaDebitos/BaixaManual/nomcgm.html.twig',
                ]
            )
            ->add(
                'inscricaoMunicipal',
                'customField',
                [
                    'label' => 'label.baixaDebitos.inscricaoMunicipal',
                    'template' => 'TributarioBundle::Arrecadacao/BaixaDebitos/BaixaManual/inscricaoMunicipal.html.twig',
                ]
            )
            ->add(
                'origem',
                'customField',
                [
                    'label' => 'label.baixaDebitos.origem',
                    'template' => 'TributarioBundle::Arrecadacao/BaixaDebitos/BaixaManual/origem.html.twig'
                ]
            )
            ->add(
                'parcela',
                'customField',
                [
                    'label' => 'label.baixaDebitos.parcela',
                    'template' => 'TributarioBundle::Arrecadacao/BaixaDebitos/BaixaManual/parcela.html.twig'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'alterar' => ['template' => 'TributarioBundle:Sonata/Arrecadacao/BaixaManual/CRUD:list__action_alterar.html.twig'],
                        'estornar' => ['template' => 'TributarioBundle:Sonata/Arrecadacao/BaixaManual/CRUD:list__action_estornar.html.twig'],
                    ],
                    'header_style' => 'width: 20%'
                ]
            )
        ;
    }

    /**
     *  @param Carne
     *  @return bool
     */
    public function hasEstorno(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $carne)
    {
        if ($carne->getFkArrecadacaoPagamentos()->last() && $carne->getFkArrecadacaoPagamentos()->last()->getDataPagamento()) {
            return true;
        }
        return false;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        list($numeracao,) = explode('~', $id);

        $carne = $this->getSubject();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($carne) {
            $parcela = $em->getRepository(Parcela::class)->findOneByCodParcela($carne->getCodParcela());
            $lancamentoCalculo = $em->getRepository(LancamentoCalculo::class)->findOneByCodLancamento($parcela->getCodLancamento());
            $calculo = $em->getRepository(Calculo::class)->findOneByCodCalculo($lancamentoCalculo->getCodCalculo());
            $calculoCgm = $em->getRepository(CalculoCgm::class)->findOneByCodCalculo($calculo->getCodCalculo());
            $cgm = $em->getRepository(SwCgm::class)->findOneByNumcgm($calculoCgm->getNumcgm());
        }

        $numCgm = $cgm ? $cgm->getNumcgm() : 0;
        $nomCgm = $cgm ? $cgm->getNomcgm() : '';
        $calculo = $calculo ? $calculo->getCodCalculo() : 0;
        $parcela = $parcela ? $parcela->getValor() : 0;

        // Infos Básicas
        $fieldOptions['codClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'required' => false,
            'label' => 'label.imobiliarioLote.classificacao',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'required' => false,
            'label' => 'label.imobiliarioLote.assunto',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['procAdministrativo'] = [
            'label' => 'label.imobiliarioLote.processo',
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'class' => SwProcesso::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'required' => false,
            'query_builder' => function (EntityRepository $entityManager) {
                $qb = $entityManager->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
        ];

        $fieldOptions['tipoPagamento'] = array(
            'label' => 'label.baixaDebitos.formLabel.tipoPagamento',
            'class' => TipoPagamento::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->where('o.codTipo > 1 AND o.pagamento = true')
                    ->orderBy('o.codTipo', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters js-tipoPagamento',
                'required' => true
            )
        );

        $formMapper
            ->with('label.baixaDebitos.dadosBaixaManual')
                ->add(
                    'numeracao',
                    'text',
                    [
                        'label' => 'label.baixaDebitos.formLabel.numeracao',
                        'attr' => [
                            'readonly' => true
                        ]
                    ]
                )
                ->add(
                    'numcgm',
                    'hidden',
                    [
                        'data' => $numCgm,
                        'mapped' => false
                    ]
                )
                ->add(
                    'codCalculo',
                    'hidden',
                    [
                        'data' => $calculo,
                        'mapped' => false
                    ]
                )
                ->add(
                    'fkArrecadacaoParcela.vencimento',
                    'datepkpicker',
                    [
                        'pk_class' => DatePK::class,
                        'attr' => [
                            'readonly' => true
                        ],
                        'format' => 'dd/MM/yyyy',
                        'label' => 'label.baixaDebitos.formLabel.vencimento',
                    ]
                )
                ->add(
                    'fkArrecadacaoParcela.valor',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => true
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.valor',
                        'required' => false,
                        'mapped' => false,
                        'data' => $parcela
                    ]
                )
                ->add(
                    'juro',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => true
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.juro',
                        'mapped' => false,
                        'required' => false
                    ]
                )
                ->add(
                    'multa',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => true
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.multa',
                        'mapped' => false,
                        'required' => false
                    ]
                )
                ->add(
                    'correcao',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => true
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.correcao',
                        'mapped' => false,
                        'required' => false
                    ]
                )
                ->add(
                    'valorCorrigido',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => true
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.valorCorrigido',
                        'mapped' => false,
                        'required' => false
                    ]
                )
                ->add(
                    'contribuinte',
                    'text',
                    [
                        'attr' => [
                            'readonly' => true
                        ],
                        'mapped' => false,
                        'data' => sprintf('%s - %s', $numCgm, $nomCgm),
                        'label' => 'label.baixaDebitos.formLabel.contribuinte'
                    ]
                )
                ->add(
                    'banco',
                    ChoiceType::class,
                    [
                        'attr' => [
                            'class' => 'select2-parameters js-banco'
                        ],
                        'mapped' => false,
                        'choices' => $em->getRepository(Banco::class)->findAll(),
                        'choice_label' => function (Banco $banco) {
                            return "{$banco->getNumBanco()} - {$banco->getNomBanco()}";
                        },
                        'choice_value' => 'codBanco',
                        'placeholder' => 'label.selecione'
                    ]
                )
                ->add(
                    'agencia',
                    ChoiceType::class,
                    [
                        'attr' => [
                            'class' => 'select2-parameters js-agencia '
                        ],
                        'mapped' => false,
                        'choices' => $em->getRepository(Agencia::class)->findAll(),
                        'choice_label' => 'nomAgencia',
                        'choice_value' => 'codAgencia',
                        'label' => 'label.baixaDebitos.formLabel.agencia',
                        'placeholder' => 'label.selecione'
                    ]
                )
                ->add(
                    'dtPagamento',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.baixaDebitos.formLabel.dataPagamento',
                        'required' => true,
                        'mapped' => false,
                        'format' => 'dd/MM/yyyy',
                        'attr' => [
                            'class' => 'js-dtPagamento '
                        ]
                    ]
                )
                ->add(
                    'tipoPagamento',
                    'entity',
                    $fieldOptions['tipoPagamento']
                )
                ->add(
                    'valor',
                    'money',
                    [
                        'attr' => [
                            'class' => 'money js-valor '
                        ],
                        'currency' => 'BRL',
                        'label' => 'label.baixaDebitos.formLabel.valor',
                        'mapped' => false
                    ]
                )
                ->add(
                    'numParcelamento',
                    'hidden',
                    [
                        'attr' => [
                            'class' => 'js-numParcelamento '
                        ],
                        'mapped' => false,
                        'required' => true
                    ]
                )
                ->add(
                    'numParcela',
                    'hidden',
                    [
                        'attr' => [
                            'class' => 'js-numParcela '
                        ],
                        'mapped' => false,
                        'required' => true
                    ]
                )->end()
                ->with('label.baixaDebitos.formLabel.dadosProcesso')
                    ->add('codClassificacao', 'entity', $fieldOptions['codClassificacao'])
                    ->add('codAssunto', 'entity', $fieldOptions['codAssunto'])
                    ->add('codProcesso', 'entity', $fieldOptions['procAdministrativo'])

                ->end()
                ->with(' ')
                ->add(
                    'observacao',
                    'textarea',
                    [
                        'label' => 'label.baixaDebitos.formLabel.observacao',
                        'mapped' => false,
                        'required' => false
                    ]
                )
                ->end()
        ;

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new SwAssuntoModel($em);
        $admin = $this;

        //codAssunto
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.codAssunto',
                            'mapped' => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );
        //codProcesso
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $processoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (strpos($data['codAssunto'], '~')) {
                    list($codAssunto, $codClassificacao) = explode('~', $data['codAssunto']);
                } else {
                    $codAssunto = $data['codAssunto'];
                    $codClassificacao = $data['codClassificacao'];
                }

                if (isset($data['codProcesso']) && $data['codProcesso'] != "") {
                    $processos = $processoModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $processoCompleto = $processo->cod_processo_completo;
                        $processoAssunto = " | " . $processo->nom_assunto;

                        $choiceKey = $processoCompleto . $processoAssunto;
                        $choiceValue = $processo->cod_processo.'~'.$processo->ano_exercicio;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comProcesso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codProcesso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.procAdministrativo',
                            'mapped' => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numeracao')
            ->add('ocorrenciaPagamento')
            ->add('codConvenio')
            ->add('dataPagamento')
            ->add('inconsistente')
            ->add('valor')
            ->add('observacao')
            ->add('codTipo')
            ->add('dataBaixa')
            ->add('numcgm')
        ;
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $numeracao = $object->getNumeracao();
            $ocorrenciaPagamento = 1;
            $codConvenio = $object->getCodConvenio();
            $dtPagamento = $this->getForm()->get('dtPagamento')->getData();
            $inconsistente = false;
            $valor = $this->getForm()->get('valor')->getData();
            $observacao = $this->getForm()->get('observacao')->getData();
            $tipoPagamento = $this->getForm()->get('tipoPagamento')->getData();
            $numcgm = $this->getForm()->get('numcgm')->getData();
            $banco = $this->getForm()->get('banco')->getData();
            $agencia = $this->getForm()->get('agencia')->getData();
            $codCalculo = $this->getForm()->get('codCalculo')->getData();
            $numParcelamento = $this->getForm()->get('numParcelamento')->getData();
            $numParcela = $this->getForm()->get('numParcela')->getData();
            list($codProcesso, $anoExercicio) = explode('~', $this->getForm()->get('codProcesso')->getData());

            // Prepara ProcessoPagamento
            if ($codProcesso) {
                $processo = new ProcessoPagamento();
                $processo->setNumeracao($numeracao);
                $processo->setOcorrenciaPagamento($ocorrenciaPagamento);
                $processo->setCodConvenio($codConvenio);
                $processo->setCodProcesso($codProcesso);
                $processo->setAnoExercicio($anoExercicio);
            }

            // Salva Pagamento
            $pagamento = new Pagamento();
            $pagamento->setOcorrenciaPagamento($ocorrenciaPagamento);
            $pagamento->setDataPagamento($dtPagamento);
            $pagamento->setInconsistente($inconsistente);
            $pagamento->setValor($valor);
            $pagamento->setObservacao($observacao);
            $pagamento->setCodTipo($tipoPagamento->getCodTipo());
            $pagamento->setNumcgm($numcgm);
            $pagamento->setFkArrecadacaoCarne($object);

            if ($codProcesso) {
                $pagamento->addFkArrecadacaoProcessoPagamentos($processo);
            }

            $object->addFkArrecadacaoPagamentos($pagamento);
            $em->persist($pagamento);

            // Salva PagamentoLoteManual
            $pagamentoLoteManual = new PagamentoLoteManual();
            $pagamentoLoteManual->setNumeracao($numeracao);
            $pagamentoLoteManual->setOcorrenciaPagamento($ocorrenciaPagamento);
            $pagamentoLoteManual->setCodConvenio($codConvenio);
            $pagamentoLoteManual->setCodBanco($banco->getCodBanco());
            $pagamentoLoteManual->setCodAgencia($agencia->getCodAgencia());

            $pagamento->addFkArrecadacaoPagamentoLoteManuais($pagamentoLoteManual);

            $parcela = $em->getRepository(dividaParcela::class)->findOneBy(['numParcelamento' => $numParcelamento, 'numParcela' => $numParcela]);

            if (!$parcela) {
                $parcela = new dividaParcela();
                $parcela->setNumParcelamento($numParcelamento);
                $parcela->setNumParcela($numParcela);
            }
            $parcela->setPaga(true);
            $parcela->setCancelada(false);

            // Salva PagamentoCalculo
            $pagamentoCalculo = new PagamentoCalculo();
            $pagamentoCalculo->setCodCalculo($codCalculo);
            $pagamentoCalculo->setNumeracao($numeracao);
            $pagamentoCalculo->setOcorrenciaPagamento($ocorrenciaPagamento);
            $pagamentoCalculo->setCodConvenio($codConvenio);
            $pagamentoCalculo->setValor($valor);

            $pagamento->addFkArrecadacaoPagamentoCalculos($pagamentoCalculo);

            $object->addFkArrecadacaoPagamentos($pagamento);

            $em->persist($object);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.baixaDebitos.msgBaixaManualSucesso', ['%numeracao%' => $numeracao]));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
        $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param ErrorElement $errorElement
     * @param Vigencia $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $dataExpired = ($object->getFkArrecadacaoParcela()->getVencimento() < $this->getForm()->get('dtPagamento')->getData());

        if ($object->getCodConvenio() == -1 && $dataExpired) {
            $em = $this->modelManager->getEntityManager(Configuracao::class);
            $configuracaoModel = new ConfiguracaoModel($em);
            $configuracao = $configuracaoModel->findConfiguracaoByParameters(['baixa_manual_divida_vencida'], $this->getExercicio());
            $qtdDiasVencidos = $configuracao['baixa_manual_divida_vencida'];

            $dataVencimentoFinal = clone $object->getFkArrecadacaoParcela()->getVencimento();
            $dataVencimentoFinal->add(new DateInterval(sprintf('P%dD', $qtdDiasVencidos)));

            // se a data de pagamento for maior que o prazo final
            if ($this->getForm()->get('dtPagamento')->getData() > $dataVencimentoFinal) {
                $error = $this->getTranslator()->trans('label.baixaDebitos.msgErroDtVencida');
                $errorElement->with('dtPagamento')->addViolation($error)->end();
            }
        }

        // se o valor a pagar for menor que o valor do carne
        if (($object->getCodConvenio() == -1) && $this->getForm()->get('valor')->getData() < $this->getForm()->get('valorCorrigido')->getData()) {
            $error = $this->getTranslator()->trans('label.baixaDebitos.msgErroValorMenor');
            $errorElement->with('valor')->addViolation($error)->end();
        }
    }
}
