<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EventoRepository extends ORM\EntityRepository
{
    public function getEventoPensaoFuncaoPadrao()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.natureza = :natureza');
        $qb->andWhere('e.eventoSistema = true');
        $qb->setParameter('natureza', 'D');
        return $qb;
    }

    /**
     * @param array|string $sw
     * @param $eventoSistema
     * @param $tipo
     * @return array
     */
    public function getEventoByParams($sw, $eventoSistema, $tipo)
    {
        $str = "SELECT FPE.cod_evento
            , FPE.codigo
            , TRIM(FPE.descricao) as descricao
            , FPE.natureza
            , FPE.sigla
            , CASE WHEN FPE.natureza = 'P' THEN 'Proventos'
                   WHEN FPE.natureza = 'I' THEN 'Informaticos'
                   WHEN FPE.natureza = 'B' THEN 'Base'
                  ELSE 'Descontos'
              END AS proventos_descontos
            , FPE.tipo
            , FPE.fixado
            , FPE.limite_calculo
            , FPE.apresenta_parcela
            , FPE.evento_sistema
            , FPEE.timestamp
            , FPEE.valor_quantidade
            , FPEE.unidade_quantitativa
            , FPEE.observacao
            , FSCE.cod_sequencia
            , FPE.cod_verba
            , FPE.apresentar_contracheque
         FROM folhapagamento.evento AS FPE
            , folhapagamento.evento_evento AS FPEE
    LEFT JOIN folhapagamento.sequencia_calculo_evento AS FSCE
           ON FSCE.cod_evento = FPEE.cod_evento
            , (   SELECT FPEE.cod_evento
                       , MAX (FPEE.timestamp) AS timestamp
                    FROM folhapagamento.evento_evento FPEE
                GROUP BY FPEE.cod_evento
              ) AS MAX_FPEE
        WHERE FPE.cod_evento  = MAX_FPEE.cod_evento
          AND FPEE.timestamp  = MAX_FPEE.timestamp
          AND FPE.cod_evento  = FPEE.cod_evento";

        if (is_array($sw)) {
            $str .= " AND natureza IN ('" . implode("','", $sw) . "')";
        } else {
            $str .= " AND natureza = '{$sw}'";
        }

        if ($eventoSistema === true) {
            $str .= " AND evento_sistema = true";
        } elseif ($eventoSistema === false) {
            $str .= " AND evento_sistema = false";
        }

        if ($tipo) {
            $str .= " AND tipo = '{$tipo}'";
        }

        $str .= " ORDER BY codigo;";

        $query = $this->_em->getConnection()->prepare($str);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $listOpt = [];

        foreach ($result as $key => $optName) {
            $listOpt[$optName->descricao] = $optName->codigo;
        }

        return $listOpt;
    }

    public function getCodEventoSequenciaCalculo($codigo)
    {
        $sql = sprintf("
          select sce.*
          from folhapagamento.sequencia_calculo_evento sce
          join folhapagamento.evento e on sce.cod_evento = e.cod_evento
          where e.cod_evento = %d", $codigo);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = array_shift($query->fetchAll(\PDO::FETCH_OBJ));

        return $result;
    }

    /**
     * Lista os eventos de acordo com o sistema legado
     * @return array
     */
    public function montaRecuperaEventosFormatado()
    {
        $sql = sprintf("
            SELECT  evento.cod_evento
                 , evento.codigo
                 , TRIM(evento.descricao) as descricao
                 , sequencia_calculo.sequencia
                 , evento.fixado
                 , ( CASE when evento.tipo = 'F' then 'Fixo'
                          when evento.tipo = 'V' then 'Variável'
                          when evento.tipo = 'B' then 'Base'
                     END ) as tipo
                 , ( CASE when evento.natureza = 'P' THEN 'Provento'
                          when evento.natureza = 'D' THEN 'Desconto'
                          when evento.natureza = 'B' THEN 'Base'
                          when evento.natureza = 'I' THEN 'Informativo'
                     END ) as natureza
            FROM folhapagamento.evento
                , folhapagamento.evento_evento
                , folhapagamento.sequencia_calculo_evento
                , folhapagamento.sequencia_calculo
                , ( SELECT cod_evento
                         , MAX(timestamp) AS timestamp
                     FROM folhapagamento.evento_evento
                    GROUP BY cod_evento
                   ) AS max_evento_evento
            WHERE evento.cod_evento = evento_evento.cod_evento
            AND evento_evento.cod_evento = max_evento_evento.cod_evento
            AND evento_evento.timestamp = max_evento_evento.timestamp
            AND evento_evento.cod_evento = sequencia_calculo_evento.cod_evento
            AND sequencia_calculo_evento.cod_sequencia = sequencia_calculo.cod_sequencia
        ");

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function executaFuncaoPL($sql)
    {
        $sql = sprintf($sql);

        $query = $this->_em->getConnection()->prepare($sql);

        return $query->execute();
    }

    public function recuperaBibliotecaEntidade($cod_modulo, $exercicio)
    {
        $sql = "SELECT cod_biblioteca FROM administracao.biblioteca_entidade WHERE cod_modulo = " . $cod_modulo . " AND exercicio = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getProximoCodigo($campo, $tabela)
    {
        $query = $this->_em->getConnection()->prepare("SELECT MAX(" . $campo . ") AS CODIGO FROM " . $tabela);
        $query->execute();
        $result = current($query->fetchAll());
        $result = array_shift($result);
        if ($result) {
            return $result + 1;
        } else {
            return 1;
        }
    }

    public function findEventosPorNatureza($natureza = 'P')
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.natureza = :natureza');
        $qb->andWhere('e.eventoSistema = true');
        $qb->setParameter('natureza', $natureza);

        return $qb;
    }

    /**
     * Retorna a lista de eventos para os autocompletes customizados
     * @param  array $params
     * @return array
     */
    public function findApiEventosPorNatureza($params)
    {
        $sql = "
        SELECT
            FPE.cod_evento,
            FPE.codigo,
            trim(FPE.descricao) AS descricao,
            FPE.natureza,
            FPE.sigla,
            CASE
                WHEN FPE.natureza = 'P' THEN 'Proventos'
                WHEN FPE.natureza = 'I' THEN 'Informativos'
                WHEN FPE.natureza = 'B' THEN 'Base'
            ELSE
                'Descontos'
            END AS proventos_descontos,
            FPE.tipo,
            FPE.fixado,
            FPE.limite_calculo,
            FPE.apresenta_parcela,
            FPE.evento_sistema,
            FPEE.timestamp,
            FPEE.valor_quantidade,
            FPEE.unidade_quantitativa,
            FPEE.observacao,
            FSCE.cod_sequencia,
            FPE.cod_verba,
            FPE.apresentar_contracheque
        FROM
            folhapagamento.evento AS FPE,
            folhapagamento.evento_evento AS FPEE
            LEFT JOIN folhapagamento.sequencia_calculo_evento AS FSCE ON FSCE.cod_evento = FPEE.cod_evento, (
                SELECT
                    FPEE.cod_evento,
                    max(FPEE.timestamp) AS TIMESTAMP
                FROM
                    folhapagamento.evento_evento FPEE
                GROUP BY
                    FPEE.cod_evento) AS MAX_FPEE
        WHERE
            FPE.cod_evento = MAX_FPEE.cod_evento
            AND FPEE.timestamp = MAX_FPEE.timestamp
            AND FPE.cod_evento = FPEE.cod_evento
            AND natureza = :natureza
            AND evento_sistema = TRUE";

        if (is_numeric($params['q'])) {
            $sql .= "
            AND codigo::integer = :codigo
            ";
        } else {
            $sql .= "
            AND LOWER(descricao) LIKE LOWER(:descricao)
            ";
        }

        $sql .= "
        ORDER BY
            codigo;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        if (is_numeric($params['q'])) {
            $query->bindParam(':codigo', $params['q'], \PDO::PARAM_INT);
        } else {
            $descricao = "%" . $params['q'] . "%";
            $query->bindParam(':descricao', $descricao, \PDO::PARAM_STR);
        }

        $query->bindParam(':natureza', $params['natureza'], \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codEvento
     * @param $timestamp
     * @return array
     */
    public function listarEventosBase($codEvento, $timestamp)
    {
        $sql = "SELECT evento_base.*                                                                                            
	     , evento.codigo                                                                                        
	     , trim(evento.descricao) as descricao                                                                    
	  FROM ( SELECT evento_base.cod_evento                                                                          
	              , evento_base.cod_evento_base                                                                     
	              , evento_base.cod_configuracao                                                                    
	              , max(evento_base.timestamp) as timestamp                                                         
	              , max(evento_base.cod_caso) as cod_caso                                                           
	              , evento_base.cod_caso_base                                                                       
	              , evento_base.cod_configuracao_base                                                               
	              , evento_base.timestamp_base                                                                      
	           FROM folhapagamento.evento_base                                                                      
	              , folhapagamento.configuracao_evento_caso                                                         
	              , folhapagamento.evento_configuracao_evento                                                       
	              , folhapagamento.evento_evento                                                                    
	              , (  SELECT cod_evento                                                                            
	                        , max(timestamp) as timestamp                                                           
	                     FROM folhapagamento.evento_evento                                                          
	                 GROUP BY cod_evento ) as max_evento_evento                                                     
	          WHERE evento_base.cod_evento_base       = configuracao_evento_caso.cod_evento                         
	            AND evento_base.cod_configuracao_base = configuracao_evento_caso.cod_configuracao                   
	            AND evento_base.cod_caso_base         = configuracao_evento_caso.cod_caso                           
	            AND evento_base.timestamp_base        = configuracao_evento_caso.timestamp                          
	            AND configuracao_evento_caso.cod_evento       = evento_configuracao_evento.cod_evento               
	            AND configuracao_evento_caso.cod_configuracao = evento_configuracao_evento.cod_configuracao         
	            AND configuracao_evento_caso.timestamp        = evento_configuracao_evento.timestamp                
	            AND evento_configuracao_evento.cod_evento = evento_evento.cod_evento                                
	            AND evento_configuracao_evento.timestamp  = evento_evento.timestamp                                 
	            AND evento_evento.cod_evento = max_evento_evento.cod_evento                                         
	            AND evento_evento.timestamp  = max_evento_evento.timestamp                                          
	       GROUP BY evento_base.cod_evento                                                                          
	              , evento_base.cod_evento_base                                                                     
	              , evento_base.cod_configuracao                                                                    
	              , evento_base.cod_caso_base                                                                       
	              , evento_base.cod_configuracao_base                                                               
	              , evento_base.timestamp_base) as evento_base                                                      
	     , folhapagamento.evento                                                                                    
	 WHERE evento_base.cod_evento_base = evento.cod_evento                                            
	 AND evento_base.cod_evento = $codEvento AND evento_base.timestamp = '".$timestamp."'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $codEvento
     * @return array
     */
    public function listarEvento($codEvento)
    {
        $sql = "SELECT FPE.cod_evento                                         
	        , FPE.codigo                                             
	        , TRIM(FPE.descricao) as descricao                       
	        , FPE.natureza                                           
	        , FPE.sigla                                              
	        , CASE WHEN FPE.natureza = 'P' THEN 'Proventos'          
	               WHEN FPE.natureza = 'I' THEN 'Informativos'       
	               WHEN FPE.natureza = 'B' THEN 'Base'               
	              ELSE 'Descontos'                                   
	          END AS proventos_descontos                             
	        , FPE.tipo                                               
	        , FPE.fixado                                             
	        , FPE.limite_calculo                                     
	        , FPE.apresenta_parcela                                  
	        , FPE.evento_sistema                                     
	        , FPEE.timestamp                                         
	        , FPEE.valor_quantidade                                  
	        , FPEE.unidade_quantitativa                              
	        , FPEE.observacao                                        
	        , FSCE.cod_sequencia                                     
	        , FPE.cod_verba                                          
	        , FPE.apresentar_contracheque                            
	     FROM folhapagamento.evento AS FPE                           
	        , folhapagamento.evento_evento AS FPEE                   
	LEFT JOIN folhapagamento.sequencia_calculo_evento AS FSCE        
	       ON FSCE.cod_evento = FPEE.cod_evento                      
	        , (   SELECT FPEE.cod_evento                             
	                   , MAX (FPEE.timestamp) AS timestamp           
	                FROM folhapagamento.evento_evento FPEE           
	            GROUP BY FPEE.cod_evento                             
	          ) AS MAX_FPEE                                          
	    WHERE FPE.cod_evento  = MAX_FPEE.cod_evento                  
	      AND FPEE.timestamp  = MAX_FPEE.timestamp                   
	      AND FPE.cod_evento  = FPEE.cod_evento                      
	 AND FPE.cod_evento = $codEvento Order by codigo";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param string $codigo
     * @param integer|null $codSubDivisao
     * @param integer|null $codEspecialidade
     * @return array
     */
    public function carregaConfiguracaoContratoManutencao($codigo, $codSubDivisao, $codEspecialidade)
    {
        $sql = "
            SELECT evento.*
              , evento_evento.observacao
              , evento_evento.valor_quantidade
              , configuracao_evento_caso.cod_caso
              , configuracao_evento_caso.cod_configuracao
              , configuracao_evento_caso.timestamp
            FROM folhapagamento.evento
              INNER JOIN folhapagamento.evento_evento
                ON evento.cod_evento = evento_evento.cod_evento
              INNER JOIN folhapagamento.configuracao_evento_caso
                ON evento_evento.cod_evento = configuracao_evento_caso.cod_evento
                   AND evento_evento.timestamp = configuracao_evento_caso.timestamp
              INNER JOIN folhapagamento.configuracao_evento_caso_sub_divisao as sub_divisao
                ON configuracao_evento_caso.cod_caso          = sub_divisao.cod_caso
                   AND configuracao_evento_caso.cod_evento        = sub_divisao.cod_evento
                   AND configuracao_evento_caso.cod_configuracao  = sub_divisao.cod_configuracao
                   AND configuracao_evento_caso.timestamp         = sub_divisao.timestamp
              INNER JOIN folhapagamento.configuracao_evento_caso_cargo as cargo
                ON configuracao_evento_caso.cod_caso          = cargo.cod_caso
                   AND configuracao_evento_caso.cod_evento        = cargo.cod_evento
                   AND configuracao_evento_caso.cod_configuracao  = cargo.cod_configuracao
                   AND configuracao_evento_caso.timestamp         = cargo.timestamp
              LEFT JOIN folhapagamento.configuracao_evento_caso_especialidade as especialidade
                ON cargo.cod_caso                             = especialidade.cod_caso
                   AND cargo.cod_evento                           = especialidade.cod_evento
                   AND cargo.cod_configuracao                     = especialidade.cod_configuracao
                   AND cargo.timestamp                            = especialidade.timestamp
                   AND cargo.cod_cargo                            = especialidade.cod_cargo
            WHERE evento_evento.timestamp = ( SELECT timestamp
                                              FROM folhapagamento.evento_evento as evento_evento_interno
                                              WHERE evento_evento_interno.cod_evento = evento_evento.cod_evento
                                              ORDER BY timestamp desc
                                              LIMIT 1 )
                  AND codigo = :codigo AND cod_especialidade = :codEspecialidade
        ";

        if ($codSubDivisao) {
            $sql .= " AND cod_sub_divisao = :codSubDivisao";
        }

        $sql .= " ORDER BY descricao;";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindParam(':codigo', $codigo, \PDO::PARAM_STR);
        if ($codSubDivisao) {
            $query->bindParam(':codSubDivisao', $codSubDivisao, \PDO::PARAM_INT);
        }
        $codEspecialidade = ($codEspecialidade) ? $codEspecialidade : 2;
        $query->bindParam(':codEspecialidade', $codEspecialidade, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getEventos()
    {
        $sql = "SELECT FPE.cod_evento                                         
	        , FPE.codigo                                             
	        , TRIM(FPE.descricao) as descricao                       
	        , FPE.natureza                                           
	        , FPE.sigla                                              
	        , CASE WHEN FPE.natureza = 'P' THEN 'Proventos'          
	               WHEN FPE.natureza = 'I' THEN 'Informativos'       
	               WHEN FPE.natureza = 'B' THEN 'Base'               
	              ELSE 'Descontos'                                   
	          END AS proventos_descontos                             
	        , FPE.tipo                                               
	        , FPE.fixado                                             
	        , FPE.limite_calculo                                     
	        , FPE.apresenta_parcela                                  
	        , FPE.evento_sistema                                     
	        , FPEE.timestamp                                         
	        , FPEE.valor_quantidade                                  
	        , FPEE.unidade_quantitativa                              
	        , FPEE.observacao                                        
	        , FSCE.cod_sequencia                                     
	        , FPE.cod_verba                                          
	        , FPE.apresentar_contracheque                            
	     FROM folhapagamento.evento AS FPE                           
	        , folhapagamento.evento_evento AS FPEE                   
	LEFT JOIN folhapagamento.sequencia_calculo_evento AS FSCE        
	       ON FSCE.cod_evento = FPEE.cod_evento                      
	        , (   SELECT FPEE.cod_evento                             
	                   , MAX (FPEE.timestamp) AS timestamp           
	                FROM folhapagamento.evento_evento FPEE           
	            GROUP BY FPEE.cod_evento                             
	          ) AS MAX_FPEE                                          
	    WHERE FPE.cod_evento  = MAX_FPEE.cod_evento                  
	      AND FPEE.timestamp  = MAX_FPEE.timestamp                   
	      AND FPE.cod_evento  = FPEE.cod_evento                      
          AND evento_sistema = false ORDER BY FPE.descricao ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
