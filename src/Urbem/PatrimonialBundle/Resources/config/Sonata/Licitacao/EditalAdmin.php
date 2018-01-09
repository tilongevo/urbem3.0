<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\EditalAnulado;
use Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado;
use Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Model;

class EditalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_edital';
    protected $baseRoutePattern = 'patrimonial/licitacao/edital';

    protected $exibirBotaoExcluir = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAlias()}.exercicio = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }

        return $query;
    }

    /**[
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'participante_update',
            '{id}/edital-participante-update'
        );
        $collection->remove('delete');

        $collection->add('gera_edital', '{id}/gera-edital');
    }

    /**
     * @param Edital $licitacaoEdital
     */
    public function postPersist($licitacaoEdital)
    {
        $this->forceRedirect("/patrimonial/licitacao/edital/{$this->getObjectKey($licitacaoEdital)}/show");
    }

    /**
     * @param Edital $licitacaoEdital
     */
    public function postUpdate($licitacaoEdital)
    {
        $this->forceRedirect("/patrimonial/licitacao/edital/{$this->getObjectKey($licitacaoEdital)}/show");
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $swProcessoModel = new SwProcessoModel($entityManager);

        $codProcessoChoices = [];

        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add('numEdital', null, ['label' => 'label.patrimonial.licitacao.edital.numEdital'])
            ->add('codLicitacao', null, ['label' => 'label.patrimonial.licitacao.edital.codLicitacao'])
            ->add('fkLicitacaoLicitacao.fkOrcamentoEntidade', 'composite_filter', [
                'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade',
            ], null, [
                'class'         => Entidade::class,
                'choice_label'  => function (Entidade $entidade) {
                    return $entidade->getCodEntidade() . ' - ' .
                        $entidade->getFkSwCgm()->getNomCgm();
                },
                'attr'          => ['class' => 'select2-parameters ',],
                'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                    return $em->findAllByExercicioAsQueryBuilder($exercicio);
                },
                'placeholder'   => 'label.selecione',
            ], [
                'admin_code' => 'financeiro.admin.entidade',
            ])
            ->add('fkLicitacaoLicitacao.fkSwProcesso', 'composite_filter', [
                'label'      => 'label.comprasDireta.codProcesso',
                'admin_code' => 'administrativo.admin.processo',
            ], 'autocomplete', [
                'class'       => SwProcesso::class,
                'route'       => ['name' => 'urbem_core_filter_swprocesso_autocomplete'],
                'attr'        => ['class' => 'select2-parameters ',],
                'placeholder' => 'Selecione',
            ])
            ->add('fkLicitacaoLicitacao.fkComprasModalidade', null, [
                'label'        => 'label.comprasDireta.codModalidade',
                'choice_label' => 'descricao',
                'placeholder'  => 'label.selecione',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $this->setBreadCrumb();

        $listMapper
            ->add(
                'numEdital',
                'text',
                [
                    'associated_property' => function (Edital $edital) {
                        return $edital->getNumEdital();
                    },
                    'label' => 'label.patrimonial.licitacao.edital.numEdital'
                ]
            )
            ->add('fkLicitacaoLicitacao', null, [
                'label' => 'label.patrimonial.licitacao.edital.codLicitacao',
                'admin_code' => 'patrimonial.admin.licitacao'
            ])
            ->add('fkLicitacaoLicitacao.fkOrcamentoEntidade', null, [
                'label' => 'label.patrimonial.licitacao.edital.codEntidade',
                'admin_code' => 'financeiro.admin.entidade'
            ])
            ->add('fkLicitacaoLicitacao.fkSwProcesso', null, [
                'label' => 'label.patrimonial.licitacao.edital.codProcesso',
                'admin_code' => 'administrativo.admin.processo'
            ])
            ->add('fkLicitacaoLicitacao.fkComprasModalidade', null, [
                'label' => 'label.patrimonial.licitacao.edital.codModalidade'
            ])
            ->add('_action', 'actions', [
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/patrimonial/javascripts/licitacao/edital.js');

        $ids = explode('~', $this->getAdminRequestId());
        $id = $ids[0];

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $route = $this->getRequest()->get('_sonata_name');
        $exercicio = $this->getExercicio();

        $disabledEdit = 'false';
        $dataNumEdital = '';
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        $fieldOptions['fkSwCgm'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return strtoupper($swCgm);
            },
            'class' => SwCgm::class,
            'required' => true,
            'property' => 'nomCgm',
            'label' => 'label.patrimonial.licitacao.edital.responsavelJuridico',
            'placeholder' => 'Selecione'
        ];

        /** @var Edital $edital */
        $edital = $this->getSubject();

        $queryBuilder = function (EntidadeRepository $repo) use ($exercicio) {
            return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio);
        };

        if (!is_null($edital->getNumEdital())) {
            $exercicio = $this->getSubject()->getExercicio();
            $disabledEdit = true;
            $dataNumEdital = $edital->getNumEdital();
            $queryBuilder = function (EntidadeRepository $repo) use ($exercicio, $edital) {
                return $repo->getEntidadeByCgmAndExercicioQueryBuilder($exercicio, $edital->getCodEntidade());
            };
        }

        $fieldOptions['codEntidade'] = [
            'label' => 'label.patrimonial.compras.contrato.codEntidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'choice_value' => 'codEntidade',
            'required' => true,
            'query_builder' => $queryBuilder,
            'placeholder' => 'Selecione',
            'mapped' => false,
        ];

        $fieldOptions['modalidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'required' => true,
            'class' => Modalidade::class,
            'label' => 'Modalidade',
            'placeholder' => 'Selecione',
            'choice_value' => 'codModalidade',
        ];

        $fieldOptions['licitacaoCompra'] = [
            'label' => 'Licitação',
            'mapped' => false,
            'multiple' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['swProcesso'] = [
            'label' => 'Processo Administrativo',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['valor'] = [
            'label' => 'Valor da Licitação',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        if ($this->getAdminRequestId()) {
            $fieldOptions['codEntidade']['data'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade();
            $fieldOptions['modalidade']['data'] = $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade();

            $key = $edital->getFkLicitacaoLicitacao()->getCodLicitacao() . " / " . $edital->getFkLicitacaoLicitacao()->getExercicio() . " - " . $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();
            $dados[$key] =  $edital->getFkLicitacaoLicitacao()->getCodLicitacao();
            $fieldOptions['licitacaoCompra']['choices'] = $dados;
        }

        $formMapper
            ->with('Dados do Edital');
        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $numeracaoAutomaticaLicitacao = $configuracaoModel->getConfiguracao('numeracao_automatica_licitacao', ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, true, $exercicio);
        if ($numeracaoAutomaticaLicitacao == 'false') {
            $fieldOptions['numEdital'] = [
                'label' => 'label.patrimonial.licitacao.edital.numEdital',
                'attr' => [
                    'class' => ' numero ',
                    'maxlength' => '20',
                    'readonly' => (!empty($dataNumEdital)) ? true : false,
                ],
                'data' => $dataNumEdital,
            ];

            $formMapper->add('numEdital', 'text', $fieldOptions['numEdital']);
        }
        $formMapper->add(
            'exercicio',
            'text',
            [
                'label' => 'label.patrimonial.licitacao.edital.exercicio',
                'data' => $exercicio,
                'attr' => [
                    'readonly' => 'readonly'
                ],
            ]
        )
            ->add('codEntidade', 'entity', $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('modalidade', 'entity', $fieldOptions['modalidade'])
            ->add('licitacaoCompra', 'choice', $fieldOptions['licitacaoCompra'])
            ->add('swProcesso', 'text', $fieldOptions['swProcesso'])
            ->add('valor', 'text', $fieldOptions['valor'])
            ->end()
            ->with('label.patrimonial.licitacao.edital.aprovacaoJuridica')
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add(
                'dtAprovacaoJuridico',
                'sonata_type_date_picker',
                [
                    'label' => 'label.patrimonial.licitacao.edital.dtAprovacaoJuridico',
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->end()
            ->with('label.patrimonial.licitacao.edital.sobrePropostas')
            ->add(
                'localEntregaPropostas',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.localEntregaPropostas',
                ]
            )
            ->add(
                'dtEntregaPropostas',
                'sonata_type_date_picker',
                [
                    'label' => 'label.patrimonial.licitacao.edital.dtEntregaPropostas',
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'dtFinalEntregaPropostas',
                'sonata_type_date_picker',
                [
                    'label' => 'label.patrimonial.licitacao.edital.dtFinalEntregaPropostas',
                    'format' => 'dd/MM/yyyy',
                    'required' => false
                ]
            )
            ->add(
                'horaEntregaPropostas',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.horaEntregaPropostas',
                    'attr' => [
                        'class' => 'hora'
                    ]
                ]
            )
            ->add(
                'horaFinalEntregaPropostas',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.horaFinalEntregaPropostas',
                    'required' => false,
                    'attr' => [
                        'class' => 'hora'
                    ]
                ]
            )
            ->add(
                'localAberturaPropostas',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.localAberturaPropostas',
                ]
            )
            ->add(
                'dtAberturaPropostas',
                'sonata_type_date_picker',
                [
                    'label' => 'label.patrimonial.licitacao.edital.dtAberturaPropostas',
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'horaAberturaPropostas',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.horaAberturaPropostas',
                    'attr' => [
                        'class' => 'hora'
                    ]
                ]
            )
            ->add(
                'dtValidadeProposta',
                'sonata_type_date_picker',
                [
                    'label' => 'label.patrimonial.licitacao.edital.dtValidadeProposta',
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'observacaoValidadeProposta',
                'textarea',
                [
                    'label' => 'label.patrimonial.licitacao.edital.observacaoValidadeProposta',
                ]
            )
            ->end()
            ->with('label.patrimonial.licitacao.edital.outrasInformacoes')
            ->add(
                'localEntregaMaterial',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.localEntregaMaterial',
                ]
            )
            ->add(
                'condicoesPagamento',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.edital.condicoesPagamento',
                ]
            );

        $admin = $this;
        /** @var LicitacaoModel $licitacaoModel */
        $licitacaoModel = new LicitacaoModel($entityManager);
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $licitacaoModel) {
                $form = $event->getForm();
                $data = $event->getData();
                /** @var Edital $edital */
                $edital = $admin->getSubject();
                if (isset($data['licitacaoCompra']) && $data['modalidade'] != "" && $data['codEntidade'] != "" && $data['exercicio'] != "") {
                    $licitacoes = $licitacaoModel->carregaLicitacaoEdital($data['modalidade'], $data['codEntidade'], $data['exercicio']);
                    $dados = [];
                    foreach ($licitacoes as $licitacao) {
                        $key = $licitacao->cod_licitacao . " / " . $licitacao->exercicio . " - " . $licitacao->nom_cgm;
                        $dados[$key] =  $licitacao->cod_licitacao;
                    }

                    if (empty($dados)) {
                        $key = $edital->getCodLicitacao() . " / " . $edital->getFkLicitacaoLicitacao()->getExercicio() . " - " . $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();
                        $dados[$key] =  $edital->getCodLicitacao();
                    }

                    $licitacaoCampo = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'licitacaoCompra',
                        'choice',
                        null,
                        array(
                            'choices' => $dados,
                            'auto_initialize' => false,
                            'label' => 'Licitação',
                            'mapped' => false,
                            'multiple' => false,
                            'attr' => [
                                'class' => 'select2-parameters '
                            ],
                            'placeholder' => 'Selecione'
                        )
                    );

                    $form->add($licitacaoCampo);
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

        /** @var Edital $edital */
        $edital = $this->getSubject();
        $edital->edital = $edital;

        /** @var EditalAnulado $anulacao */
        $edital->anulacao = $edital->getFkLicitacaoEditalAnulado();

        /** @var EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $editalModel = new Model\Patrimonial\Licitacao\EditalModel($em);

        $filtro = [
            'exercicio' => $edital->getExercicio(),
            'num_edital' => $edital->getNumEdital(),
            'cod_entidade' => $edital->getFkLicitacaoLicitacao()->getCodEntidade(),
        ];

        /** @var boolean $passivelAnulacaoImpugnacao */
        $edital->passivelAnulacaoImpugnacao = (count($editalModel->getEditalPassivelAnulacaoImpugnacao($filtro)) > 0) ? true : false;

        /** @var boolean $passivelImpugnacao */
        $edital->passivelImpugnacao = (count($editalModel->getEditalPassivelImpugnacao($filtro)) > 0) ? true : false;

        /** @var boolean $passivelSuspensao */
        $edital->passivelSuspensao = (count($editalModel->getEditalPassivelSuspensao($filtro)) > 0) ? true : false;

        /** @var PublicacaoEdital $publicacoes */
        $edital->publicacoes = $edital->getFkLicitacaoPublicacaoEditais();

        $filtros = [
            'exercicio' => $edital->getExercicioLicitacao(),
            'cod_entidade' => (is_object($edital->getCodEntidade())) ? $edital->getCodEntidade()->getCodEntidade(): $edital->getCodEntidade(),
            'cod_modalidade' => $edital->getCodModalidade(),
            'cod_licitacao' => $edital->getCodLicitacao()
        ];

        $edital->participantes = $editalModel->getParticipantesByLicitacao($filtros);

        /** @var EditalImpugnado $impugnacaoEdital */
        $edital->impugnados = $edital->getFkLicitacaoEditalImpugnados();
    }


    /**
     * @param ErrorElement $errorElement
     * @param Edital $edital
     */
    public function validate(ErrorElement $errorElement, $edital)
    {
        if (is_null($edital->getFkLicitacaoLicitacao())) {
            $form = $this->getForm();
            $codModalidade = $form->get('modalidade')->getData();
            $codEntidade = $form->get('codEntidade')->getData();
            $exercicio = $form->get('exercicio')->getData();
            $formData = $this->getRequest()->request->get($this->getUniqid());

            /** @var EntityManager $entityManager */
            $entityManager = $this->getEntityManager();

            /** @var Licitacao $licitacao */
            $licitacao = $entityManager->getRepository(Licitacao::class)->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codModalidade' => $codModalidade->getCodModalidade(),
                    'codEntidade' => $codEntidade->getCodEntidade(),
                    'codLicitacao' => $formData['licitacaoCompra']
                ]
            );

            $edital->setFkLicitacaoLicitacao($licitacao);
        }

        /**
         *  VALIDAÇÃO
         */
        //verifica se a data de abertura é superior a data de entrega
        if ($edital->getDtEntregaPropostas()->getTimestamp() > $edital->getDtAberturaPropostas()->getTimestamp()) {
            $stMensagem = 'Data e hora da abertura (' . $edital->getDtAberturaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraAberturaPropostas() . ') deve ser igual ou maior a data e hora de entrega (' . $edital->getDtEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraEntregaPropostas() . ').';
            $errorElement->with('dtEntregaPropostas')->addViolation($stMensagem)->end();
        } elseif (($edital->getDtEntregaPropostas()->getTimestamp() == $edital->getDtAberturaPropostas()->getTimestamp()) && ($edital->getHoraEntregaPropostas() > $edital->getHoraAberturaPropostas())) {
            $stMensagem = 'Data e hora da abertura (' . $edital->getDtAberturaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraAberturaPropostas() . ') deve ser igual ou maior a data e hora de entrega (' . $edital->getDtEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraEntregaPropostas() . ').';
            $errorElement->with('dtEntregaPropostas')->addViolation($stMensagem)->end();
        }

        if (!is_null($edital->getDtFinalEntregaPropostas())) {
            if ($edital->getDtEntregaPropostas()->getTimestamp() > $edital->getDtFinalEntregaPropostas()->getTimestamp()) {
                $stMensagem = 'Data final de Entrega (' . $edital->getDtFinalEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraFinalEntregaPropostas() . ') deve ser igual ou maior a data e hora de entrega (' . $edital->getDtEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraEntregaPropostas() . ').';
                $errorElement->with('dtFinalEntregaPropostas')->addViolation($stMensagem)->end();
            } elseif (($edital->getDtEntregaPropostas()->getTimestamp() == $edital->getDtFinalEntregaPropostas()->getTimestamp()) && ($edital->getHoraEntregaPropostas() > $edital->getHoraFinalEntregaPropostas())) {
                $stMensagem = 'Data e hora finais da Entrega (' . $edital->getDtFinalEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraFinalEntregaPropostas() . ') deve ser igual ou maior a data e hora de entrega (' . $edital->getDtEntregaPropostas()->format('d/m/Y') . ' ' . $edital->getHoraEntregaPropostas() . ').';
                $errorElement->with('dtFinalEntregaPropostas')->addViolation($stMensagem)->end();
            }
        }

        if (!is_null($edital->getHoraFinalEntregaPropostas())) {
            if ($edital->getHoraEntregaPropostas() > $edital->getHoraFinalEntregaPropostas()) {
                $stMensagem = 'Hora final de Entrega (' . $edital->getHoraFinalEntregaPropostas() . ') deve ser igual ou maior que a hora de entrega (' . $edital->getHoraEntregaPropostas() . ').';
                $errorElement->with('horaFinalEntregaPropostas')->addViolation($stMensagem)->end();
            }
        }

        // VERIFICA SE A DATA DE APROVAÇÃO É SUPERIOR A DATA DE ENTREGA
        if ($edital->getDtAprovacaoJuridico()->getTimestamp() > $edital->getDtEntregaPropostas()->getTimestamp()) {
            $stMensagem = 'Data de aprovação do jurídico (' . $edital->getDtAprovacaoJuridico()->format('d/m/Y') . ') deve ser menor que a data de entrega (' . $edital->getDtEntregaPropostas()->format('d/m/Y') . ').';
            $errorElement->with('dtAprovacaoJuridico')->addViolation($stMensagem)->end();
        }


        // VERIFICA SE A DATA DE VALIDADE É SUPERIOR A DATA DE ABERTURA
        if ($edital->getDtAberturaPropostas()->getTimestamp() > $edital->getDtValidadeProposta()->getTimestamp()) {
            $stMensagem = 'Data de validade das propostas (' . $edital->getDtValidadeProposta()->format('d/m/Y') . ') deve ser maior que a data de abertura das propostas(' . $edital->getDtAberturaPropostas()->format('d/m/Y') . ').';
            $errorElement->with('dtValidadeProposta')->addViolation($stMensagem)->end();
        }

        /** FIM VALIDAÇÃO */
        if (false === $this->getComissaoLicitacao($edital)) {
            $message = $this->trans('licitacao_edital.errors.comissaoNaoCadastrada', [], 'validators');
            $errorElement->addViolation($message)->end();
        }
    }

    /**
     * @param Edital $edital
     */
    public function prePersist($edital)
    {
        $this->loadEditalKey($edital);
    }

    /**
     * @param Edital $edital
     * @return ComissaoLicitacao
     */
    protected function getComissaoLicitacao(Edital $edital)
    {
        /** @var ComissaoLicitacao $comissaoLicitacao */
        $comissaoLicitacao = $edital->getFkLicitacaoLicitacao()->getFkLicitacaoComissaoLicitacoes()->last();

        return $comissaoLicitacao;
    }


    /**
     * @param Edital $edital
     */
    protected function loadEditalKey(Edital $edital)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Licitacao\Licitacao');

        $edital->setExercicio($this->getExercicio());

        $maxNumEdital = $entityManager->createQueryBuilder()
            ->select('MAX(e.numEdital)')
            ->from('CoreBundle:Licitacao\Edital', 'e')
            ->Where('e.exercicio = ?1')
            ->setParameter(1, $edital->getExercicio())
            ->getQuery()
            ->getSingleScalarResult();

        $edital->setNumEdital(1);

        if (null != $maxNumEdital) {
            $edital->setNumEdital($maxNumEdital + 1);
        }
    }
}
