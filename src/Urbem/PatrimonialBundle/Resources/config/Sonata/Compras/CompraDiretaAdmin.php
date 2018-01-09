<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaProcessoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwClassificacaoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity;

class CompraDiretaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_compra_direta';
    protected $baseRoutePattern = 'patrimonial/compras/compra-direta';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = true;

    protected $includeJs = [
        '/patrimonial/javascripts/compras/compra-direta.js',
        '/core/javascripts/sw-processo.js',
    ];

    /**
     * Lista Customizada
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicioEntidade = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }
        return $query;
    }

    /**
     * Retorna se é possivel anular Compra Direta
     *
     * @param Compras\CompraDireta $compraDireta
     * @return bool
     */
    public function anulacaoIsAvailable(Compras\CompraDireta $compraDireta)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $compraDiretaModel = new CompraDiretaModel($entityManager);
        $queryBuilder = $compraDiretaModel->getAutorizacoesAndJulgamentos($compraDireta);

        if (!is_null($queryBuilder)) {
            $results = $queryBuilder->getQuery()->getResult();

            if (count($results) > 0) {
                $compraDireta->autorizacoesAndJulgamentos = $results;

                return false;
            }
        }

        return true;
    }

    /**
     * @param Compras\CompraDireta $compraDireta
     */
    public function prePersist($compraDireta)
    {
        $formData = $this->getForm();
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var CompraDiretaModel $compraDiretaModel */
        $compraDiretaModel = new CompraDiretaModel($entityManager);

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);

        $numeracaoAutomatica = $configuracaoModel->getConfiguracao('numeracao_automatica', ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, true, $this->getExercicio());
        if ($numeracaoAutomatica == 'true') {
            $compraDireta->setCodCompraDireta($compraDiretaModel->getNextCodCompraDireta(
                $compraDireta->getCodEntidade(),
                $compraDireta->getExercicioEntidade(),
                $compraDireta->getCodModalidade()
            ));
        }

        $codProcesso = $formData->get('codProcesso')->getData();
        list($codProcesso, $anoProcesso) = explode("~", $codProcesso);

        if (!is_null($codProcesso)) {
            /** @var CompraDiretaProcessoModel $compraDiretaProcessoModel */
            $compraDiretaProcessoModel = new CompraDiretaProcessoModel($entityManager);
            /** @var SwProcesso $swProcesso */
            $swProcesso = $entityManager->getRepository(Entity\SwProcesso::class)->findOneBy(
                [
                    'codProcesso' => $codProcesso,
                    'anoExercicio' => $anoProcesso
                ]
            );

            $compraDiretaProcessoModel->buildOneEqualCompraDireta($compraDireta, $swProcesso);
        }
    }

    /**
     * @param Compras\CompraDireta $compraDireta
     */
    public function preUpdate($compraDireta)
    {
        $formData = $this->getForm();

        $codProcesso = $formData->get('codProcesso')->getData();
        // Verifica se o campo codProcesso foi preenchido.
        if (!is_null($codProcesso)) {
            list($codProcesso, $anoProcesso) = explode("~", $codProcesso);

            /** @var EntityManager $entityManager */
            $entityManager = $this->modelManager->getEntityManager($this->getClass());

            /** @var CompraDiretaProcessoModel $compraDiretaProcessoModel */
            $compraDiretaProcessoModel = new CompraDiretaProcessoModel($entityManager);
            /** @var SwProcesso $swProcesso */
            $swProcesso = $entityManager->getRepository(Entity\SwProcesso::class)->findOneBy(
                [
                    'codProcesso' => $codProcesso,
                    'anoExercicio' => $anoProcesso
                ]
            );
            $compraDireta = $compraDiretaProcessoModel->buildOneEqualCompraDireta($compraDireta, $swProcesso);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param Compras\CompraDireta $compraDireta
     */
    public function validate(ErrorElement $errorElement, $compraDireta)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager(Compras\CompraDireta::class);
        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);

        $route = $this->getRequest()->get('_sonata_name');
        if (sprintf("%s_create", $this->baseRouteName) == $route) {
            $numeracaoAutomatica = $configuracaoModel->getConfiguracao('numeracao_automatica', ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, true, $this->getExercicio());
            if ($numeracaoAutomatica == 'false') {
                $compra = $entityManager->getRepository(Compras\CompraDireta::class)->findOneBy(
                    [
                        'codCompraDireta' => $compraDireta->getCodCompraDireta(),
                        'codEntidade' => $compraDireta->getCodEntidade(),
                        'exercicioEntidade' => $compraDireta->getExercicioEntidade(),
                        'codModalidade' => $compraDireta->getCodModalidade()
                    ]
                );

                if (!is_null($compra)) {
                    $message = $this->trans('compra_direta.errors.codCompraDiretaJaUtilizado', [], 'validators');
                    $errorElement->with('codCompraDireta')->addViolation($message)->end();
                }
            }
        }

        if ($compraDireta->getDtValidadeProposta()->format('YYYY-mm-dd') < $compraDireta->getDtEntregaProposta()->format('YYYY-mm-dd')) {
            $message = $this->trans('compra_direta.errors.dtValidadeLessThanDtEntrega', [], 'validators');
            $errorElement->with('dtValidadeProposta')->addViolation($message)->end();
        }
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('publicacoes', 'publicacoes', [
            '_controller' => 'PatrimonialBundle:Compras/CompraDireta:publicacoes'
        ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $fieldOptions['fkOrcamentoEntidade']['label'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade'
        ];
        $fieldOptions['fkOrcamentoEntidade']['class'] = [
            'class' => Entidade::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                return $em->findAllByExercicioAsQueryBuilder($exercicio);
            },
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['fkOrcamentoEntidade']['adminCode'] = [
            'admin_code' => 'financeiro.admin.entidade'
        ];


        $datagridMapper
            ->add('fkOrcamentoEntidade', 'composite_filter', $fieldOptions['fkOrcamentoEntidade']['label'], null, $fieldOptions['fkOrcamentoEntidade']['class'], $fieldOptions['fkOrcamentoEntidade']['adminCode'])
            ->add('fkComprasModalidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codModalidade'
            ], null, [
                'class' => Compras\Modalidade::class,
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione'
            ])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'doctrine_orm_callback', [
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return;
                    }

                    $date = $value['value']->format('Y-m-d');

                    $queryBuilder
                        ->andWhere("DATE({$alias}.timestamp) = :timestamp")
                        ->setParameter('timestamp', $date);

                    return true;
                },
                'label' => 'label.comprasDireta.timestamp'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
            ])
            ->add('fkComprasMapa', 'composite_filter', [
                'label' => 'label.comprasDireta.codMapa'
            ], null, [
                'class' => Compras\Mapa::class,
                'choice_label' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'placeholder' => 'label.selecione',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.comprasDireta.codEntidade'])
            ->add('fkComprasModalidade.descricao', null, ['label' => 'label.comprasDireta.codModalidade'])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'date', [
                'label' => 'label.comprasDireta.timestamp',
                'format' => 'd/m/Y',
            ])
            ->add('fkComprasMapa', null, [
                'associated_property' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'label' => 'label.comprasDireta.codMapa'
            ])
            ->add(
                'fkComprasCompraDiretaAnulacao',
                null,
                [
                    'editable' => true,
                    'associated_property' => function (Compras\CompraDiretaAnulacao $anulacao) {
                        $status = ($anulacao) ? 'Anulada' : 'Ativa';

                        return $status;
                    },
                    'label' => 'label.comprasDireta.situacao'
                ]
            );

        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit' => ['template' => 'PatrimonialBundle:Sonata/Compras/CompraDireta/CRUD:list__action_edit.html.twig'],
                    'delete' => ['template' => 'PatrimonialBundle:Sonata/Compras/CompraDireta/CRUD:list__action_anular.html.twig']
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $mapaModel = new MapaModel($entityManager);
        $disabledEdit = false;
        $exercicio = $this->getExercicio();

        $now = new \DateTime();

        $defaultDate = [
            'widget' => 'single_text',
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true
        ];

        $fieldOptions = [];
        $fieldOptions['codEntidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codEntidade',
            'placeholder' => 'label.selecione',
            'required' => true,
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
            'choice_value' => 'codEntidade'
        ];

        $fieldOptions['codClassificacao'] = [
            'class' => Entity\SwClassificacao::class,
            'choice_label' => 'nomClassificacao',
            'mapped' => false,
            'label' => 'Classificação',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
        ];
        $fieldOptions['codAssunto'] = [
            'class' => Entity\SwAssunto::class,
            'mapped' => false,
            'label' => 'Assunto',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters ',
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codProcesso'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'readonly' => 'readonly'
            ],
            'label' => 'label.comprasDireta.codProcesso',
            'mapped' => false,
            'required' => true,
            'placeholder' => 'label.selecione',
            'choices' => array(),
        ];

        $mapaModel = new MapaModel($entityManager);
        $mapasDisponiveis = $mapaModel->recuperMapaDisponiveisCompraDireta($exercicio);
        $mapas = [];
        foreach ($mapasDisponiveis as $mapa) {
            $mapas[] = $mapa['cod_mapa'];
        }

        if (empty($mapas)) {
            $mapas[] = 0;
        }

        $admin = $this;
        $fieldOptions['codMapa'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codMapa',
            'choice_value' => function ($mapa) use ($admin) {
                if (is_null($mapa)) {
                    return;
                }
                return $admin->getObjectKey($mapa);
            },
            'choice_label' => function (Compras\Mapa $mapa) {
                $exercicio = $mapa->getExercicio();

                return "{$exercicio} | {$mapa->getCodMapa()}";
            },
            'placeholder' => 'label.selecione',
            'required' => true,
            'query_builder' => function (EntityRepository $entityManager) use ($mapas, $exercicio) {
                $qb = $entityManager->createQueryBuilder('codMapa');
                $result = $qb->where('codMapa.exercicio = :exercicio')
                    ->andWhere($qb->expr()->in('codMapa.codMapa', $mapas))
                    ->setParameter(':exercicio', $exercicio);
                return $result;
            },
        ];

        $fieldOptions['dtEntregaProposta'] = $defaultDate;
        $fieldOptions['dtEntregaProposta']['label'] = 'label.comprasDireta.dtEntregaProposta';

        $fieldOptions['dtValidadeProposta'] = $defaultDate;
        $fieldOptions['dtValidadeProposta']['label'] = 'label.comprasDireta.dtValidadeProposta';

        $fieldOptions['timestamp']['label'] = 'label.comprasDireta.timestamp';
        $fieldOptions['timestamp']['mapped'] = false;
        $fieldOptions['timestamp']['format'] = 'd/MM/yyyy';

        $fieldOptions['codModalidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codModalidade',
            'placeholder' => 'label.selecione',
            'required' => true,
            'query_builder' => function (EntityRepository $entityRepository) {
                $qb = $entityRepository->createQueryBuilder('codModalidade');
                $result = $qb->where($qb->expr()->in('codModalidade.codModalidade', [8, 9]));
                return $result;
            }
        ];

        $fieldOptions['padrao'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'required' => true,
        ];

        $fieldOptions['codTipoObjeto'] = $fieldOptions['padrao'];
        $fieldOptions['codTipoObjeto']['label'] = 'label.comprasDireta.codTipoObjeto';

        $fieldOptions['codObjeto'] = $fieldOptions['padrao'];
        $fieldOptions['codObjeto']['label'] = 'label.comprasDireta.codObjeto';
        $fieldOptions['codObjeto']['attr']['data-value-from'] = '_fkComprasMapa';

        $fieldOptions['condicoesPagamento'] = [
            'required' => true,
            'label' => 'label.comprasDireta.condicoesPagamento'
        ];
        $fieldOptions['prazoEntrega'] = [
            'required' => true,
            'label' => 'label.comprasDireta.prazoEntrega'
        ];

        if (!is_null($id)) {
            $id = $this->getObjectIdentifier();
            $disabledEdit = true;
            /** @var Compras\CompraDireta $compraDireta */
            $compraDireta = $this->getSubject();

            $fieldOptions['codMapa'] = [
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'label' => 'label.comprasDireta.codMapa',
                'placeholder' => 'label.selecione',
                'required' => true,
                'choice_value' => function ($codMapa) {
                    return $codMapa->getExercicio() . '~' . $codMapa->getCodMapa();
                },
                'choice_label' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();
                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },

            ];

            $fieldOptions['codMapa']['data'] = $compraDireta->getFkComprasMapa();

            /** @var Compras\CompraDiretaProcesso $compraDiretaProcessoCollection */
            $compraDiretaProcessoCollection = $compraDireta->getFkComprasCompraDiretaProcesso();

            $fieldOptions['timestamp']['data'] = new \DateTime($compraDireta->getTimestamp());

            $codClassificacao = $compraDiretaProcessoCollection->getFkSwProcesso()->getCodClassificacao();

            // Desabilita campos que não podem ser alterados durante a edição
            $fieldOptions['codModalidade']['disabled'] = true;
            $fieldOptions['codMapa']['disabled'] = true;
            $fieldOptions['codEntidade']['disabled'] = true;
            $fieldOptions['timestamp']['disabled'] = true;
            $fieldOptions['codObjeto']['disabled'] = true;

            $fieldOptions['codClassificacao']['choice_attr'] = function (Entity\SwClassificacao $classificacao, $key, $index) use ($codClassificacao) {
                if ($classificacao->getCodClassificacao() == $codClassificacao) {
                    return ['selected' => 'selected'];
                }
                return ['selected' => false];
            };

            $codAssunto = $compraDiretaProcessoCollection->getFkSwProcesso()->getFkSwAssunto();
            $fieldOptions['codAssunto']['query_builder'] = function (EntityRepository $entityRepository) use ($codClassificacao) {
                $qb = $entityRepository->createQueryBuilder('swAssunto');
                $result = $qb->where('swAssunto.codClassificacao = :codClassificacao')
                    ->setParameter(':codClassificacao', $codClassificacao);
                return $result;
            };
            $fieldOptions['codAssunto']['data'] = $codAssunto;
            $fieldOptions['codAssunto']['choice_value'] = function (Entity\SwAssunto $assunto) {
                return $this->getObjectKey($assunto);
            };

            if (!is_null($compraDiretaProcessoCollection)) {
                $processos = $entityManager->getRepository(SwProcesso::class)->findBy([
                    'codClassificacao' => $codClassificacao,
                    'codAssunto' => $codAssunto->getCodAssunto()
                ]);

                $choices = [];
                /** @var SwProcesso $processo */
                foreach ($processos as $processo) {
                    $choices[(string) $processo] = $this->id($processo);
                }

                $idCompostoProcesso = $this->id($compraDiretaProcessoCollection->getFkSwProcesso());
                $fieldOptions['codProcesso']['choice_attr'] = function ($processo, $key, $index) use ($idCompostoProcesso) {
                    if ($processo == $idCompostoProcesso) {
                        return ['selected' => 'selected'];
                    }
                    return ['selected' => false];
                };
                $fieldOptions['codProcesso']['choices'] = $choices;
            }
        }

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $numeracaoAutomatica = $configuracaoModel->getConfiguracao('numeracao_automatica', ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, true, $this->getExercicio());
        if ($numeracaoAutomatica != 'true') {
            $fieldOptions['codCompraDireta'] = [
                'label' => 'label.comprasDireta.codCompraDireta',
                'attr' => [
                    'class' => ' numero ',
                    'maxlength' => '10',
                    'disabled' => $disabledEdit
                ],
            ];
        }

        $formMapper
            ->with('label.comprasDireta.compraDireta');
        if ($numeracaoAutomatica != 'true') {
            $formMapper->add('codCompraDireta', 'text', $fieldOptions['codCompraDireta']);
        }
        $formMapper->add('fkOrcamentoEntidade', null, $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('codClassificacao', 'entity', $fieldOptions['codClassificacao'])
            ->add('codAssunto', 'entity', $fieldOptions['codAssunto'])
            ->add('codProcesso', 'choice', $fieldOptions['codProcesso'])
            ->add('fkComprasMapa', null, $fieldOptions['codMapa'])
            ->add('timestamp', 'sonata_type_date_picker', $fieldOptions['timestamp'])
            ->end()
            ->with('label.comprasDireta.codObjeto')
            ->add('fkComprasModalidade', null, $fieldOptions['codModalidade'])
            ->add('fkComprasTipoObjeto', null, $fieldOptions['codTipoObjeto'])
            ->add('fkComprasObjeto', null, $fieldOptions['codObjeto'])
            ->end()
            ->with('label.comprasDireta.proposta')
            ->add('dtEntregaProposta', 'sonata_type_date_picker', $fieldOptions['dtEntregaProposta'])
            ->add('dtValidadeProposta', 'sonata_type_date_picker', $fieldOptions['dtValidadeProposta'])
            ->add('condicoesPagamento', null, $fieldOptions['condicoesPagamento'])
            ->add('prazoEntrega', null, $fieldOptions['prazoEntrega'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 comprasdireta-items'
            ])
            ->end();

        $processoModel = new SwProcessoModel($entityManager);
        $assuntoModel = new SwAssuntoModel($entityManager);
        $admin = $this;
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
                        $choiceValue = $processo->cod_processo . '~' . $processo->ano_exercicio;

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
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var Compras\CompraDireta $compraDireta */
        $compraDireta = $this->getSubject();
        $solicitacoes = $compraDireta->getFkComprasMapa()->getFkComprasMapaSolicitacoes()->last();
        $compraDireta->mapaItems = $entityManager->getRepository(MapaItem::class)
            ->montaRecuperaItemSolicitacaoMapa(
                $compraDireta->getFkComprasMapa()->getFkComprasMapaSolicitacoes()->last()->getCodSolicitacao(),
                $compraDireta->getCodEntidade(),
                $compraDireta->getFkComprasMapa()->getFkComprasMapaSolicitacoes()->last()->getExercicioSolicitacao(),
                null,
                null,
                $compraDireta->getCodMapa(),
                $compraDireta->getExercicioMapa()
            );

        $status = ($compraDireta->getFkComprasCompraDiretaAnulacao()) ? 'Anulada' : 'Ativa';

        if ($status == 'Anulada') {
            $this->exibirBotaoEditar = false;
        }

        $fieldOptions['status'] = [
            'label' => 'label.comprasDireta.situacao',
            'mapped' => false,
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $status
        ];

        $showMapper
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('fkOrcamentoEntidade', null, ['label' => 'label.comprasDireta.codEntidade', 'admin_code' => 'financeiro.admin.entidade'])
            ->add('fkComprasCompraDiretaProcesso.fkSwProcesso', null, ['label' => 'label.comprasDireta.codProcesso', 'admin_code' => 'administrativo.admin.processo'])
            ->add('fkComprasMapa', null, [
                'associated_property' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();
                    $codigo = $mapa->getCodMapa();

                    return "{$exercicio} | {$codigo}";
                },
                'label' => 'label.comprasDireta.codMapa'
            ], null, [])
            ->add('timestamp', 'date', [
                'format' => 'd/m/Y',
                'label' => 'label.comprasDireta.timestamp'
            ])
            ->add('fkComprasModalidade', null, ['label' => 'label.comprasDireta.codModalidade'])
            ->add('fkComprasTipoObjeto', null, ['label' => 'label.comprasDireta.codTipoObjeto'])
            ->add('fkComprasObjeto', null, ['label' => 'label.comprasDireta.codObjeto'])
            ->add('dtEntregaProposta', null, ['label' => 'label.comprasDireta.dtEntregaProposta'])
            ->add('dtValidadeProposta', null, ['label' => 'label.comprasDireta.dtValidadeProposta'])
            ->add('condicoesPagamento', null, ['label' => 'label.comprasDireta.condicoesPagamento'])
            ->add('prazoEntrega', null, ['label' => 'label.comprasDireta.prazoEntrega'])
            ->add('status', 'text', $fieldOptions['status'])
            ->add(
                'mapaItems',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'PatrimonialBundle:Sonata/Compras/CompraDireta:compraDiretaItens.html.twig',
                    'data' => [
                        'label' => 'label.atributoDinamico.codTipo',
                        'value' => $compraDireta->mapaItems
                    ]
                ]
            );

        $compraDireta->mapaItems = $compraDireta->mapaItems;
        $compraDireta->compraDireta = $compraDireta;
        $compraDireta->status = $status;
        $compraDireta->publicacoes = $compraDireta->getFkComprasPublicacaoCompraDiretas();
    }
}
