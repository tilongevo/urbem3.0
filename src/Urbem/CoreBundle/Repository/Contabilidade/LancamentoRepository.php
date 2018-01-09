<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Urbem\CoreBundle\Repository\AbstractRepository;

class LancamentoRepository extends AbstractRepository
{
    /**
     * @param $codLote
     * @param $tipo
     * @param $exercicio
     * @param $codEntidade
     * @return int
     */
    public function getProximaSequencia($codLote, $tipo, $exercicio, $codEntidade)
    {
        return $this->nextVal('sequencia', [
            'cod_lote' => $codLote,
            'tipo' => $tipo,
            'exercicio' => $exercicio,
            'cod_entidade' => $codEntidade
        ]);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function fezEncerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.fezEncerramentoAnualLancamentosVariacoesPatrimoniais2013('%s','%s') as fez ",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function fezEncerramentoAnualLancamentosOrcamentario2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.fezEncerramentoAnualLancamentosOrcamentario2013('%s','%s') as fez ",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function fezencerramentoanuallancamentoscontrole2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.fezEncerramentoAnualLancamentosControle2013('%s','%s') as fez ",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function encerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.encerramentoAnualLancamentosVariacoesPatrimoniais2013('%s','%s') as fez ",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function encerramentoAnualLancamentosOrcamentario2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.encerramentoAnualLancamentosOrcamentario2013('%s','%s')",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function encerramentoAnualLancamentosControle2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.encerramentoAnualLancamentosControle2013('%s','%s')",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function excluiEncerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.excluiEncerramentoAnualLancamentosVariacoesPatrimoniais2013('%s','%d') as fez",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function excluiEncerramentoAnualLancamentosOrcamentario2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.excluiEncerramentoAnualLancamentosOrcamentario2013 ('%s','%d') as fez",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function excluiencerramentoanuallancamentoscontrole2013($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.excluiencerramentoanuallancamentoscontrole2013 ('%s','%d') as fez",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function anularRestosEncerramento($exercicio, $codEntidade)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.fn_anular_restos_encerramento ('%s','%d')",
            $exercicio,
            $codEntidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $dtFinal
     * @return array
     */
    public function geraRelatorioInsuficiencia($exercicio, $codEntidade, $dtFinal)
    {
        $sql = sprintf(
            "
            select
                *,
                (saldo - restos_processados - restos_nao_processados - liquidado_a_pagar - a_liquidar) as saldo_inscrito
            from
                (
                    select
                        lpad(
                            cod_recurso :: varchar,
                            4,
                            '0'
                        ) as cod_recurso,
                        tipo,
                        cod_entidade,
                        coalesce(
                            contabilidade.saldo_conta_banco_recurso(
                                '%s',
                                cod_recurso,
                                cod_entidade
                            ),
                            0
                        ) as saldo,
                        (
                            sum( total_processados_exercicios_anteriores ) + sum( total_processados_exercicio_anterior )
                        ) as restos_processados,
                        (
                            sum( total_nao_processados_exercicios_anteriores ) + sum( total_nao_processados_exercicio_anterior )
                        ) as restos_nao_processados,
                        sum( liquidados_nao_pagos ) as liquidado_a_pagar,
                        sum( empenhados_nao_liquidados ) as a_liquidar
                    from
                        contabilidade.relatorio_insuficiencia(
                            '%s',
                            '%s',
                            '%s'
                        ) as tb(
                            cod_recurso integer,
                            tipo varchar,
                            cod_entidade integer,
                            total_processados_exercicios_anteriores numeric,
                            total_processados_exercicio_anterior numeric,
                            total_nao_processados_exercicios_anteriores numeric,
                            total_nao_processados_exercicio_anterior numeric,
                            liquidados_nao_pagos numeric,
                            empenhados_nao_liquidados numeric
                        )
                    group by
                        cod_recurso,
                        tipo,
                        cod_entidade
                    order by
                        cod_recurso,
                        tipo
                ) as tabela
            where
                (
                    saldo > 0
                    or restos_processados > 0
                    or restos_nao_processados > 0
                    or liquidado_a_pagar > 0
                    or a_liquidar > 0
                )",
            $exercicio,
            $exercicio,
            $codEntidade,
            $dtFinal
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
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
        $sql = sprintf(
            "SELECT
            contabilidade.fn_insere_lote('%s', '%d','%s','%s','%s') AS cod_lote ",
            $exercicio,
            $codEntidade,
            $tipoLote,
            $nomLote,
            $dtLote
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $params
     * @return array
     */
    public function getLancamentos($params)
    {
        $sql = sprintf(
            "
             SELECT 
                sequencia ,
                cod_lote ,
                tipo ,
                exercicio ,
                cod_entidade ,
                cod_historico ,
                complemento 
            FROM 
                contabilidade.lancamento 
            WHERE 
                exercicio = '%s'
                AND  tipo = '%s'
                AND  cod_historico = %d",
            $params['exercicio'],
            $params['tipo'],
            $params['codHistorico']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
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
     * @return null
     */
    public function insereLancamento($exercicio, $contaDebito, $contaCredito, $valor, $codLote, $codEntidade, $codHistorico, $tipo, $complemento)
    {
        $sql = "
            SELECT
                contabilidade.fn_insere_lancamentos (
                    :exercicio,
                    :contaDebito,
                    :contaCredito,
                    '',
                    '',
                    :valor,
                    :codLote,
                    :codEntidade,
                    :codHistorico,
                    :tipo,
                    :complemento
                ) AS sequencia
        ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue("exercicio", $exercicio);
        $result->bindValue("contaDebito", $contaDebito);
        $result->bindValue("contaCredito", $contaCredito);
        $result->bindValue("valor", (float) $valor);
        $result->bindValue("codLote", $codLote);
        $result->bindValue("codEntidade", $codEntidade);
        $result->bindValue("codHistorico", $codHistorico);
        $result->bindValue("tipo", $tipo);
        $result->bindValue("complemento", $complemento);

        $result->execute();

        $retorno = $result->fetch();
        $sequencia = null;
        if ($retorno) {
            $sequencia = $retorno['sequencia'];
        }
        return $sequencia;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function fnAberturaRestosPagar($exercicio)
    {
        $sql = 'SELECT fn_abertura_restos_pagar as abertura FROM contabilidade.fn_abertura_restos_pagar(:exercicio)';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", (string) $exercicio);

        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $exercicio
     * @param $codContaDespesa
     * @param bool $estorno
     * @return mixed
     */
    public function retornaPlanoDebito($exercicio, $codContaDespesa, $estorno = false)
    {
        $sql = "
            select
                pa.cod_plano
            from
                contabilidade.configuracao_lancamento_credito as clc inner join contabilidade.plano_conta as pc on
                pc.exercicio = clc.exercicio
                and pc.cod_conta = clc.cod_conta inner join contabilidade.plano_analitica as pa on
                pa.exercicio = clc.exercicio
                and pa.cod_conta = clc.cod_conta
            where
                clc.exercicio = :exercicio
                and clc.cod_conta_despesa = :codContaDespesa
                and clc.estorno = :estorno
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue("codContaDespesa", $codContaDespesa, \PDO::PARAM_INT);
        $query->bindValue("estorno", ($estorno) ? 't' : 'f', \PDO::PARAM_STR);

        $query->execute();
        $result = $query->fetch();

        return $result['cod_plano'];
    }

    public function retornaCodPlanoUmEDois($exercicio, $codRecurso)
    {
        $sql = "
            select
            (
                select
                    plano_analitica.cod_plano
                from
                    contabilidade.plano_conta join contabilidade.plano_analitica on
                    plano_analitica.cod_conta = plano_conta.cod_conta
                    and plano_analitica.exercicio = plano_conta.exercicio join contabilidade.plano_recurso on
                    plano_recurso.cod_plano = plano_analitica.cod_plano
                    and plano_recurso.exercicio = plano_analitica.exercicio
                where
                    plano_conta.cod_estrutural like '8.2.1.1.4.%'
                    and plano_recurso.cod_recurso =:codRecurso
                    and plano_conta.exercicio =:exercicio
            ) as cod_plano_um,
            (
                select
                    plano_analitica.cod_plano
                from
                    contabilidade.plano_conta join contabilidade.plano_analitica on
                    plano_analitica.cod_conta = plano_conta.cod_conta
                    and plano_analitica.exercicio = plano_conta.exercicio join contabilidade.plano_recurso on
                    plano_recurso.cod_plano = plano_analitica.cod_plano
                    and plano_recurso.exercicio = plano_analitica.exercicio
                where
                    plano_conta.cod_estrutural like '8.2.1.1.3.%'
                    and plano_recurso.cod_recurso =:codRecurso
                    and plano_conta.exercicio =:exercicio
            ) as cod_plano_dois
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue("codRecurso", $codRecurso, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetch();
    }
}
