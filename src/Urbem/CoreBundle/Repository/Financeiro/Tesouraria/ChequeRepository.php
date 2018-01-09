<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;

class ChequeRepository extends ORM\EntityRepository
{

    /**
     * Busca os bancos
     * @return array
     */
    public function findBancosPorExercicio($exercicio)
    {
        $sql = "SELECT
                    cod_banco ,
                    num_banco ,
                    nom_banco
                FROM
                    monetario.banco WHERE EXISTS (
                        SELECT 1 
                        FROM contabilidade.plano_banco 
                        WHERE banco.cod_banco = plano_banco.cod_banco
                        AND plano_banco.exercicio = :exercicio
                    )  
                ORDER BY num_banco";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Busca as agencias
     * @return array
     */
    public function findAllAgenciasPorBancoExercicio($banco, $exercicio)
    {
        $sql = "SELECT
                    cod_banco ,
                    cod_agencia ,
                    num_agencia ,
                    nom_agencia ,
                    numcgm_agencia ,
                    nom_pessoa_contato
                FROM
                    monetario.agencia where cod_banco = :banco AND EXISTS ( 
                        SELECT 1
                        FROM contabilidade.plano_banco
                        WHERE plano_banco.cod_banco = agencia.cod_banco
                        AND plano_banco.cod_agencia = agencia.cod_agencia
                        AND plano_banco.exercicio = :exercicio
                    )";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('banco', $banco);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetchAll();
    }


    public function findAllContasCorrentePorBancoAgenciaExercicio($numBanco, $numAgencia, $exercicio)
    {
        $sql = "SELECT                                                           
                    CCor.cod_banco,                                              
                    CCor.cod_agencia,                                            
                    CCor.cod_conta_corrente,                                     
                    CCor.num_conta_corrente,                                     
                    TCon.cod_tipo,                                               
                    TCon.descricao,                                              
                    TO_CHAR(CCor.data_criacao , 'DD/MM/YYYY') as data_criacao,   
                    Ag.num_agencia,                                              
                    Ag.nom_agencia,                                              
                    Ban.num_banco,                                               
                    Ban.nom_banco                                                
                FROM                                                             
                    monetario.conta_corrente AS CCor                             
                INNER JOIN                                                       
                    monetario.banco AS Ban                                       
                ON                                                               
                    Ban.cod_banco = Ccor.cod_banco                               
                INNER JOIN                                                       
                    monetario.tipo_conta AS TCon                                 
                ON                                                               
                    TCon.cod_tipo = Ccor.cod_tipo                                
                LEFT JOIN                                                        
                    monetario.agencia AS Ag                                      
                ON                                                               
                    CCor.cod_agencia = Ag.cod_agencia                            
                    AND                                                          
                    Ban.cod_banco = Ag.cod_banco                                 
                WHERE  num_banco = :num_banco AND  num_agencia = :num_agencia AND  EXISTS ( 
                    SELECT 1
                    FROM contabilidade.plano_banco
                    JOIN contabilidade.plano_analitica
                    ON plano_analitica.cod_plano = plano_banco.cod_plano
                    AND plano_analitica.exercicio = plano_banco.exercicio
                    JOIN contabilidade.plano_conta
                    ON plano_conta.cod_conta = plano_analitica.cod_conta
                    AND plano_conta.exercicio = plano_analitica.exercicio
                    WHERE plano_banco.cod_banco = CCor.cod_banco
                    AND plano_banco.cod_agencia = CCor.cod_agencia
                    AND plano_banco.cod_conta_corrente = CCor.cod_conta_corrente
                    AND plano_conta.cod_estrutural NOT LIKE '1.1.1.1.3%'
                    AND plano_banco.exercicio = :exercicio 
                )  
                ORDER BY ban.cod_banco, Ag.cod_agencia, cod_conta_corrente ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_banco', $numBanco);
        $query->bindValue('num_agencia', $numAgencia);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Busca as agencias
     * @return array
     */
    public function findAllAgencias()
    {
        $sql = "SELECT                  
                    cod_agencia ,
                    nom_agencia 
                FROM
                    monetario.agencia";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Busca as agencias
     * @return array
     */
    public function findAllContasCorrente()
    {
        $sql = "SELECT                  
                    cod_conta_corrente ,
                    num_conta_corrente
                FROM
                    monetario.conta_corrente";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function statusCheque($numBanco, $numAgencia, $numContaCorrente, $numCheque)
    {
        $sql = "SELECT cheque.num_cheque
	                 , conta_corrente.cod_conta_corrente
	                 , conta_corrente.num_conta_corrente
	                 , agencia.cod_agencia
	                 , agencia.num_agencia
	                 , agencia.nom_agencia
	                 , banco.cod_banco
	                 , banco.num_banco
	                 , banco.nom_banco
	                 , CASE WHEN cheque_emissao.num_cheque IS NULL
	                        THEN 'Não'
	                        ELSE CASE WHEN cheque_emissao_anulada.num_cheque IS NULL
	                                  THEN 'Sim'
	                                  ELSE 'Anulado'
	                             END
	                   END AS emitido
	              FROM tesouraria.cheque
	        INNER JOIN monetario.conta_corrente
	                ON cheque.cod_conta_corrente  = conta_corrente.cod_conta_corrente
	               AND cheque.cod_agencia         = conta_corrente.cod_agencia
	               AND cheque.cod_banco           = conta_corrente.cod_banco
	        INNER JOIN monetario.agencia
	                ON conta_corrente.cod_agencia = agencia.cod_agencia
	               AND conta_corrente.cod_banco   = agencia.cod_banco
	        INNER JOIN monetario.banco
	                ON agencia.cod_banco          = banco.cod_banco
	
	         LEFT JOIN ( SELECT cheque_emissao.cod_banco
	                          , cheque_emissao.cod_agencia
	                          , cheque_emissao.cod_conta_corrente
	                          , cheque_emissao.num_cheque
	                          , cheque_emissao.timestamp_emissao
	                       FROM tesouraria.cheque_emissao
	                 INNER JOIN ( SELECT cheque_emissao.cod_banco
	                                   , cheque_emissao.cod_agencia
	                                   , cheque_emissao.cod_conta_corrente
	                                   , cheque_emissao.num_cheque
	                                   , MAX(cheque_emissao.timestamp_emissao) AS timestamp_emissao
	                                FROM tesouraria.cheque_emissao
	                            GROUP BY cheque_emissao.cod_banco
	                                   , cheque_emissao.cod_agencia
	                                   , cheque_emissao.cod_conta_corrente
	                                   , cheque_emissao.num_cheque
	                            ) AS cheque_emissao_max
	                         ON cheque_emissao.cod_banco          = cheque_emissao_max.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_max.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_max.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_max.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_max.timestamp_emissao
	                   ) AS cheque_emissao
	                ON cheque.cod_banco          = cheque_emissao.cod_banco
	               AND cheque.cod_agencia        = cheque_emissao.cod_agencia
	               AND cheque.cod_conta_corrente = cheque_emissao.cod_conta_corrente
	               AND cheque.num_cheque         = cheque_emissao.num_cheque
	
	         LEFT JOIN tesouraria.cheque_emissao_ordem_pagamento
	                ON cheque_emissao.cod_banco          = cheque_emissao_ordem_pagamento.cod_banco
	               AND cheque_emissao.cod_agencia        = cheque_emissao_ordem_pagamento.cod_agencia
	               AND cheque_emissao.cod_conta_corrente = cheque_emissao_ordem_pagamento.cod_conta_corrente
	               AND cheque_emissao.num_cheque         = cheque_emissao_ordem_pagamento.num_cheque
	               AND cheque_emissao.timestamp_emissao  = cheque_emissao_ordem_pagamento.timestamp_emissao
	
	         LEFT JOIN ( SELECT cheque_emissao_transferencia.cod_banco
	                          , cheque_emissao_transferencia.cod_agencia
	                          , cheque_emissao_transferencia.cod_conta_corrente
	                          , cheque_emissao_transferencia.num_cheque
	                          , cheque_emissao_transferencia.timestamp_emissao
	                          , transferencia.exercicio
	                          , transferencia.cod_entidade
	                          , transferencia.cod_plano_credito
	                          , transferencia.cod_plano_debito
	                          , transferencia.cod_tipo
	                       FROM tesouraria.cheque_emissao_transferencia
	                 INNER JOIN tesouraria.transferencia
	                         ON cheque_emissao_transferencia.cod_lote     = transferencia.cod_lote
	                        AND cheque_emissao_transferencia.cod_entidade = transferencia.cod_entidade
	                        AND cheque_emissao_transferencia.exercicio    = transferencia.exercicio
	                        AND cheque_emissao_transferencia.tipo         = transferencia.tipo
	
	                   ) AS cheque_emissao_transferencia
	                ON cheque_emissao.cod_banco          = cheque_emissao_transferencia.cod_banco
	               AND cheque_emissao.cod_agencia        = cheque_emissao_transferencia.cod_agencia
	               AND cheque_emissao.cod_conta_corrente = cheque_emissao_transferencia.cod_conta_corrente
	               AND cheque_emissao.num_cheque         = cheque_emissao_transferencia.num_cheque
	               AND cheque_emissao.timestamp_emissao  = cheque_emissao_transferencia.timestamp_emissao
	
	         LEFT JOIN ( SELECT cheque_emissao_recibo_extra.cod_banco
	                          , cheque_emissao_recibo_extra.cod_agencia
	                          , cheque_emissao_recibo_extra.cod_conta_corrente
	                          , cheque_emissao_recibo_extra.num_cheque
	                          , cheque_emissao_recibo_extra.timestamp_emissao
	                          , recibo_extra.timestamp
	                          , recibo_extra.cod_plano
	                          , cheque_emissao_recibo_extra.cod_recibo_extra
	                          , cheque_emissao_recibo_extra.cod_entidade
	                          , cheque_emissao_recibo_extra.exercicio
	                       FROM tesouraria.cheque_emissao_recibo_extra
	                 INNER JOIN tesouraria.recibo_extra
	                         ON cheque_emissao_recibo_extra.cod_recibo_extra = recibo_extra.cod_recibo_extra
	                        AND cheque_emissao_recibo_extra.cod_entidade     = recibo_extra.cod_entidade
	                        AND cheque_emissao_recibo_extra.exercicio        = recibo_extra.exercicio
	                        AND cheque_emissao_recibo_extra.tipo_recibo      = recibo_extra.tipo_recibo
	
	                   ) AS cheque_emissao_recibo_extra
	                ON cheque_emissao.cod_banco          = cheque_emissao_recibo_extra.cod_banco
	               AND cheque_emissao.cod_agencia        = cheque_emissao_recibo_extra.cod_agencia
	               AND cheque_emissao.cod_conta_corrente = cheque_emissao_recibo_extra.cod_conta_corrente
	               AND cheque_emissao.num_cheque         = cheque_emissao_recibo_extra.num_cheque
	               AND cheque_emissao.timestamp_emissao  = cheque_emissao_recibo_extra.timestamp_emissao
	         LEFT JOIN tesouraria.cheque_emissao_anulada
	                ON cheque_emissao.cod_banco          = cheque_emissao_anulada.cod_banco
	               AND cheque_emissao.cod_agencia        = cheque_emissao_anulada.cod_agencia
	               AND cheque_emissao.cod_conta_corrente = cheque_emissao_anulada.cod_conta_corrente
	               AND cheque_emissao.num_cheque         = cheque_emissao_anulada.num_cheque
	               AND cheque_emissao.timestamp_emissao  = cheque_emissao_anulada.timestamp_emissao
	         LEFT JOIN ( SELECT cheque_emissao_baixa.cod_banco
	                          , cheque_emissao_baixa.cod_agencia
	                          , cheque_emissao_baixa.cod_conta_corrente
	                          , cheque_emissao_baixa.num_cheque
	                          , cheque_emissao_baixa.timestamp_emissao
	                       FROM tesouraria.cheque_emissao_baixa
	                 INNER JOIN ( SELECT cheque_emissao_baixa.cod_banco
	                                   , cheque_emissao_baixa.cod_agencia
	                                   , cheque_emissao_baixa.cod_conta_corrente
	                                   , cheque_emissao_baixa.num_cheque
	                                   , cheque_emissao_baixa.timestamp_emissao
	                                   , MAX(cheque_emissao_baixa.timestamp_baixa) AS timestamp_baixa
	                                FROM tesouraria.cheque_emissao_baixa
	                            GROUP BY cheque_emissao_baixa.cod_banco
	                                   , cheque_emissao_baixa.cod_agencia
	                                   , cheque_emissao_baixa.cod_conta_corrente
	                                   , cheque_emissao_baixa.num_cheque
	                                   , cheque_emissao_baixa.timestamp_emissao
	                            ) AS cheque_emissao_baixa_max
	                         ON cheque_emissao_baixa.cod_banco          = cheque_emissao_baixa_max.cod_banco
	                        AND cheque_emissao_baixa.cod_agencia        = cheque_emissao_baixa_max.cod_agencia
	                        AND cheque_emissao_baixa.cod_conta_corrente = cheque_emissao_baixa_max.cod_conta_corrente
	                        AND cheque_emissao_baixa.num_cheque         = cheque_emissao_baixa_max.num_cheque
	                        AND cheque_emissao_baixa.timestamp_emissao  = cheque_emissao_baixa_max.timestamp_emissao
	                        AND cheque_emissao_baixa.timestamp_baixa    = cheque_emissao_baixa_max.timestamp_baixa
	                      WHERE NOT EXISTS ( SELECT 1
	                                           FROM tesouraria.cheque_emissao_baixa_anulada
	                                          WHERE cheque_emissao_baixa.cod_banco          = cheque_emissao_baixa_anulada.cod_banco
	                                            AND cheque_emissao_baixa.cod_agencia        = cheque_emissao_baixa_anulada.cod_agencia
	                                            AND cheque_emissao_baixa.cod_conta_corrente = cheque_emissao_baixa_anulada.cod_conta_corrente
	                                            AND cheque_emissao_baixa.num_cheque         = cheque_emissao_baixa_anulada.num_cheque
	                                            AND cheque_emissao_baixa.timestamp_emissao  = cheque_emissao_baixa_anulada.timestamp_emissao
	                                            AND cheque_emissao_baixa.timestamp_baixa  = cheque_emissao_baixa_anulada.timestamp_baixa
	                                       )
	                    ) AS cheque_emissao_baixa
	                 ON cheque_emissao.cod_banco          = cheque_emissao_baixa.cod_banco
	                AND cheque_emissao.cod_agencia        = cheque_emissao_baixa.cod_agencia
	                AND cheque_emissao.cod_conta_corrente = cheque_emissao_baixa.cod_conta_corrente
	                AND cheque_emissao.num_cheque         = cheque_emissao_baixa.num_cheque
	                AND cheque_emissao.timestamp_emissao  = cheque_emissao_baixa.timestamp_emissao
	         WHERE  banco.num_banco = :num_banco  AND agencia.num_agencia = :num_agencia  AND conta_corrente.num_conta_corrente = :num_conta_corrente AND cheque.num_cheque = :num_cheque ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_banco', $numBanco);
        $query->bindValue('num_agencia', $numAgencia);
        $query->bindValue('num_conta_corrente', $numContaCorrente);
        $query->bindValue('num_cheque', $numCheque);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Retorna os dados :
     * Cheque
     * Emissõa
     * Ordem de pagamento
     * @param $numBanco
     * @param $numAgencia
     * @param $numContaCorrente
     * @param $numCheque
     * @return mixed
     */
    public function dadosCheque($numBanco, $numAgencia, $numContaCorrente, $numCheque)
    {
        $sql = "
            SELECT cheque.num_cheque
            , conta_corrente.cod_conta_corrente
            , conta_corrente.num_conta_corrente
            , agencia.cod_agencia
            , agencia.num_agencia
            , agencia.nom_agencia
            , banco.cod_banco
            , banco.num_banco
            , banco.nom_banco
            , TO_CHAR(cheque.data_entrada,'dd/mm/yyyy') AS data_entrada
            , CASE WHEN cheque_emissao.num_cheque IS NULL
            THEN 'Não'
            ELSE CASE WHEN cheque_emissao_anulada.num_cheque IS NULL
            THEN 'Sim'
            ELSE 'Anulado'
            END
            END AS emitido
            , cheque_emissao.valor
            , TO_CHAR(cheque_emissao_anulada.data_anulacao,'dd/mm/yyyy') AS data_anulacao
            , TO_CHAR(cheque_emissao.data_emissao,'dd/mm/yyyy') AS data_emissao
            , cheque_emissao.descricao
            , CASE WHEN (cheque_emissao_ordem_pagamento.cod_ordem IS NOT NULL)
            THEN cheque_emissao_ordem_pagamento.exercicio
            WHEN (cheque_emissao_recibo_extra.cod_recibo_extra IS NOT NULL)
            THEN cheque_emissao_recibo_extra.exercicio
            ELSE cheque_emissao_transferencia.exercicio
            END AS exercicio
            , CASE WHEN (cheque_emissao_ordem_pagamento.cod_ordem IS NOT NULL)
            THEN cheque_emissao_ordem_pagamento.cod_entidade
            WHEN (cheque_emissao_recibo_extra.cod_recibo_extra IS NOT NULL)
            THEN cheque_emissao_recibo_extra.cod_entidade
            ELSE cheque_emissao_transferencia.cod_entidade
            END AS cod_entidade
            , CASE WHEN (cheque_emissao_ordem_pagamento.cod_ordem IS NOT NULL)
            THEN cheque_emissao_ordem_pagamento.nom_entidade
            WHEN (cheque_emissao_recibo_extra.cod_recibo_extra IS NOT NULL)
            THEN cheque_emissao_recibo_extra.nom_entidade
            ELSE cheque_emissao_transferencia.nom_entidade
            END AS nom_entidade
            , cheque_emissao_ordem_pagamento.cod_ordem
            , cheque_emissao_recibo_extra.cod_recibo_extra
            , cheque_emissao_transferencia.cod_plano_credito
            , cheque_emissao_transferencia.nom_plano_credito
            , cheque_emissao_transferencia.cod_plano_debito
            , cheque_emissao_transferencia.nom_plano_debito
            , CASE WHEN (cheque_emissao_recibo_extra.cod_recibo_extra IS NOT NULL)
            THEN 'despesa_extra'
            WHEN (cheque_emissao_transferencia.cod_tipo IS NOT NULL)
            THEN 'transferencia'
            WHEN (cheque_emissao_ordem_pagamento.cod_ordem IS NOT NULL)
            THEN 'ordem_pagamento'
            ELSE ''
            END AS tipo_emissao
            , CASE WHEN (cheque_emissao_baixa.num_cheque IS NOT NULL)
            THEN 'Sim'
            ELSE 'Não'
            END AS cheque_baixado
            , CASE WHEN (cheque_emissao_recibo_extra.data_baixa IS NOT NULL)
            THEN cheque_emissao_recibo_extra.data_baixa
            WHEN (cheque_emissao_transferencia.data_baixa IS NOT NULL)
            THEN cheque_emissao_transferencia.data_baixa
            WHEN (cheque_emissao_ordem_pagamento.data_baixa IS NOT NULL)
            THEN cheque_emissao_ordem_pagamento.data_baixa
            ELSE ''
            END AS data_baixa
            FROM tesouraria.cheque
            INNER JOIN monetario.conta_corrente
            ON cheque.cod_conta_corrente  = conta_corrente.cod_conta_corrente
            AND cheque.cod_agencia         = conta_corrente.cod_agencia
            AND cheque.cod_banco           = conta_corrente.cod_banco
            INNER JOIN monetario.agencia
            ON conta_corrente.cod_agencia = agencia.cod_agencia
            AND conta_corrente.cod_banco   = agencia.cod_banco
            INNER JOIN monetario.banco
            ON agencia.cod_banco          = banco.cod_banco
            
            LEFT JOIN tesouraria.cheque_emissao
            ON cheque.cod_banco          = cheque_emissao.cod_banco
            AND cheque.cod_agencia        = cheque_emissao.cod_agencia
            AND cheque.cod_conta_corrente = cheque_emissao.cod_conta_corrente
            AND cheque.num_cheque         = cheque_emissao.num_cheque
            
            LEFT JOIN ( SELECT cheque_emissao_ordem_pagamento.cod_banco
            , cheque_emissao_ordem_pagamento.cod_agencia
            , cheque_emissao_ordem_pagamento.cod_conta_corrente
            , cheque_emissao_ordem_pagamento.num_cheque
            , cheque_emissao_ordem_pagamento.timestamp_emissao
            , entidade.cod_entidade
            , sw_cgm.nom_cgm AS nom_entidade
            , cheque_emissao_ordem_pagamento.cod_ordem
            , cheque_emissao_ordem_pagamento.exercicio
            , data_baixa
            FROM tesouraria.cheque_emissao_ordem_pagamento
            INNER JOIN orcamento.entidade
            ON cheque_emissao_ordem_pagamento.cod_entidade = entidade.cod_entidade
            AND cheque_emissao_ordem_pagamento.exercicio    = entidade.exercicio
            INNER JOIN sw_cgm
            ON entidade.numcgm = sw_cgm.numcgm
            LEFT JOIN ( SELECT pagamento_liquidacao.exercicio
            , pagamento_liquidacao.cod_entidade
            , pagamento_liquidacao.cod_ordem
            , data_baixa
            FROM empenho.pagamento_liquidacao
            INNER JOIN ( SELECT nota_liquidacao_paga.cod_nota
            , nota_liquidacao_paga.cod_entidade
            , nota_liquidacao_paga.exercicio
            , TO_CHAR(MAX(nota_liquidacao_paga.timestamp),'dd/mm/yyyy') AS data_baixa
            FROM empenho.nota_liquidacao_paga
            WHERE NOT EXISTS ( SELECT 1
            FROM empenho.nota_liquidacao_paga_anulada
            WHERE nota_liquidacao_paga.cod_entidade = nota_liquidacao_paga_anulada.cod_entidade
            AND nota_liquidacao_paga.cod_nota     = nota_liquidacao_paga_anulada.cod_nota
            AND nota_liquidacao_paga.exercicio    = nota_liquidacao_paga_anulada.exercicio
            AND nota_liquidacao_paga.timestamp    = nota_liquidacao_paga_anulada.timestamp
            )
            GROUP BY nota_liquidacao_paga.cod_nota
            , nota_liquidacao_paga.cod_entidade
            , nota_liquidacao_paga.exercicio
            ) AS nota_liquidacao_paga
            ON pagamento_liquidacao.exercicio_liquidacao = nota_liquidacao_paga.exercicio
            AND pagamento_liquidacao.cod_nota             = nota_liquidacao_paga.cod_nota
            AND pagamento_liquidacao.cod_entidade         = nota_liquidacao_paga.cod_entidade
            GROUP BY pagamento_liquidacao.exercicio
            , pagamento_liquidacao.cod_entidade
            , pagamento_liquidacao.cod_ordem
            , data_baixa
            ) AS pagamento_liquidacao
            ON cheque_emissao_ordem_pagamento.exercicio    = pagamento_liquidacao.exercicio
            AND cheque_emissao_ordem_pagamento.cod_entidade = pagamento_liquidacao.cod_entidade
            AND cheque_emissao_ordem_pagamento.cod_ordem    = pagamento_liquidacao.cod_ordem
            
            ) AS cheque_emissao_ordem_pagamento
            ON cheque_emissao.cod_banco          = cheque_emissao_ordem_pagamento.cod_banco
            AND cheque_emissao.cod_agencia        = cheque_emissao_ordem_pagamento.cod_agencia
            AND cheque_emissao.cod_conta_corrente = cheque_emissao_ordem_pagamento.cod_conta_corrente
            AND cheque_emissao.num_cheque         = cheque_emissao_ordem_pagamento.num_cheque
            AND cheque_emissao.timestamp_emissao  = cheque_emissao_ordem_pagamento.timestamp_emissao
            
            LEFT JOIN ( SELECT cheque_emissao_recibo_extra.cod_banco
            , cheque_emissao_recibo_extra.cod_agencia
            , cheque_emissao_recibo_extra.cod_conta_corrente
            , cheque_emissao_recibo_extra.num_cheque
            , cheque_emissao_recibo_extra.timestamp_emissao
            , entidade.cod_entidade
            , sw_cgm.nom_cgm AS nom_entidade
            , cheque_emissao_recibo_extra.cod_recibo_extra
            , cheque_emissao_recibo_extra.exercicio
            , TO_CHAR(boletim.dt_boletim,'dd/mm/yyyy') AS data_baixa
            FROM tesouraria.cheque_emissao_recibo_extra
            INNER JOIN orcamento.entidade
            ON cheque_emissao_recibo_extra.cod_entidade = entidade.cod_entidade
            AND cheque_emissao_recibo_extra.exercicio    = entidade.exercicio
            INNER JOIN sw_cgm
            ON entidade.numcgm = sw_cgm.numcgm
            LEFT JOIN tesouraria.recibo_extra_transferencia
            ON cheque_emissao_recibo_extra.cod_recibo_extra = recibo_extra_transferencia.cod_recibo_extra
            AND cheque_emissao_recibo_extra.exercicio        = recibo_extra_transferencia.exercicio
            AND cheque_emissao_recibo_extra.cod_entidade     = recibo_extra_transferencia.cod_entidade
            AND cheque_emissao_recibo_extra.tipo_recibo      = recibo_extra_transferencia.tipo_recibo
            LEFT JOIN tesouraria.transferencia
            ON recibo_extra_transferencia.cod_lote     = transferencia.cod_lote
            AND recibo_extra_transferencia.cod_entidade = transferencia.cod_entidade
            AND recibo_extra_transferencia.exercicio    = transferencia.exercicio
            AND recibo_extra_transferencia.tipo         = transferencia.tipo
            LEFT JOIN tesouraria.boletim
            ON transferencia.cod_boletim  = boletim.cod_boletim
            AND transferencia.cod_entidade = boletim.cod_entidade
            AND transferencia.exercicio    = boletim.exercicio
            ) AS cheque_emissao_recibo_extra
            ON cheque_emissao.cod_banco          = cheque_emissao_recibo_extra.cod_banco
            AND cheque_emissao.cod_agencia        = cheque_emissao_recibo_extra.cod_agencia
            AND cheque_emissao.cod_conta_corrente = cheque_emissao_recibo_extra.cod_conta_corrente
            AND cheque_emissao.num_cheque         = cheque_emissao_recibo_extra.num_cheque
            AND cheque_emissao.timestamp_emissao  = cheque_emissao_recibo_extra.timestamp_emissao
            
            LEFT JOIN ( SELECT cheque_emissao_transferencia.cod_banco
            , cheque_emissao_transferencia.cod_agencia
            , cheque_emissao_transferencia.cod_conta_corrente
            , cheque_emissao_transferencia.num_cheque
            , cheque_emissao_transferencia.timestamp_emissao
            , entidade.cod_entidade
            , sw_cgm.nom_cgm AS nom_entidade
            , transferencia.exercicio
            , transferencia.cod_plano_credito
            , plano_conta_credito.nom_conta AS nom_plano_credito
            , transferencia.cod_plano_debito
            , plano_conta_debito.nom_conta AS nom_plano_debito
            , transferencia.cod_tipo
            , TO_CHAR(boletim.dt_boletim,'dd/mm/yyyy') AS data_baixa
            FROM tesouraria.cheque_emissao_transferencia
            INNER JOIN tesouraria.transferencia
            ON cheque_emissao_transferencia.cod_lote     = transferencia.cod_lote
            AND cheque_emissao_transferencia.cod_entidade = transferencia.cod_entidade
            AND cheque_emissao_transferencia.exercicio    = transferencia.exercicio
            AND cheque_emissao_transferencia.tipo         = transferencia.tipo
            INNER JOIN orcamento.entidade
            ON transferencia.cod_entidade = entidade.cod_entidade
            AND transferencia.exercicio    = entidade.exercicio
            INNER JOIN sw_cgm
            ON entidade.numcgm = sw_cgm.numcgm
            
            INNER JOIN contabilidade.plano_analitica AS plano_analitica_debito
            ON transferencia.cod_plano_debito = plano_analitica_debito.cod_plano
            AND transferencia.exercicio        = plano_analitica_debito.exercicio
            INNER JOIN contabilidade.plano_conta AS plano_conta_debito
            ON plano_analitica_debito.cod_conta = plano_conta_debito.cod_conta
            AND plano_analitica_debito.exercicio = plano_conta_debito.exercicio
            
            INNER JOIN contabilidade.plano_analitica AS plano_analitica_credito
            ON transferencia.cod_plano_credito = plano_analitica_credito.cod_plano
            AND transferencia.exercicio         = plano_analitica_credito.exercicio
            INNER JOIN contabilidade.plano_conta AS plano_conta_credito
            ON plano_analitica_credito.cod_conta = plano_conta_credito.cod_conta
            AND plano_analitica_credito.exercicio = plano_conta_credito.exercicio
            LEFT JOIN tesouraria.boletim
            ON transferencia.cod_boletim  = boletim.cod_boletim
            AND transferencia.cod_entidade = boletim.cod_entidade
            AND transferencia.exercicio    = boletim.exercicio
            ) AS cheque_emissao_transferencia
            ON cheque_emissao.cod_banco          = cheque_emissao_transferencia.cod_banco
            AND cheque_emissao.cod_agencia        = cheque_emissao_transferencia.cod_agencia
            AND cheque_emissao.cod_conta_corrente = cheque_emissao_transferencia.cod_conta_corrente
            AND cheque_emissao.num_cheque         = cheque_emissao_transferencia.num_cheque
            AND cheque_emissao.timestamp_emissao  = cheque_emissao_transferencia.timestamp_emissao
            LEFT JOIN tesouraria.cheque_emissao_anulada
            ON cheque_emissao.cod_banco          = cheque_emissao_anulada.cod_banco
            AND cheque_emissao.cod_agencia        = cheque_emissao_anulada.cod_agencia
            AND cheque_emissao.cod_conta_corrente = cheque_emissao_anulada.cod_conta_corrente
            AND cheque_emissao.num_cheque         = cheque_emissao_anulada.num_cheque
            AND cheque_emissao.timestamp_emissao  = cheque_emissao_anulada.timestamp_emissao
            LEFT JOIN ( SELECT cheque_emissao_baixa.cod_banco
            , cheque_emissao_baixa.cod_agencia
            , cheque_emissao_baixa.cod_conta_corrente
            , cheque_emissao_baixa.num_cheque
            , cheque_emissao_baixa.timestamp_emissao
            FROM tesouraria.cheque_emissao_baixa
            INNER JOIN ( SELECT cheque_emissao_baixa.cod_banco
            , cheque_emissao_baixa.cod_agencia
            , cheque_emissao_baixa.cod_conta_corrente
            , cheque_emissao_baixa.num_cheque
            , cheque_emissao_baixa.timestamp_emissao
            , MAX(cheque_emissao_baixa.timestamp_baixa) AS timestamp_baixa
            FROM tesouraria.cheque_emissao_baixa
            GROUP BY cheque_emissao_baixa.cod_banco
            , cheque_emissao_baixa.cod_agencia
            , cheque_emissao_baixa.cod_conta_corrente
            , cheque_emissao_baixa.num_cheque
            , cheque_emissao_baixa.timestamp_emissao
            ) AS cheque_emissao_baixa_max
            ON cheque_emissao_baixa.cod_banco          = cheque_emissao_baixa_max.cod_banco
            AND cheque_emissao_baixa.cod_agencia        = cheque_emissao_baixa_max.cod_agencia
            AND cheque_emissao_baixa.cod_conta_corrente = cheque_emissao_baixa_max.cod_conta_corrente
            AND cheque_emissao_baixa.num_cheque         = cheque_emissao_baixa_max.num_cheque
            AND cheque_emissao_baixa.timestamp_emissao  = cheque_emissao_baixa_max.timestamp_emissao
            AND cheque_emissao_baixa.timestamp_baixa    = cheque_emissao_baixa_max.timestamp_baixa
            WHERE NOT EXISTS ( SELECT 1
            FROM tesouraria.cheque_emissao_baixa_anulada
            WHERE cheque_emissao_baixa.cod_banco          = cheque_emissao_baixa_anulada.cod_banco
            AND cheque_emissao_baixa.cod_agencia        = cheque_emissao_baixa_anulada.cod_agencia
            AND cheque_emissao_baixa.cod_conta_corrente = cheque_emissao_baixa_anulada.cod_conta_corrente
            AND cheque_emissao_baixa.num_cheque         = cheque_emissao_baixa_anulada.num_cheque
            AND cheque_emissao_baixa.timestamp_emissao  = cheque_emissao_baixa_anulada.timestamp_emissao
            AND cheque_emissao_baixa.timestamp_baixa  = cheque_emissao_baixa_anulada.timestamp_baixa
            )
            ) AS cheque_emissao_baixa
            ON cheque_emissao.cod_banco          = cheque_emissao_baixa.cod_banco
            AND cheque_emissao.cod_agencia        = cheque_emissao_baixa.cod_agencia
            AND cheque_emissao.cod_conta_corrente = cheque_emissao_baixa.cod_conta_corrente
            AND cheque_emissao.num_cheque         = cheque_emissao_baixa.num_cheque
            AND cheque_emissao.timestamp_emissao  = cheque_emissao_baixa.timestamp_emissao      
        WHERE  banco.num_banco = :num_banco  AND agencia.num_agencia = :num_agencia  AND conta_corrente.num_conta_corrente = :num_conta_corrente AND cheque.num_cheque = :num_cheque ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_banco', $numBanco);
        $query->bindValue('num_agencia', $numAgencia);
        $query->bindValue('num_conta_corrente', $numContaCorrente);
        $query->bindValue('num_cheque', $numCheque);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Vai buscas os cheques para um determinado banco, agencia e conta corrente
     * Verifica se os cheques já foram emitidos
     * Retona apenas os cheques que não foram emitidos
     * @param $codBanco
     * @param $codAgencia
     * @param $codContaCorrente
     * @return array
     */
    public function findByCheques($codBanco, $codAgencia, $codContaCorrente)
    {
        $chequesId = $this->createQueryBuilder('c')
            ->select('c.numCheque')
            ->where('c.codBanco =:codBanco')
            ->andWhere('c.codAgencia =:codAgencia')
            ->andWhere('c.codContaCorrente =:codContaCorrente')
            ->setParameter('codBanco', $codBanco)
            ->setParameter('codAgencia', $codAgencia)
            ->setParameter('codContaCorrente', $codContaCorrente)
            ->getQuery()
            ->getResult(ORM\Query::HYDRATE_ARRAY);


        $contaCorrente = $this
                            ->getEntityManager()
                            ->getRepository(ContaCorrente::class)
                            ->findOneBy(['codBanco' => $codBanco, 'codAgencia' => $codAgencia, 'codContaCorrente' => $codContaCorrente]);


        //Verifica se o cheque já foi emitido
        foreach ($chequesId as $key => $cheque) {
            $emitido = $this->dadosCheque(
                $contaCorrente->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNumBanco(),
                $contaCorrente->getFkMonetarioAgencia()->getNumAgencia(),
                $contaCorrente->getNumContaCorrente(),
                $cheque['numCheque']
            );

            if ($emitido['emitido'] == "Sim" || $emitido['emitido'] == "Anulado") {
                unset($chequesId[$key]);
            }
        }

        return $chequesId;
    }

    /**
     * Busca os cheques e retorna um array
     * @return array
     */
    public function findAllCheques()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.numCheque')
            ->getQuery()
            ->getResult(ORM\Query::HYDRATE_ARRAY);

        return $qb;
    }

    public function findChequeEmitido($codBanco, $codAgencia, $codContaCorrente, $numCheque)
    {
        $sql = "SELECT cheque.num_cheque
	                 , conta_corrente.cod_conta_corrente
	                 , conta_corrente.num_conta_corrente
	                 , agencia.cod_agencia
	                 , agencia.num_agencia
	                 , agencia.nom_agencia
	                 , banco.cod_banco
	                 , banco.num_banco
	                 , banco.nom_banco
	                 , cheque_emissao.data_emissao
	                 , cheque_emissao.nom_credor
	                 , cheque_emissao.valor
	                 , cheque_emissao.descricao
	                 , cheque_emissao.tipo_emissao
	                 , cheque_emissao.timestamp_emissao
	                 , cheque_emissao.timestamp_baixa
	              FROM tesouraria.cheque
	
	        INNER JOIN ( SELECT cheque_emissao.num_cheque
	                          , cheque_emissao.cod_banco
	                          , cheque_emissao.cod_agencia
	                          , cheque_emissao.cod_conta_corrente
	                          , cheque_emissao.timestamp_emissao
	                          , cheque_emissao_baixa.timestamp_baixa
	                          , TO_CHAR(cheque_emissao.data_emissao,'dd/mm/yyyy') AS data_emissao
	                          , cheque_emissao.valor
	                          , CASE WHEN (cheque_emissao_ordem_pagamento.nom_credor IS NOT NULL)
	                                 THEN cheque_emissao_ordem_pagamento.nom_credor
	                                 WHEN (cheque_emissao_transferencia.nom_credor IS NOT NULL)
	                                 THEN cheque_emissao_transferencia.nom_credor
	                                 WHEN (cheque_emissao_recibo_extra.nom_credor IS NOT NULL)
	                                 THEN cheque_emissao_recibo_extra.nom_credor
	                                 ELSE ''
	                            END AS nom_credor
	                          , CASE WHEN (cheque_emissao_ordem_pagamento.num_cheque IS NOT NULL)
	                                 THEN 'ordem_pagamento'
	                                 WHEN (cheque_emissao_transferencia.num_cheque IS NOT NULL)
	                                 THEN 'transferencia'
	                                 WHEN (cheque_emissao_recibo_extra.num_cheque IS NOT NULL)
	                                 THEN 'recibo_extra'
	                                 ELSE ''
	                            END AS tipo_emissao
	                          , cheque_emissao.descricao
	                       FROM tesouraria.cheque_emissao
	                 INNER JOIN ( SELECT cheque_emissao.cod_banco
	                                   , cheque_emissao.cod_agencia
	                                   , cheque_emissao.cod_conta_corrente
	                                   , cheque_emissao.num_cheque
	                                   , MAX(cheque_emissao.timestamp_emissao) AS timestamp_emissao
	                                FROM tesouraria.cheque_emissao
	                            GROUP BY cheque_emissao.cod_banco
	                                   , cheque_emissao.cod_agencia
	                                   , cheque_emissao.cod_conta_corrente
	                                   , cheque_emissao.num_cheque
	                            ) AS cheque_emissao_max
	                         ON cheque_emissao.cod_banco          = cheque_emissao_max.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_max.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_max.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_max.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_max.timestamp_emissao
	
	                  LEFT JOIN ( SELECT cheque_emissao_baixa.cod_banco
	                                   , cheque_emissao_baixa.cod_agencia
	                                   , cheque_emissao_baixa.cod_conta_corrente
	                                   , cheque_emissao_baixa.num_cheque
	                                   , cheque_emissao_baixa.timestamp_emissao
	                                   , cheque_emissao_baixa.timestamp_baixa
	                                FROM tesouraria.cheque_emissao_baixa
	                          INNER JOIN ( SELECT cheque_emissao_baixa.cod_banco
	                                            , cheque_emissao_baixa.cod_agencia
	                                            , cheque_emissao_baixa.cod_conta_corrente
	                                            , cheque_emissao_baixa.num_cheque
	                                            , cheque_emissao_baixa.timestamp_emissao
	                                            , MAX(cheque_emissao_baixa.timestamp_baixa) AS timestamp_baixa
	                                         FROM tesouraria.cheque_emissao_baixa
	                                     GROUP BY cheque_emissao_baixa.cod_banco
	                                            , cheque_emissao_baixa.cod_agencia
	                                            , cheque_emissao_baixa.cod_conta_corrente
	                                            , cheque_emissao_baixa.num_cheque
	                                            , cheque_emissao_baixa.timestamp_emissao
	                                     ) AS cheque_emissao_baixa_max
	                                  ON cheque_emissao_baixa.cod_banco          = cheque_emissao_baixa_max.cod_banco
	                                 AND cheque_emissao_baixa.cod_agencia        = cheque_emissao_baixa_max.cod_agencia
	                                 AND cheque_emissao_baixa.cod_conta_corrente = cheque_emissao_baixa_max.cod_conta_corrente
	                                 AND cheque_emissao_baixa.num_cheque         = cheque_emissao_baixa_max.num_cheque
	                                 AND cheque_emissao_baixa.timestamp_emissao  = cheque_emissao_baixa_max.timestamp_emissao
	                                 AND cheque_emissao_baixa.timestamp_baixa    = cheque_emissao_baixa_max.timestamp_baixa
	                            ) AS cheque_emissao_baixa
	                         ON cheque_emissao.cod_banco          = cheque_emissao_baixa.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_baixa.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_baixa.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_baixa.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_baixa.timestamp_emissao
	
	                  LEFT JOIN ( SELECT cheque_emissao_ordem_pagamento.cod_banco
	                                   , cheque_emissao_ordem_pagamento.cod_agencia
	                                   , cheque_emissao_ordem_pagamento.cod_conta_corrente
	                                   , cheque_emissao_ordem_pagamento.num_cheque
	                                   , cheque_emissao_ordem_pagamento.timestamp_emissao
	                                   , cgm_credor.nom_cgm AS nom_credor
	                                FROM tesouraria.cheque_emissao_ordem_pagamento
	
	                          INNER JOIN ( SELECT pagamento_liquidacao.cod_nota
	                                            , pagamento_liquidacao.cod_entidade
	                                            , pagamento_liquidacao.exercicio
	                                            , pagamento_liquidacao.cod_ordem
	                                         FROM empenho.pagamento_liquidacao
	                                   INNER JOIN ( SELECT MAX(pagamento_liquidacao.cod_nota) AS cod_nota
	                                                     , pagamento_liquidacao.cod_entidade
	                                                     , pagamento_liquidacao.exercicio
	                                                     , pagamento_liquidacao.cod_ordem
	                                                  FROM empenho.pagamento_liquidacao
	                                              GROUP BY pagamento_liquidacao.cod_entidade
	                                                     , pagamento_liquidacao.exercicio
	                                                     , pagamento_liquidacao.cod_ordem
	                                              ) AS pagamento_liquidacao_max
	                                           ON pagamento_liquidacao.cod_ordem = pagamento_liquidacao_max.cod_ordem
	                                          AND pagamento_liquidacao.cod_nota  = pagamento_liquidacao_max.cod_nota
	                                          AND pagamento_liquidacao.exercicio = pagamento_liquidacao_max.exercicio
	                                          AND pagamento_liquidacao.cod_entidade = pagamento_liquidacao_max.cod_entidade
	                                     ) AS pagamento_liquidacao
	                                  ON cheque_emissao_ordem_pagamento.cod_ordem    = pagamento_liquidacao.cod_ordem
	                                 AND cheque_emissao_ordem_pagamento.cod_entidade = pagamento_liquidacao.cod_entidade
	                                 AND cheque_emissao_ordem_pagamento.exercicio    = pagamento_liquidacao.exercicio
	                          INNER JOIN empenho.nota_liquidacao
	                                  ON pagamento_liquidacao.cod_nota     = nota_liquidacao.cod_nota
	                                 AND pagamento_liquidacao.cod_entidade = nota_liquidacao.cod_entidade
	                                 AND pagamento_liquidacao.exercicio    = nota_liquidacao.exercicio
	                          INNER JOIN empenho.empenho
	                                  ON nota_liquidacao.exercicio_empenho = empenho.exercicio
	                                 AND nota_liquidacao.cod_empenho       = empenho.cod_empenho
	                                 AND nota_liquidacao.cod_entidade      = empenho.cod_entidade
	                          INNER JOIN empenho.pre_empenho
	                                  ON empenho.exercicio       = pre_empenho.exercicio
	                                 AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
	                          INNER JOIN sw_cgm AS cgm_credor
	                                  ON pre_empenho.cgm_beneficiario = cgm_credor.numcgm
	                            ) AS cheque_emissao_ordem_pagamento
	                         ON cheque_emissao.cod_banco          = cheque_emissao_ordem_pagamento.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_ordem_pagamento.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_ordem_pagamento.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_ordem_pagamento.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_ordem_pagamento.timestamp_emissao
	
	                  LEFT JOIN ( SELECT cheque_emissao_transferencia.cod_banco
	                                   , cheque_emissao_transferencia.cod_agencia
	                                   , cheque_emissao_transferencia.cod_conta_corrente
	                                   , cheque_emissao_transferencia.num_cheque
	                                   , cheque_emissao_transferencia.timestamp_emissao
	                                   , sw_cgm.nom_cgm AS nom_credor
	                                FROM tesouraria.cheque_emissao_transferencia
	                           LEFT JOIN tesouraria.transferencia_credor
	                                  ON cheque_emissao_transferencia.cod_lote     = transferencia_credor.cod_lote
	                                 AND cheque_emissao_transferencia.cod_entidade = transferencia_credor.cod_entidade
	                                 AND cheque_emissao_transferencia.tipo         = transferencia_credor.tipo
	                                 AND cheque_emissao_transferencia.exercicio    = transferencia_credor.exercicio
	                           LEFT JOIN sw_cgm
	                                  ON transferencia_credor.numcgm = sw_cgm.numcgm
	                            ) AS cheque_emissao_transferencia
	                         ON cheque_emissao.cod_banco          = cheque_emissao_transferencia.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_transferencia.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_transferencia.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_transferencia.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_transferencia.timestamp_emissao
	
	                  LEFT JOIN ( SELECT cheque_emissao_recibo_extra.cod_banco
	                                   , cheque_emissao_recibo_extra.cod_agencia
	                                   , cheque_emissao_recibo_extra.cod_conta_corrente
	                                   , cheque_emissao_recibo_extra.num_cheque
	                                   , cheque_emissao_recibo_extra.timestamp_emissao
	                                   , sw_cgm.nom_cgm AS nom_credor
	                                FROM tesouraria.cheque_emissao_recibo_extra
	                           LEFT JOIN tesouraria.recibo_extra_credor
	                                  ON cheque_emissao_recibo_extra.cod_entidade     = recibo_extra_credor.cod_entidade
	                                 AND cheque_emissao_recibo_extra.exercicio        = recibo_extra_credor.exercicio
	                                 AND cheque_emissao_recibo_extra.cod_recibo_extra = recibo_extra_credor.cod_recibo_extra
	                                 AND cheque_emissao_recibo_extra.tipo_recibo      = recibo_extra_credor.tipo_recibo
	                           LEFT JOIN sw_cgm
	                                  ON recibo_extra_credor.numcgm = sw_cgm.numcgm
	                            ) AS cheque_emissao_recibo_extra
	                         ON cheque_emissao.cod_banco          = cheque_emissao_recibo_extra.cod_banco
	                        AND cheque_emissao.cod_agencia        = cheque_emissao_recibo_extra.cod_agencia
	                        AND cheque_emissao.cod_conta_corrente = cheque_emissao_recibo_extra.cod_conta_corrente
	                        AND cheque_emissao.num_cheque         = cheque_emissao_recibo_extra.num_cheque
	                        AND cheque_emissao.timestamp_emissao  = cheque_emissao_recibo_extra.timestamp_emissao
	
	                   ) AS cheque_emissao
	                ON cheque.cod_banco          = cheque_emissao.cod_banco
	               AND cheque.cod_agencia        = cheque_emissao.cod_agencia
	               AND cheque.cod_conta_corrente = cheque_emissao.cod_conta_corrente
	               AND cheque.num_cheque         = cheque_emissao.num_cheque
	
	        INNER JOIN monetario.conta_corrente
	                ON cheque.cod_conta_corrente  = conta_corrente.cod_conta_corrente
	               AND cheque.cod_agencia         = conta_corrente.cod_agencia
	               AND cheque.cod_banco           = conta_corrente.cod_banco
	        INNER JOIN monetario.agencia
	                ON conta_corrente.cod_agencia = agencia.cod_agencia
	               AND conta_corrente.cod_banco   = agencia.cod_banco
	        INNER JOIN monetario.banco
	                ON agencia.cod_banco          = banco.cod_banco
	         WHERE  banco.cod_banco = :cod_banco  AND agencia.cod_agencia = :cod_agencia  AND conta_corrente.cod_conta_corrente = :cod_conta_corrente  AND cheque.num_cheque = :num_cheque ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_banco', $codBanco);
        $query->bindValue('cod_agencia', $codAgencia);
        $query->bindValue('cod_conta_corrente', $codContaCorrente);
        $query->bindValue('num_cheque', $numCheque);
        $query->execute();
        return $query->fetch();
    }
}
