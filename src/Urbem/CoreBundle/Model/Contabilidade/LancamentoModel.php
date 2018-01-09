<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Contabilidade\LancamentoRepository;

class LancamentoModel extends AbstractModel
{
    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var LancamentoRepository $repository */
    protected $repository;

    const ABERTURA_RP = 'abertura_RP';
    const COD_MODULO = 9;
    const VALOR_T = 'T';
    const VALOR_INICIAL = 1;

    /**
     * LancamentoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\Lancamento");
    }

    /**
     * @param $codLote
     * @param $tipo
     * @param $exercicio
     * @param $codEntidade
     * @return int
     */
    public function getProximaSequencia($codLote, $tipo, $exercicio, $codEntidade)
    {
        return $this->repository->getProximaSequencia($codLote, $tipo, $exercicio, $codEntidade);
    }

    /**
     * @param $exercicio
     * @throws \Exception
     */
    public function gerarSaldosBalanco($exercicio)
    {
        try {
            $loteModel = new LoteModel($this->entityManager);
            $verificaImplantacao = $loteModel->verificaImplantacaoSaldo($exercicio);
            $boRetorno = $verificaImplantacao['retorno'];

            if ($boRetorno == true) {
                $this->excluirImplantacaoSaldos($exercicio);
            }

            // Lista saldo de conta analitica
            $anoAnterior = $exercicio - 1;
            $planoAnaliticaModel = new PlanoAnaliticaModel($this->entityManager);
            $rsSaldos = $planoAnaliticaModel->listarSaldoContaAnalitica($anoAnterior);

            $empenhoModel = new Model\Empenho\EmpenhoModel($this->entityManager);
            $planoContaModel = new PlanoContaModel($this->entityManager);
            $emPlanoAnalitica = $this->entityManager->getRepository("CoreBundle:Contabilidade\\PlanoAnalitica");

            foreach ($rsSaldos as $rsSaldo) {
                // Listar lote implantacao
                $params = [
                    'codEntidade' => $rsSaldo['cod_entidade'],
                    'exercicio' => $exercicio,
                    'codEstrutural' => $rsSaldo['cod_estrutural']
                ];

                $rsContas = $planoAnaliticaModel->listarLoteImplantacao($params);

                foreach ($rsContas as $rsConta) {
                    if (trim($rsSaldo['saldo']) == '') {
                        continue;
                    }

                    $codLote = $empenhoModel->fnInsereLote(
                        $exercicio,
                        $rsSaldo['cod_entidade'],
                        LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                        LoteModel::TYPE_NOME_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                        '01/01/' . $exercicio
                    );

                    $contaCredito = 0;
                    $contaDebito = 0;
                    $codPlano = 0;
                    if ($rsConta['natureza_saldo'] == PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_DEBITO) {
                        $contaDebito = $rsSaldo['cod_plano'];
                        $codPlano = $contaDebito;
                    } elseif ($rsConta['natureza_saldo'] == PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_CREDITO) {
                        $contaCredito = $rsSaldo['cod_plano'];
                        $codPlano = $contaCredito;
                    }

                    if (!$contaCredito && !$contaDebito) {
                        continue;
                    }

                    $planoAnalitica = $emPlanoAnalitica->findOneBy([
                        'codPlano' => $codPlano,
                        'exercicio' => $exercicio
                    ]);

                    if (is_null($planoAnalitica)) {
                        continue;
                    }

                    $planoContaModel->insertLancamento(
                        $exercicio,
                        $contaDebito,
                        $contaCredito,
                        '',
                        '',
                        $rsSaldo['saldo'],
                        $codLote,
                        $rsSaldo['cod_entidade'],
                        1,
                        LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                        ''
                    );
                }
            }
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $exercicio
     * @return bool
     */
    private function excluirImplantacaoSaldos($exercicio)
    {
        $historicoContabilModel = new HistoricoContabilModel($this->entityManager);
        $historico = $historicoContabilModel->getHistoricoByExericicioAndNomHistorico($exercicio, 'Implantação de Saldo');

        if (!$historico) {
            return false;
        }

        $params = [
            'exercicio' => $exercicio,
            'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
            'codHistorico' => $historico->getCodHistorico()
        ];

        $lancamentos = $this->getLancamentos($params);

        $emContaCredito = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ContaCredito");
        $emContaDebito = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ContaDebito");
        $emValorLancamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ValorLancamento");
        $emLancamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\\Lancamento");

        foreach ($lancamentos as $lancamento) {
            // Exclui Conta Credito
            $contaCredito = $emContaCredito->findOneBy([
                'codLote' => $lancamento['cod_lote'],
                'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                'sequencia' => $lancamento['sequencia'],
                'exercicio' => $lancamento['exercicio'],
                'codEntidade' => $lancamento['cod_entidade'],
                'tipoValor' => PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_CREDITO
            ]);

            if ($contaCredito) {
                $this->entityManager->remove($contaCredito);
            }

            // Exclui Valor Lancamento da Conta Credito
            $valorLancamentoContaCredito = $emValorLancamento->findOneBy([
                'codLote' => $lancamento['cod_lote'],
                'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                'sequencia' => $lancamento['sequencia'],
                'exercicio' => $lancamento['exercicio'],
                'codEntidade' => $lancamento['cod_entidade'],
                'tipoValor' => PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_CREDITO
            ]);

            if ($valorLancamentoContaCredito) {
                $this->entityManager->remove($valorLancamentoContaCredito);
            }

            // Exclui Conta Débito
            $contaDebito = $emContaDebito->findOneBy([
                'codLote' => $lancamento['cod_lote'],
                'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                'sequencia' => $lancamento['sequencia'],
                'exercicio' => $lancamento['exercicio'],
                'codEntidade' => $lancamento['cod_entidade'],
                'tipoValor' => PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_DEBITO
            ]);

            if ($contaDebito) {
                $this->entityManager->remove($contaDebito);
            }

            // Exclui Valor Lancamento da Conta Credito
            $valorLancamentoContaDebito = $emValorLancamento->findOneBy([
                'codLote' => $lancamento['cod_lote'],
                'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                'sequencia' => $lancamento['sequencia'],
                'exercicio' => $lancamento['exercicio'],
                'codEntidade' => $lancamento['cod_entidade'],
                'tipoValor' => PlanoAnaliticaModel::TYPE_NATUREZA_SALDO_DEBITO
            ]);

            if ($valorLancamentoContaDebito) {
                $this->entityManager->remove($valorLancamentoContaDebito);
            }

            // Exclui Lancamento
            $lancamentoObj = $emLancamento->findOneBy([
                'codLote' => $lancamento['cod_lote'],
                'tipo' => LoteModel::TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA,
                'sequencia' => $lancamento['sequencia'],
                'exercicio' => $lancamento['exercicio'],
                'codEntidade' => $lancamento['cod_entidade'],
            ]);

            if ($lancamentoObj) {
                $this->entityManager->remove($lancamentoObj);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getLancamentos($params)
    {
        return $this->repository->getLancamentos($params);
    }

    /**
     * @param $exercicio
     * @return bool
     */
    public function podeGerarAberturaRestosPagar($exercicio)
    {
        return self::VALOR_T !== (string) (new Model\Administracao\ConfiguracaoModel($this->entityManager))->pegaConfiguracao(self::ABERTURA_RP, self::COD_MODULO, (string) $exercicio, true);
    }

    /**
     * @param $exercicio
     * @return bool
     */
    public function gerarAberturaRestosPagar($exercicio)
    {
        $response = false;
        $aberturaRestosPagar = $this->entityManager->getRepository(Lancamento::class)->fnAberturaRestosPagar($exercicio);
        if (!empty($aberturaRestosPagar['abertura'])) {
            (new Model\Administracao\ConfiguracaoModel($this->entityManager))->updateAtributosDinamicos([
                'valor' => self::VALOR_T,
                'cod_modulo' => self::COD_MODULO,
                'parametro' => self::ABERTURA_RP,
                'exercicio' => $exercicio
            ]);
            $response = true;
        }
        return $response;
    }

    /**
     * @param $exercicio
     * @param $contaDebito
     * @param $contaCredito
     * @param $valor
     * @param $codLote
     * @param $codEntidade
     * @param $codHistorico
     * @param $tipo
     * @param $complemento
     * @return mixed
     */
    public function insereLancamento($exercicio, $contaDebito, $contaCredito, $valor, $codLote, $codEntidade, $codHistorico, $tipo, $complemento)
    {
        $sequencia = $this->repository->insereLancamento($exercicio, $contaDebito, $contaCredito, $valor, $codLote, $codEntidade, $codHistorico, $tipo, $complemento);
        return $sequencia;
    }

    /**
     * @param $tipo
     * @return int
     */
    public function getSequencia($tipo)
    {
        $qb = $this->entityManager->getRepository(Lancamento::class)->createQueryBuilder('o');
        $qb->select('MAX(o.sequencia)');
        $qb->where('o.tipo = :tipo');
        $qb->setParameter('tipo', $tipo);
        $sequencia = $qb->getQuery()->getSingleScalarResult();
        return $sequencia ? $sequencia : self::VALOR_INICIAL;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $tipoLote
     * @param $nomLote
     * @param $dtLote
     * @return array
     */
    public function montaInsereLote($exercicio, $codEntidade, $tipoLote, $nomLote, $dtLote)
    {
        return $this->repository->montaInsereLote($exercicio, $codEntidade, $tipoLote, $nomLote, $dtLote);
    }
}
