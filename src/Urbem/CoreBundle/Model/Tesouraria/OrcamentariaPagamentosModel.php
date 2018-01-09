<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Contabilidade;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Repository\Contabilidade\LancamentoRepository;
use Urbem\CoreBundle\Repository\Empenho\EmpenhoRepository;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\AutenticacaoRepository;

/**
 * Class OrcamentariaPagamentosModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class OrcamentariaPagamentosModel extends AbstractModel
{
    protected $entityManager = null;

    const TIPO_AUTENTICACAO = 'P ';
    const COD_HISTORICO = 903;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Retorna os registros de empenho a serem pagos
     *
     * @param  integer $codOrdem
     * @param  string $exercicio
     * @return array
     */
    public function getRegistros($codOrdem, $exercicio)
    {
        return $this->entityManager->getRepository('CoreBundle:Tesouraria\VwOrcamentariaPagamentosRegistrosView')
            ->findBy(
                array(
                    'codOrdem' => $codOrdem,
                    'exercicio' => $exercicio
                )
            );
    }

    /**
     * @param string|int $codOrdem
     * @param string $exercicio
     * @return null|ArrayCollection
     */
    public function getEstornoRegistros($codOrdem, $exercicio)
    {
        return $this->entityManager
            ->getRepository(Tesouraria\VwOrcamentariaPagamentosEstornoRegistrosView::class)
            ->findBy([
                'codOrdem' => $codOrdem,
                'exercicio' => $exercicio
            ])
            ;
    }

    /**
     * @param Tesouraria\VwOrcamentariaPagamentoEstornoView $vwOrcamentariaPagamentoEstornoView
     * @param Administracao\Usuario $usuario
     * @param Form $formData
     * @param string $exercicio
     * @return Tesouraria\VwOrcamentariaPagamentoEstornoView
     */
    public function estornoPagamento(
        Tesouraria\VwOrcamentariaPagamentoEstornoView $vwOrcamentariaPagamentoEstornoView,
        Administracao\Usuario $usuario,
        Form $formData,
        $exercicio
    ) {
        $em = $this->entityManager;

        /** @var EmpenhoRepository $empenhoRepository */
        $empenhoRepository = $em->getRepository(Empenho\Empenho::class);

        /** @var AutenticacaoRepository $autenticacaoRepository */
        $autenticacaoRepository = $em->getRepository(Tesouraria\Autenticacao::class);

        /** @var LancamentoRepository $lancamentoRepository */
        $lancamentoRepository = $em->getRepository(Contabilidade\Lancamento::class);

        /** @var Empenho\NotaLiquidacaoPaga $notaLiquidacaoPaga */
        $notaLiquidacaoPaga = $em->getRepository(Empenho\NotaLiquidacaoPaga::class)->findOneBy([
            'codEntidade' => $vwOrcamentariaPagamentoEstornoView->getCodEntidade(),
            'exercicio' => $vwOrcamentariaPagamentoEstornoView->getExercicio(),
            'codNota' => $vwOrcamentariaPagamentoEstornoView->getCodNota()
        ]);

        /** @var Empenho\Empenho $empenho */
        $empenho = $empenhoRepository->find([
            'exercicio' => $vwOrcamentariaPagamentoEstornoView->getExercicioEmpenho(),
            'codEmpenho' => $vwOrcamentariaPagamentoEstornoView->getCodEmpenho(),
            'codEntidade' => $vwOrcamentariaPagamentoEstornoView->getCodEntidade()
        ]);

        $preEmpenho = $empenho->getFkEmpenhoPreEmpenho();

        /** @var Empenho\PreEmpenhoDespesa $preEmpenhoDespesa */
        $preEmpenhoDespesa = $em->getRepository(Empenho\PreEmpenhoDespesa::class)->findOneBy([
            'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
            'exercicio' => $empenho->getExercicio()
        ]);

        /** @var Orcamento\Despesa $despesa */
        $despesa = $em->getRepository(Orcamento\Despesa::class)->findOneBy([
            'codDespesa' => $preEmpenhoDespesa->getCodDespesa(),
            'exercicio' => $preEmpenhoDespesa->getExercicio()
        ]);

        /** @var Empenho\Empenho $empenho */
        $empenho = $empenhoRepository->find([
            'exercicio' => $vwOrcamentariaPagamentoEstornoView->getExercicioEmpenho(),
            'codEmpenho' => $vwOrcamentariaPagamentoEstornoView->getCodEmpenho(),
            'codEntidade' => $vwOrcamentariaPagamentoEstornoView->getCodEntidade()
        ]);

        /** @var Tesouraria\TipoAutenticacao $tipoAutenticacao */
        $tipoAutenticacao = $this->entityManager
            ->getRepository(Tesouraria\TipoAutenticacao::class)
            ->find('PE');

        $nomeLote =
            sprintf('Estorno de Pagamento do Empenho n° %s/%s', $empenho->getEmpenho(), $empenho->getExercicio());

        list($codigoOrdem, $exercicioOrdem) = explode('/', $vwOrcamentariaPagamentoEstornoView->getOrdem());
        $vwOrcamentariaPagamentoEstornoViewCollection = $this->getEstornoRegistros($codigoOrdem, $exercicioOrdem);

        $autenticacaoRepositoryRes = $autenticacaoRepository->recuperaUltimoCodigoAutenticacao([
            'dt_autenticacao' => date('d/m/Y')
        ]);

        $usuarioTerminal = $this->entityManager->getRepository(Tesouraria\UsuarioTerminal::class)
            ->findOneBy([
                'cgmUsuario' => $usuario->getNumcgm()
            ]);

        $abertura = new Tesouraria\Abertura();
        $abertura->setFkTesourariaUsuarioTerminal($usuarioTerminal);
        $abertura->setFkTerminal($usuarioTerminal->getFkTerminal());
        $abertura->setFkBoletim($formData->get('codBoletim')->getData());
        $this->save($abertura);

        $autenticacao = new Tesouraria\Autenticacao();
        $autenticacao->setCodAutenticacao($autenticacaoRepositoryRes['codigo'] + 1);
        $autenticacao->setDtAutenticacao(date('Y-m-d'));
        $autenticacao->setTipo($tipoAutenticacao);
        $this->save($autenticacao);

        /** @var Tesouraria\VwOrcamentariaPagamentosEstornoRegistrosView $vwOrcamentariaPagamentosEstornoRegistrosView */
        foreach ($vwOrcamentariaPagamentoEstornoViewCollection as $vwOrcamentariaPagamentosEstornoRegistrosView) {
            $notaLiquidacaoPagaAnulada = new Empenho\NotaLiquidacaoPagaAnulada($em);
            $notaLiquidacaoPagaAnulada->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
            $notaLiquidacaoPagaAnulada->setVlAnulado($vwOrcamentariaPagamentosEstornoRegistrosView->getVlPago());
            $notaLiquidacaoPagaAnulada->setObservacao($formData->get('motivo')->getData());
            $this->save($notaLiquidacaoPagaAnulada);

            $notaLiquidacaoPagaAnuladaAuditoria = new Empenho\NotaLiquidacaoPagaAnuladaAuditoria($em);
            $notaLiquidacaoPagaAnuladaAuditoria->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
            $notaLiquidacaoPagaAnuladaAuditoria->setFkSwCgm($usuario->getNumcgm());
            $this->save($notaLiquidacaoPagaAnuladaAuditoria);

            /** @var Contabilidade\PlanoAnalitica $planoAnalitica */
            $planoAnalitica = $em->getRepository(Contabilidade\PlanoAnalitica::class)->findOneBy([
                'exercicio' => $exercicio,
                'codPlano' => $vwOrcamentariaPagamentosEstornoRegistrosView->getCodPlano()
            ]);

            $codLote = $empenhoRepository->fnInsereLote(
                $vwOrcamentariaPagamentosEstornoRegistrosView->getExercicio(),
                $vwOrcamentariaPagamentosEstornoRegistrosView->getCodEntidade(),
                'P',
                $nomeLote,
                $empenho->getDtEmpenho()->format('d/m/Y')
            );

            $sequecia = $empenhoRepository->empenhoAnulacaoPagamento([
                'exercicio' => $vwOrcamentariaPagamentosEstornoRegistrosView->getExercicio(),
                'valor' => $vwOrcamentariaPagamentosEstornoRegistrosView->getVlPago(),
                'complemento' => $formData->get('motivo')->getData(),
                'codLote' => $codLote,
                'tipoLote' => 'P',
                'codEntidade' => $vwOrcamentariaPagamentosEstornoRegistrosView->getCodEntidade(),
                'codNota' => $vwOrcamentariaPagamentosEstornoRegistrosView->getCodNota(),
                'contaPagamentoFinanc' => '',
                'classificacaoDespesa' => '',
                'numOrgao' => $despesa->getNumOrgao(),
                'botCEMS' => true,
                'codPlanoDebito' => null,
                'codPlanoCredito' => $planoAnalitica->getCodPlano()
            ]);

            $lancamentoRepository->insereLancamento(
                $exercicio,
                $planoAnalitica->getCodPlano(),
                null,
                $vwOrcamentariaPagamentosEstornoRegistrosView->getVlPago(),
                $codLote,
                $vwOrcamentariaPagamentosEstornoRegistrosView->getCodEntidade(),
                '906',
                'P',
                $nomeLote
            );

            $lancamento = $em->getRepository(Contabilidade\Lancamento::class)->find([
                'codLote' => $codLote,
                'tipo' => 'P',
                'exercicio' => $exercicio,
                'codEntidade' => $vwOrcamentariaPagamentosEstornoRegistrosView->getCodEntidade(),
                'sequencia' => $sequecia
            ]);

            $lancamentoEmpenho = new Contabilidade\LancamentoEmpenho();
            $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);
            $lancamentoEmpenho->setEstorno(true);
            $this->save($lancamentoEmpenho);

            $contabilidadePagamento =  new Contabilidade\Pagamento();
            $contabilidadePagamento->setExercicio($exercicio);
            $contabilidadePagamento->setSequencia($sequecia);
            $contabilidadePagamento->setTipo('P');
            $contabilidadePagamento->setCodLote($codLote);
            $contabilidadePagamento->setCodEntidade($vwOrcamentariaPagamentosEstornoRegistrosView->getCodEntidade());
            $contabilidadePagamento->setCodNota($vwOrcamentariaPagamentosEstornoRegistrosView->getCodNota());
            $contabilidadePagamento->setExercicioLiquidacao($vwOrcamentariaPagamentoEstornoView->getExercicioLiquidacao());
            $this->save($contabilidadePagamento);

            $pagamentoEstorno = new Contabilidade\PagamentoEstorno();
            $pagamentoEstorno->setFkContabilidadePagamento($contabilidadePagamento);
            $pagamentoEstorno->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
            $this->save($pagamentoEstorno);

            $pagamentoEstornado = new Tesouraria\PagamentoEstornado();
            $pagamentoEstornado->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
            $pagamentoEstornado->setFkTesourariaAutenticacao($autenticacao);
            $pagamentoEstornado->setFkTesourariaUsuarioTerminal($usuarioTerminal);
            $this->save($pagamentoEstornado);
        }

        return $vwOrcamentariaPagamentoEstornoView;
    }

    /**
     * @param $codEntidade
     * @param $codEmpenhoDe
     * @param $codEmpenhoAte
     * @param $codNotaDe
     * @param $codNotaAte
     * @param $exercicio
     * @param $exercicioEmpenho
     * @param null $codOrdemDe
     * @param null $codOrdemAte
     * @param null $cgmBeneficiario
     * @return array
     */
    public function listaEmpenhosPagarTesouraria($codEntidade, $codEmpenhoDe, $codEmpenhoAte, $codNotaDe, $codNotaAte, $exercicio, $exercicioEmpenho, $codOrdemDe = null, $codOrdemAte = null, $cgmBeneficiario = null)
    {
        $param1 = "";
        $param1 .= sprintf(
            " AND ENL.cod_nota >= %d AND ENL.cod_nota <= %d AND EE.cod_empenho >= %d AND EE.cod_empenho <= %d AND EE.exercicio = ''%s'' AND EE.cod_entidade in (%d) ",
            $codNotaDe,
            $codNotaAte,
            $codEmpenhoDe,
            $codEmpenhoAte,
            $exercicio,
            $codEntidade
        );
        if ($cgmBeneficiario) {
            $param1 .= sprintf("AND EPE.cgm_beneficiario = %d ", $cgmBeneficiario);
        }

        $param2 = "";
        if ($codOrdemDe && $codOrdemAte) {
            $param2 .= sprintf(
                " AND EOP.cod_ordem >= %d  AND EOP.cod_ordem <= %d AND EOP.cod_ordem IS NOT NULL ",
                $codOrdemDe,
                $codOrdemAte
            );
        }
        $param2 .= sprintf(
            " AND EOP.exercicio = ''%s'' AND EPL.exercicio_empenho = ''%s'' AND EPL.cod_entidade IN(%d) ",
            $exercicio,
            $exercicioEmpenho,
            $codEntidade
        );

        $param3 = "";
        $param3 .= sprintf(
            " AND ENL.cod_nota >= %d AND ENL.cod_nota <= %d AND EE.cod_empenho >= %d AND EE.cod_empenho <= %d ",
            $codNotaDe,
            $codNotaAte,
            $codEmpenhoDe,
            $codEmpenhoAte,
            $codEntidade
        );
        if ($cgmBeneficiario) {
            $param3 .= sprintf(
                " AND EPE.cgm_beneficiario = %d",
                $cgmBeneficiario
            );
        }

        $sql = "
            select
                *
            from
                empenho.fn_lista_empenhos_pagar_tesouraria(
                    '".$param1."',
                    '".$param2."',
                    '".$param3."'
                ) as retorno(
                    empenho varchar,
                    nota varchar,
                    adiantamento varchar,
                    ordem varchar,
                    cod_entidade integer,
                    entidade varchar,
                    cgm_beneficiario integer,
                    beneficiario varchar,
                    vl_nota numeric,
                    vl_ordem numeric
                )
        ";
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $retorno = $query->fetchAll();

        $notas = array();
        if ($retorno) {
            foreach ($retorno as $item) {
                list($codNota) = explode('/', $item['nota']);
                $notas[] = $codNota;
            }
        }
        return $notas;
    }

    public function listaBoletins($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "select
                TB.cod_boletim
            from
                tesouraria.boletim as TB left join(
                    select
                        TBF.cod_boletim,
                        TBF.exercicio,
                        TBF.cod_entidade,
                        max( TBF.timestamp_fechamento ) as timestamp_fechamento
                    from
                        tesouraria.boletim_fechado as TBF
                    group by
                        cod_boletim,
                        exercicio,
                        cod_entidade
                    order by
                        cod_boletim,
                        exercicio,
                        cod_entidade
                ) as TBF on
                (
                    TB.cod_boletim = TBF.cod_boletim
                    and TB.exercicio = TBF.exercicio
                    and TB.cod_entidade = TBF.cod_entidade
                ) left join(
                    select
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade,
                        max( TBR.timestamp_reabertura ) as timestamp_reabertura
                    from
                        tesouraria.boletim_reaberto as TBR
                    group by
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade
                    order by
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade
                ) as TBR on
                (
                    TB.cod_boletim = TBR.cod_boletim
                    and TB.exercicio = TBR.exercicio
                    and TB.cod_entidade = TBR.cod_entidade
                ) left join(
                    select
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade,
                        max( TBL.timestamp_liberado ) as timestamp_liberado
                    from
                        tesouraria.boletim_liberado as TBL
                    group by
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade
                    order by
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade
                ) as TBL on
                (
                    TB.cod_boletim = TBL.cod_boletim
                    and TB.exercicio = TBL.exercicio
                    and TB.cod_entidade = TBL.cod_entidade
                ),
                sw_cgm as CGM
            where
                TB.cgm_usuario = CGM.numcgm
                and TB.exercicio = '%s'::varchar
                and TB.cod_entidade in(%d)
                and TBL.timestamp_liberado is null
                and case
                    when tbf.timestamp_fechamento is null then true
                    else case
                        when TBR.timestamp_reabertura is not null then TBF.timestamp_fechamento < TBR.timestamp_reabertura
                        else false
                    end
                end
            ",
            $exercicio,
            $codEntidade
        );
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        $boletins = array();
        foreach ($result as $boletim) {
            $boletins[] = $boletim['cod_boletim'];
        }
        return $boletins;
    }

    /**
     * @param $exercicio
     * @param $codPlano
     * @param $movimentacao
     * @return float
     */
    public function verificaSaldoConta($exercicio, $codPlano, $movimentacao = true)
    {
        $dtInicial = sprintf('01/01/%s', $exercicio);
        $dtFinal = sprintf('31/12/%s', $exercicio);

        $sql = "
            select
                tesouraria.fn_saldo_conta_tesouraria(
                    :exercicio,
                    :codPlano,
                    :dtInicial,
                    :dtFinal,
                    :movimentacao
                ) as valor
        ";
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindParam('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindParam('codPlano', $codPlano, \PDO::PARAM_INT);
        $query->bindParam('dtInicial', $dtInicial, \PDO::PARAM_STR);
        $query->bindParam('dtFinal', $dtFinal, \PDO::PARAM_STR);
        $query->bindParam('movimentacao', $movimentacao, \PDO::PARAM_BOOL);
        $query->execute();
        $retorno = $query->fetch();
        return (float) $retorno['valor'];
    }

    /**
     * @param Empenho\NotaLiquidacao $notaLiquidacao
     * @param $formData
     * @param $currentUser
     * @param $registros
     * @return bool|\Exception
     */
    public function realizaPagamento(Empenho\NotaLiquidacao $notaLiquidacao, $formData, $currentUser, $registros, $translator)
    {
        $em = $this->entityManager;
        $usuarioTerminal = $em->getRepository(Tesouraria\UsuarioTerminal::class)
            ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

        $boletim = $formData->get('boletim')->getData();

        try {
            // Tesouraria - Abertura
            $abertura = new Tesouraria\Abertura();
            $abertura->setFkTesourariaBoletim($boletim);
            $abertura->setFkTesourariaUsuarioTerminal($usuarioTerminal);
            $abertura->setFkTesourariaTerminal($usuarioTerminal->getFkTesourariaTerminal());
            $em->persist($abertura);


            // Autenticacao
            $tipoAutenticacao = $em->getRepository(Tesouraria\TipoAutenticacao::class)
                ->findOneByCodTipoAutenticacao(self::TIPO_AUTENTICACAO);

            $codAutenticacao = $em->getRepository(Tesouraria\Autenticacao::class)
                ->recuperaUltimoCodigoAutenticacao(
                    array(
                        'dt_autenticacao' => $boletim->getDtBoletim()->format('d/m/Y')
                    )
                );

            $dtAutenticacao = new DateTimeMicrosecondPK($boletim->getDtBoletim()->format('Y-m-d'));
            $autenticacao = new Tesouraria\Autenticacao();
            $autenticacao->setFkTesourariaTipoAutenticacao($tipoAutenticacao);
            $autenticacao->setDtAutenticacao($dtAutenticacao);
            $autenticacao->setCodAutenticacao($codAutenticacao['codigo'] + 1);
            $em->persist($autenticacao);

            foreach ($registros as $params => $registro) {
                // Nota Liquidacao Paga
                $notaLiquidacaoPaga = new Empenho\NotaLiquidacaoPaga();
                $notaLiquidacaoPaga->setVlPago((float) $registro);
                $notaLiquidacaoPaga->setObservacao($formData->get('observacao')->getData());
                $notaLiquidacaoPaga->setFkEmpenhoNotaLiquidacao($notaLiquidacao);
                $em->persist($notaLiquidacaoPaga);

                // Nota Liquidacao Paga Auditoria
                $notaLiquidacaoPagaAuditoria = new Empenho\NotaLiquidacaoPagaAuditoria();
                $notaLiquidacaoPagaAuditoria->setFkSwCgm($currentUser->getFkSwCgm());
                $notaLiquidacaoPagaAuditoria->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                $em->persist($notaLiquidacaoPagaAuditoria);

                // Nota Liquidacao Conta Pagadora
                $planoAnalitica = $em->getRepository(Contabilidade\PlanoAnalitica::class)
                    ->findOneBy(
                        array(
                            'codPlano' => $formData->get('contaPagadora')->getData(),
                            'exercicio' => $notaLiquidacao->getExercicio()
                        )
                    );
                $notaLiquidacaoContaPagadora = new Empenho\NotaLiquidacaoContaPagadora();
                $notaLiquidacaoContaPagadora->setFkContabilidadePlanoAnalitica($planoAnalitica);
                $notaLiquidacaoContaPagadora->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                $em->persist($notaLiquidacaoContaPagadora);

                // Pagamento Liquidacao Nota Liquidacao Paga
                if ($params) {
                    list($codOrdem, $exercicio, $codEntidade, $exercicioLiquidacao, $codNota) = explode('~', $params);
                    $pagamentoLiquidacao = $em->getRepository(Empenho\PagamentoLiquidacao::class)
                        ->findOneBy(
                            array(
                                'codOrdem' => $codOrdem,
                                'exercicio' => $exercicio,
                                'codEntidade' => $codEntidade,
                                'exercicioLiquidacao' => $exercicioLiquidacao,
                                'codNota' => $codNota
                            )
                        );
                } else {
                    // No Urbem antigo não funciona
                    // Estou criando uma Ordem de Pagamento e um Pagamento Liquidação com o valor total da nota, assim posso seguir o escript normalmente
                    $ordemPagamentoModel = new Model\Empenho\OrdemPagamentoModel($em);
                    $codOrdem = $ordemPagamentoModel
                        ->getProximoCodOrdem(
                            $notaLiquidacao->getExercicio(),
                            $notaLiquidacao->getCodEntidade()
                        );
                    $dtEmissao = $ordemPagamentoModel
                        ->getDtOrdemPagamento(
                            $notaLiquidacao->getExercicio(),
                            $notaLiquidacao->getCodEntidade()
                        );

                    $entidade = $em->getRepository(Orcamento\Entidade::class)
                        ->findOneBy(
                            array(
                                'codEntidade' => $notaLiquidacao->getCodEntidade(),
                                'exercicio' => $notaLiquidacao->getExercicio()
                            )
                        );
                    $dtVencimento = new \DateTime(sprintf('%s-12-31', $notaLiquidacao->getExercicio()));

                    $ordemPagamento = new Empenho\OrdemPagamento();
                    $ordemPagamento->setCodOrdem($codOrdem);
                    $ordemPagamento->setDtEmissao($dtEmissao);
                    $ordemPagamento->setDtVencimento($dtVencimento);
                    $ordemPagamento->setObservacao('');
                    $ordemPagamento->setTipo('');
                    $ordemPagamento->setFkOrcamentoEntidade($entidade);

                    $pagamentoLiquidacao = new Empenho\PagamentoLiquidacao();
                    $pagamentoLiquidacao->setFkEmpenhoNotaLiquidacao($notaLiquidacao);
                    $pagamentoLiquidacao->setVlPagamento($notaLiquidacao->getVlNota());
                    $ordemPagamento->addFkEmpenhoPagamentoLiquidacoes($pagamentoLiquidacao);
                    $em->persist($ordemPagamento);
                }

                $pagamentoLiquidacaoNotaLiquidacaoPaga = new Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga();
                $pagamentoLiquidacaoNotaLiquidacaoPaga->setFkEmpenhoPagamentoLiquidacao($pagamentoLiquidacao);
                $pagamentoLiquidacaoNotaLiquidacaoPaga->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                $em->persist($pagamentoLiquidacaoNotaLiquidacaoPaga);

                // Insere Lote
                $nomLote = $translator
                    ->trans(
                        'label.orcamentariaPagamentos.nomLote',
                        array(
                            '%codEmpenho%' => $notaLiquidacao->getFkEmpenhoEmpenho()->getCodEmpenho(),
                            '%exercicio%' => $notaLiquidacao->getFkEmpenhoEmpenho()->getExercicio()
                        )
                    );

                $codLote = $em->getRepository(Empenho\Empenho::class)
                    ->fnInsereLote(
                        $notaLiquidacao->getExercicio(),
                        $notaLiquidacao->getCodEntidade(),
                        self::TIPO_AUTENTICACAO,
                        $nomLote,
                        $notaLiquidacao->getFkEmpenhoEmpenho()->getDtEmpenho()->format("d/m/Y")
                    );

                // Busca Conta Debito
                $contaDebito = $em->getRepository(Contabilidade\Lancamento::class)
                    ->retornaPlanoDebito(
                        $notaLiquidacao->getExercicio(),
                        $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getCodConta()
                    );

                $sequencia = $em->getRepository(Empenho\Empenho::class)
                    ->empenhoPagamento(
                        $notaLiquidacao->getExercicio(),
                        (float) $registro,
                        $notaLiquidacao->getEmpenho(),
                        (int) $codLote,
                        self::TIPO_AUTENTICACAO,
                        (int) $notaLiquidacao->getCodEntidade(),
                        (int) $notaLiquidacao->getCodNota(),
                        '',
                        '',
                        $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getNumOrgao(),
                        true,
                        $contaDebito,
                        $planoAnalitica->getCodPlano()
                    );

                // Retorna Conta Debito e Credito para Lancamento
                $contas = $em->getRepository(Contabilidade\Lancamento::class)
                    ->retornaCodPlanoUmEDois(
                        $notaLiquidacao->getExercicio(),
                        $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getCodRecurso()
                    );

                // Insere Lancamento
                $sequenciaLancamento = $em->getRepository(Contabilidade\Lancamento::class)
                    ->insereLancamento(
                        $notaLiquidacao->getExercicio(),
                        $contas['cod_plano_dois'],
                        $contas['cod_plano_um'],
                        (float) $registro,
                        (int) $codLote,
                        (int) $notaLiquidacao->getCodEntidade(),
                        self::COD_HISTORICO,
                        self::TIPO_AUTENTICACAO,
                        $notaLiquidacao->getEmpenho()
                    );

                // Lancamento Empenho
                $lancamento = $em->getRepository(Contabilidade\Lancamento::class)
                    ->findOneBy(
                        array(
                            'codLote' => $codLote,
                            'tipo' => trim(self::TIPO_AUTENTICACAO),
                            'exercicio' => $notaLiquidacao->getExercicio(),
                            'codEntidade' => $notaLiquidacao->getCodEntidade(),
                            'sequencia' => $sequenciaLancamento
                        )
                    );
                $lancamentoEmpenho = new Contabilidade\LancamentoEmpenho();
                $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);
                $em->persist($lancamentoEmpenho);
                ;

                // Contabilidade Pagamento
                $pagamento = new Contabilidade\Pagamento();
                $pagamento->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                $pagamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
                $em->persist($pagamento);

                // Tesouraria Pagamento
                $tesourariaPagamento = new Tesouraria\Pagamento();
                $tesourariaPagamento->setFkContabilidadePlanoAnalitica($planoAnalitica);
                $tesourariaPagamento->setFkTesourariaBoletim($boletim);
                $tesourariaPagamento->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                $tesourariaPagamento->setFkTesourariaAutenticacao($autenticacao);
                $tesourariaPagamento->setFkTesourariaUsuarioTerminal($usuarioTerminal);
                $em->persist($tesourariaPagamento);

                // Pagamento Tipo Documento
                $pagamentoTipoDocumento = new PagamentoTipoDocumento();
                $pagamentoTipoDocumento->setFkTcemgTipoDocumento($formData->get('tipoDocumento')->getData());
                $pagamentoTipoDocumento->setNumDocumento($formData->get('numero')->getData());
                $pagamentoTipoDocumento->setFkTesourariaPagamento($tesourariaPagamento);
                $em->persist($pagamentoTipoDocumento);
            }
            $em->flush();
            if (($formData->get('pagarOutra')->getData()) && ((float) $registro < $pagamentoLiquidacao->getVlLiquido())) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
