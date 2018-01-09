<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros;
use Urbem\CoreBundle\Entity\Licitacao\Documento;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento;
use Urbem\CoreBundle\Entity\Licitacao\TipoChamadaPublica;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\UnidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModalidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoLicitacaoMembrosModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoLicitacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoDocumentosModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Compras\Objeto;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class LicitacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class LicitacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_licitacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/licitacao';
    protected $inCodModulo = 35;
    protected $exibirBotaoExcluir = false;

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/licitacao.js',
        '/core/javascripts/sw-processo.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_itens_licitacao',
            'get-itens-licitacao/'
        );
        $collection->add(
            'carrega_informacoes_mapa',
            'carrega-informacoes-mapa/'
        );
        $collection->add(
            'get_membros_comissao',
            'get-membros-comissao/'
        );
        $collection->add(
            'carrega_modalidade',
            'carrega-modalidade/'
        );
        $collection->remove('delete');
    }

    /**
     * @param Licitacao $licitacao
     *
     * @return $this
     */
    public function persistDocumentos(Licitacao $licitacao)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $licitacaoDocumentosModel = new LicitacaoDocumentosModel($entityManager);

        /** @var Collection $documentos */
        $documentos = $this->getForm()->get('fkLicitacaoDocumento')->getData();

        /** @var Documento $documento */
        foreach ($documentos as $documento) {
            /** @var LicitacaoDocumentos $licitacaoDocumentos */
            $licitacaoDocumentos = $modelManager->findOneBy(LicitacaoDocumentos::class, [
                'fkLicitacaoDocumento' => $documento,
                'fkLicitacaoLicitacao' => $licitacao
            ]);

            if (is_null($licitacaoDocumentos)) {
                $licitacaoDocumentosModel->buildOne($documento, $licitacao);
            }
        }

        return $this;
    }

    /**
     * @param Licitacao $licitacao
     */
    public function prePersist($licitacao)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();

        $formData = $this->getForm();
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formRequest = $this->getRequest()->request->get($uniqid);

        /** @var SwProcesso $processo */
        $processo = $modelManager->find(SwProcesso::class, $formData->get('codProcesso')->getData());

        $chamadaPublica = $formData->get('codTipoChamadaPublica')->getData();
        if (!isset($chamadaPublica)) {
            $chamadaPublica = 0;
        }

        if (in_array($licitacao->getCodModalidade(), Compras\Modalidade::MODALIDADE_CHAMADA_PUBLICA_ZERO)) {
            $chamadaPublica = isset($chamadaPublica) ? $chamadaPublica : 0;

            /** @var TipoChamadaPublica $tipoChamadaPublica */
            $tipoChamadaPublica = $modelManager->findOneBy(TipoChamadaPublica::class, [
                'codTipo' => $chamadaPublica,
            ]);

            $licitacao->setFkLicitacaoTipoChamadaPublica($tipoChamadaPublica);
        }

        $licitacao->setExercicio($exercicio);
        $licitacao->setExercicioMapa($licitacao->getFkComprasMapa()->getExercicio());
        $licitacao->setFkSwProcesso($processo);
        $licitacao->setFkComprasTipoLicitacao($licitacao->getFkComprasMapa()->getFkComprasTipoLicitacao());

        $codLicitacao = (new LicitacaoModel($entityManager))->getNextCodLicitacao(
            $licitacao->getCodModalidade(),
            $licitacao->getCodEntidade(),
            $licitacao->getExercicio()
        );

        $licitacao->setCodLicitacao($codLicitacao);

        $registroPrecos = ($licitacao->getRegistroPrecos()) == "Sim" ? true : false;

        $licitacao->setRegistroPrecos($registroPrecos);

        $unidade = (new UnidadeModel($entityManager))->getOneByUnidadeOrgaoExercicio(
            $formRequest['unidade'],
            $formData->get('orgaoOrg')->getData()->getNumOrgao(),
            $licitacao->getExercicio()
        );

        $licitacao->setFkOrcamentoUnidade($unidade);

        $numeracaoAutomaticaLicitacao = (new ConfiguracaoModel($entityManager))
            ->getConfiguracao(
                'numeracao_automatica_licitacao',
                ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS,
                true,
                $this->getExercicio()
            );

        if ($numeracaoAutomaticaLicitacao == 'false') {
            $newCodLicitacao = (int) $formData->get('codLicitacao')->getData();
            if (is_int($codLicitacao) && !is_null($codLicitacao) && $codLicitacao != 0) {
                $licitacao->setCodLicitacao($newCodLicitacao);
            }
        }

        $this->persistDocumentos($licitacao);
    }

    /**
     * @param Licitacao $licitacao
     */
    public function postPersist($licitacao)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
        $emComissao = $this->modelManager->getEntityManager('CoreBundle:Licitacao\Comissao');
        $coModel = new ConfiguracaoModel($em);
        $exercicio = $this->getExercicio();

        $boReservaRigida = $coModel->pegaConfiguracao('reserva_rigida', $this->inCodModulo, $exercicio);
        $boReservaRigida = ($boReservaRigida == 'true') ? true : false;

        $mapaSolicitacao = $entityManager
            ->getRepository(Compras\MapaSolicitacao::class)
            ->findBy([
                'codMapa' => $licitacao->getCodMapa(),
                'exercicio' => $exercicio,
            ]);

        // SOMANDO OS VALORES DAS SOLICITAÇÕES
        $soma = 0;
        $boReservaSaldo = '';
        $emMapa = $this->modelManager->getEntityManager('CoreBundle:Compras\Mapa');
        $mapaModel = new MapaModel($emMapa);
        /** @var Compras\MapaSolicitacao $mSolicitacao */
        foreach ($mapaSolicitacao as $mSolicitacao) {
            $valor = $mapaModel->montaRecuperaValoresTotaisSolicitacao(
                $mSolicitacao->getCodSolicitacao(),
                $mSolicitacao->getExercicioSolicitacao(),
                $mSolicitacao->getCodEntidade()
            );
            $soma = $soma + $valor[0]->total;

            $reserva = $mapaModel->montaRecuperaMapaItemReserva(
                $mSolicitacao->getCodSolicitacao(),
                $mSolicitacao->getExercicioSolicitacao(),
                $mSolicitacao->getCodEntidade(),
                $licitacao->getCodMapa()
            );
            if (count($reserva) > 0) {
                if ($boReservaRigida) {
                    $boReservaSaldo = false;
                }
            }
        }

        $formData = $this->getForm();

        $mapaModalidadeModel = new MapaModalidadeModel($entityManager);
        $mapaModalidadeModel->buildOne($licitacao->getFkComprasMapa(), $licitacao->getFkComprasModalidade());

        $comissao = $formData->get('comissao')->getData();

        $comissaoLicitacaoModel = new ComissaoLicitacaoModel($entityManager);
        $comissaoLicitacao = $comissaoLicitacaoModel->insertComissaoLicitacao($licitacao, $comissao);

        /** @var ComissaoMembros $comissaoMembros */
        $comissaoMembros = $entityManager
            ->getRepository(ComissaoMembros::class)
            ->findBy([
                'codComissao' => $comissao,
            ]);

        if (count($comissaoMembros) > 0) {
            $comissaoMembrosModel = new ComissaoLicitacaoMembrosModel($entityManager);
            foreach ($comissaoMembros as $cMembro) {
                $comissaoMembrosModel->insertComissaMembros($comissaoLicitacao, $cMembro);
            }
        }
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getCodProcessoFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        if (is_numeric($value['value'])) {
            $queryBuilder->orWhere("$alias.codProcesso = :value");
            $queryBuilder->setParameter('value', $value['value']);
        }
        $queryBuilder
            ->join("$alias.fkSwProcesso", 'p')
            ->join("p.fkSwAssunto", 'a')
            ->join("p.fkSwProcessoInteressados", 'pi')
            ->join("pi.fkSwCgm", 'cgm')
            ->orWhere('LOWER(a.nomAssunto) like :query')
            ->orWhere('LOWER(cgm.nomCgm) like :query');
        $query = strtolower("%{$value['value']}%");
        $queryBuilder->setParameter('query', $query);

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add('exercicio', null, [], null, [])
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade',
                ],
                null,
                [
                    'class' => Orcamento\Entidade::class,
                    'choice_label' => 'fkSwCgm.nomCgm',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ],
                    'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                        return $em->findAllByExercicioAsQueryBuilder($exercicio);
                    },
                    'placeholder' => 'label.selecione',
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade',
                ]
            )
            ->add(
                'fkSwProcesso',
                'composite_filter',
                [
                    'label' => 'label.comprasDireta.codProcesso',
                    'admin_code' => 'administrativo.admin.processo',
                ],
                'autocomplete',
                [
                    'class' => SwProcesso::class,
                    'route' => ['name' => 'urbem_core_filter_swprocesso_autocomplete'],
                    'attr' => [

                        'class' => 'select2-parameters ',
                    ],
                    'placeholder' => 'Selecione',
                ]
            )
            ->add('fkComprasModalidade', null, [
                'label' => 'label.comprasDireta.codModalidade',
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione',
            ])
            ->add(
                'vlCotado',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.vlCotado',
                ],
                null,
                [
                    'attr' => [
                        'class' => 'money ',
                    ],
                ]
            )
            ->add('registroPrecos');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLicitacaoExercicio')
            ->add('fkOrcamentoEntidade', null, [
                'associated_property' => function (Orcamento\Entidade $entidade) {
                    return "{$entidade->getCodEntidade()} - {$entidade->getFkSwCgm()->getNomCgm()}";
                },
                'label' => 'label.patrimonial.licitacao.entidade',
                'admin_code' => 'financeiro.admin.entidade',
            ])
            ->add('fkSwProcesso', 'string', [
                'label' => 'label.comprasDireta.codProcesso',
                'admin_code' => 'administrativo.admin.processo',
            ])
            ->add('fkComprasModalidade', null, [
                'associated_property' => function (Compras\Modalidade $modalidade) {
                    return "{$modalidade->getCodModalidade()} - {$modalidade->getDescricao()}";
                },
                'label' => 'label.comprasDireta.codModalidade',
            ])
            ->add('vlCotado', null, ['label' => 'label.patrimonial.licitacao.vlCotado'])
            ->add('_action', 'actions', [
                'actions' => array(
                    'edit' => [
                        'template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig',
                    ],
                    'delete' => [
                        'template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig',
                    ],
                ),
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        /** @var Licitacao $licitacao */
        $licitacao = $this->getSubject();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();

        $fieldOptions
            = [];
        $fieldOptions['numUnidadeUpdate'] = [
            'mapped' => false,
            'data'   => 0,
        ];

        $fieldOptions['codProcesso'] = [
            'attr'     => [
                'class' => 'select2-parameters ',
            ],
            'label'    => 'label.comprasDireta.codProcesso',
            'mapped'   => false,
            'required' => false,
            'route'    => ['name' => 'urbem_core_filter_swprocesso_autocomplete'],
            'data'     => [],
        ];

        $admin = $this;

        $mapaModel = new MapaModel($entityManager);
        $mapasDisponiveis = $mapaModel->getMapasDisponiveisArray($exercicio);
        $mapas = [];
        foreach ($mapasDisponiveis as $mapa) {
            $mapas[] = $mapa['cod_mapa'];
        }

        if (empty($mapas)) {
            $mapas[] = 0;
        }

        $fieldOptions['codTipoObjeto'] = [
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'required'    => true,
            'class'       => Compras\TipoObjeto::class,
            'label'       => 'label.patrimonial.licitacao.codTipoObjeto',
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codObjeto'] = [
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'required'    => true,
            'class'       => Objeto::class,
            'label'       => 'label.patrimonial.licitacao.codObjeto',
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['timestamp'] = [
            'label'           => 'label.patrimonial.licitacao.timestamp',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format'          => 'dd/MM/yyyy',
            'pk_class'        => DateTimeMicrosecondPK::class,
        ];

        $fieldOptions['codModalidade'] = [
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'required'    => true,
            'class'       => Compras\Modalidade::class,
            'label'       => 'label.patrimonial.licitacao.codModalidade',
            'placeholder' => 'label.patrimonial.licitacao.selecioneMapa',
        ];

        $fieldOptions['codCriterio'] = [
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'required'    => true,
            'class'       => CriterioJulgamento::class,
            'label'       => 'label.patrimonial.licitacao.codCriterio',
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['orgaoOrg'] = [
            'class'         => Orcamento\Orgao::class,
            'choice_label'  => function (Orcamento\Orgao $orgaoOrg) {
                return $orgaoOrg;
            },
            'label'         => 'label.bem.orgaoOrg',
            'mapped'        => false,
            'required'      => true,
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'choice_value'  => 'numOrgao',
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('orgaoOrg');
                $result = $qb->where('orgaoOrg.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
            'placeholder'   => 'label.selecione',
        ];

        $fieldOptions['unidade'] = [
            'class'        => Orcamento\Unidade::class,
            'choice_label' => function (Orcamento\Unidade $unidade) {
                return $unidade;
            },
            'label'        => 'label.bem.unidade',
            'mapped'       => false,
            'required'     => true,
            'attr'         => [
                'class'    => 'select2-parameters ',
                'disabled' => 'disabled',
            ],
            'placeholder'  => 'label.selecione',
        ];

        $fieldOptions['registroPrecos'] = [
            'label' => 'label.patrimonial.licitacao.registroPrecos',
            'attr'  => [
                'readonly' => 'readonly',
            ],
        ];

        $fieldOptions['itens'] = [
            'mapped'   => false,
            'required' => false,
            'attr'     => [
                'expanded' => false,
                'multiple' => true,
                'class'    => 'select2-parameters ',
            ],
        ];

        $fieldOptions['vlCotado'] = [
            'label' => 'label.patrimonial.licitacao.vlCotado',
            'attr'  => [
                'class'    => 'money ',
                'readonly' => 'readonly',
            ],
        ];

        $fieldOptions['tipoCotacao'] = [
            'label'  => 'label.patrimonial.licitacao.tipoCotacao',
            'attr'   => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
        ];

        $fieldOptions['getModalidade'] = [
            'mapped' => false,
        ];

        $fieldOptions['chamadaPublica'] = [
            'label'       => 'label.patrimonial.licitacao.chamadaPublica',
            'required'    => false,
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'choices'     => [
                'Sim' => 2,
                'Não' => 0,
            ],
            'placeholder' => 'label.selecione',
            'mapped'      => false,
        ];

        $comissaoModel = new ComissaoModel($entityManager);

        $codComissoesChoices = [];

        foreach ($comissaoModel->getComissaoAtivas() as $comissao) {
            $choiceKey = $comissao['finalidade'] . ' | Vigência: ' . $comissao['dt_publicacao'] . ' ' . $comissao['dt_termino'];
            $choiceValue = $comissao['cod_comissao'];

            $codComissoesChoices[$choiceKey] = $choiceValue;
        }

        $fieldOptions['comissao'] = [
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'mapped'      => false,
            'choices'     => $codComissoesChoices,
            'required'    => true,
            'placeholder' => 'label.selecione',
            'label'       => 'label.patrimonial.licitacao.comissao',
        ];

        $fieldOptions['comissaoMembros'] = [
            'label'    => 'label.patrimonial.licitacao.comissaoMembros',
            'mapped'   => false,
            'required' => false,
            'choices'  => [],
            'attr'     => [
                'class' => 'select2-parameters ',
            ],
            'expanded' => false,
            'multiple' => true,
        ];

        $fieldOptions['codClassificacao'] = [
            'class'       => SwClassificacao::class,
            'mapped'      => false,
            'label'       => 'label.bem.codClassificacao',
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codAssunto'] = [
            'class'       => SwAssunto::class,
            'mapped'      => false,
            'label'       => 'label.bem.codAssunto',
            'placeholder' => 'label.selecione',
            'attr'        => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['procAdministrativo'] = [
            'class'         => SwProcesso::class,
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'label'         => 'label.bem.procAdministrativo',
            'mapped'        => false,
            'placeholder'   => 'label.selecione',
            'required'      => true,
            'query_builder' => function (EntityRepository $entityManager) {
                $qb = $entityManager->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
        ];

        $fieldOptions['fkLicitacaoDocumentos'] = [
            'class'    => Documento::class,
            'label'    => 'label.patrimonial.licitacao.documentoExigidos',
            'mapped'   => false,
            'multiple' => true,
        ];

        $disabledEdit = false;
        $dataCodLicitacao = null;
        if (!is_null($id)) {
            $fieldOptions['codMapa']['data'] = $licitacao->getFkComprasMapa();

            $fieldOptions['comissao']['data'] = ($licitacao->getFkLicitacaoComissaoLicitacoes()->first()->getCodComissao());
            $mapas[] = $licitacao->getFkComprasMapa()->getCodMapa();

            /** @var ComissaoLicitacao $comissaoLicitacoes */
            $comissaoLicitacoes = $this->getSubject()->getFkLicitacaoComissaoLicitacoes();
            $licitacaoCodComissao = null;

            if ($comissaoLicitacoes->count()) {
                $licitacaoCodComissao = $comissaoLicitacoes->first();
            }

            $fieldOptions['comissao']['data'] = $licitacaoCodComissao->getCodComissao();

            if ($licitacao->getFkSwProcesso()) {
                $fieldOptions['codClassificacao']['data'] = $licitacao->getFkSwProcesso()
                    ->getFkSwAssunto()->getFkSwClassificacao();
                $assunto = $licitacao->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['codAssunto']['choice_value'] = function (SwAssunto $assunto) {
                    return $this->getObjectKey($assunto);
                };
                $fieldOptions['codAssunto']['data'] = $licitacao->getFkSwProcesso()
                    ->getFkSwAssunto();
                $processo = $licitacao->getFkSwProcesso();
                $fieldOptions['procAdministrativo']['query_builder'] =
                    function (EntityRepository $entityManager) use ($processo) {
                        $qb = $entityManager->createQueryBuilder('processo');
                        $result = $qb
                            ->where('processo.codProcesso = :codProcesso')
                            ->andWhere('processo.anoExercicio = :anoExercicio')
                            ->setParameter(':codProcesso', $processo->getCodProcesso())
                            ->setParameter(':anoExercicio', $processo->getAnoExercicio());

                        return $result;
                    };
                $processo = $licitacao->getFkSwProcesso();
                $fieldOptions['procAdministrativo']['choice_value'] = function (SwProcesso $processo) {
                    return $this->getObjectKey($processo);
                };
                $fieldOptions['procAdministrativo']['data'] = $processo;
            }
            $fieldOptions['codModalidade']['data'] = $licitacao->getFkComprasModalidade();
            $fieldOptions['getModalidade']['data'] = $licitacao->getCodModalidade();

            $fieldOptions['orgaoOrg']['data'] = $licitacao->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
            $fieldOptions['chamadaPublica']['data'] = $licitacao->getTipoChamadaPublica();
            $disabledEdit = true;
            $dataCodLicitacao = $licitacao->getCodLicitacao();

            $fieldOptions['fkLicitacaoDocumentos']['data'] = $licitacao
                ->getFkLicitacaoLicitacaoDocumentos()
                ->map(function (LicitacaoDocumentos $licitacaoDocumentos) {
                    return $licitacaoDocumentos->getFkLicitacaoDocumento();
                });
        }

        $fieldOptions['codEntidade'] = [
            'attr'          => ['class' => 'select2-parameters '],
            'label'         => 'label.comprasDireta.codEntidade',
            'placeholder'   => 'label.selecione',
            'required'      => true,
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
        ];

        $fieldOptions['codMapa'] = [
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'label'         => 'label.comprasDireta.codMapa',
            'choice_value'  => function ($mapa) use ($admin) {
                if (is_null($mapa)) {
                    return;
                }

                return $admin->getObjectKey($mapa);
            },
            'required'      => true,
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $entityManager) use ($mapas, $exercicio) {
                $qb = $entityManager->createQueryBuilder('codMapa');
                $result = $qb->where('codMapa.exercicio = :exercicio')
                    ->andWhere($qb->expr()->in('codMapa.codMapa', $mapas))
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            },
        ];

        $formMapper
            ->with('label.patrimonial.licitacao.dadoslicitacao');

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $numeracaoAutomaticaLicitacao = $configuracaoModel->getConfiguracao('numeracao_automatica_licitacao', ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, true, $this->getExercicio());
        if ($numeracaoAutomaticaLicitacao == 'false') {
            $fieldOptions['codLicitacao'] = [
                'label'  => 'label.patrimonial.licitacao.codLicitacao',
                'attr'   => [
                    'class'     => ' numero ',
                    'maxlength' => '20',
                    'readonly'  => $disabledEdit,
                ],
                'data'   => $dataCodLicitacao,
                'mapped' => false,
            ];

            $formMapper->add('codLicitacao', 'text', $fieldOptions['codLicitacao']);
        }

        $formMapper
            ->add('codHExercicio', 'hidden', ['data' => $this->getExercicio(), 'mapped' => false])
            ->add('codClassificacao', 'entity', $fieldOptions['codClassificacao'])
            ->add('codAssunto', 'entity', $fieldOptions['codAssunto'])
            ->add('codProcesso', 'entity', $fieldOptions['procAdministrativo'])
            ->add('fkComprasMapa', null, $fieldOptions['codMapa'])
            ->add('fkOrcamentoEntidade', null, $fieldOptions['codEntidade'], [
                'admin_code' => 'financeiro.admin.entidade',
            ])
            ->add('timestamp', 'datepkpicker', $fieldOptions['timestamp'])
            ->add('vlCotado', null, $fieldOptions['vlCotado'])
            ->add('tipoCotacao', 'text', $fieldOptions['tipoCotacao'])
            ->add('registroPrecos', 'text', $fieldOptions['registroPrecos'])
            ->add('fkComprasModalidade', null, $fieldOptions['codModalidade'])
            ->add('getModalidade', 'hidden', $fieldOptions['getModalidade'])
            ->add('fkLicitacaoCriterioJulgamento', null, $fieldOptions['codCriterio'])
            ->add('fkComprasTipoObjeto', null, $fieldOptions['codTipoObjeto'])
            ->add('fkComprasObjeto', null, $fieldOptions['codObjeto'])
            ->add('codTipoChamadaPublica', 'choice', $fieldOptions['chamadaPublica'])
            ->add('fkLicitacaoDocumento', 'entity', $fieldOptions['fkLicitacaoDocumentos'])
            ->end()
            ->with('label.ppaAcao.unidadeExecutora')
            ->add(
                'orgaoOrg',
                'entity',
                $fieldOptions['orgaoOrg']
            )
            ->add('codUnidade', 'hidden', ['data' => $licitacao->getNumUnidade(), 'mapped' => false])
            ->add(
                'unidade',
                'entity',
                $fieldOptions['unidade']
            )
            ->add('numUnidadeUpdate', 'hidden', $fieldOptions['numUnidadeUpdate'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 comprasdireta-items',
            ])
            ->end()
            ->with('label.patrimonial.licitacao.dadoscomissaolicitacao')
            ->add('comissao', 'choice', $fieldOptions['comissao'])
            ->add('comissaoMembros', 'choice', $fieldOptions['comissaoMembros'])
            ->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $comissaoModel) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if (isset($data['comissao']) && $data['comissao'] != "") {
                    $comissaoMembros = $comissaoModel->getMembrosComissao($data['comissao']);

                    $dados = [];
                    foreach ($comissaoMembros as $membro) {
                        $key = $membro['nom_cgm']
                            . ' - ' . $membro['tipo_membro']
                            . ' - ' . $membro['dt_publicacao']
                            . ' - ' . $membro['cargo'];
                        $dados[$key] = $membro['numcgm'];
                    }

                    $comMembros = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'comissaoMembros',
                        'choice',
                        null,
                        [
                            'choices'         => $dados,
                            'label'           => 'label.patrimonial.licitacao.comissaoMembros',
                            'mapped'          => false,
                            'auto_initialize' => false,
                            'attr'            => [
                                'class' => 'select2-parameters ',
                            ],
                            'expanded'        => false,
                            'multiple'        => true,
                        ]
                    );

                    $form->add($comMembros);
                }
            }
        );
        $assuntoModel = new SwAssuntoModel($entityManager);
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = [];
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr'            => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices'         => $dados,
                            'label'           => 'label.bem.codAssunto',
                            'mapped'          => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );
        $processoModel = new SwProcessoModel($entityManager);
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

                    $dados = [];
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
                            'attr'            => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices'         => $dados,
                            'label'           => 'label.bem.procAdministrativo',
                            'mapped'          => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
    }

    /**
     * @param ErrorElement $errorElement
     * @param Licitacao    $licitacao
     */
    public function validate(ErrorElement $errorElement, $licitacao)
    {
        /** @var Collection $documentos */
        $documentos = $this->getForm()->get('fkLicitacaoDocumento')->getData();

        $licitacaoDocumentosRemovidos = $licitacao
            ->getFkLicitacaoLicitacaoDocumentos()
            ->filter(function (LicitacaoDocumentos $licitacaoDocumento) use ($documentos) {
                return !$documentos->contains($licitacaoDocumento->getFkLicitacaoDocumento());
            });

        $licitacaoDocumentoModel = new LicitacaoDocumentosModel($this->getEntityManager());

        /** @var LicitacaoDocumentos $licitacaoDocumentoRemovido */
        foreach ($licitacaoDocumentosRemovidos as $licitacaoDocumentoRemovido) {
            if (!$licitacaoDocumentoModel->canRemove($licitacaoDocumentoRemovido)) {
                $errorElement
                    ->with('fkLicitacaoDocumento')
                    ->addViolation($this->trans('licitacao.errors.documentoRemovido', ['%documento%' => (string) $licitacaoDocumentoRemovido], 'validators'))
                    ->end();
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var Licitacao $licitacao */
        $licitacao = $this->getSubject();
        $licitacao->licitacao = $licitacao;
        $licitacao->passivelAdjudicacao = is_null($licitacao->getFkLicitacaoAdjudicacao()) ? false : true;
        $licitacao->passivelHomologacao = !\is_null($licitacao->getFkLicitacaoAdjudicacao()) ? true : false;
        $licitacao->comissoesMembros = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\ComissaoLicitacaoMembros')
            ->findBy([
                'codLicitacao' => $licitacao->getCodLicitacao(),
                'exercicio' => $licitacao->getExercicio(),
                'codModalidade' => $licitacao->getCodModalidade(),
                'codEntidade' => $licitacao->getCodEntidade(),
            ]);
        $licitacao->membrosAdicionais = $licitacao->getFkLicitacaoMembroAdicionais();
        $licitacao->documentos = $licitacao->getFkLicitacaoLicitacaoDocumentos();
        $licitacao->participantes = $licitacao->getFkLicitacaoParticipantes();
        $licitacao->documentoParticipantes = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\ParticipanteDocumentos')
            ->findBy([
                'codLicitacao' => $licitacao->getCodLicitacao(),
                'exercicio' => $licitacao->getExercicio(),
                'codModalidade' => $licitacao->getCodModalidade(),
                'codEntidade' => $licitacao->getCodEntidade(),
            ]);

        // Para AS modalidades 1,2,3,4,5,6,7,10,11 é obrigatório exister um edital
        $arrayModalidadesEdital = [1, 2, 3, 4, 5, 6, 7, 10, 11];
        // Para AS modalidades 8,9 é facultativo possuir um edital
        $arrayModalidadesNaoEdital = [8, 9];
        $licitacao->habilitaParticipante = false;

        if (in_array($licitacao->getFkComprasModalidade()->getCodModalidade(), $arrayModalidadesEdital) && $licitacao->getFkLicitacaoEditais()->last()) {
            $licitacao->habilitaParticipante = true;
        }
        if (in_array($licitacao->getFkComprasModalidade()->getCodModalidade(), $arrayModalidadesNaoEdital)) {
            $licitacao->habilitaParticipante = true;
        }
    }

    /**
     * @param string $context
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var $query \Doctrine\ORM\QueryBuilder */
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];

        $select = [];
        $select[] = $alias;

        foreach ([
                     'fkLicitacaoJustificativaRazao',
                     'fkTcemgResplic',
                     'fkTcmgoResponsavelLicitacao',
                     'fkTcmgoResponsavelLicitacaoDispensa',
                     'fkLicitacaoLicitacaoAnulada',
                     'fkTcemgLicitacaoTc',
                     'fkOrcamentoEntidade',
                 ] as $fkName) {
            $query->leftJoin(sprintf('%s.%s', $alias, $fkName), $fkName);
            $select[] = $fkName;
        }
        $query->select(implode(', ', $select));

        $filter = $this->getRequest()->get('filter');

        if (!$filter) {
            $query->andWhere("$alias.exercicio = :exercicio")
                ->setParameter('exercicio', $this->getExercicio());
        }

        if ($filter && $swProcesso = $filter['fkSwProcesso']['value']) {
            list($codProcesso, $exercicioProcesso) = explode('~', $swProcesso);
            $query->andWhere("$alias.codProcesso = :codProcesso")
                ->andWhere("$alias.exercicioProcesso = :exercicioProcesso")
                ->setParameter('codProcesso', $codProcesso)
                ->setParameter('exercicioProcesso', $exercicioProcesso);
        }

        return $query;
    }

    /**
     * @param Licitacao $licitacao
     */
    public function removeLicitacaoDocumetos(Licitacao $licitacao)
    {
        /** @var Collection $documentos */
        $documentos = $this->getForm()->get('fkLicitacaoDocumento')->getData();

        $licitacaoDocumentosRemovidos = $licitacao
            ->getFkLicitacaoLicitacaoDocumentos()
            ->filter(function (LicitacaoDocumentos $licitacaoDocumento) use ($documentos) {
                return !$documentos->contains($licitacaoDocumento->getFkLicitacaoDocumento());
            });

        $licitacaoDocumentosModel = new LicitacaoDocumentosModel($this->getEntityManager());

        foreach ($licitacaoDocumentosRemovidos as $licitacaoDocumentoRemovido) {
            $licitacaoDocumentosModel->remove($licitacaoDocumentoRemovido);
        }
    }

    /**
     * @param Licitacao $licitacao
     */
    public function preUpdate($licitacao)
    {
        $this->prePersist($licitacao);
        $this->removeLicitacaoDocumetos($licitacao);
    }

    /**
     * @param mixed $licitacao
     */
    public function postUpdate($licitacao)
    {
        $this->forceRedirect("/patrimonial/licitacao/licitacao/{$this->getObjectKey($licitacao)}/show");
    }
}
