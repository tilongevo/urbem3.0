<?php
namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;

class TransferenciaRepository extends EntityRepository
{
    public function getEntidades($numCgm)
    {
        $exercicio = date('Y');
        $sql = "
                SELECT
                  E.cod_entidade,
                  concat(E.cod_entidade, ' - ', C.nom_cgm) as nom_cgm
                FROM orcamento.entidade AS E,
                     sw_cgm AS C
                WHERE E.numcgm = C.numcgm
                AND (
                concat(E.cod_entidade, '-', exercicio) IN (SELECT
                  concat(cod_entidade, '-', exercicio)
                FROM orcamento.usuario_entidade
                WHERE numcgm = {$numCgm}
                AND exercicio = '{$exercicio}')
                OR E.exercicio < (SELECT
                  SUBSTRING(valor, 7, 4)
                FROM administracao.configuracao
                WHERE parametro = 'data_implantacao'
                AND exercicio = '{$exercicio}'
                AND cod_modulo = 9)
                )
                AND E.exercicio = '{$exercicio}'
                ORDER BY cod_entidade;";

        return $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql)
            ->fetchAll();
    }

    private function getNextKey($table, $field, $filter = '')
    {
        $sql = "SELECT COALESCE(MAX({$field}), 0)+1 as nextkey FROM {$table} {$filter}";

        $param = $this->getEntityManager()
            ->getConnection()
            ->executeQuery($sql)
            ->fetch();
        return $param['nextkey'];
    }

    public function getNexCodLote($codEntidade, $exercicio = null)
    {
        $exercicio = (!$exercicio) ? date('Y') : $exercicio;
        $filter = "WHERE exercicio = '{$exercicio}'
                AND tipo = 'T'
                AND cod_entidade = {$codEntidade}";

        return $this->getNextKey('contabilidade.lote', 'cod_lote', $filter);
    }

    public function getNextCodAutenticacao(\DateTime $dataBoletim)
    {
        $filter = "WHERE to_char(dt_autenticacao,'dd/mm/yyyy') = '{$dataBoletim->format('d/m/Y')}'";

        return $this->getNextKey('tesouraria.autenticacao', 'cod_autenticacao', $filter);
    }

    public function gerarLancamento(Transferencia $transferencia)
    {
        /**
         * SELECT contabilidade.fn_insere_lancamentos (
         *  '2016', --Exercicio
         *  2529, -- Cod conta debito (PinCodPlanoDeb)
         *  2510, -- Cod Conta Credito (PinCodPlanoCred) - retirada
         *  '', -- estrutura debido
         *  '', -- estrutura credito
         *  12.00, -- Valor
         *  1285, -- Cod Lote
         *  2, -- Cod Entidade
         *  904, -- cod historico
         *  'T', -- tipo padrao
         *  '' -- PstComplemento
         *) as sequencia
         */

        $valor = (float) str_replace(',', '.', $transferencia->getValor());
        $sql = "SELECT contabilidade.fn_insere_lancamentos (
                    '{$transferencia->getExercicio()}',
                    {$transferencia->getCodPlanoDebito()},
                    {$transferencia->getCodPlanoCredito()},
                    '','',
                    {$valor},
                    {$transferencia->getCodLote()},
                    {$transferencia->getCodEntidade()},
                    {$transferencia->getCodHistorico()},
                    'T',
                    ''
             ) as sequencia;";

        $exec = $this->getEntityManager()->getConnection()->executeQuery($sql);
        $this->getEntityManager()->flush();

        return $exec->fetch();
    }

    public function geraTransferencia(Transferencia $transferencia)
    {
        $insert = "INSERT INTO tesouraria.transferencia (
                    cod_lote,
                    exercicio,
                    cod_entidade,
                    tipo,
                    cod_autenticacao,
                    dt_autenticacao,
                    cod_plano_credito,
                    cod_plano_debito,
                    cod_boletim,
                    cod_historico,
                    cod_terminal,
                    timestamp_terminal,
                    cgm_usuario,
                    timestamp_usuario,
                    timestamp_transferencia,
                    observacao,
                    valor,
                    cod_tipo
                )VALUES(
                    {$transferencia->getCodLote()},
                    '{$transferencia->getExercicio()}',
                    {$transferencia->getCodEntidade()},
                    '{$transferencia->getTipo()}',
                    {$transferencia->getFkTesourariaAutenticacao()->getCodAutenticacao()},
                    '{$transferencia->getFkTesourariaAutenticacao()->getdtAutenticacao()}',
                    {$transferencia->getCodPlanoDebito()},
                    {$transferencia->getCodPlanoCredito()},
                    {$transferencia->getCodBoletim()},
                    {$transferencia->getCodHistorico()},
                    {$transferencia->getCodTerminal()},
                    TO_TIMESTAMP('{$transferencia->getTimestampTerminal()}' ,'yyyy-mm-dd hh24:mi:ss.US'),
                    {$transferencia->getCgmUsuario()},
                    TO_TIMESTAMP('{$transferencia->getTimestampUsuario()}' ,'yyyy-mm-dd hh24:mi:ss.US'),
                    TO_TIMESTAMP('{$transferencia->getTimestampTransferencia()->format("Y-m-d H:i:s")}' ,'yyyy-mm-dd hh24:mi:ss.US'),
                    '{$transferencia->getObservacao()}',
                    {$transferencia->getValor()},
                    {$transferencia->getCodTipo()}
                )";

        $this->getEntityManager()->getConnection()->executeQuery($insert);
    }

    public function gerarLote($exercicio, $codEntidade, $nomeLote, $data)
    {
        /*
         * SELECT
	      contabilidade.fn_insere_lote(  '2016'  ,2 ,'T'  ,'Transferência - CD:2529 | CC:2510'  ,'19/04/2016'  ) as cod_lote
         */

        $sql = "SELECT contabilidade.fn_insere_lote('{$exercicio}', {$codEntidade}, 'T', '{$nomeLote}', '{$data}') as cod_lote";
        $exec = $this->getEntityManager()->getConnection()->executeQuery($sql)->fetch();
        return $exec['cod_lote'];
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codTipo
     * @return array
     */
    public function getArrecadacaoExtraEstornos($exercicio, $codEntidade, $codTipo)
    {
        $sql = "
            select
                T.cod_lote,
                T.exercicio,
                T.cod_entidade,
                ent.nom_cgm as nom_entidade,
                T.tipo,
                T.cod_boletim,
                to_char(
                    B.dt_boletim,
                    'dd/mm/yyyy'
                ) as dt_boletim,
                T.cod_historico,
                to_char(
                    T.timestamp_transferencia,
                    'dd/mm/yyyy'
                ) as dt_transferencia,
                T.timestamp_transferencia,
                T.observacao,
                t.cod_plano_credito,
                credito.nom_conta as nom_conta_credito,
                t.cod_plano_debito,
                debito.nom_conta as nom_conta_debito,
                coalesce(
                    t.valor,
                    0.00
                ) as valor,
                coalesce(
                    te.valor,
                    0.00
                ) as valor_estornado,
                ret.cod_recibo_extra as cod_recibo,
                tr.cod_recurso,
                tr.masc_recurso_red,
                tr.nom_recurso,
                tr.masc_recurso_red || ' - ' || tr.nom_recurso as recurso,
                tc.cod_credor,
                tc.nom_credor,
                t.cod_tipo
            from
                tesouraria.transferencia as T left join tesouraria.recibo_extra_transferencia as ret on
                (
                    ret.exercicio = t.exercicio
                    and ret.cod_entidade = t.cod_entidade
                    and ret.tipo = t.tipo
                    and ret.cod_lote = t.cod_lote
                ) left join(
                    select
                        tr.cod_recurso,
                        tr.exercicio,
                        tr.tipo,
                        tr.cod_entidade,
                        tr.cod_lote,
                        rec.nom_recurso,
                        rec.masc_recurso_red,
                        rec.cod_detalhamento
                    from
                        tesouraria.transferencia_recurso as TR,
                        orcamento.recurso(:exercicio) as REC
                    where
                        tr.cod_recurso = rec.cod_recurso
                        and tr.exercicio = rec.exercicio
                ) as TR on
                (
                    tr.tipo = t.tipo
                    and tr.exercicio = t.exercicio
                    and tr.cod_entidade = t.cod_entidade
                    and tr.cod_lote = t.cod_lote
                ) left join(
                    select
                        tc.numcgm as cod_credor,
                        tc.exercicio,
                        tc.tipo,
                        tc.cod_entidade,
                        tc.cod_lote,
                        cgm.nom_cgm as nom_credor
                    from
                        tesouraria.transferencia_credor as TC,
                        sw_cgm as CGM
                    where
                        tc.numcgm = cgm.numcgm
                ) as TC on
                (
                    tc.tipo = t.tipo
                    and tc.exercicio = t.exercicio
                    and tc.cod_entidade = t.cod_entidade
                    and tc.cod_lote = t.cod_lote
                ) left join(
                    select
                        cgm.nom_cgm,
                        e.cod_entidade,
                        e.exercicio
                    from
                        sw_cgm as CGM,
                        orcamento.entidade as E
                    where
                        cgm.numcgm = e.numcgm
                ) as ENT on
                (
                    ent.exercicio = t.exercicio
                    and ent.cod_entidade = t.cod_entidade
                ) left join tesouraria.boletim as B on
                (
                    B.cod_boletim = T.cod_boletim
                    and B.exercicio = T.exercicio
                    and B.cod_entidade = T.cod_entidade
                ) left join(
                    select
                        pc.nom_conta,
                        pa.cod_plano,
                        pa.exercicio
                    from
                        contabilidade.plano_conta as pc,
                        contabilidade.plano_analitica as pa
                    where
                        pa.exercicio = pc.exercicio
                        and pa.cod_conta = pc.cod_conta
                ) as debito on
                (
                    debito.cod_plano = t.cod_plano_debito
                    and debito.exercicio = t.exercicio
                ) left join(
                    select
                        pc.nom_conta,
                        pa.cod_plano,
                        pa.exercicio
                    from
                        contabilidade.plano_conta as pc,
                        contabilidade.plano_analitica as pa
                    where
                        pa.exercicio = pc.exercicio
                        and pa.cod_conta = pc.cod_conta
                ) as credito on
                (
                    credito.cod_plano = t.cod_plano_credito
                    and credito.exercicio = t.exercicio
                ) left join(
                    select
                        coalesce(
                            sum( te.valor ),
                            0.00
                        ) as valor,
                        te.cod_lote,
                        te.cod_entidade,
                        te.exercicio,
                        te.tipo
                    from
                        tesouraria.transferencia_estornada as te
                    group by
                        te.cod_lote,
                        te.cod_entidade,
                        te.exercicio,
                        te.tipo
                ) as te on
                (
                    t.cod_lote = te.cod_lote
                    and t.cod_entidade = te.cod_entidade
                    and t.exercicio = te.exercicio
                    and t.tipo = te.tipo
                ) left join tesouraria.tipo_transferencia as TT on
                (
                    t.cod_tipo = tt.cod_tipo
                )
            where
                t.exercicio = :exercicio
                and t.cod_entidade is not null
                and t.cod_entidade = :codEntidade
                and t.cod_tipo = :codTipo
                and(
                    coalesce(
                        t.valor,
                        0.00
                    )- coalesce(
                        te.valor,
                        0.00
                    )
                )> 0.00
                and not exists(
                    select
                        topr.cod_lote
                    from
                        tesouraria.transferencia_ordem_pagamento_retencao as topr
                    where
                        topr.cod_lote = t.cod_lote
                        and topr.cod_entidade = t.cod_entidade
                        and topr.exercicio = t.exercicio
                        and topr.tipo = t.tipo
                )
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue('codTipo', $codTipo, \PDO::PARAM_INT);
        $query->execute();
        $return = $query->fetchAll();
        $ids = array();
        foreach ($return as $item) {
            $ids[] = $item['cod_lote'];
        }
        return $ids;
    }
}
