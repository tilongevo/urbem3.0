<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ChequeEmissaoReciboExtraRepository extends ORM\EntityRepository
{

    /**
     * Busca os recibo extra
     * @return array
     */
    public function findAllReciboExtraPorExercicioEntidadeTipo($codEntidade, $exercicio, $tipoRecibo)
    {
        $sql = "   SELECT recibo_extra.cod_recibo_extra
	             , recibo_extra.exercicio
	             , recibo_extra.cod_entidade
	             , entidade_cgm.nom_cgm AS nom_entidade
	             , (recibo_extra.valor - COALESCE(cheque_emissao_recibo_extra.valor,0.00)) AS valor
	             , credor_cgm.nom_cgm AS nom_credor
	             , TO_CHAR(recibo_extra.timestamp,'dd/mm/yyyy') AS data_cheque
	          FROM tesouraria.recibo_extra
	     LEFT JOIN tesouraria.recibo_extra_credor
	            ON recibo_extra.exercicio        = recibo_extra_credor.exercicio
	           AND recibo_extra.cod_entidade     = recibo_extra_credor.cod_entidade
	           AND recibo_extra.cod_recibo_extra = recibo_extra_credor.cod_recibo_extra
	           AND recibo_extra.tipo_recibo      = recibo_extra_credor.tipo_recibo
	     LEFT JOIN sw_cgm AS credor_cgm
	            ON recibo_extra_credor.numcgm = credor_cgm.numcgm
	    INNER JOIN orcamento.entidade
	            ON recibo_extra.cod_entidade = entidade.cod_entidade
	           AND recibo_extra.exercicio    = entidade.exercicio
	    INNER JOIN sw_cgm AS entidade_cgm
	            ON entidade.numcgm = entidade_cgm.numcgm
	     LEFT JOIN ( SELECT cheque_emissao_recibo_extra.exercicio
	                      , cheque_emissao_recibo_extra.cod_entidade
	                      , cheque_emissao_recibo_extra.cod_recibo_extra
	                      , cheque_emissao_recibo_extra.tipo_recibo
	                      , SUM(cheque_emissao.valor) AS valor
	                   FROM tesouraria.cheque_emissao
	             INNER JOIN tesouraria.cheque_emissao_recibo_extra
	                     ON cheque_emissao.cod_banco          = cheque_emissao_recibo_extra.cod_banco
	                    AND cheque_emissao.cod_agencia        = cheque_emissao_recibo_extra.cod_agencia
	                    AND cheque_emissao.cod_conta_corrente = cheque_emissao_recibo_extra.cod_conta_corrente
	                    AND cheque_emissao.num_cheque         = cheque_emissao_recibo_extra.num_cheque
	                    AND cheque_emissao.timestamp_emissao  = cheque_emissao_recibo_extra.timestamp_emissao
	                  WHERE NOT EXISTS ( SELECT 1
	                                       FROM tesouraria.cheque_emissao_anulada
	                                      WHERE cheque_emissao.cod_banco          = cheque_emissao_anulada.cod_banco
	                                        AND cheque_emissao.cod_agencia        = cheque_emissao_anulada.cod_agencia
	                                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_anulada.cod_conta_corrente
	                                        AND cheque_emissao.num_cheque         = cheque_emissao_anulada.num_cheque
	                                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_anulada.timestamp_emissao
	                                   )
	               GROUP BY cheque_emissao_recibo_extra.exercicio
	                      , cheque_emissao_recibo_extra.cod_entidade
	                      , cheque_emissao_recibo_extra.cod_recibo_extra
	                      , cheque_emissao_recibo_extra.tipo_recibo
	               ) AS cheque_emissao_recibo_extra
	            ON recibo_extra.exercicio        = cheque_emissao_recibo_extra.exercicio
	           AND recibo_extra.cod_entidade     = cheque_emissao_recibo_extra.cod_entidade
	           AND recibo_extra.cod_recibo_extra = cheque_emissao_recibo_extra.cod_recibo_extra
	           AND recibo_extra.tipo_recibo      = cheque_emissao_recibo_extra.tipo_recibo
	         WHERE NOT EXISTS ( SELECT 1
	                              FROM tesouraria.recibo_extra_anulacao
	                             WHERE recibo_extra.exercicio        = recibo_extra_anulacao.exercicio
	                               AND recibo_extra.cod_entidade     = recibo_extra_anulacao.cod_entidade
	                               AND recibo_extra.cod_recibo_extra = recibo_extra_anulacao.cod_recibo_extra
	                               AND recibo_extra.tipo_recibo      = recibo_extra_anulacao.tipo_recibo
	                          )
	           AND NOT EXISTS ( SELECT 1
	                              FROM tesouraria.recibo_extra_transferencia
	                             WHERE recibo_extra.exercicio        = recibo_extra_transferencia.exercicio
	                               AND recibo_extra.cod_entidade     = recibo_extra_transferencia.cod_entidade
	                               AND recibo_extra.cod_recibo_extra = recibo_extra_transferencia.cod_recibo_extra
	                               AND recibo_extra.tipo_recibo      = recibo_extra_transferencia.tipo_recibo
	                          )
	           AND (recibo_extra.valor - COALESCE(cheque_emissao_recibo_extra.valor,0.00)) > 0  AND recibo_extra.cod_entidade = :cod_entidade  AND recibo_extra.exercicio = :exercicio  AND recibo_extra.tipo_recibo = :tipo_recibo ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('tipo_recibo', $tipoRecibo);
        $query->execute();
        return $query->fetchAll();
    }
}
