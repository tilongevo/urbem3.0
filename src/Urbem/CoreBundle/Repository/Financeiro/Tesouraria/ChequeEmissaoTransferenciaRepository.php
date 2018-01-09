<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ChequeEmissaoTransferenciaRepository extends ORM\EntityRepository
{

    /**
     * @return array
     */
    public function findAllTransferenciasPorEntidade($codEntidade)
    {
        $sql = "SELECT
	            T.cod_lote,
	            T.exercicio,
	            T.cod_entidade,
	            ent.nom_cgm as nom_entidade,
	            T.tipo,
	            T.cod_boletim,
	            TO_CHAR(boletim.dt_boletim,'dd/mm/yyyy') AS data_cheque,
	            T.cod_historico,
	            T.observacao,
	            t.cod_plano_credito,
	            credito.nom_conta as nom_conta_credito,
	            t.cod_plano_debito,
	            debito.nom_conta as nom_conta_debito,
	            (coalesce(t.valor,0.00) - coalesce(te.valor,0.00) - COALESCE(cheque_emissao_transferencia.valor,0.00)) as valor,
	            tc.cod_credor,
	            tc.nom_credor,
	            t.cod_tipo
	        FROM
	         tesouraria.transferencia as T
	         LEFT JOIN
	            ( SELECT
	                 tc.numcgm as cod_credor,
	                 tc.exercicio,
	                 tc.tipo,
	                 tc.cod_entidade,
	                 tc.cod_lote,
	                 cgm.nom_cgm as nom_credor
	              FROM
	                 tesouraria.transferencia_credor  as TC,
	                 sw_cgm  as CGM
	              WHERE
	                     tc.numcgm    = cgm.numcgm
	            ) as TC on (     tc.tipo         = t.tipo
	                         AND tc.exercicio    = t.exercicio
	                         AND tc.cod_entidade = t.cod_entidade
	                         AND tc.cod_lote     = t.cod_lote
	                       )
	         LEFT JOIN
	             ( SELECT
	                  cgm.nom_cgm,
	                  e.cod_entidade,
	                  e.exercicio
	               FROM
	                  sw_cgm as CGM,
	                  orcamento.entidade as E
	               WHERE
	                  cgm.numcgm = e.numcgm
	             ) as ENT on (
	                  ent.exercicio    = t.exercicio    AND
	                  ent.cod_entidade = t.cod_entidade
	             )
	         LEFT JOIN
	             ( SELECT
	                 pc.nom_conta,
	                 pa.cod_plano,
	                 pa.exercicio
	               FROM
	                 contabilidade.plano_conta     as pc,
	                 contabilidade.plano_analitica as pa
	               WHERE
	                 pa.exercicio = pc.exercicio AND
	                 pa.cod_conta = pc.cod_conta
	             ) as debito on (
	                     debito.cod_plano = t.cod_plano_debito AND
	                     debito.exercicio = t.exercicio
	             )
	         LEFT JOIN
	             ( SELECT
	                 pc.nom_conta,
	                 pa.cod_plano,
	                 pa.exercicio
	               FROM
	                 contabilidade.plano_conta     as pc,
	                 contabilidade.plano_analitica as pa
	               WHERE
	                 pa.exercicio = pc.exercicio AND
	                 pa.cod_conta = pc.cod_conta
	             ) as credito on (
	                     credito.cod_plano = t.cod_plano_credito AND
	                     credito.exercicio = t.exercicio
	             )
	         LEFT JOIN
	             ( SELECT
	                     coalesce(sum(te.valor),0.00) as valor,
	                     te.cod_lote,
	                     te.cod_entidade,
	                     te.exercicio,
	                     te.tipo
	               FROM tesouraria.transferencia_estornada as te
	               GROUP BY
	                     te.cod_lote,
	                     te.cod_entidade,
	                     te.exercicio,
	                     te.tipo
	             ) as te on (
	                    t.cod_lote        = te.cod_lote          AND
	                    t.cod_entidade    = te.cod_entidade      AND
	                    t.exercicio       = te.exercicio         AND
	                    t.tipo            = te.tipo
	             )
	         LEFT JOIN tesouraria.tipo_transferencia as TT on (
	                    t.cod_tipo = tt.cod_tipo )
	         LEFT JOIN tesouraria.boletim
	                ON T.cod_boletim  = boletim.cod_boletim
	               AND T.cod_entidade = boletim.cod_entidade
	               AND T.exercicio    = boletim.exercicio
	         LEFT JOIN ( SELECT cheque_emissao_transferencia.cod_lote
	                          , cheque_emissao_transferencia.cod_entidade
	                          , cheque_emissao_transferencia.exercicio
	                          , cheque_emissao_transferencia.tipo
	                          , SUM(COALESCE(cheque_emissao.valor,0.00)) AS valor
	                       FROM tesouraria.cheque_emissao_transferencia
	                 INNER JOIN tesouraria.cheque_emissao
	                         ON cheque_emissao_transferencia.num_cheque         = cheque_emissao.num_cheque
	                        AND cheque_emissao_transferencia.cod_banco          = cheque_emissao.cod_banco
	                        AND cheque_emissao_transferencia.cod_agencia        = cheque_emissao.cod_agencia
	                        AND cheque_emissao_transferencia.cod_conta_corrente = cheque_emissao.cod_conta_corrente
	                        AND cheque_emissao_transferencia.timestamp_emissao  = cheque_emissao.timestamp_emissao
	                      WHERE NOT EXISTS ( SELECT 1
	                                           FROM tesouraria.cheque_emissao_anulada
	                                          WHERE cheque_emissao.cod_banco          = cheque_emissao_anulada.cod_banco
	                                            AND cheque_emissao.cod_agencia        = cheque_emissao_anulada.cod_agencia
	                                            AND cheque_emissao.cod_conta_corrente = cheque_emissao_anulada.cod_conta_corrente
	                                            AND cheque_emissao.timestamp_emissao  = cheque_emissao_anulada.timestamp_emissao
	                                            AND cheque_emissao.num_cheque         = cheque_emissao_anulada.num_cheque
	                                       )
	                   GROUP BY cheque_emissao_transferencia.cod_lote
	                          , cheque_emissao_transferencia.cod_entidade
	                          , cheque_emissao_transferencia.exercicio
	                          , cheque_emissao_transferencia.tipo
	                   ) AS cheque_emissao_transferencia
	                ON cheque_emissao_transferencia.cod_lote     = t.cod_lote
	               AND cheque_emissao_transferencia.cod_entidade = t.cod_entidade
	               AND cheque_emissao_transferencia.exercicio    = t.exercicio
	               AND cheque_emissao_transferencia.tipo         = t.tipo
	          where T.cod_entidade = :cod_entidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }
}
