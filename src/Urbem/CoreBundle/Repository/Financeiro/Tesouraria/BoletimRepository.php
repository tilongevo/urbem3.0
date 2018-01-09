<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class BoletimRepository extends ORM\EntityRepository
{

    /**
     * Busca os dados do terminal
     * Os parametros passados pelo array são:
     * codigo cgm do usuário
     * codigo verificador
     * @param array $params
     * @return mixed
     */
    public function findTerminalUsuario(array $params)
    {
        $sql = "SELECT
                    TUT.cod_terminal,
                    TUT.timestamp_terminal,
                    TUT.cgm_usuario,
                    TUT.timestamp_usuario,
                    TUT.responsavel,
                    CGM.nom_cgm,
                    TT.cod_verificador
                FROM
                    tesouraria.terminal AS TT
                        LEFT JOIN tesouraria.terminal_desativado AS TTD ON(
                    TT.cod_terminal       = TTD.cod_terminal       AND
                    TT.timestamp_terminal = TTD.timestamp_terminal
                ),
                    tesouraria.usuario_terminal AS TUT
                        LEFT JOIN tesouraria.usuario_terminal_excluido AS TUTE ON(
                    TUT.cod_terminal       = TUTE.cod_terminal       AND
                    TUT.timestamp_terminal = TUTE.timestamp_terminal AND
                    TUT.cgm_usuario        = TUTE.cgm_usuario        AND
                    TUT.timestamp_usuario  = TUTE.timestamp_usuario
                )
                    ,sw_cgm     AS CGM
                WHERE
                    TUT.cod_terminal       = TT.cod_terminal       AND
                    TUT.timestamp_terminal = TT.timestamp_terminal AND
            
                    TUT.cgm_usuario = CGM.numcgm
                    AND TTD.cod_terminal is null  AND TUTE.cod_terminal is null  AND TUT.cgm_usuario = :cgm_usuario ";

        list($cgmUsuario,$codVerificador) = $params;
        if (!empty($codVerificador)) {
            $sql .= " AND TT.cod_verificador = :cod_verificador ";
        }

        $sql .= " ORDER BY TUT.cod_terminal,TUT.cgm_usuario";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cgm_usuario', $cgmUsuario);
        if (!empty($codVerificador)) {
            $query->bindValue('cod_verificador', $codVerificador);
        }
        $query->execute();
        return $query->fetch();
    }

    /**
     * Se Já foi efetuado o encerramento do exercício
     * @param $exercicio
     * @return mixed
     */
    public function isExercicioFoiEncerrado($exercicio)
    {
        $sql = "SELECT 
                  count(*)
                FROM 
                    administracao.configuracao WHERE cod_modulo = 10 AND parametro = 'virada_GF' AND exercicio = :exercicio ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetch()['count'];
    }

    /**
     * Verifica o status do boletim
     * @param $params
     * @return mixed
     */
    public function verificarStatusBoletim($params)
    {
        $sql = "SELECT TB.cod_boletim                                                             
                  ,TB.exercicio                                                               
                  ,TB.cod_entidade                                                            
                  ,TB.cod_terminal                                                            
                  ,TB.timestamp_terminal                                                      
                  ,TB.cgm_usuario                                                             
                  ,TB.timestamp_usuario                                                       
                  ,TB.dt_boletim                                                              
                  ,TBF.timestamp_fechamento                                                   
                  ,TBR.timestamp_reabertura                                                   
                  ,TO_CHAR( TB.dt_boletim, 'dd/mm/yyyy' ) as data_boletim                     
                  ,TO_CHAR( TBF.timestamp_fechamento, 'dd/mm/yyyy - HH24:mm:ss' ) as dt_fechamento  
                  ,CGM.nom_cgm                                                               
                  ,TBL.timestamp_liberado                                                     
                  ,CASE WHEN TBF.timestamp_fechamento IS NOT NULL                             
                    THEN CASE WHEN TBR.timestamp_reabertura IS NOT NULL                       
                          THEN CASE WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura 
                                THEN CASE WHEN TBL.timestamp_liberado IS NOT NULL             
                                      THEN 'liberado'                                         
                                      ELSE 'fechado'                                          
                                     END                                                      
                                ELSE 'reaberto'                                               
                               END                                                            
                          ELSE CASE WHEN TBL.timestamp_liberado IS NOT NULL                   
                                 THEN 'liberado'                                              
                                 ELSE 'fechado'                                               
                               END                                                            
                         END                                                                  
                    ELSE 'aberto'                                                             
                   END AS situacao                                                            
            FROM tesouraria.boletim AS TB                                                     
            LEFT JOIN( SELECT TBF.cod_boletim                                                 
                             ,TBF.exercicio                                                   
                             ,TBF.cod_entidade                                                
                             ,MAX( TBF.timestamp_fechamento ) as timestamp_fechamento         
                       FROM tesouraria.boletim_fechado AS TBF                                 
                       GROUP BY cod_boletim                                                   
                               ,exercicio                                                     
                               ,cod_entidade                                                  
                       ORDER BY cod_boletim                                                   
                               ,exercicio                                                     
                               ,cod_entidade                                                  
            ) AS TBF ON( TB.cod_boletim = TBF.cod_boletim                                     
                     AND TB.exercicio   = TBF.exercicio                                       
                     AND TB.cod_entidade= TBF.cod_entidade )                                  
            LEFT JOIN( SELECT TBR.cod_boletim                                                 
                             ,TBR.exercicio                                                   
                             ,TBR.cod_entidade                                                
                             ,MAX( TBR.timestamp_reabertura ) as timestamp_reabertura         
                       FROM tesouraria.boletim_reaberto AS TBR                                
                       GROUP BY TBR.cod_boletim                                               
                               ,TBR.exercicio                                                 
                               ,TBR.cod_entidade                                              
                       ORDER BY TBR.cod_boletim                                               
                               ,TBR.exercicio                                                 
                               ,TBR.cod_entidade                                              
            ) AS TBR ON( TB.cod_boletim = TBR.cod_boletim                                     
                     AND TB.exercicio   = TBR.exercicio                                       
                     AND TB.cod_entidade= TBR.cod_entidade )                                  
            LEFT JOIN( SELECT TBL.cod_boletim                                                 
                             ,TBL.exercicio                                                   
                             ,TBL.cod_entidade                                                
                             ,MAX( TBL.timestamp_liberado  ) as timestamp_liberado            
                       FROM tesouraria.boletim_liberado   AS TBL                              
                       GROUP BY TBL.cod_boletim                                               
                               ,TBL.exercicio                                                 
                               ,TBL.cod_entidade                                              
                       ORDER BY TBL.cod_boletim                                               
                               ,TBL.exercicio                                                 
                               ,TBL.cod_entidade                                              
            ) AS TBL ON( TB.cod_boletim = TBL.cod_boletim                                     
                     AND TB.exercicio   = TBL.exercicio                                       
                     AND TB.cod_entidade= TBL.cod_entidade )                                  
            ,sw_cgm as CGM                                                                    
            WHERE TB.cgm_usuario = CGM.numcgm                                                 
             AND  TB.exercicio = :exercicio AND  TB.cod_boletim = :cod_boletim AND  TB.cod_entidade IN ( :cod_entidade ) ";

        list($codBoletim, $exercicio, $codEntidade) = $params;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_boletim', $codBoletim);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Verifica o status do boletim
     * @param $params
     * @return mixed
     */
    public function verificarBoletimPodeSerLiberadoStatus($params)
    {
        $sql = "
              SELECT TB.cod_boletim                                                             
                      ,TB.exercicio                                                               
                      ,TB.cod_entidade                                                            
                      ,TB.cod_terminal                                                            
                      ,TB.timestamp_terminal                                                      
                      ,TB.cgm_usuario                                                             
                      ,TB.timestamp_usuario                                                       
                      ,TB.dt_boletim                                                              
                      ,TBF.timestamp_fechamento                                                   
                      ,TBR.timestamp_reabertura                                                   
                      ,TO_CHAR( TB.dt_boletim, 'dd/mm/yyyy' ) as data_boletim                     
                      ,TO_CHAR( TBF.timestamp_fechamento, 'dd/mm/yyyy - HH24:mm:ss' ) as dt_fechamento  
                      ,CGM.nom_cgm                                                               
                      ,TBL.timestamp_liberado                                                     
                      ,CASE WHEN TBF.timestamp_fechamento IS NOT NULL                             
                        THEN CASE WHEN TBR.timestamp_reabertura IS NOT NULL                       
                              THEN CASE WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura 
                                    THEN CASE WHEN TBL.timestamp_liberado IS NOT NULL             
                                          THEN 'liberado'                                         
                                          ELSE 'fechado'                                          
                                         END                                                      
                                    ELSE 'reaberto'                                               
                                   END                                                            
                              ELSE CASE WHEN TBL.timestamp_liberado IS NOT NULL                   
                                     THEN 'liberado'                                              
                                     ELSE 'fechado'                                               
                                   END                                                            
                             END                                                                  
                        ELSE 'aberto'                                                             
                       END AS situacao                                                            
                FROM tesouraria.boletim AS TB                                                     
                LEFT JOIN( SELECT TBF.cod_boletim                                                 
                                 ,TBF.exercicio                                                   
                                 ,TBF.cod_entidade                                                
                                 ,MAX( TBF.timestamp_fechamento ) as timestamp_fechamento         
                           FROM tesouraria.boletim_fechado AS TBF                                 
                           GROUP BY cod_boletim                                                   
                                   ,exercicio                                                     
                                   ,cod_entidade                                                  
                           ORDER BY cod_boletim                                                   
                                   ,exercicio                                                     
                                   ,cod_entidade                                                  
                ) AS TBF ON( TB.cod_boletim = TBF.cod_boletim                                     
                         AND TB.exercicio   = TBF.exercicio                                       
                         AND TB.cod_entidade= TBF.cod_entidade )                                  
                LEFT JOIN( SELECT TBR.cod_boletim                                                 
                                 ,TBR.exercicio                                                   
                                 ,TBR.cod_entidade                                                
                                 ,MAX( TBR.timestamp_reabertura ) as timestamp_reabertura         
                           FROM tesouraria.boletim_reaberto AS TBR                                
                           GROUP BY TBR.cod_boletim                                               
                                   ,TBR.exercicio                                                 
                                   ,TBR.cod_entidade                                              
                           ORDER BY TBR.cod_boletim                                               
                                   ,TBR.exercicio                                                 
                                   ,TBR.cod_entidade                                              
                ) AS TBR ON( TB.cod_boletim = TBR.cod_boletim                                     
                         AND TB.exercicio   = TBR.exercicio                                       
                         AND TB.cod_entidade= TBR.cod_entidade )                                  
                LEFT JOIN( SELECT TBL.cod_boletim                                                 
                                 ,TBL.exercicio                                                   
                                 ,TBL.cod_entidade                                                
                                 ,MAX( TBL.timestamp_liberado  ) as timestamp_liberado            
                           FROM tesouraria.boletim_liberado   AS TBL                              
                           GROUP BY TBL.cod_boletim                                               
                                   ,TBL.exercicio                                                 
                                   ,TBL.cod_entidade                                              
                           ORDER BY TBL.cod_boletim                                               
                                   ,TBL.exercicio                                                 
                                   ,TBL.cod_entidade                                              
                ) AS TBL ON( TB.cod_boletim = TBL.cod_boletim                                     
                         AND TB.exercicio   = TBL.exercicio                                       
                         AND TB.cod_entidade= TBL.cod_entidade )                                  
                ,sw_cgm as CGM                                                                    
                WHERE TB.cgm_usuario = CGM.numcgm                                                 
                 AND  TB.exercicio = :exercicio AND  TB.cod_entidade IN(:cod_entidade) AND TB.cod_boletim = :cod_boletim and  TBL.timestamp_liberado IS NULL AND TBF.timestamp_fechamento IS NOT NULL AND
                                    CASE WHEN TBR.timestamp_reabertura IS NOT NULL
                                        THEN
                                            TBF.timestamp_fechamento > TBR.timestamp_reabertura
                                        ELSE
                                            TRUE
                                    END  ORDER BY  tb.cod_boletim  ";

        list($codBoletim, $exercicio, $codEntidade) = $params;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_boletim', $codBoletim);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();
        return $query->rowCount();
    }

    public function findBoletins(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "select * from tesouraria.vw_boletins WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function listaArrecadacaoSeRetencao()
    {
        $sql = "SELECT tbl.exercicio
                    ,tbl.cod_entidade
                    ,tbl.cod_boletim
                    ,tbl.conta_debito
                    ,tbl.conta_credito
                    ,tbl.numeracao
                    ,tbl.cod_receita
                    ,tbl.tipo
                    ,tbl.cod_ordem
                    ,tbl.cod_plano
                    ,( tbl.valor - tbl.vl_desconto + tbl.vl_juros + tbl.vl_multa ) AS valor
                    ,CPCD.cod_estrutural AS cod_estrutural_debito
                    ,CPCC.cod_estrutural AS cod_estrutural_credito
                    ,tbl.cod_historico
                FROM(
                     SELECT tmp_arrecadacao.cod_entidade
                          ,tmp_arrecadacao.exercicio
                          ,tmp_arrecadacao.cod_boletim
                          ,tmp_arrecadacao.conta_debito
                          ,tmp_arrecadacao.conta_credito
                          ,tmp_arrecadacao.numeracao
                          ,tmp_arrecadacao.cod_receita
                          ,'A' as tipo
                          ,aopr.cod_ordem
                          ,aopr.cod_plano
                          ,valor
                          ,vl_desconto
                          ,vl_juros
                          ,vl_multa
                          ,tmp_arrecadacao.cod_historico
                       FROM tmp_arrecadacao
                 INNER JOIN tesouraria.arrecadacao_ordem_pagamento_retencao as aopr
                         ON (    aopr.cod_arrecadacao       = tmp_arrecadacao.cod_arrecadacao
                             AND aopr.timestamp_arrecadacao = tmp_arrecadacao.timestamp_arrecadacao
                             AND aopr.exercicio             = tmp_arrecadacao.exercicio
                             AND aopr.cod_entidade          = tmp_arrecadacao.cod_entidade
                             AND aopr.cod_plano             = tmp_arrecadacao.conta_credito
                            )
                      WHERE EXISTS
                            ( SELECT aopr.cod_arrecadacao
                                FROM tesouraria.arrecadacao_ordem_pagamento_retencao as aopr
                               WHERE aopr.cod_arrecadacao       = tmp_arrecadacao.cod_arrecadacao
                                 AND aopr.timestamp_arrecadacao = tmp_arrecadacao.timestamp_arrecadacao
                                 AND aopr.exercicio             = tmp_arrecadacao.exercicio
                                 AND aopr.cod_entidade          = tmp_arrecadacao.cod_entidade
                                 AND aopr.cod_plano             = tmp_arrecadacao.conta_credito
                            )

                      UNION ALL

                     SELECT tmp_arrecadacao_estornada.cod_entidade
                          ,tmp_arrecadacao_estornada.exercicio
                          ,tmp_arrecadacao_estornada.cod_boletim
                          ,tmp_arrecadacao_estornada.conta_debito
                          ,tmp_arrecadacao_estornada.conta_credito
                          ,tmp_arrecadacao_estornada.numeracao
                          ,tmp_arrecadacao_estornada.cod_receita
                          ,'E' as tipo
                          ,aeopr.cod_ordem
                          ,aeopr.cod_plano
                          ,valor
                          ,vl_desconto
                          ,vl_juros
                          ,vl_multa
                          ,tmp_arrecadacao_estornada.cod_historico
                       FROM tmp_arrecadacao_estornada
                 INNER JOIN tesouraria.arrecadacao_estornada_ordem_pagamento_retencao as aeopr
                         ON (    aeopr.cod_arrecadacao       = tmp_arrecadacao_estornada.cod_arrecadacao
                             AND aeopr.timestamp_arrecadacao = tmp_arrecadacao_estornada.timestamp_arrecadacao
                             AND aeopr.exercicio             = tmp_arrecadacao_estornada.exercicio
                             AND aeopr.cod_entidade          = tmp_arrecadacao_estornada.cod_entidade
                             AND aeopr.cod_plano             = tmp_arrecadacao_estornada.conta_debito
                            )
                      WHERE EXISTS
                            ( SELECT aeopr.cod_arrecadacao
                                FROM tesouraria.arrecadacao_estornada_ordem_pagamento_retencao as aeopr
                               WHERE aeopr.cod_arrecadacao       = tmp_arrecadacao_estornada.cod_arrecadacao
                                 AND aeopr.timestamp_arrecadacao = tmp_arrecadacao_estornada.timestamp_arrecadacao
                                 AND aeopr.exercicio             = tmp_arrecadacao_estornada.exercicio
                                 AND aeopr.cod_entidade          = tmp_arrecadacao_estornada.cod_entidade
                                 AND aeopr.cod_plano             = tmp_arrecadacao_estornada.conta_debito
                            )
                   ORDER BY exercicio
                          ,cod_entidade
                          ,cod_boletim
                          ,conta_debito
                          ,conta_credito
                          ,numeracao
                    ) AS tbl
           LEFT JOIN contabilidade.plano_analitica CPAD
                  ON tbl.conta_debito = CPAD.cod_plano
                 AND tbl.exercicio    = CPAD.exercicio
           LEFT JOIN contabilidade.plano_conta  CPCD
                  ON CPAD.cod_conta = CPCD.cod_conta
                 AND CPAD.exercicio = CPCD.exercicio
           LEFT JOIN contabilidade.plano_analitica CPAC
                  ON tbl.conta_credito = CPAC.cod_plano
                 AND tbl.exercicio     = CPAC.exercicio
           LEFT JOIN contabilidade.plano_conta CPCC
                  ON CPAC.cod_conta = CPCC.cod_conta
                 AND CPAC.exercicio = CPCC.exercicio
            ORDER BY tipo
                   ,exercicio
                   ,cod_entidade
                   ,cod_ordem
                   ,conta_debito
                   ,conta_credito ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function listaArrecadacaoSeNaoRetencao($filtro)
    {
        $sqlFunction = "SELECT * FROM tesouraria.fn_listar_arrecadacao_tce(:filtro ,:filtro );  \n";
        $sql = "
             SELECT tbl.exercicio
                    ,tbl.cod_entidade
                    ,tbl.cod_boletim
                    ,tbl.conta_debito
                    ,tbl.conta_credito
                    ,tbl.numeracao
                    ,tbl.cod_receita
                    ,tbl.tipo
                    ,( tbl.valor - tbl.vl_desconto + tbl.vl_juros + tbl.vl_multa ) AS valor
                    ,CPCD.cod_estrutural AS cod_estrutural_debito
                    ,CPCC.cod_estrutural AS cod_estrutural_credito
                    ,tbl.cod_historico
                FROM(
                     SELECT tmp_arrecadacao.cod_entidade
                          ,tmp_arrecadacao.exercicio
                          ,tmp_arrecadacao.cod_boletim
                          ,tmp_arrecadacao.conta_debito
                          ,tmp_arrecadacao.conta_credito
                          ,tmp_arrecadacao.numeracao
                          ,tmp_arrecadacao.cod_receita
                          ,'A' as tipo
                          ,SUM( valor ) AS valor
                          ,SUM( vl_desconto ) AS vl_desconto
                          ,SUM( vl_juros ) AS vl_juros
                          ,SUM( vl_multa ) as vl_multa
                          ,tmp_arrecadacao.cod_historico
                       FROM tmp_arrecadacao
                      WHERE NOT EXISTS
                            ( SELECT aopr.cod_arrecadacao
                                FROM tesouraria.arrecadacao_ordem_pagamento_retencao as aopr
                               WHERE aopr.cod_arrecadacao       = tmp_arrecadacao.cod_arrecadacao
                                 AND aopr.timestamp_arrecadacao = tmp_arrecadacao.timestamp_arrecadacao
                                 AND aopr.exercicio             = tmp_arrecadacao.exercicio
                                 AND aopr.cod_entidade          = tmp_arrecadacao.cod_entidade
                                 AND aopr.cod_plano             = tmp_arrecadacao.conta_credito
                            )
                   GROUP BY exercicio
                          ,cod_entidade
                          ,cod_boletim
                          ,conta_debito
                          ,conta_credito
                          ,numeracao
                          ,cod_receita
                          ,cod_historico

                      UNION ALL

                     SELECT tmp_arrecadacao_estornada.cod_entidade
                          ,tmp_arrecadacao_estornada.exercicio
                          ,tmp_arrecadacao_estornada.cod_boletim
                          ,tmp_arrecadacao_estornada.conta_debito
                          ,tmp_arrecadacao_estornada.conta_credito
                          ,tmp_arrecadacao_estornada.numeracao
                          ,tmp_arrecadacao_estornada.cod_receita
                          ,'E' as tipo
                          ,SUM( valor ) as valor
                          ,SUM( vl_desconto ) as vl_desconto
                          ,SUM( vl_juros ) AS vl_juros
                          ,SUM( vl_multa ) as vl_multa
                          ,tmp_arrecadacao_estornada.cod_historico
                       FROM tmp_arrecadacao_estornada
                      WHERE NOT EXISTS
                            ( SELECT aeopr.cod_arrecadacao
                                FROM tesouraria.arrecadacao_estornada_ordem_pagamento_retencao as aeopr
                               WHERE aeopr.cod_arrecadacao       = tmp_arrecadacao_estornada.cod_arrecadacao
                                 AND aeopr.timestamp_arrecadacao = tmp_arrecadacao_estornada.timestamp_arrecadacao
                                 AND aeopr.exercicio             = tmp_arrecadacao_estornada.exercicio
                                 AND aeopr.cod_entidade          = tmp_arrecadacao_estornada.cod_entidade
                                 AND aeopr.cod_plano             = tmp_arrecadacao_estornada.conta_debito
                            )
                   GROUP BY exercicio
                          ,cod_entidade
                          ,cod_boletim
                          ,conta_debito
                          ,conta_credito
                          ,numeracao
                          ,cod_receita
                          ,cod_historico
                   
                   ORDER BY exercicio
                          ,cod_entidade
                          ,cod_boletim
                          ,conta_debito
                          ,conta_credito
                          ,numeracao
                    ) AS tbl
           LEFT JOIN contabilidade.plano_analitica CPAD
                  ON tbl.conta_debito = CPAD.cod_plano
                 AND tbl.exercicio    = CPAD.exercicio
           LEFT JOIN contabilidade.plano_conta  CPCD
                  ON CPAD.cod_conta = CPCD.cod_conta
                 AND CPAD.exercicio = CPCD.exercicio
           LEFT JOIN contabilidade.plano_analitica CPAC
                  ON tbl.conta_credito = CPAC.cod_plano
                 AND tbl.exercicio     = CPAC.exercicio
           LEFT JOIN contabilidade.plano_conta CPCC
                  ON CPAC.cod_conta = CPCC.cod_conta
                 AND CPAC.exercicio = CPCC.exercicio

            ORDER BY tipo
                   ,exercicio
                   ,cod_entidade
                   ,conta_debito
                   ,conta_credito 
        ";

        $query = $this->_em->getConnection()->prepare($sqlFunction);
        $query->bindValue('filtro', $filtro);
        $query->execute();
        $query->fetchAll();

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function insereLote($lote)
    {
        $sqlFunction = "SELECT * FROM  contabilidade.fn_insere_lote(:exercicio, :cod_entidade, :tipo, :nome_lote, :dt_lote)  AS cod_lote;";

        $query = $this->_em->getConnection()->prepare($sqlFunction);
        $query->bindValue('exercicio', $lote->getExercicio());
        $query->bindValue('cod_entidade', $lote->getCodEntidade());
        $query->bindValue('nome_lote', $lote->getNomLote());
        $query->bindValue('dt_lote', $lote->getDtLote());
        $query->bindValue('tipo', $lote->getTipo());
        $query->execute();
        return $query->fetch();
    }

    public function recuperaRecursoVinculoConta($recursoDestinacao, $codEstrutural)
    {
        $sql = "SELECT recurso_destinacao.cod_recurso
                 FROM orcamento.recurso_destinacao
                 JOIN contabilidade.plano_recurso
                   ON plano_recurso.exercicio = recurso_destinacao.exercicio
                AND plano_recurso.cod_recurso = recurso_destinacao.cod_recurso
            
                    JOIN contabilidade.plano_analitica
                       ON plano_analitica.cod_plano = plano_recurso.cod_plano
                    AND plano_analitica.exercicio = plano_recurso.exercicio
                     JOIN contabilidade.plano_conta ON plano_conta.cod_conta = plano_analitica.cod_conta
                    AND plano_conta.exercicio = plano_analitica.exercicio
                WHERE true ";

        $bindValue = [];
        if (!empty($recursoDestinacao->getExercicio())) {
            $sql .= "AND recurso_destinacao.exercicio = :exercicio ";
            $bindValue['exercicio'] = $recursoDestinacao->getExercicio();
        }
        if (!empty($codEstrutural)) {
            $sql .= "AND plano_conta.cod_estrutural like :cod_estrutural ";
            $bindValue['cod_estrutural'] = $codEstrutural;
        }
        if (!empty($recursoDestinacao->getCodEspecificacao())) {
            $sql .= "AND recurso_destinacao.cod_especificacao  = :cod_especificacao ";
            $bindValue['cod_especificacao'] = $recursoDestinacao->getCodEspecificacao();
        }

        $query = $this->_em->getConnection()->prepare($sql);
        foreach ($bindValue as $key => $value) {
            $query->bindValue($key, $value);
        }
        $query->execute();
        return $query->fetch();
    }

    public function verificaContasRecurso($codRecurso, $exercicio, $codEstrutural)
    {
        $sql = "  SELECT plano_analitica.cod_plano
                  FROM contabilidade.plano_conta
                  JOIN contabilidade.plano_analitica
                    ON plano_analitica.cod_conta = plano_conta.cod_conta
                    AND plano_analitica.exercicio = plano_conta.exercicio
                                  JOIN contabilidade.plano_recurso
                                    ON plano_recurso.cod_plano = plano_analitica.cod_plano
                    AND plano_recurso.exercicio = plano_analitica.exercicio
                                 WHERE plano_conta.cod_estrutural LIKE :cod_estrutural
                    AND plano_recurso.cod_recurso = :cod_recurso
                    AND plano_conta.exercicio = :exercicio ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_recurso', $codRecurso);
        $query->bindValue('cod_estrutural', $codEstrutural);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $query->fetch();
    }


    public function dadosParaLancamento($exercicio, $codReceita)
    {
        $sql = "   SELECT configuracao_lancamento_receita.cod_conta
	                         , plano_conta.cod_estrutural
	                         , configuracao_lancamento_receita.cod_conta_receita
	                         , receita.cod_receita
	                         , plano_analitica.cod_plano
	                      FROM contabilidade.configuracao_lancamento_receita
	                INNER JOIN contabilidade.plano_conta
	                        ON configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
                    AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
                                    INNER JOIN contabilidade.plano_analitica
                                            ON plano_conta.cod_conta = plano_analitica.cod_conta
                    AND plano_conta.exercicio = plano_analitica.exercicio
                                    INNER JOIN orcamento.receita
                                            ON configuracao_lancamento_receita.cod_conta_receita = receita.cod_conta
                    AND configuracao_lancamento_receita.exercicio = receita.exercicio
                                        WHERE configuracao_lancamento_receita.estorno = 'false'
                    AND configuracao_lancamento_receita.exercicio = :exercicio
                    AND receita.cod_receita = :cod_receita ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_receita', $codReceita);
        $query->execute();
        return $query->fetch();
    }


    public function realizacaoReceitaVariavelTribunal($dados)
    {
        $sql = "SELECT
	       RealizacaoReceitaVariavelTribunal(
               :conta_recebimento,
               :clas_receita,
               :exercicio,
               :valor,
               :complemento,
               :cod_lote,
               :tipo_lote,
               :cod_entidade,
               :cod_reduzido ,
               :cod_historico ,
               :cod_plano_conta_recebimento ,
               :cod_plano_clas_receita ) as sequencia";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('conta_recebimento', $dados['conta_recebimento']);
        $query->bindValue('clas_receita', $dados['clas_receita']);
        $query->bindValue('exercicio', $dados['exercicio']);
        $query->bindValue('valor', $dados['valor']);
        $query->bindValue('complemento', $dados['complemento']);
        $query->bindValue('cod_lote', $dados['cod_lote']);
        $query->bindValue('tipo_lote', $dados['tipo_lote']);
        $query->bindValue('cod_entidade', $dados['cod_entidade']);
        $query->bindValue('cod_reduzido', $dados['cod_reduzido']);
        $query->bindValue('cod_historico', $dados['cod_historico']);
        $query->bindValue('cod_plano_conta_recebimento', $dados['cod_plano_conta_recebimento']);
        $query->bindValue('cod_plano_clas_receita', $dados['cod_plano_clas_receita']);
        $query->execute();
        return $query->fetch();
    }

    public function realizacaoReceitaFixaTribunal($dados)
    {
        $sql = "SELECT
	       RealizacaoReceitaFixaTribunal(            
               :exercicio,
               :valor,
               :complemento,
               :cod_lote,
               :tipo_lote,
               :cod_entidade,              
               :cod_historico ) as sequencia";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $dados['exercicio']);
        $query->bindValue('valor', $dados['valor']);
        $query->bindValue('complemento', $dados['complemento']);
        $query->bindValue('cod_lote', $dados['cod_lote']);
        $query->bindValue('tipo_lote', $dados['tipo_lote']);
        $query->bindValue('cod_entidade', $dados['cod_entidade']);
        $query->bindValue('cod_historico', $dados['cod_historico']);
        $query->execute();
        return $query->fetch();
    }
}
