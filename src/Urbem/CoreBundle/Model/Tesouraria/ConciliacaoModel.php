<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\ConciliacaoRepository;

class ConciliacaoModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var ConciliacaoRepository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\Conciliacao');
    }

    /**
     * @param array $params
     * @return \Doctrine\DBAL\Driver\Statement
     */
    public function recuperaMovimentacao(array $params)
    {
        return $this->repository->recuperaMovimentacao($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function recuperaMovimentacaoPendente(array $params)
    {
        return $this->repository->recuperaMovimentacaoPendente($params);
    }

    /**
     * @param $cod_plano
     * @param $exercicio
     * @param $mes
     * @return array
     */
    public function montaRecuperaCabecalhoConciliacao($cod_plano, $exercicio, $mes)
    {
        return $this->repository->montaRecuperaCabecalhoConciliacao($cod_plano, $exercicio, $mes);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $dtExtrato
     * @param $codPlano
     * @param $mes
     * @return mixed
     */
    public function montaParamsMovimentacao($exercicio, $codEntidade, $dtExtrato, $codPlano, $mes)
    {
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        $params['exercicio'] = $exercicio;
        $params['inCodEntidade'] = $codEntidade;
        $params['stDtInicial'] = '';
        $params['stDtFinal'] = $dtExtrato;

        $params['stFiltro'] = sprintf(
            " WHERE  exercicio = ' || quote_literal('%s')|| ' AND  TO_CHAR(dt_lancamento,' || quote_literal('mm')|| ') = TO_CHAR(TO_DATE( ' || quote_literal('%s')|| '::varchar,' || quote_literal('dd/mm/yyyy')|| '),' || quote_literal('mm')|| ') AND  cod_plano = %s  AND  ((mes >= ' || quote_literal('%s')|| ' AND exercicio_conciliacao = ' || quote_literal('%s')|| ') OR conciliar != ' || quote_literal('true')|| ') ",
            $exercicio,
            $dtExtrato,
            $codPlano,
            $mes,
            $exercicio
        );

        $params['stFiltroArrecadacao'] = sprintf(
            " AND TB.exercicio = ' || quote_literal('%s')|| '  AND TO_CHAR(TB.dt_boletim,' || quote_literal('mm')|| ') = TO_CHAR(TO_DATE( ' || quote_literal('%s')|| '::varchar, ' || quote_literal('dd/mm/yyyy')|| '),' || quote_literal('mm')|| ') ",
            $exercicio,
            $dtExtrato
        );

        $params['inCodPlano'] = (integer) $codPlano;
        $params['inMes'] = $mes;

        return $params;
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @param $dtExtrato
     * @param $codEntidade
     * @return mixed
     */
    public function montaParamsMovimentacaoPendente($codPlano, $exercicio, $mes, $dtExtrato, $codEntidade)
    {
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        $dtInicial = sprintf("%s/%s/%s", '01', $mes, $exercicio);

        $params['exercicio'] = $exercicio;
        $params['inCodEntidade'] = $codEntidade;
        $params['stDtInicial'] = $dtExtrato;
        $params['stDtFinal'] = '';

        $params['stFiltro'] = sprintf(
            " WHERE  exercicio <= ' || quote_literal('%s')|| ' AND  dt_lancamento < TO_DATE( ' || quote_literal('%s')|| ', ' || quote_literal('dd/mm/yyyy')|| ' ) AND  cod_plano = %d  AND  ((CASE WHEN mes = ' || quote_literal('')|| ' THEN false ELSE mes::integer >= %d END AND exercicio_conciliacao = ' || quote_literal('%s')|| ') OR conciliar != ' || quote_literal('true')|| ') ",
            $exercicio,
            $dtInicial,
            $codPlano,
            $mes,
            $exercicio
        );

        $params['stFiltroArrecadacao'] = sprintf(
            " AND TB.exercicio <= ' || quote_literal('%s')|| '  AND TB.dt_boletim <= TO_DATE( ' || quote_literal('%s')|| '::varchar, ' || quote_literal('dd/mm/yyyy')|| ' ) ",
            $exercicio,
            $dtInicial
        );

        $params['inCodPlano'] = $codPlano;
        $params['inMes'] = $mes;

        return $params;
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return mixed
     */
    public function listLancamentosManuais($codPlano, $exercicio, $mes)
    {
        return $this->repository->listLancamentosManuais($codPlano, $exercicio, $mes);
    }

    /**
     * @param $cod_plano
     * @param $dt_inicial
     * @param $dt_final
     * @param $exercicio
     * @param $movimentacao
     * @return array
     */

    public function recuperaSaldoContaTesouraria($cod_plano, $exercicio, $dt_inicial = false, $dt_final = false, $movimentacao = false)
    {
        $dt_inicial = ($dt_inicial) ? $dt_inicial : sprintf('%s/%s/%s', '01', '01', $exercicio);
        $dt_final   = ($dt_final) ? $dt_final : sprintf('%s/%s/%s', '31', '12', $exercicio);
        $movimentacao = ($movimentacao) ? 'true' : 'false';
        return $this->repository->recuperaSaldoContaTesouraria($cod_plano, $dt_inicial, $dt_final, $exercicio, $movimentacao);
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     */
    public function removeConciliacaoLancamentoManual($codPlano, $exercicio, $mes)
    {
        return $this->repository->removeConciliacaoLancamentoManual($codPlano, $exercicio, $mes);
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $exercicioConciliacao
     * @param $mes
     * @return bool
     */
    public function removeConciliacaoLancamentoContabil($codPlano, $exercicio, $exercicioConciliacao, $mes)
    {
        return $this->repository->removeConciliacaoLancamentoContabil($codPlano, $exercicio, $exercicioConciliacao, $mes);
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     */
    public function removeConciliacaoLancamentoArrecadacao($codPlano, $exercicio, $mes)
    {
        return $this->repository->removeConciliacaoLancamentoArrecadacao($codPlano, $exercicio, $mes);
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     */
    public function removeConciliacaoLancamentoArrecadacaoEstornada($codPlano, $exercicio, $mes)
    {
        return $this->repository->removeConciliacaoLancamentoArrecadacaoEstornada($codPlano, $exercicio, $mes);
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $tipo
     * @return bool
     */
    public function removeAssinatura($codEntidade, $exercicio, $tipo)
    {
        return $this->repository->removeAssinatura($codEntidade, $exercicio, $tipo);
    }
}
