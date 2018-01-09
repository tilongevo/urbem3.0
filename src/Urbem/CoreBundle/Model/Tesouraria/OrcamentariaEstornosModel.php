<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Class OrcamentariaPagamentosModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class OrcamentariaEstornosModel extends AbstractModel
{
    protected $entityManager = null;

    const TIPO_AUTENTICACAO = 'PE ';
    const TIPO_LANCAMENTO = 'P';
    const COD_HISTORICO = 906;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
     * @param null $numcgm
     * @return array
     */
    public function listaEmpenhosEstornarTesouraria($codEntidade, $codEmpenhoDe, $codEmpenhoAte, $codNotaDe, $codNotaAte, $exercicio, $exercicioEmpenho, $codOrdemDe = null, $codOrdemAte = null, $numcgm = null)
    {
        $sql = "
            select
                *
            from
                tesouraria.fn_ordem_pagamento_estorno(
                    :exercicioBoletim,
                    :exercicioEmpenho,
                    :codEntidade,
                    :codOrdemDe,
                    :codOrdemAte,
                    :codEmpenhoDe,
                    :codEmpenhoAte,
                    :codNotaDe,
                    :codNotaAte,
                    :numcgm
                ) as tbl(
                    exercicio varchar,
                    empenho_pagamento varchar,
                    exercicio_liquidacao varchar,
                    exercicio_empenho varchar,
                    cod_entidade integer,
                    cod_empenho integer,
                    cod_nota integer,
                    empenho varchar,
                    ordem varchar,
                    nota varchar,
                    beneficiario varchar,
                    vl_nota decimal(14,2),
                    vl_ordem decimal(14,2),
                    vl_prestado decimal(14,2),
                    cod_conta integer,
                    nom_conta varchar
                )
            order by
                cod_empenho
        ";
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('exercicioBoletim', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('exercicioEmpenho', $exercicioEmpenho, \PDO::PARAM_STR);
        $query->bindValue('codEntidade', $codEntidade, \PDO::PARAM_STR);
        $query->bindValue('codOrdemDe', ($codOrdemDe) ? $codOrdemDe : '', \PDO::PARAM_STR);
        $query->bindValue('codOrdemAte', ($codOrdemAte) ? $codOrdemAte : '', \PDO::PARAM_STR);
        $query->bindValue('codEmpenhoDe', $codEmpenhoDe, \PDO::PARAM_STR);
        $query->bindValue('codEmpenhoAte', $codEmpenhoAte, \PDO::PARAM_STR);
        $query->bindValue('codNotaDe', $codNotaDe, \PDO::PARAM_STR);
        $query->bindValue('codNotaAte', $codNotaAte, \PDO::PARAM_STR);
        $query->bindValue('numcgm', ($numcgm) ? $numcgm : '', \PDO::PARAM_STR);
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

    /**
     * @param Empenho\NotaLiquidacao $notaLiquidacao
     * @param $formData
     * @param $currentUser
     * @param $registros
     * @return bool|\Exception
     */
    public function realizaEstorno(Empenho\NotaLiquidacao $notaLiquidacao, $formData, $currentUser, $registros, $translator)
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
                if ((float) $registro > 0) {
                    list($codEntidade, $codNota, $exercicio, $timestamp) = explode('~', $params);
                    $notaLiquidacaoPaga = $em->getRepository(Empenho\NotaLiquidacaoPaga::class)
                        ->findOneBy(
                            array(
                                'codEntidade' => $codEntidade,
                                'codNota' => $codNota,
                                'exercicio' => $exercicio,
                                'timestamp' => $timestamp
                            )
                        );

                    // Nota Liquidacao Paga Anulada
                    $notaLiquidacaoPagaAnulada = new Empenho\NotaLiquidacaoPagaAnulada();
                    $notaLiquidacaoPagaAnulada->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                    $notaLiquidacaoPagaAnulada->setObservacao($formData->get('motivoEstorno')->getData());
                    $notaLiquidacaoPagaAnulada->setVlAnulado((float) $registro);
                    $em->persist($notaLiquidacaoPagaAnulada);

                    // Nota Liquidacao Paga Anulada Auditoria
                    $notaLiquidacaoPagaAnuladaAuditoria = new Empenho\NotaLiquidacaoPagaAnuladaAuditoria();
                    $notaLiquidacaoPagaAnuladaAuditoria->setFkSwCgm($currentUser->getFkSwCgm());
                    $notaLiquidacaoPagaAnuladaAuditoria->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
                    $em->persist($notaLiquidacaoPagaAnuladaAuditoria);

                    // Insere Lote
                    $nomLote = $translator
                        ->trans(
                            'label.orcamentariaEstornos.nomLote',
                            array(
                                '%codEmpenho%' => $notaLiquidacao->getFkEmpenhoEmpenho()->getCodEmpenho(),
                                '%exercicio%' => $notaLiquidacao->getFkEmpenhoEmpenho()->getExercicio()
                            )
                        );

                    $codLote = $em->getRepository(Empenho\Empenho::class)
                        ->fnInsereLote(
                            $notaLiquidacao->getExercicio(),
                            $notaLiquidacao->getCodEntidade(),
                            self::TIPO_LANCAMENTO,
                            $nomLote,
                            $boletim->getDtBoletim()->format("d/m/Y")
                        );

                    // Busca Conta Debito
                    $contaDebito = $em->getRepository(Contabilidade\Lancamento::class)
                        ->retornaPlanoDebito(
                            $notaLiquidacao->getExercicio(),
                            $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getCodConta()
                        );

                    $sequencia = $em->getRepository(Empenho\Empenho::class)
                        ->empenhoAnulacaoPagamento(
                            $notaLiquidacao->getExercicio(),
                            (float) $registro,
                            $notaLiquidacao->getEmpenho(),
                            (int) $codLote,
                            self::TIPO_LANCAMENTO,
                            (int) $notaLiquidacao->getCodEntidade(),
                            (int) $notaLiquidacao->getCodNota(),
                            '',
                            '',
                            $notaLiquidacao->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getNumOrgao(),
                            true,
                            $notaLiquidacaoPaga->getFkTesourariaPagamento()->getCodPlano(),
                            $contaDebito
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
                            self::TIPO_LANCAMENTO,
                            $notaLiquidacao->getEmpenho()
                        );

                    // Lancamento Empenho
                    $lancamento = $em->getRepository(Contabilidade\Lancamento::class)
                        ->findOneBy(
                            array(
                                'codLote' => $codLote,
                                'tipo' => trim(self::TIPO_LANCAMENTO),
                                'exercicio' => $notaLiquidacao->getExercicio(),
                                'codEntidade' => $notaLiquidacao->getCodEntidade(),
                                'sequencia' => $sequenciaLancamento
                            )
                        );
                    $lancamentoEmpenho = new Contabilidade\LancamentoEmpenho();
                    $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);
                    $em->persist($lancamentoEmpenho);

                    // Contabilidade Pagamento
                    $pagamento = new Contabilidade\Pagamento();
                    $pagamento->setFkEmpenhoNotaLiquidacaoPaga($notaLiquidacaoPaga);
                    $pagamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
                    $em->persist($pagamento);

                    // Contabilidade Pagamento Estornado
                    $pagamentoEstornado = new Contabilidade\PagamentoEstorno();
                    $pagamentoEstornado->setFkContabilidadePagamento($pagamento);
                    $pagamentoEstornado->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
                    $em->persist($pagamentoEstornado);

                    // Tesouraria Pagamento Estornado
                    $tesourariaPagamentoEstornado = new Tesouraria\PagamentoEstornado();
                    $tesourariaPagamentoEstornado->setFkEmpenhoNotaLiquidacaoPagaAnulada($notaLiquidacaoPagaAnulada);
                    $tesourariaPagamentoEstornado->setFkTesourariaPagamento($notaLiquidacaoPaga->getFkTesourariaPagamento());
                    $tesourariaPagamentoEstornado->setFkTesourariaBoletim($boletim);
                    $tesourariaPagamentoEstornado->setFkTesourariaAutenticacao($autenticacao);
                    $tesourariaPagamentoEstornado->setFkTesourariaUsuarioTerminal($usuarioTerminal);
                    $em->persist($tesourariaPagamentoEstornado);
                }
            }
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
