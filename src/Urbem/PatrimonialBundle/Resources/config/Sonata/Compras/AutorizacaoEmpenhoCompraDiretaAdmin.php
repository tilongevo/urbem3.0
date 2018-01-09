<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Administracao\UnidadeMedidaModel;
use Urbem\CoreBundle\Model\Empenho\TipoDiariaModel;
use Urbem\CoreBundle\Model\Empenho\CategoriaEmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\HistoricoModel;
use Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\PermissaoAutorizacaoModel;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\TipoEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosAnuladaModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Orcamento\UnidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemReservaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Compras;

class AutorizacaoEmpenhoCompraDiretaAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_compras_autorizacao_empenho_compra_direta';
    protected $baseRoutePattern = 'patrimonial/compras/autorizar-empenho-compra-direta';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
    }

    protected $includeJs = [
        '/patrimonial/javascripts/compras/autorizacao-empenho-compra-direta.js',
    ];

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();

        $compraDiretaModel = new CompraDiretaModel($entityManager);

        $query = parent::createQuery($context);
        $query = $compraDiretaModel->getRecuperaNaoAutorizadas($query, $exercicio);

        return $query;
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $compraDiretaModel = new CompraDiretaModel($entityManager);

        $codCompraDireta = $formData['hcodCompraDireta'];
        $codModalidade = $formData['hcodModalidade'];
        $codEntidade = $formData['hcodEntidade'];
        $exercicioEntidade = $formData['hexercicio'];
        $itensAgrupados = $compraDiretaModel->montaRecuperaItensAgrupadosAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
        try {
            foreach ($itensAgrupados as $rsAutEmpenho) {
                $this->saveRelationships($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $rsAutEmpenho, $formData, $compraDiretaModel, $entityManager);
            }
        } catch (Exception $e) {
            throw $e;
        }

        $message = 'Item inserido com sucesso';
        $this->redirect($message);
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $compraDiretaModel
     * @param $entityManager
     */

    public function gravaReserva($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $compraDiretaModel, $entityManager)
    {
        $rsSolicitacaoReserva = $compraDiretaModel->montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
        foreach ($rsSolicitacaoReserva as $reserva) {
            $despesaModel = new DespesaModel($entityManager);
            $rsSaldoDotacao = $despesaModel->recuperaSaldoDotacao($this->getExercicio(), $reserva->cod_despesa);
            if (!isset($arSaldoDotacao[$reserva->cod_despesa])) {
                $arSaldoDotacao[$reserva->cod_despesa]['saldo_inicial'] = $rsSaldoDotacao[0]['saldo_dotacao'];
                $arSaldoDotacao[$reserva->cod_despesa]['vl_reserva'] = $reserva->vl_cotacao;
            } else {
                $arSaldoDotacao[$reserva->cod_despesa]['vl_reserva'] += $reserva->vl_cotacao;
            }

            // Mensagem do motivo da criação da Reserva de Saldo.
            $stMsgReserva = $this->geraMensagem($reserva);

            $dtFinal = '31/12/' . $this->getExercicio();

            $dtValidadeInicial = date('d/m/Y');

            $reservaSaldosModel = new ReservaSaldosModel($entityManager);
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

            if ($reservaInserida[0]['fn_reserva_saldo'] == true) {
                //Busca Reserva Saldos
                $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($codReserva, $this->getExercicio());

                //Busca o Mapa Item Dotacao
                $mapaItemDotacaoModel = new MapaItemDotacaoModel($entityManager);
                $mapaItemDotacao = $mapaItemDotacaoModel->getOneMapaItemDotacao($reserva);

                //Inserindo na Mapa Item Reserva
                $obTComprasMapaItemReservaModel = new MapaItemReservaModel($entityManager);
                $obTComprasMapaItemReservaModel->saveMapaItemReserva($mapaItemDotacao, $reservaSaldos);
            } else {
                $stSolicitacao = $reserva->cod_solicitacao . '/' . $reserva->exercicio_solicitacao;
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

    /**
     * @param $entityManager
     * @param $rsAutEmpenho
     * @param $stItens
     * @param $formData
     * @param $empenho
     */
    public function gravaReservaItensSemCotacao($entityManager, $rsAutEmpenho, $stItens, $formData, $empenho)
    {
        // atualizar saldo do item na solicitação ou anula caso seja zero
        // busca info da reserva
        $reservaSaldosAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);

        $motivo = 'Anulação Automática. Entidade: ' . $rsAutEmpenho->cod_entidade . ' - ' . $rsAutEmpenho->nom_entidade;
        $obTOrcamentoReservaSaldosAnulada = $reservaSaldosAnuladaModel->getOneByCodReservaAndExercicio(
            $empenho->cod_reserva,
            $empenho->exercicio_reserva
        );

        $stItens .= ',' . $empenho->cod_item;
        if (is_null($obTOrcamentoReservaSaldosAnulada)) {
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);
            $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($empenho->cod_reserva, $empenho->exercicio_solicitacao);
            $rSaldoAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);
            //Save reserva Saldo Anulada
            $rSaldoAnuladaModel->saveReservaSaldosAnulada($reservaSaldos, $formData, $motivo);
        }
    }

    /**
     * @param $entityManager
     * @param $rsAutEmpenho
     * @param $empenho
     * @param $formData
     * @param $stItens
     */
    public function atualizaSaldoItemSolicitacao($entityManager, $rsAutEmpenho, $empenho, $formData, $stItens)
    {
        // busca info da reserva
        $reservaSaldosAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);
        $motivo = 'Anulação Automática. Entidade: ' . $rsAutEmpenho->cod_entidade . ' - ' . $rsAutEmpenho->nom_entidade . ', Mapa de compras: ' . $empenho->cod_mapa . '/' . $empenho->exercicio_mapa;
        $obTOrcamentoReservaSaldosAnulada = $reservaSaldosAnuladaModel->getOneByCodReservaAndExercicio(
            $empenho->cod_reserva,
            $empenho->exercicio_solicitacao
        );
        $stItens .= ',' . $empenho->cod_item;
        if (is_null($obTOrcamentoReservaSaldosAnulada)) {
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);
            $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($empenho->cod_reserva, $empenho->exercicio_solicitacao);
            $rSaldoAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);
            //Save reserva Saldo Anulada
            $rSaldoAnuladaModel->saveReservaSaldosAnulada($reservaSaldos, $formData);
        }
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $rsAutEmpenho
     * @param $formData
     * @param CompraDiretaModel $compraDiretaModel
     * @param $entityManager
     */
    public function saveRelationships($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $rsAutEmpenho, $formData, $compraDiretaModel, $entityManager)
    {
        $fornecedor = $rsAutEmpenho->fornecedor;
        $codDespesa = $rsAutEmpenho->cod_despesa;
        $codConta = $rsAutEmpenho->cod_conta;

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $rsSolicitacao = $solicitacaoModel->montaRecuperaSolicitacaoAgrupadaNaoAnulada($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);

        $observacaoSolicitacao = '';
        foreach ($rsSolicitacao as $rsSolicitacaoAtiva) {
            $observacaoSolicitacao .= $rsSolicitacaoAtiva->observacao . ' §§';
        }

        $configuracaoModel = new ConfiguracaoModel($entityManager);

        $boReservaRigida = $configuracaoModel->pegaConfiguracao('reserva_rigida', '35', $this->getExercicio());
        $boReservaRigida = ($boReservaRigida == 'true') ? true : false;

        $boReservaAutorizacao = $configuracaoModel->pegaConfiguracao('reserva_autorizacao', '35', $this->getExercicio());
        $boReservaAutorizacao = ($boReservaAutorizacao == 'true') ? true : false;

        if (!$boReservaRigida && $boReservaAutorizacao) {
            $rsSolicitacaoReservas = $compraDiretaModel->montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
            foreach ($rsSolicitacaoReservas as $rsSolicitacaoReserva) {
                $despesaModel = new DespesaModel($entityManager);
                $rsSaldoDotacao = $despesaModel->recuperaSaldoDotacao($this->getExercicio(), $rsSolicitacaoReserva->cod_despesa);
                if (!isset($arSaldoDotacao[$rsSolicitacaoReserva->cod_despesa])) {
                    $arSaldoDotacao[$rsSolicitacaoReserva->cod_despesa]['saldo_inicial'] = $rsSaldoDotacao[0]['saldo_dotacao'];
                    $arSaldoDotacao[$rsSolicitacaoReserva->cod_despesa]['vl_reserva'] = $rsSolicitacaoReserva->vl_cotacao;
                } else {
                    $arSaldoDotacao[$rsSolicitacaoReserva->cod_despesa]['vl_reserva'] += $rsSolicitacaoReserva->vl_cotacao;
                }

                // Persist Reserva Saldos
                $reservaSaldosModel = new ReservaSaldosModel($entityManager);

                $stMsgReserva  = "Entidade: ".$rsSolicitacaoReserva->cod_entidade.", ";
                $stMsgReserva .= "Mapa de Compras: ".$rsSolicitacaoReserva->cod_mapa.", ";
                $stMsgReserva .= "Item: ".$rsSolicitacaoReserva->cod_item.", ";
                $stMsgReserva .= "Centro de Custo: " . $rsSolicitacaoReserva->cod_centro . ", ";
                $stMsgReserva .= "(Origem da criação: Compra Direta/Autorização de Empenho).";

                $dtFinal = '31/12/' . $this->getExercicio();

                $dtValidadeInicial = date('d/m/Y');

                $codReserva = $reservaSaldosModel->getProximoCodReserva($this->getExercicio());
                $reservaInserida = $reservaSaldosModel->montaincluiReservaSaldo(
                    $codReserva,
                    $this->getExercicio(),
                    $rsSolicitacaoReserva->cod_despesa,
                    $dtValidadeInicial,
                    $dtFinal,
                    $rsSolicitacaoReserva->vl_cotacao,
                    'A',
                    $stMsgReserva
                );

                // Persiste Mapa Item Reserva
                if ($reservaInserida[0]['fn_reserva_saldo'] == true) {
                    $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($codReserva, $this->getExercicio());
                    $mapaItemDotacaoModel = new MapaItemDotacaoModel($entityManager);
                    $mapaItemDotacao = $mapaItemDotacaoModel->getOneMapaItemDotacao(
                        $rsSolicitacaoReserva
                    );


                    $obTComprasMapaItemReserva = new Compras\MapaItemReserva();
                    $obTComprasMapaItemReservaModel = new MapaItemReservaModel($entityManager);
                    $obTComprasMapaItemReserva->setFkComprasMapaItemDotacao($mapaItemDotacao);
                    $obTComprasMapaItemReserva->setFkOrcamentoReservaSaldos($reservaSaldos);
                    $obTComprasMapaItemReservaModel->save($obTComprasMapaItemReserva);
                } else {
                    $stSolicitacao = $rsSolicitacaoReserva->cod_solicitacao. '/' . $rsSolicitacaoReserva->exercicio_solicitacao;
                    $arSaldoDotacaoFormatado = number_format($arSaldoDotacao[$rsSolicitacaoReserva->cod_despesa]['saldo_inicial'], 2, ',', '.');

                    $message = $this->trans(
                        'AutorizacaoEmpenhoCompraDiretaReservarItem',
                        [
                            '%cod_item%' => $rsSolicitacaoReserva->cod_item,
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

        $rsItensAutEmpenho = $compraDiretaModel->montaRecuperaItensAutorizacao(
            $codCompraDireta,
            $codModalidade,
            $codEntidade,
            $exercicioEntidade,
            $fornecedor,
            $codDespesa,
            $codConta
        );

        // atualizar saldo do item na solicitação ou anula caso seja zero
        $stItens = '';
        foreach ($rsItensAutEmpenho as $empenho) {
            $this->atualizaSaldoItemSolicitacao($entityManager, $rsAutEmpenho, $empenho, $formData, $stItens);
        }

        //anula reserva de saldo dos itens que não possuem cotação
        //recupera itens que nao tiveram cotacao
        $stItens = substr($stItens, 1);
        $stItens = ($stItens === false) ? 0 : $stItens;
        $mapaItemReservaModel = new MapaItemReservaModel($entityManager);
        $rsItensSemCotacao = $mapaItemReservaModel->montaRecuperaReservas(
            $stItens,
            $rsItensAutEmpenho[0]->cod_mapa,
            $rsItensAutEmpenho[0]->exercicio_mapa,
            $rsItensAutEmpenho[0]->cod_solicitacao,
            $rsItensAutEmpenho[0]->exercicio_solicitacao
        );

        foreach ($rsItensSemCotacao as $empenho) {
            $this->gravaReservaItensSemCotacao($entityManager, $rsAutEmpenho, $stItens, $formData, $empenho);
        }

        $rsItensSolicitacaoAgrupados = $compraDiretaModel->montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
        $inNumItemCont = 1;

        $retornoEmpenho = $configuracaoModel->pegaConfiguracao('numero_empenho', '10', $this->getExercicio());
        $autorizacaoEmpenhoModel = new TipoDiariaModel($entityManager);
        if ($retornoEmpenho == 'P') {
            $codAutorizacao = $autorizacaoEmpenhoModel->getProximoCodAutorizacao($this->getExercicio(), $codEntidade);
        } else {
            $codAutorizacao = $autorizacaoEmpenhoModel->getProximoCodAutorizacao($this->getExercicio());
        }

        $user = $this->getCurrentUser()->getNumcgm();

        foreach ($rsItensSolicitacaoAgrupados as $rsItensSolicitacao) {
            //checarPermissaoAutorizacao
            $this->checarPermissaoAutorizacao($entityManager, $rsItensSolicitacao->exercicio, $rsItensSolicitacao->num_unidade, $rsItensSolicitacao->num_orgao, $user);

            //Buscando a Entidade
            $entidadeModel = new EntidadeModel($entityManager);
            $entidade = $entidadeModel->findOneByCodEntidadeAndExercicio($codEntidade, $rsItensSolicitacao->exercicio);

            $preEmpenhoModel = new PreEmpenhoModel($entityManager);

            //Buscando o Tipo do Empenho
            $tipoEmpenhoModel = new TipoEmpenhoModel($entityManager);
            $tipoEmpenho = $tipoEmpenhoModel->getOneTipoEmpenho(0);

            //Buscando o Fornecedor
            $fornecedorModel = new FornecedorModel($entityManager);
            $fornecedor = $fornecedorModel->getFornecedor($rsItensSolicitacao->fornecedor);

            //Adicionando o Historico
            $historicoModel = new HistoricoModel($entityManager);
            $historico = $historicoModel->saveHistorico($rsItensSolicitacao->exercicio);

            //Buscando a Categoria
            $categoriaModel = new CategoriaEmpenhoModel($entityManager);
            $categoria = $categoriaModel->getOneByCodCategoria(1);

            //Buscando a Unidade
            $unidadeModel = new UnidadeModel($entityManager);
            $unidade = $unidadeModel->getOneByUnidadeOrgaoExercicio($rsItensSolicitacao->num_unidade, $rsItensSolicitacao->num_orgao, $rsItensSolicitacao->exercicio);
            //Buscando o Centro de Custo
            $centroCustoModel = new CentroCustoModel($entityManager);
            $centroCusto = $centroCustoModel->getCentroCustoByCodCentro($rsItensSolicitacao->cod_centro);

            //Buscando o Item
            $itemModel = new CatalogoItemModel($entityManager);
            $item = $itemModel->getOneByCodItem($rsItensSolicitacao->cod_item);

            //Buscando a Unidade Medida
            $unidadeMedida = new UnidadeMedidaModel($entityManager);
            $unidadeMedida = $unidadeMedida->getOneByCodUnidadeCodGrandeza($rsItensSolicitacao->cod_unidade, $rsItensSolicitacao->cod_grandeza);

            /**
             * Salvando pre empenho
             */
            $obtPreEmpenho = $preEmpenhoModel->savePreEmpenho($tipoEmpenho, $fornecedor, $user, $rsItensSolicitacao->exercicio, $historico);

            /**
             * Salvando Autorização Empenho
             */
            $obTEmpenhoAutorizacaoEmpenho = new TipoDiariaModel($entityManager);
            $obTEmpenhoAutorizacaoEmpenho->saveAutorizacaoEmpenho($entidade, $rsItensSolicitacao->exercicio, $unidade, $categoria, $formData['dtAutorizacao'], $obtPreEmpenho);

            /**
             * Salvando o Item Pre Empenho
             */
            $itemPreEmpenhoModel = new ItemPreEmpenhoModel($entityManager);
            $itemPreEmpenhoModel->saveItemPreEmpenho($inNumItemCont, $obtPreEmpenho, $rsItensSolicitacao, $centroCusto, $item, $unidadeMedida);
            $inNumItemCont++;
        }
    }

    /**
     * @param $entityManager
     * @param $exercicio
     * @param $num_unidade
     * @param $num_orgao
     * @param $numcgm
     */
    public function checarPermissaoAutorizacao($entityManager, $exercicio, $num_unidade, $num_orgao, $numcgm)
    {
        $permissaoAutorizacaoModel = new PermissaoAutorizacaoModel($entityManager);
        $permissao = $permissaoAutorizacaoModel->checarPermissaoAutorizacao($exercicio, $num_unidade, $num_orgao, $numcgm);

        if (!is_object($permissao)) {
            $message = 'Este usuário não tem permissão para realizar esta operação';
            $this->redirect($message, 'error');
        }
    }

    /**
     * @param $message
     * @param string $type
     */
    public function redirect($message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/compras/autorizar-empenho-compra-direta/list");
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade'
                ],
                null,
                [
                    'class' => Entidade::class,
                    'choice_label' => 'fkSwCgm.nomCgm',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                        return $em->findAllByExercicioAsQueryBuilder($exercicio);
                    },
                    'placeholder' => 'label.selecione'
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add('fkComprasModalidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codModalidade'
            ], null, [
                'class' => Modalidade::class,
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters '
                ],
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
                'placeholder' => 'label.selecione',
                'class' => Mapa::class,
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'query_builder' => function (\Doctrine\ORM\EntityRepository $em) use ($exercicio) {
                    return $em->createQueryBuilder("h")
                        ->where("h.exercicio = '" . $exercicio . "'");
                },
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

                'label' => 'label.comprasDireta.codMapa'
            ]);

        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'create' => ['template' => 'PatrimonialBundle:Sonata/Compras/AutorizacaoEmpenhoCompraDireta/CRUD:list__action_autorizacao_empenho_create.html.twig']
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

        $exercicio = $this->getExercicio();

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codCompraDireta = $formData['hcodCompraDireta'];
            $codEntidade = $formData['hcodEntidade'];
            $exercicioEntidade = $formData['hexercicio'];
            $codModalidade = $formData['hcodModalidade'];
        } else {
            list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode("~", $id);
        }

        $now = new \DateTime();

        $defaultDate = [
            'widget' => 'single_text',
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true
        ];

        /** @var  $compraDireta Compras\CompraDireta */
        $compraDireta = $entityManager->getRepository(Compras\CompraDireta::class)->find([
            'codCompraDireta' => $codCompraDireta,
            'codEntidade' => $codEntidade,
            'exercicioEntidade' => $exercicioEntidade,
            'codModalidade' => $codModalidade
        ]);

        $fieldOptions = [];
        $fieldOptions['codEntidade'] = [
            'label' => 'label.comprasDireta.codEntidade',
            'data' => $compraDireta->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm(),
        ];

        $fieldOptions['dtEntregaProposta']['data'] = $compraDireta->getDtEntregaProposta()->format('d/m/Y');
        $fieldOptions['dtEntregaProposta']['label'] = 'label.comprasDireta.dtEntregaProposta';

        $fieldOptions['dtValidadeProposta']['data'] = $compraDireta->getDtValidadeProposta()->format('d/m/Y');
        $fieldOptions['dtValidadeProposta']['label'] = 'label.comprasDireta.dtValidadeProposta';

        $fieldOptions['timestamp']['data'] = $compraDireta->getTimestamp()->format('d/m/Y');
        $fieldOptions['timestamp']['label'] = 'label.comprasDireta.timestamp';

        $fieldOptions['codModalidade'] = [
            'label' => 'label.comprasDireta.codModalidade',
            'data' => $compraDireta->getFkComprasModalidade()->getDescricao(),
        ];

        $fieldOptions['codTipoObjeto']['data'] = $compraDireta->getFkComprasTipoObjeto()->getDescricao();
        $fieldOptions['codTipoObjeto']['label'] = 'label.comprasDireta.codTipoObjeto';

        $fieldOptions['codObjeto']['data'] = $compraDireta->getFkComprasObjeto()->getDescricao();
        $fieldOptions['codObjeto']['label'] = 'label.comprasDireta.codObjeto';
        $fieldOptions['codObjeto']['attr']['data-value-from'] = '_codMapa';

        $fieldOptions['condicoesPagamento'] = [
            'label' => 'label.comprasDireta.condicoesPagamento',
            'data' => $compraDireta->getCondicoesPagamento(),
        ];
        $fieldOptions['prazoEntrega'] = [
            'label' => 'label.comprasDireta.prazoEntrega',
            'data' => $compraDireta->getPrazoEntrega(),
        ];
        $fieldOptions['codMapa'] = [
            'mapped' => false
        ];

        $fieldOptions['hcodEntidade']['data'] = $compraDireta->getFkOrcamentoEntidade()->getCodEntidade();
        $fieldOptions['hcodEntidade']['mapped'] = false;

        $fieldOptions['hcodModalidade']['data'] = $compraDireta->getFkComprasModalidade()->getCodModalidade();
        $fieldOptions['hcodModalidade']['mapped'] = false;

        $fieldOptions['hexercicio']['data'] = $compraDireta->getExercicioEntidade();
        $fieldOptions['hexercicio']['mapped'] = false;

        $fieldOptions['hcodCompraDireta']['data'] = $compraDireta->getCodCompraDireta();
        $fieldOptions['hcodCompraDireta']['mapped'] = false;

        $fieldOptions['dtAutorizacao'] = $defaultDate;
        $fieldOptions['dtAutorizacao']['label'] = 'label.comprasDireta.autorizacaoEmpenho.dtAutorizacao';
        $fieldOptions['dtAutorizacao']['mapped'] = false;
        $fieldOptions['dtAutorizacao']['dp_max_date'] = $now;

        if (!is_null($id)) {
            // Desabilita campos que não podem ser alterados durante a edição
            $fieldOptions['codModalidade']['disabled'] = true;
            $fieldOptions['codEntidade']['disabled'] = true;
            $fieldOptions['timestamp']['disabled'] = true;
            $fieldOptions['codObjeto']['disabled'] = true;
            $fieldOptions['codTipoObjeto']['disabled'] = true;
            $fieldOptions['dtEntregaProposta']['disabled'] = true;
            $fieldOptions['dtValidadeProposta']['disabled'] = true;
            $fieldOptions['condicoesPagamento']['disabled'] = true;
            $fieldOptions['prazoEntrega']['disabled'] = true;
            $fieldOptions['codMapa']['data'] = 1;
        }

        $formMapper
            ->with('label.comprasDireta.autorizacaoEmpenho.gerarAutorizacaoEmpenho')
            ->add('codEntidade', 'text', $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('hcodEntidade', 'hidden', $fieldOptions['hcodEntidade'])
            ->add('hexercicio', 'hidden', $fieldOptions['hexercicio'])
            ->add('hcodCompraDireta', 'hidden', $fieldOptions['hcodCompraDireta'])
            ->add('hcodModalidade', 'hidden', $fieldOptions['hcodModalidade'])
            ->add('timestamp', 'text', $fieldOptions['timestamp'])
            ->add('codMapa', 'hidden', $fieldOptions['codMapa'])
            ->add('codModalidade', 'text', $fieldOptions['codModalidade'])
            ->add('codTipoObjeto', 'text', $fieldOptions['codTipoObjeto'])
            ->add('codObjeto', 'text', $fieldOptions['codObjeto'])
            ->end()
            ->with('label.comprasDireta.proposta')
            ->add('dtEntregaProposta', 'text', $fieldOptions['dtEntregaProposta'])
            ->add('dtValidadeProposta', 'text', $fieldOptions['dtValidadeProposta'])
            ->add('condicoesPagamento', 'text', $fieldOptions['condicoesPagamento'])
            ->add('prazoEntrega', 'text', $fieldOptions['prazoEntrega'])
            ->add('dtAutorizacao', 'sonata_type_date_picker', $fieldOptions['dtAutorizacao'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 comprasdireta-items'
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codCompraDireta')
            ->add('exercicioEntidade')
            ->add('exercicioMapa')
            ->add('dtEntregaProposta')
            ->add('dtValidadeProposta')
            ->add('condicoesPagamento')
            ->add('prazoEntrega')
            ->add('timestamp');
    }

    public function geraMensagem($reserva)
    {
        $stMsgReserva = "Entidade: " . $reserva->cod_entidade . " - " . ucwords(strtolower($reserva->nom_entidade)) . ", ";
        $stMsgReserva .= "Mapa de Compras: " . $reserva->cod_mapa . "/" . $reserva->exercicio_mapa . ", ";
        $stMsgReserva .= "Item: " . $reserva->cod_item . ", ";
        $stMsgReserva .= "Centro de Custo: " . $reserva->cod_centro . ", ";
        $stMsgReserva .= "(Origem da criação: Autorização Empenho Compra Direta).";
        return $stMsgReserva;
    }
}
