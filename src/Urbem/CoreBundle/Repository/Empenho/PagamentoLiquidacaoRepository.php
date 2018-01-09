<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;

/**
 * Class PagamentoLiquidacaoRepository
 * @package Urbem\CoreBundle\Repository\Empenho
 */
class PagamentoLiquidacaoRepository extends ORM\EntityRepository
{
    /**
     * @param array $params
     * @return array
     */
    public function recuperaPagamentoLiquidacao(array $params)
    {
        $sql = <<<SQL
SELECT *
FROM (
       SELECT

         eem.cod_empenho,
         eem.exercicio                AS ex_empenho,
         to_char(eem.dt_empenho,
                 'dd/mm/yyyy')        AS dt_empenho,
         enl.cod_nota,
         enl.exercicio                AS ex_nota,
         to_char(enl.dt_liquidacao,
                 'dd/mm/yyyy')        AS dt_nota,
         enl.cod_entidade,
         coalesce(sum(pag.vl_pago),
                  0.00)               AS vl_pago,
         coalesce((epl.vl_pagamento - coalesce(opla.vl_anulado, 0.00)) - coalesce(sum(pag.vl_pago), 0.00),
                  0.00)               AS vl_pagamento,
         CASE WHEN ode.cod_recurso IS NOT NULL
           THEN ode.cod_recurso
         ELSE rpe.recurso
         END                          AS cod_recurso,
         ece.conta_contrapartida
       FROM
         empenho.pagamento_liquidacao AS epl

         LEFT JOIN (
                     SELECT
                       opla.cod_nota,
                       opla.exercicio_liquidacao,
                       opla.cod_entidade,
                       opla.cod_ordem,
                       opla.exercicio,
                       sum(opla.vl_anulado) AS vl_anulado

                     FROM empenho.ordem_pagamento_liquidacao_anulada AS opla
                     GROUP BY opla.cod_nota
                       , opla.exercicio_liquidacao
                       , opla.cod_entidade
                       , opla.cod_ordem
                       , opla.exercicio
                   ) AS opla
           ON (
           opla.cod_nota = epl.cod_nota
           AND opla.exercicio_liquidacao = epl.exercicio_liquidacao
           AND opla.cod_entidade = epl.cod_entidade
           AND opla.cod_ordem = epl.cod_ordem
           AND opla.exercicio = epl.exercicio
           )

         LEFT JOIN
         (
           SELECT
             plnlp.exercicio,
             plnlp.cod_entidade,
             plnlp.cod_ordem,
             plnlp.timestamp,
             plnlp.cod_nota,
             plnlp.exercicio_liquidacao,
             coalesce(sum(tnlp.vl_pago), 0.00) AS vl_pago
           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS plnlp
             LEFT JOIN (

                         SELECT
                           nlp.exercicio,
                           nlp.cod_entidade,
                           nlp.cod_nota,
                           nlp.timestamp,
                           coalesce(coalesce(vl_pago, 0.00) - coalesce(vl_pago_anulado, 0.00), 0.00) AS vl_pago
                         FROM empenho.nota_liquidacao_paga AS nlp
                           LEFT JOIN (
                                       SELECT
                                         nlpa.exercicio,
                                         nlpa.cod_nota,
                                         nlpa.cod_entidade,
                                         nlpa.timestamp,
                                         coalesce(sum(vl_anulado), 0.00) AS vl_pago_anulado
                                       FROM empenho.nota_liquidacao_paga_anulada AS nlpa
                                       GROUP BY nlpa.exercicio
                                         , nlpa.cod_nota
                                         , nlpa.cod_entidade
                                         , nlpa.timestamp
                                     ) AS nlpa
                             ON (nlpa.exercicio = nlp.exercicio
                                 AND nlpa.cod_nota = nlp.cod_nota
                                 AND nlpa.cod_entidade = nlp.cod_entidade
                                 AND nlpa.timestamp = nlp.timestamp
                             )


                       ) AS tnlp
               ON (tnlp.exercicio = plnlp.exercicio_liquidacao
                   AND tnlp.cod_nota = plnlp.cod_nota
                   AND tnlp.cod_entidade = plnlp.cod_entidade
                   AND tnlp.timestamp = plnlp.timestamp
               )

           GROUP BY plnlp.exercicio
             , plnlp.cod_entidade
             , plnlp.cod_ordem
             , plnlp.timestamp
             , plnlp.cod_nota
             , plnlp.exercicio_liquidacao

         ) AS pag

           ON (pag.exercicio = epl.exercicio
               AND pag.cod_entidade = epl.cod_entidade
               AND pag.cod_ordem = epl.cod_ordem
               AND pag.cod_nota = epl.cod_nota
               AND pag.exercicio_liquidacao = epl.exercicio_liquidacao

           )
         JOIN empenho.nota_liquidacao AS enl
           ON (
           epl.exercicio_liquidacao = enl.exercicio
           AND epl.cod_nota = enl.cod_nota
           AND epl.cod_entidade = enl.cod_entidade
           )

         JOIN empenho.empenho AS eem
           ON (
           enl.exercicio_empenho = eem.exercicio
           AND enl.cod_entidade = eem.cod_entidade
           AND enl.cod_empenho = eem.cod_empenho
           )
         JOIN empenho.pre_empenho AS epe
           ON (
           eem.exercicio = epe.exercicio
           AND eem.cod_pre_empenho = epe.cod_pre_empenho
           )
         LEFT JOIN empenho.contrapartida_empenho AS ece
           ON (
           eem.exercicio = ece.exercicio
           AND eem.cod_entidade = ece.cod_entidade
           AND eem.cod_empenho = ece.cod_empenho
           )
         LEFT JOIN
         empenho.pre_empenho_despesa AS epd
           ON (
           epe.exercicio = epd.exercicio
           AND epe.cod_pre_empenho = epd.cod_pre_empenho
           )
         LEFT JOIN
         orcamento.despesa AS ode
           ON (
           epd.exercicio = ode.exercicio
           AND epd.cod_despesa = ode.cod_despesa
           )
         LEFT JOIN
         empenho.restos_pre_empenho AS rpe
           ON (
           epe.exercicio = rpe.exercicio
           AND epe.cod_pre_empenho = rpe.cod_pre_empenho
           )
       WHERE 1 = 1
             AND epl.cod_ordem = :cod_ordem AND epl.exercicio = :exercicio AND epl.cod_entidade = :cod_entidade
       GROUP BY
         eem.cod_empenho,
         eem.exercicio,
         to_char(eem.dt_empenho, 'dd/mm/yyyy'),
         enl.cod_nota,
         enl.exercicio,
         to_char(enl.dt_liquidacao, 'dd/mm/yyyy'),
         enl.cod_entidade,
         epl.vl_pagamento,
         opla.vl_anulado,
         ode.cod_recurso,
         rpe.recurso,
         ece.conta_contrapartida

       ORDER BY enl.cod_nota

     ) AS tbl
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}
