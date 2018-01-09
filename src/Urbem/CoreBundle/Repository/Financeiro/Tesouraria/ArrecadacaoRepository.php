<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ArrecadacaoRepository extends ORM\EntityRepository
{
    public function getBoletim($exercicio, $codEntidade)
    {
        $sql = "
            SELECT
                TB.cod_boletim,
                TB.exercicio,
                TB.cod_entidade,
                TB.cod_terminal,
                TB.timestamp_terminal,
                TB.cgm_usuario,
                TB.timestamp_usuario,
                TBF.timestamp_fechamento,
                TBR.timestamp_reabertura,
                to_char (
                    TB.dt_boletim,
                    'dd/mm/yyyy' ) AS dt_boletim,
                to_char (
                    TBF.timestamp_fechamento,
                    'dd/mm/yyyy - HH24:mm:ss' ) AS dt_fechamento,
                CGM.nom_cgm,
                TBL.timestamp_liberado,
                CASE
                    WHEN TBF.timestamp_fechamento IS NOT NULL THEN CASE
                        WHEN TBR.timestamp_reabertura IS NOT NULL THEN CASE
                            WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura THEN CASE
                                WHEN TBL.timestamp_liberado IS NOT NULL THEN 'liberado'
                                ELSE 'fechado'
                            END
                            ELSE 'reaberto'
                        END
                        ELSE CASE
                            WHEN TBL.timestamp_liberado IS NOT NULL THEN 'liberado'
                            ELSE 'fechado'
                        END
                    END
                    ELSE 'aberto'
                END AS situacao
            FROM
                tesouraria.boletim AS TB
                LEFT JOIN (
                    SELECT
                        TBF.cod_boletim,
                        TBF.exercicio,
                        TBF.cod_entidade,
                        max (
                            TBF.timestamp_fechamento ) AS timestamp_fechamento
                    FROM
                        tesouraria.boletim_fechado AS TBF
                    GROUP BY
                        cod_boletim,
                        exercicio,
                        cod_entidade
                    ORDER BY
                        cod_boletim,
                        exercicio,
                        cod_entidade ) AS TBF ON (
                    TB.cod_boletim = TBF.cod_boletim
                    AND TB.exercicio = TBF.exercicio
                    AND TB.cod_entidade = TBF.cod_entidade )
                LEFT JOIN (
                    SELECT
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade,
                        max (
                            TBR.timestamp_reabertura ) AS timestamp_reabertura
                    FROM
                        tesouraria.boletim_reaberto AS TBR
                    GROUP BY
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade
                    ORDER BY
                        TBR.cod_boletim,
                        TBR.exercicio,
                        TBR.cod_entidade ) AS TBR ON (
                    TB.cod_boletim = TBR.cod_boletim
                    AND TB.exercicio = TBR.exercicio
                    AND TB.cod_entidade = TBR.cod_entidade )
                LEFT JOIN (
                    SELECT
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade,
                        max (
                            TBL.timestamp_liberado ) AS timestamp_liberado
                    FROM
                        tesouraria.boletim_liberado AS TBL
                    GROUP BY
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade
                    ORDER BY
                        TBL.cod_boletim,
                        TBL.exercicio,
                        TBL.cod_entidade ) AS TBL ON (
                    TB.cod_boletim = TBL.cod_boletim
                    AND TB.exercicio = TBL.exercicio
                    AND TB.cod_entidade = TBL.cod_entidade ),
                sw_cgm AS CGM
            WHERE
                TB.cgm_usuario = CGM.numcgm
                AND TB.exercicio = :exercicio
                AND TB.cod_entidade IN ( :codEntidade )
                AND TBL.timestamp_liberado IS NULL
                AND CASE
                    WHEN tbf.timestamp_fechamento IS NULL THEN TRUE
                    ELSE CASE
                        WHEN TBR.timestamp_reabertura IS NOT NULL THEN TBF.timestamp_fechamento < TBR.timestamp_reabertura
                        ELSE FALSE
                    END
                END
            ORDER BY
                cod_boletim
        ";

        if (is_array($codEntidade)) {
            $codEntidade = implode(',', $codEntidade);
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    public function getReceita($exercicio, $codEntidade)
    {
        $sql = "
            SELECT
                CLASSIFICACAO.mascara_classificacao,
                CLASSIFICACAO.descricao,
                RECEITA.*
            FROM
                orcamento.VW_CLASSIFICACAO_RECEITA AS CLASSIFICACAO,
                ORCAMENTO.RECEITA AS RECEITA,
                ORCAMENTO.CONTA_RECEITA AS CR,
                CONTABILIDADE.CONFIGURACAO_LANCAMENTO_RECEITA AS CLR
            WHERE
                CLASSIFICACAO.exercicio IS NOT NULL
                AND RECEITA.cod_conta = CLASSIFICACAO.cod_conta
                AND RECEITA.exercicio = CLASSIFICACAO.exercicio
                AND RECEITA.exercicio = CR.exercicio
                AND RECEITA.cod_conta = CR.cod_conta
                AND CR.exercicio = CLR.exercicio
                AND CR.cod_conta = CLR.cod_conta_receita
                AND RECEITA.exercicio = :exercicio
                AND RECEITA.cod_entidade IN ( :codEntidade )
                AND NOT EXISTS (
                    SELECT
                        dr.cod_receita_secundaria
                    FROM
                        contabilidade.desdobramento_receita AS dr
                    WHERE
                        receita.cod_receita = dr.cod_receita_secundaria
                        AND receita.exercicio = dr.exercicio )
                AND CLR.estorno = 'false'
            ORDER BY
                mascara_classificacao
        ";

        if (is_array($codEntidade)) {
            $codEntidade = implode(',', $codEntidade);
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    public function getConta($exercicio, $codEntidade)
    {
        $sql = "
            SELECT
                pa.cod_plano,
                pc.cod_estrutural,
                pc.nom_conta,
                pc.cod_conta,
                publico.fn_mascarareduzida (
                    pc.cod_estrutural ) AS cod_reduzido,
                pc.cod_classificacao,
                pc.cod_sistema,
                pb.exercicio,
                pb.cod_banco,
                pb.cod_agencia,
                pb.cod_entidade,
                pa.natureza_saldo,
                CASE
                    WHEN publico.fn_nivel (
                        cod_estrutural )
                    > 4 THEN 5
                    ELSE publico.fn_nivel (
                        cod_estrutural )
                END AS nivel
            FROM
                contabilidade.plano_conta AS pc
                LEFT JOIN contabilidade.plano_analitica AS pa ON (
                    pc.cod_conta = pa.cod_conta
                    AND pc.exercicio = pa.exercicio )
                LEFT JOIN contabilidade.plano_banco AS pb ON (
                    pb.cod_plano = pa.cod_plano
                    AND pb.exercicio = pa.exercicio )
            WHERE
                pa.cod_plano IS NOT NULL
                AND pc.exercicio = :exercicio
                AND pb.cod_banco IS NOT NULL
                AND (
                    pc.cod_estrutural LIKE '1.1.1.%'
                    OR pc.cod_estrutural LIKE '1.1.4.%' )
                AND pb.cod_entidade IN (
                    :codEntidade )
            ORDER BY
                cod_estrutural
        ";

        if (is_array($codEntidade)) {
            $codEntidade = implode(',', $codEntidade);
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    public function getContaDeducao($exercicio, $codEntidade)
    {
        $sql = "
            SELECT
                CLASSIFICACAO.mascara_classificacao,
                CLASSIFICACAO.descricao,
                RECEITA.*
            FROM
                orcamento.VW_CLASSIFICACAO_RECEITA AS CLASSIFICACAO,
                ORCAMENTO.RECEITA AS RECEITA,
                ORCAMENTO.CONTA_RECEITA AS CR,
                CONTABILIDADE.CONFIGURACAO_LANCAMENTO_RECEITA AS CLR
            WHERE
                CLASSIFICACAO.exercicio IS NOT NULL
                AND RECEITA.cod_conta = CLASSIFICACAO.cod_conta
                AND RECEITA.exercicio = CLASSIFICACAO.exercicio
                AND CLASSIFICACAO.mascara_classificacao LIKE '9.%'
                AND RECEITA.exercicio = CR.exercicio
                AND RECEITA.cod_conta = CR.cod_conta
                AND CR.exercicio = CLR.exercicio
                AND CR.cod_conta = CLR.cod_conta_receita
                AND CLR.estorno = 'false'
                AND CLASSIFICACAO.exercicio = :exercicio
                AND RECEITA.cod_entidade = :codEntidade
            ORDER BY
                cod_receita
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    public function getCodAutenticacao($dtBoletim)
    {
        $sql = "
            SELECT (
                COALESCE ( max ( cod_autenticacao ), 0 ) + 1 ) AS cod_autenticacao
        FROM
            tesouraria.autenticacao
        WHERE
            --DIA                                                                                                    
            to_char ( dt_autenticacao, 'dd/mm/yyyy' ) = :dtBoletim
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('dtBoletim', $dtBoletim);
        $query->execute();
        $return = $query->fetch();
        return $return['cod_autenticacao'];
    }

    public function getCodArrecadacao()
    {
        $sql = "SELECT COALESCE(MAX(cod_arrecadacao), 0) + 1 AS CODIGO FROM tesouraria.arrecadacao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $return = $query->fetch();

        return $return['codigo'];
    }

    public function getArrecadacaoEstornar()
    {
        $sql = "
        select
                *
            from
                (
                    select
                        TA.cod_arrecadacao                                                                       
                         ,TA.exercicio                                                                             
                         ,TA.timestamp_arrecadacao                                                                 
                         ,TA.cod_autenticacao                                                                      
                         ,TA.dt_autenticacao                                                                       
                         ,TA.cod_boletim                                                                           
                         ,TB.dt_boletim                                                                            
                         ,TA.cod_terminal                                                                          
                         ,TA.timestamp_terminal                                                                    
                         ,TA.cgm_usuario                                                                           
                         ,TA.timestamp_usuario                                                                     
                         ,TA.cod_plano                                                                             
                         ,TA.cod_entidade                                                                          
                         ,TA.observacao                                                                            
                         ,TAER.cod_receita                                                                         
                         ,TAER.vl_arrecadacao                                                                      
                         ,TAER.vl_estornado                                                                        
                         ,TARDE.cod_receita_dedutora                                                               
                         ,TARDE.vl_deducao                                                                         
                         ,TARDE.vl_deducao_estornado                                                               
                         ,TO_CHAR( TA.timestamp_arrecadacao, 'dd/mm/yyyy' ) as dt_arrecadacao                      
                         ,TAER.descricao
                    from
                        tesouraria.arrecadacao as TA inner join tesouraria.arrecadacao_estornada as TAE on
                        (
                            TA.cod_arrecadacao = TAE.cod_arrecadacao
                            and TA.exercicio = TAE.exercicio
                            and TA.timestamp_arrecadacao = TAE.timestamp_arrecadacao
                        ) left join(
                            select
                                TAR.exercicio,
                                TAR.cod_arrecadacao,
                                TAR.timestamp_arrecadacao,
                                TAR.cod_receita,
                                TAR.vl_arrecadacao,
                                sum( coalesce( TAER.vl_estornado, 0.00 )) as vl_estornado,
                                OCR.descricao
                            from
                                tesouraria.arrecadacao_receita as TAR left join tesouraria.arrecadacao_estornada_receita as TAER on
                                (
                                    TAR.exercicio = TAER.exercicio
                                    and TAR.cod_arrecadacao = TAER.cod_arrecadacao
                                    and TAR.cod_receita = TAER.cod_receita
                                    and TAR.timestamp_arrecadacao = TAER.timestamp_arrecadacao
                                ),
                                orcamento.receita as RECEITA,
                                orcamento.conta_receita as OCR
                            where
                                TAR.cod_receita = RECEITA.cod_receita
                                and TAR.exercicio = RECEITA.exercicio
                                and RECEITA.cod_conta = OCR.cod_conta
                                and RECEITA.exercicio = OCR.exercicio
                            group by
                                TAR.exercicio,
                                TAR.cod_arrecadacao,
                                TAR.timestamp_arrecadacao,
                                TAR.cod_receita,
                                TAR.vl_arrecadacao,
                                OCR.descricao
                            having
                                TAR.vl_arrecadacao > sum( coalesce( TAER.vl_estornado, 0.00 ))
                        ) as TAER on
                        (
                            TA.exercicio = TAER.exercicio
                            and TA.cod_arrecadacao = TAER.cod_arrecadacao
                            and TA.timestamp_arrecadacao = TAER.timestamp_arrecadacao
                        ) left join(
                            select
                                TAR.exercicio,
                                TAR.cod_arrecadacao,
                                TAR.timestamp_arrecadacao,
                                TAR.cod_receita,
                                TAR.vl_arrecadacao,
                                TARD.cod_receita_dedutora,
                                TARD.vl_deducao,
                                sum( coalesce( TARDE.vl_estornado, 0.00 )) as vl_deducao_estornado
                            from
                                tesouraria.arrecadacao_receita as TAR join tesouraria.arrecadacao_receita_dedutora as TARD on
                                (
                                    TAR.exercicio = TARD.exercicio
                                    and TAR.cod_arrecadacao = TARD.cod_arrecadacao
                                    and TAR.cod_receita = TARD.cod_receita
                                    and TAR.timestamp_arrecadacao = TARD.timestamp_arrecadacao
                                ) left join tesouraria.arrecadacao_receita_dedutora_estornada as TARDE on
                                (
                                    TARD.exercicio = TARDE.exercicio
                                    and TARD.cod_arrecadacao = TARDE.cod_arrecadacao
                                    and TARD.cod_receita = TARDE.cod_receita
                                    and TARD.timestamp_arrecadacao = TARDE.timestamp_arrecadacao
                                    and TARD.cod_receita_dedutora = TARDE.cod_receita_dedutora
                                )
                            group by
                                TAR.exercicio,
                                TAR.cod_arrecadacao,
                                TAR.timestamp_arrecadacao,
                                TAR.cod_receita,
                                TAR.vl_arrecadacao,
                                TARD.cod_receita_dedutora,
                                TARD.vl_deducao
                            having
                                TARD.vl_deducao > sum( coalesce( TARDE.vl_estornado, 0.00 ))
                        ) as TARDE on
                        (
                            TA.exercicio = TARDE.exercicio
                            and TA.cod_arrecadacao = TARDE.cod_arrecadacao
                            and TA.timestamp_arrecadacao = TARDE.timestamp_arrecadacao
                        ) ,
                        tesouraria.boletim as TB
                    where
                        TA.cod_boletim = TB.cod_boletim
                        and TA.exercicio = TB.exercicio
                        and TA.cod_entidade = TB.cod_entidade
                        and TA.devolucao = false
                        and TAER.vl_arrecadacao > TAER.vl_estornado
                union select
                        TA.cod_arrecadacao,
                        TA.exercicio,
                        TA.timestamp_arrecadacao,
                        TA.cod_autenticacao,
                        TA.dt_autenticacao,
                        TA.cod_boletim,
                        TB.dt_boletim,
                        TA.cod_terminal,
                        TA.timestamp_terminal,
                        TA.cgm_usuario,
                        TA.timestamp_usuario,
                        TA.cod_plano,
                        TA.cod_entidade,
                        TA.observacao,
                        TAR.cod_receita,
                        TAR.vl_arrecadacao,
                        0.00 as vl_estornado,
                        TAR.cod_receita_dedutora,
                        TAR.vl_deducao,
                        0.00 as vl_deducao_estornado,
                        TO_CHAR(
                            TA.timestamp_arrecadacao,
                            'dd/mm/yyyy'
                        ) as dt_arrecadacao,
                        TAR.descricao
                    from
                        tesouraria.arrecadacao as TA left join tesouraria.arrecadacao_estornada as TAE on
                        (
                            TA.cod_arrecadacao = TAE.cod_arrecadacao
                            and TA.exercicio = TAE.exercicio
                            and TA.timestamp_arrecadacao = TAE.timestamp_arrecadacao
                        ) left join(
                            select
                                TAR.exercicio,
                                TAR.cod_arrecadacao,
                                TAR.timestamp_arrecadacao,
                                TAR.cod_receita,
                                TAR.vl_arrecadacao,
                                TARD.cod_receita_dedutora,
                                TARD.vl_deducao,
                                OCR.descricao
                            from
                                tesouraria.arrecadacao_receita as TAR left join tesouraria.arrecadacao_receita_dedutora as TARD on
                                (
                                    TAR.exercicio = TARD.exercicio
                                    and TAR.cod_arrecadacao = TARD.cod_arrecadacao
                                    and TAR.cod_receita = TARD.cod_receita
                                    and TAR.timestamp_arrecadacao = TARD.timestamp_arrecadacao
                                ),
                                orcamento.receita as RECEITA,
                                orcamento.conta_receita as OCR
                            where
                                TAR.cod_receita = RECEITA.cod_receita
                                and TAR.exercicio = RECEITA.exercicio
                                and RECEITA.cod_conta = OCR.cod_conta
                                and RECEITA.exercicio = OCR.exercicio
                        ) as TAR on
                        (
                            TA.exercicio = TAR.exercicio
                            and TA.cod_arrecadacao = TAR.cod_arrecadacao
                            and TA.timestamp_arrecadacao = TAR.timestamp_arrecadacao
                        ) ,
                        tesouraria.boletim as TB
                    where
                        TAE.cod_arrecadacao is null
                        and TA.cod_boletim = TB.cod_boletim
                        and TA.exercicio = TB.exercicio
                        and TA.cod_entidade = TB.cod_entidade
                        and TA.devolucao = false
                ) as TBL
            where
                not exists(
                    select
                        bl.exercicio,
                        bl.cod_entidade,
                        bl.timestamp_arrecadacao,
                        bl.cod_arrecadacao
                    from
                        tesouraria.boletim_lote_arrecadacao as bl
                    where
                        bl.cod_entidade = tbl.cod_entidade
                        and bl.exercicio = tbl.exercicio
                        and bl.cod_arrecadacao = tbl.cod_arrecadacao
                        and bl.timestamp_arrecadacao = tbl.timestamp_arrecadacao
                )
                and not exists(
                    select
                        aopr.cod_arrecadacao
                    from
                        tesouraria.arrecadacao_ordem_pagamento_retencao as aopr
                    where
                        aopr.cod_entidade = tbl.cod_entidade
                        and aopr.exercicio = tbl.exercicio
                        and aopr.cod_arrecadacao = tbl.cod_arrecadacao
                        and aopr.timestamp_arrecadacao = tbl.timestamp_arrecadacao
                )
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $return = $query->fetchAll();
        $ids = array();
        foreach ($return as $item) {
            $ids[] = $item['cod_arrecadacao'];
        }
        return $ids;
    }
}
