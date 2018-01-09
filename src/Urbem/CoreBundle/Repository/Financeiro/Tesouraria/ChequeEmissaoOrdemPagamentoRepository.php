<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ChequeEmissaoOrdemPagamentoRepository extends ORM\EntityRepository
{

    /**
     * @return array
     */
    public function findAllOrdemPagamentoPorExercicioEntidade($filtro1, $filtro2)
    {
        $sql = "SELECT ordem_pagamento.nom_entidade
	             , ordem_pagamento.cod_entidade
	             , ordem_pagamento.cod_ordem
	             , ordem_pagamento.exercicio
	             , ordem_pagamento.nom_credor
	             , ((ordem_pagamento.vl_ordem) - COALESCE(cheque_emissao_ordem_pagamento.valor,0)) AS valor
	             , COALESCE(ordem_pagamento_retencao.vl_retencao,0) AS vl_retencao
	             , ( SELECT TO_CHAR(dt_emissao,'dd/mm/yyyy')
	                   FROM empenho.ordem_pagamento AS op
	                  WHERE ordem_pagamento.cod_ordem::VARCHAR    = op.cod_ordem::VARCHAR
	                    AND ordem_pagamento.exercicio    = op.exercicio
	                    AND ordem_pagamento.cod_entidade = op.cod_entidade
	               ) AS data_cheque
	         FROM  (
	        SELECT retorno.entidade AS nom_entidade
	             , retorno.cod_entidade
	             , split_part(retorno.ordem,'/',1) AS cod_ordem
	             , split_part(retorno.ordem,'/',2) AS exercicio
	             , retorno.beneficiario AS nom_credor
	             , retorno.vl_ordem
	          FROM empenho.fn_lista_empenhos_pagar_tesouraria(:filtro1 ,:filtro2 , '') 
	          AS retorno( empenho          varchar
	                            ,nota             varchar
	                            ,adiantamento     varchar
	                            ,ordem            varchar
	                            ,cod_entidade     integer
	                            ,entidade         varchar
	                            ,cgm_beneficiario integer
	                            ,beneficiario     varchar
	                            ,vl_nota          numeric
	                            ,vl_ordem         numeric )
	                ) AS ordem_pagamento
	     LEFT JOIN ( SELECT cheque_emissao_ordem_pagamento.cod_ordem
	                      , cheque_emissao_ordem_pagamento.exercicio
	                      , cheque_emissao_ordem_pagamento.cod_entidade
	                      , SUM(cheque_emissao.valor) AS valor
	                   FROM tesouraria.cheque_emissao_ordem_pagamento
	
	             INNER JOIN tesouraria.cheque_emissao
	                     ON cheque_emissao_ordem_pagamento.cod_banco          = cheque_emissao.cod_banco
	                    AND cheque_emissao_ordem_pagamento.cod_agencia        = cheque_emissao.cod_agencia
	                    AND cheque_emissao_ordem_pagamento.cod_conta_corrente = cheque_emissao.cod_conta_corrente
	                    AND cheque_emissao_ordem_pagamento.num_cheque         = cheque_emissao.num_cheque
	                    AND cheque_emissao_ordem_pagamento.timestamp_emissao  = cheque_emissao.timestamp_emissao
	
	                  WHERE NOT EXISTS ( SELECT 1
	                                       FROM tesouraria.cheque_emissao_anulada
	                                      WHERE cheque_emissao.cod_banco          = cheque_emissao_anulada.cod_banco
	                                        AND cheque_emissao.cod_agencia        = cheque_emissao_anulada.cod_agencia
	                                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_anulada.cod_conta_corrente
	                                        AND cheque_emissao.num_cheque         = cheque_emissao_anulada.num_cheque
	                                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_anulada.timestamp_emissao
	                                   )
	               GROUP BY cheque_emissao_ordem_pagamento.cod_ordem
	                      , cheque_emissao_ordem_pagamento.exercicio
	                      , cheque_emissao_ordem_pagamento.cod_entidade
	               ) AS cheque_emissao_ordem_pagamento
	            ON ordem_pagamento.cod_ordem::VARCHAR = cheque_emissao_ordem_pagamento.cod_ordem::VARCHAR
	           AND ordem_pagamento.exercicio = cheque_emissao_ordem_pagamento.exercicio
	           AND ordem_pagamento.cod_entidade = cheque_emissao_ordem_pagamento.cod_entidade
	     LEFT JOIN ( SELECT SUM(COALESCE(ordem_pagamento_retencao.vl_retencao,0)) AS vl_retencao
	                      , ordem_pagamento_retencao.exercicio
	                      , ordem_pagamento_retencao.cod_entidade
	                      , ordem_pagamento_retencao.cod_ordem
	                   FROM empenho.ordem_pagamento_retencao
	               GROUP BY ordem_pagamento_retencao.exercicio
	                      , ordem_pagamento_retencao.cod_entidade
	                      , ordem_pagamento_retencao.cod_ordem
	               ) AS ordem_pagamento_retencao
	            ON ordem_pagamento.cod_ordem::VARCHAR    = ordem_pagamento_retencao.cod_ordem::VARCHAR
	           AND ordem_pagamento.exercicio    = ordem_pagamento_retencao.exercicio
	           AND ordem_pagamento.cod_entidade = ordem_pagamento_retencao.cod_entidade
	         WHERE ((ordem_pagamento.vl_ordem) - COALESCE(cheque_emissao_ordem_pagamento.valor,0) - COALESCE(ordem_pagamento_retencao.vl_retencao,0)) > 0";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('filtro1', $filtro1);
        $query->bindValue('filtro2', $filtro2);
        $query->execute();
        return $query->fetchAll();
    }
}
