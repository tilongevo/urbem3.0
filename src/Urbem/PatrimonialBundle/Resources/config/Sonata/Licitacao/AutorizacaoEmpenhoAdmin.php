<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Exception\Error;
use Sonata\CoreBundle\Validator\ErrorElement;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;

use Urbem\CoreBundle\Model;

class AutorizacaoEmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_autorizacao_empenho';
    protected $baseRoutePattern = 'patrimonial/licitacao/autorizacao-empenho';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    /**
     * Rotas Personalizadas
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/autorizacao-empenho-licitacao.js',
    ];

    /**
     * Lista Customizada
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $licitacaoModel = new Model\Patrimonial\Licitacao\LicitacaoModel($entityManager);


        /**
         * @var \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery $query
         */
        $query = parent::createQuery($context);
        $query = $licitacaoModel->getAutorizacoesEmpenhoDisponiveis($query, $this->getExercicio());


        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkOrcamentoEntidade',
                null,
                [ 'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade' ],
                'entity',
                [
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'fkComprasModalidade',
                null,
                [ 'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codModalidade' ],
                'entity',
                [
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'codLicitacao',
                null,
                [ 'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codLicitacao' ]
            )
            ->add(
                'timestamp',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.timestampRange',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'fkComprasMapa',
                null,
                [ 'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codMapa' ],
                'entity',
                [
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
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
                'fkOrcamentoEntidade',
                'text',
                [
                    'admin_code' => 'financeiro.admin.entidade',
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'fkComprasModalidade',
                'entity',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codModalidade',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'codLicitacao',
                null,
                [ 'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codLicitacao' ]
            )
            ->add(
                'timestamp',
                'date',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.timestamp',
                ]
            )
            ->add(
                'fkComprasMapa',
                'text',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codMapa',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
        ;

        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
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
        /** @var Entity\Licitacao\Licitacao $licitacao */
        $licitacao = $this->getSubject();

        $fieldOptions['hCodEntidade'] = [
            'mapped' => false,
            'data' => $licitacao->getFkOrcamentoEntidade()->getCodEntidade()
        ];
        $fieldOptions['hCodLicitacao'] = [
            'mapped' => false,
            'data' => $licitacao->getCodLicitacao()
        ];
        $fieldOptions['hCodModalidade'] = [
            'mapped' => false,
            'data' => $licitacao->getFkComprasModalidade()->getCodModalidade()
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.exercicio',
            'required' => false,
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codEntidade'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getFkOrcamentoEntidade()->getCodEntidade().' - '.
                $licitacao->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codLicitacao'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codLicitacao',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getCodLicitacao().'/'.
                $licitacao->getExercicio(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['dtLicitacao'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.dtLicitacao',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getTimeStamp()->format('d/m/Y'),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codTipoObjeto'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codTipoObjeto',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getCodTipoObjeto().' - '.
                $licitacao->getFkComprasTipoObjeto()->getDescricao(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codObjeto'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codObjeto',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getFkComprasObjeto()->getCodObjeto().' - '.
                $licitacao->getFkComprasObjeto()->getDescricao(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['dtEntregaProposta'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.dtEntregaProposta',
            'mapped' => false,
            'required' => false,
            'data' => ($licitacao->getFkLicitacaoEditais()[0] ? $licitacao->getFkLicitacaoEditais()[0]->getDtAberturaPropostas()->format('d/m/Y') : ''),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['dtValidadeProposta'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.dtValidadeProposta',
            'mapped' => false,
            'required' => false,
            'data' => ($licitacao->getFkLicitacaoEditais()[0] ? $licitacao->getFkLicitacaoEditais()[0]->getDtValidadeProposta()->format('d/m/Y') : ''),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['condicoesPagamento'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.condicoesPagamento',
            'mapped' => false,
            'required' => false,
            'data' => ($licitacao->getFkLicitacaoEditais()[0] ? $licitacao->getFkLicitacaoEditais()[0]->getCondicoesPagamento() : ''),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codModalidade'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codModalidade',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getFkComprasModalidade()->getCodModalidade().' - '.
                $licitacao->getFkComprasModalidade()->getDescricao(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codCotacao'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codCotacao',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getCodCotacao().'/'.
                $licitacao->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getFkComprasCotacao()->getExercicio(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        $fieldOptions['codMapa'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codMapa',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao->getFkComprasMapa()->getCodMapa().'/'.
                $licitacao->getFkComprasMapa()->getExercicio(),
            'attr' => array(
                'readonly' => 'readonly'
            )
        ];

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $licitacaoModel = new Model\Patrimonial\Licitacao\LicitacaoModel($entityManager);
        $params = [
            'codLicitacao' => $licitacao->getCodLicitacao(),
            'codModalidade' => $licitacao->getCodModalidade(),
            'codEntidade' => $licitacao->getCodEntidade(),
            'exercicio' => $licitacao->getExercicio()
        ];


        $now = new \DateTime();
        $formMapper
            ->with('label.patrimonial.licitacao.autorizacaoEmpenho.dadosLicitacao')
                ->add(
                    'hCodEntidade',
                    'hidden',
                    $fieldOptions['hCodEntidade']
                )
                ->add(
                    'hCodModalidade',
                    'hidden',
                    $fieldOptions['hCodModalidade']
                )
                ->add(
                    'hCodLicitacao',
                    'hidden',
                    $fieldOptions['hCodLicitacao']
                )
                ->add(
                    'exercicio',
                    'text',
                    $fieldOptions['exercicio']
                )
                ->add(
                    'codEntidade',
                    'text',
                    $fieldOptions['codEntidade'],
                    [ 'admin_code' => 'financeiro.admin.entidade' ]
                )
                ->add(
                    'codLicitacao',
                    'text',
                    $fieldOptions['codLicitacao']
                )
                ->add(
                    'dtLicitacao',
                    'text',
                    $fieldOptions['dtLicitacao']
                )
                ->add(
                    'codTipoObjeto',
                    'text',
                    $fieldOptions['codTipoObjeto']
                )
                ->add(
                    'codObjeto',
                    'text',
                    $fieldOptions['codObjeto']
                )
                ->add(
                    'dtEntregaProposta',
                    'text',
                    $fieldOptions['dtEntregaProposta']
                )
                ->add(
                    'dtValidadeProposta',
                    'text',
                    $fieldOptions['dtValidadeProposta']
                )
                ->add(
                    'condicoesPagamento',
                    'text',
                    $fieldOptions['condicoesPagamento']
                )
                ->add(
                    'codModalidade',
                    'text',
                    $fieldOptions['codModalidade']
                )
                ->add(
                    'codCotacao',
                    'text',
                    $fieldOptions['codCotacao']
                )
                ->add(
                    'codMapa',
                    'text',
                    $fieldOptions['codMapa']
                )
            ->end()
            ->with('label.patrimonial.licitacao.autorizacaoEmpenho.AutorizacaoEmpenho')
                ->add(
                    'dtAutorizacao',
                    'datepkpicker',
                    [
                        'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.dtAutorizacao',
                        'format' => 'dd/MM/yyyy',
                        'pk_class' => DateTimeMicrosecondPK::class,
                        'mapped' => false,
                        'required' => false,
                        'dp_max_date' => $now,
                        'data' => $now
                    ]
                )
            ->end()
            ->with(
                'label.patrimonial.licitacao.autorizacaoEmpenho.autorizacaoItens',
                [
                    'class' => 'col s12 autorizacao-empenho-itens'
                ]
            )
            ->end()
        ;
    }

    /**
     * Redireciona para listagem com mensagem adicional
     *
     * @param string $message
     * @param string $type
     */
    public function redirect($message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/licitacao/autorizacao-empenho/list");
    }

    /**
     * @param ErrorElement $errorElement
     * @param RequisicaoItem $requisicaoItem
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $form = $this->getForm();
        // data máxima para a entidade
        $data = $form->get('dtAutorizacao')->getData()->format("d/m/Y");
        $ano = substr($data, 6, 4);
        $mes = substr($data, 3, 2);
        $dia = substr($data, 0, 2);
        $dataFormatadaEntidade = $ano.$mes.$dia;

        if ($dataFormatadaEntidade - (date("Y").date("m").date("d")) > 0) {
            $message = $this->trans('licitacao.autorizacaoEmpenho.errors.dtAutorizacaoMaiorAtual', [], 'validators');
            $errorElement->with('dtAutorizacao')->addViolation($message)->end();
        }
    }

    /**
     * Realiza as modificações necessárias para a persistência dos dados
     *
     * @param Entity\Licitacao\Licitacao $object
     * @param array $form
     */
    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();

        // Recupera os grupos de Autorização de Empenho
        $em = $this->modelManager->getEntityManager($this->getClass());
        $licitacaoModel = new Model\Patrimonial\Licitacao\LicitacaoModel($em);

        $codLicitacao = $form['hCodLicitacao'];
        $codModalidade = $form['hCodModalidade'];
        $codEntidade = $form['hCodEntidade'];
        $exercicioEntidade = $form['exercicio'];

        $paramsGrupos = [
            'codLicitacao' => $codLicitacao,
            'codModalidade' => $codModalidade,
            'codEntidade' => $codEntidade,
            'exercicio' => $exercicioEntidade
        ];

        $arItensAutorizacao = [];
        $arItensAutorizacaoImp = [];
        $user = $this->getCurrentUser()->getNumcgm();
        $grupos = $licitacaoModel->recuperaGrupoAutEmpenho($paramsGrupos);
        foreach ($grupos as $grupo) {
            // Recupera os itens dos grupos de Autorização de Empenho
            $fornecedor = $grupo->fornecedor;
            $codDespesa = $grupo->cod_despesa;
            $codConta = $grupo->cod_conta;

            $paramsItens = [
                'codLicitacao' => $codLicitacao,
                'codModalidade' => $codModalidade,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicioEntidade,
                'cgmFornecedor' => $fornecedor,
                'codDespesa' => $codDespesa,
                'codConta' => $codConta
            ];

            // Recupera Configuração para Reserva Rígida
            $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
            $configuracaoModel = new Model\Administracao\ConfiguracaoModel($em);

            $boolReservaRigida = $configuracaoModel->pegaConfiguracao(
                'reserva_rigida',
                Entity\Administracao\Modulo::MODULO_PATRIMONIAL_COMPRAS,
                $exercicioEntidade,
                true
            );
            $boolReservaAutorizacao = $configuracaoModel->pegaConfiguracao(
                'reserva_autorizacao',
                Entity\Administracao\Modulo::MODULO_PATRIMONIAL_COMPRAS,
                $exercicioEntidade,
                true
            );

            if ($boolReservaRigida == 'true' && $boolReservaAutorizacao == 'true') {
                $rsSolicitacaoReserva = $licitacaoModel->recuperaItensAgrupadosSolicitacaoLicitacaoMapa($paramsItens);

                foreach ($rsSolicitacaoReserva as $reserva) {
                    $despesaModel = new Model\Orcamento\DespesaModel($em);
                    $rsSaldoDotacao = $despesaModel->recuperaSaldoDotacao($this->getExercicio(), $reserva->cod_despesa);
                    if (!isset($arSaldoDotacao[$reserva->cod_despesa])) {
                        $arSaldoDotacao[$reserva->cod_despesa]['saldo_inicial'] = $rsSaldoDotacao[0]['saldo_dotacao'];
                        $arSaldoDotacao[$reserva->cod_despesa]['vl_reserva'] = $reserva->vl_cotacao;
                    } else {
                        $arSaldoDotacao[$reserva->cod_despesa]['vl_reserva'] += $reserva->vl_cotacao;
                    }

                    // Persist Reserva Saldos
                    $em = $this->modelManager->getEntityManager('CoreBundle:Orcamento\ReservaSaldos');
                    $reservaSaldosModel = new Model\Orcamento\ReservaSaldosModel($em);

                    $stMsgReserva  = "Entidade: ".$form['codEntidade'].", ";
                    $stMsgReserva .= "Mapa de Compras: ".$form['codMapa'].", ";
                    $stMsgReserva .= "Item: ".$form['codObjeto'].", ";
                    $stMsgReserva .= "Centro de Custo: " . $reserva->cod_centro . ", ";
                    $stMsgReserva .= "(Origem da criação: Licitacao/Autorização de Empenho).";

                    $dtFinal = '31/12/' . $this->getExercicio();

                    $dtValidadeInicial = date('d/m/Y');

                    $codReserva = $reservaSaldosModel->getProximoCodReserva($this->getExercicio());
                    $reservaInserida = $reservaSaldosModel->montaincluiReservaSaldo(
                        $codReserva,
                        $this->getExercicio(),
                        $reserva->cod_despesa,
                        $dtValidadeInicial,
                        $dtFinal,
                        $reserva->vl_cotacao,
                        'A',
                        $stMsgReserva
                    );

                    // Persiste Mapa Item Reserva
                    if ($reservaInserida[0]['fn_reserva_saldo'] == true) {
                        $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($codReserva, $this->getExercicio());
                        $mapaItemDotacaoModel = new Model\Patrimonial\Compras\MapaItemDotacaoModel($em);
                        $mapaItemDotacao = $mapaItemDotacaoModel->getOneMapaItemDotacao(
                            $reserva
                        );

                        $obTComprasMapaItemReserva = new Entity\Compras\MapaItemReserva();
                        $obTComprasMapaItemReservaModel = new Model\Patrimonial\Compras\MapaItemReservaModel($em);
                        $obTComprasMapaItemReserva->setFkComprasMapaItemDotacao($mapaItemDotacao);
                        $obTComprasMapaItemReserva->setFkOrcamentoReservaSaldos($reservaSaldos);
                        $obTComprasMapaItemReservaModel->save($obTComprasMapaItemReserva);
                    } else {
                        $stSolicitacao = $reserva->cod_solicitacao. '/' . $reserva->exercicio_solicitacao;
                        $arSaldoDotacaoFormatado = number_format($arSaldoDotacao[$reserva->cod_despesa]['saldo_inicial'], 2, ',', '.');

                        $message = $this->trans(
                            'AutorizacaoEmpenhoCompraDiretaReservarItem',
                            [
                                '%cod_item%' => $reserva->cod_item,
                                '%stSolicitacao%' => $stSolicitacao,
                                '%arSaldoDotacao%' => $arSaldoDotacaoFormatado,
                            ],
                            'validators'
                        );
                        $this->redirect($message, 'error');
                    }
                }
            }
            /* end if */

            $rsItensAutEmpenho = $licitacaoModel->recuperaItensAgrupadosSolicitacaoLicitacao($paramsItens);
            $arItensAutorizacao[] = $rsItensAutEmpenho;

            $rsItensAutEmpenhoImp = $licitacaoModel->recuperaItensAgrupadosSolicitacaoLicitacaoImp($paramsItens);
            $arItensAutorizacaoImp[] = $rsItensAutEmpenhoImp;

            // Valida e Persiste Reserva Saldos Anulada
            foreach ($rsItensAutEmpenho as $item) {
                $obTOrcamentoReservaSaldosAnuladaModel = new Model\Orcamento\ReservaSaldosAnuladaModel($em);

                $obTOrcamentoReservaSaldosAnulada = $obTOrcamentoReservaSaldosAnuladaModel->
                getOneByCodReservaAndExercicio(
                    $item->cod_reserva,
                    $item->exercicio
                );

                if (is_null($obTOrcamentoReservaSaldosAnulada)) {
                    $reservaSaldosModel = new Model\Orcamento\ReservaSaldosModel($em);
                    /** @var Entity\Orcamento\ReservaSaldos $reservaSaldos */
                    $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos(
                        $item->cod_reserva,
                        $item->exercicio_solicitacao
                    );
                    $rSaldoAnuladaModel = new Model\Orcamento\ReservaSaldosAnuladaModel($em);
                    $rSaldoAnuladaModel->saveReservaSaldosAnulada($reservaSaldos, $form);
                }
            }

            $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
            $entidadeModel = new Model\Orcamento\EntidadeModel($em);
            $entidade = $entidadeModel->find([
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

            $preEmpenhoModel = new Model\Empenho\PreEmpenhoModel($em);

            //Buscando o Tipo do Empenho
            $tipoEmpenhoModel = new Model\Empenho\TipoEmpenhoModel($em);
            $tipoEmpenho = $tipoEmpenhoModel->getOneTipoEmpenho(0);

            //Buscando o Fornecedor
            $fornecedorModel = new Model\Patrimonial\Compras\FornecedorModel($em);
            $fornecedor = $fornecedorModel->getFornecedor($grupo->fornecedor);

            //Adicionando o Historico
            $historicoModel = new Model\Empenho\HistoricoModel($em);
            $historico = $historicoModel->saveHistorico($grupo->exercicio);

            //Buscando a Categoria
            $categoriaModel = new Model\Empenho\CategoriaEmpenhoModel($em);
            $categoriaEmpenho = $categoriaModel->getOneByCodCategoria(1);

            //Buscando a Unidade
            $unidadeModel = new Model\Orcamento\UnidadeModel($em);
            $unidade = $unidadeModel->getOneByUnidadeOrgaoExercicio(
                $grupo->num_unidade,
                $grupo->num_orgao,
                $grupo->exercicio
            );

            //Buscando o Centro de Custo
            $centroCustoModel = new Model\Patrimonial\Almoxarifado\CentroCustoModel($em);
            $centroCusto = $centroCustoModel->getCentroCustoByCodCentro($grupo->cod_centro);

            //Buscando o Item
            $itemModel = new Model\Patrimonial\Almoxarifado\CatalogoItemModel($em);
            $item = $itemModel->getOneByCodItem($grupo->cod_item);

            //Buscando a Unidade Medida
            $unidadeMedida = new Model\Administracao\UnidadeMedidaModel($em);
            $unidadeMedida = $unidadeMedida->getOneByCodUnidadeCodGrandeza($grupo->cod_unidade, $grupo->cod_grandeza);

            /**
             * Salvando pre empenho
             */
            $obtPreEmpenho = $preEmpenhoModel->savePreEmpenho(
                $tipoEmpenho,
                $fornecedor,
                $user,
                $grupo->exercicio,
                $historico
            );

            $form = $this->getForm();
            $dtAutorizacao = $form->get('dtAutorizacao')->getData();

            /**
             * Salvando Autorização Empenho
             */
            $obTEmpenhoAutorizacaoEmpenho = new Model\Empenho\TipoDiariaModel($em);
            $obTEmpenhoAutorizacaoEmpenho->saveAutorizacaoEmpenho(
                $entidade,
                $grupo->exercicio,
                $unidade,
                $categoriaEmpenho,
                $dtAutorizacao,
                $obtPreEmpenho
            );

            $inNumItemCont = 1;
            foreach ($arItensAutorizacaoImp as $dadosItens) {
                /**
                 * Salvando o Item Pre Empenho
                 */
                $itemPreEmpenhoModel = new Model\Empenho\ItemPreEmpenhoModel($em);
                $itemPreEmpenhoModel->saveItemPreEmpenho(
                    $inNumItemCont,
                    $obtPreEmpenho,
                    $dadosItens,
                    $centroCusto,
                    $item,
                    $unidadeMedida
                );
                $inNumItemCont++;
            }
        }
        /* end foreach */
    }

    /**
     * Função executada antes do Update
     *
     * @param Entity\Licitacao\Licitacao $object
     */
    public function preUpdate($object)
    {
        try {
            $this->saveRelationships($object, $this->getRequest()->request->get($this->getUniqid()));
            $this->forceRedirect("/patrimonial/licitacao/autorizacao-empenho/list");
        } catch (\Exception $e) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/licitacao/autorizacao-empenho/{$this->getObjectKey($object)}/edit");
        }
    }
}
