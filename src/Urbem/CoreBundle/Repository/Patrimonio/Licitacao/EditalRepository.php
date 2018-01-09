<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;

class EditalRepository extends ORM\EntityRepository
{
    /*
     * Recebe como paramentros $filtros que pode ser: cod_licitacao, exercicio, cod_entidade
     */
    public function getParticipantesByLicitacao($filtros)
    {
        $stSql = "
            select participante.cod_licitacao
	                    , participante.cgm_fornecedor
	                    , participante.cod_entidade
	                    , participante.exercicio
	                    , participante.numcgm_representante
	                    , participante.dt_inclusao
	                    , participante.renuncia_recurso
	                    , sw_cgm_fornecedor.nom_cgm as fornecedor
	                    , sw_cgm_representante.nom_cgm as representante
	                    , participante_consorcio.numcgm as cgm_consorcio
	                    , sw_cgm_consorcio.nom_cgm as consorcio
	                 from licitacao.participante
	           inner join licitacao.licitacao
	                   on licitacao.cod_licitacao = participante.cod_licitacao
	                  and licitacao.cod_entidade = participante.cod_entidade
	                  and licitacao.exercicio = participante.exercicio
	            left join licitacao.participante_consorcio
	                   on participante.cod_licitacao  = participante_consorcio.cod_licitacao
	           inner join compras.fornecedor
	                   on fornecedor.cgm_fornecedor = participante.cgm_fornecedor
	           inner join sw_cgm as sw_cgm_fornecedor
	                   on sw_cgm_fornecedor.numcgm = fornecedor.cgm_fornecedor
	           inner join sw_cgm as sw_cgm_representante
	                   on sw_cgm_representante.numcgm = participante.numcgm_representante
	            left join sw_cgm as sw_cgm_consorcio
	                   on sw_cgm_consorcio.numcgm = participante_consorcio.numcgm
	            WHERE 1 = 1
        ";

        if (isset($filtros['cod_licitacao'])) {
            $stSql.=  "AND participante.cod_licitacao in (".$filtros['cod_licitacao'].")             \n";
        }

        if (isset($filtros['exercicio'])) {
            $stSql.=  "AND licitacao.exercicio = '".$filtros['exercicio']."'                     \n";
        }

        if (isset($filtros['cod_entidade'])) {
            $stSql.=  "AND licitacao.cod_entidade = '".$filtros['cod_entidade']."'             \n";
        }

        $stSql .= " group by participante.cod_licitacao
                        , participante.cgm_fornecedor
	                    , participante.cod_entidade
	                    , participante.exercicio
	                    , participante.numcgm_representante
	                    , participante.dt_inclusao
	                    , participante.renuncia_recurso
	                    , sw_cgm_fornecedor.nom_cgm
	                    , sw_cgm_representante.nom_cgm
	                    , participante_consorcio.numcgm
	                    , sw_cgm_consorcio.nom_cgm;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function updateParticipanteRenunciaRecurso($filtros)
    {
        $stSql = "
        UPDATE licitacao.participante SET renuncia_recurso=".$filtros['renuncia_recurso']." WHERE cod_licitacao = ".$filtros['cod_licitacao']." AND cgm_fornecedor = ".$filtros['cgm_fornecedor']." AND cod_entidade = ".$filtros['cod_entidade']."
	    AND exercicio = '".$filtros['exercicio']."'
        ";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getEditalPassivelImpugnacao($filtros)
    {
        $stSql = "
            SELECT
                le.num_edital,
                cp.descricao,
                le.exercicio,
                le.cod_entidade,
                ll.cod_licitacao||'/'||ll.exercicio as num_licitacao,
                ll.cod_entidade,
                cgm.nom_cgm as entidade,
                ll.cod_modalidade,
                ll.cod_licitacao,
                ll.cod_processo,
                ll.exercicio_processo,
                le.cod_modalidade,
                ll.cod_mapa,
                ll.exercicio_mapa,
                mapa.cod_tipo_licitacao
          FROM  licitacao.edital as le
        INNER JOIN  licitacao.licitacao as ll
            ON  ll.cod_licitacao = le.cod_licitacao
           AND  ll.cod_modalidade = le.cod_modalidade
           AND  ll.cod_entidade = le.cod_entidade
           AND  ll.exercicio = le.exercicio
        INNER JOIN  compras.mapa
            ON  mapa.cod_mapa = ll.cod_mapa
           AND  mapa.exercicio = ll.exercicio_mapa
        INNER JOIN  compras.modalidade as cp
            ON  cp.cod_modalidade = ll.cod_modalidade
        INNER JOIN  orcamento.entidade as oe
            ON  oe.cod_entidade = ll.cod_entidade
           AND  oe.exercicio = ll.exercicio
        INNER JOIN  sw_cgm as cgm
            ON  cgm.numcgm = oe.numcgm
         WHERE  NOT	EXISTS(	SELECT 	1
                               FROM 	licitacao.cotacao_licitacao
                              WHERE  cotacao_licitacao.cod_licitacao = ll.cod_licitacao
                                AND 	cotacao_licitacao.cod_modalidade = ll.cod_modalidade
                                AND  cotacao_licitacao.cod_entidade = ll.cod_entidade
                                AND  cotacao_licitacao.exercicio_licitacao = ll.exercicio
                            ) 	AND
                  diff_datas_em_dias(now()::date,le.dt_abertura_propostas::date) > 2 AND
        le.exercicio_licitacao = '".$filtros['exercicio']."' and  NOT EXISTS (   SELECT  1
                         FROM  licitacao.edital_anulado
                        WHERE  edital_anulado.num_edital = le.num_edital
                          AND  edital_anulado.exercicio = le.exercicio
                   )

        AND  NOT EXISTS ( SELECT 1
            FROM licitacao.edital_impugnado
                    LEFT JOIN licitacao.anulacao_impugnacao_edital
                      ON anulacao_impugnacao_edital.num_edital = edital_impugnado.num_edital
                     AND anulacao_impugnacao_edital.exercicio = edital_impugnado.exercicio
                     AND anulacao_impugnacao_edital.cod_processo = edital_impugnado.cod_processo
                     AND anulacao_impugnacao_edital.exercicio_processo = edital_impugnado.exercicio_processo
                   WHERE edital_impugnado.num_edital = le.num_edital
                     AND edital_impugnado.exercicio = le.exercicio
                     AND anulacao_impugnacao_edital.cod_processo is null
                )";

        if (isset($filtros['num_edital'])) {
            $stSql.=  "AND le.num_edital = '".$filtros['num_edital']."'             \n";
        }

        $stSql .= "
        ORDER BY
        le.exercicio DESC,
        le.num_edital,
        ll.exercicio DESC,
        ll.cod_entidade,
        ll.cod_licitacao,
        ll.cod_modalidade
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @return array[]
     */
    public function getEditalParaAtasEncerramento($ataId = null)
    {
        $sql = <<<SQL
SELECT
  le.num_edital,
  cp.descricao,
  le.exercicio,
  le.cod_entidade,
  ll.cod_licitacao || '/' || ll.exercicio AS num_licitacao,
  ll.cod_entidade,
  cgm.nom_cgm AS entidade,
  ll.cod_modalidade,
  ll.cod_licitacao,
  ll.cod_processo,
  ll.exercicio_processo,
  le.cod_modalidade,
  ll.cod_mapa,
  le.dt_entrega_propostas,
  le.hora_entrega_propostas,
  le.local_entrega_propostas,
  le.local_abertura_propostas,
  le.dt_abertura_propostas,
  le.hora_abertura_propostas,
  le.condicoes_pagamento,
  le.dt_validade_proposta,
  le.dt_validade_proposta - le.dt_entrega_propostas AS qtd_dias_validade
FROM licitacao.edital AS le
  INNER JOIN licitacao.licitacao ll
    ON le.cod_licitacao = ll.cod_licitacao
       AND le.cod_modalidade = ll.cod_modalidade
       AND le.cod_entidade = ll.cod_entidade
       AND le.exercicio = ll.exercicio
  INNER JOIN licitacao.comissao_licitacao AS cl
    ON cl.cod_licitacao = ll.cod_licitacao
       AND cl.cod_modalidade = ll.cod_modalidade
       AND cl.cod_entidade = ll.cod_entidade
       AND cl.exercicio = ll.exercicio
  INNER JOIN compras.modalidade AS cp
    ON ll.cod_modalidade = cp.cod_modalidade
  INNER JOIN orcamento.entidade AS oe
    ON oe.cod_entidade = le.cod_entidade
       AND oe.exercicio = le.exercicio
  INNER JOIN sw_cgm AS cgm
    ON oe.numcgm = cgm.numcgm
WHERE NOT EXISTS(SELECT 1
                 FROM licitacao.edital_anulado
                 WHERE le.num_edital = edital_anulado.num_edital
                       AND le.exercicio = edital_anulado.exercicio)
      AND NOT EXISTS(SELECT 1
                     FROM licitacao.edital_suspenso
                     WHERE le.num_edital = edital_suspenso.num_edital
                           AND le.exercicio = edital_suspenso.exercicio)
      AND (EXISTS(SELECT 1
                  FROM compras.julgamento
                    INNER JOIN compras.mapa_cotacao
                      ON julgamento.exercicio =
                         mapa_cotacao.exercicio_cotacao
                         AND julgamento.cod_cotacao =
                             mapa_cotacao.cod_cotacao
                  WHERE ll.cod_licitacao = le.cod_licitacao
                        AND ll.cod_modalidade = le.cod_modalidade
                        AND ll.cod_entidade = le.cod_entidade
                        AND ll.exercicio = le.exercicio
                        AND ll.exercicio_mapa = mapa_cotacao.exercicio_mapa
                        AND ll.cod_mapa = mapa_cotacao.cod_mapa
                        AND NOT EXISTS(SELECT 1
                                       FROM compras.cotacao_anulada
                                       WHERE cotacao_anulada.cod_cotacao =
                                             mapa_cotacao.cod_cotacao
                                             AND cotacao_anulada.exercicio =
                                                 mapa_cotacao.exercicio_cotacao
                  )))
      AND NOT EXISTS(SELECT *
                     FROM licitacao.ata
                     WHERE ata.num_edital = le.num_edital
                           AND ata.exercicio = le.exercicio
                           AND ata.id NOT IN (:notIn))
SQL;

        $params = ['notIn' => is_null($ataId) ? 0 : $ataId ];

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getEditalPassivelAnulacaoImpugnacao($filtros)
    {
        $stSql = "
        SELECT
                    le.num_edital,
                    cp.descricao,
                    le.exercicio,
                    le.cod_entidade,
                    ll.cod_licitacao||'/'||ll.exercicio as num_licitacao,
                    ll.cod_entidade,
                    cgm.nom_cgm as entidade,
                    ll.cod_modalidade,
                    ll.cod_licitacao,
                    ll.cod_processo,
                    ll.exercicio_processo,
                    le.cod_modalidade,
                    ll.cod_mapa,
                    ll.exercicio_mapa,
                    mapa.cod_tipo_licitacao
              FROM  licitacao.edital as le
        INNER JOIN  licitacao.licitacao as ll
                ON  ll.cod_licitacao = le.cod_licitacao
               AND  ll.cod_modalidade = le.cod_modalidade
               AND  ll.cod_entidade = le.cod_entidade
               AND  ll.exercicio = le.exercicio
        INNER JOIN  compras.mapa
                ON  mapa.cod_mapa = ll.cod_mapa
               AND  mapa.exercicio = ll.exercicio_mapa
        INNER JOIN  compras.modalidade as cp
                ON  cp.cod_modalidade = ll.cod_modalidade
        INNER JOIN  orcamento.entidade as oe
                ON  oe.cod_entidade = ll.cod_entidade
               AND  oe.exercicio = ll.exercicio
        INNER JOIN  sw_cgm as cgm
                ON  cgm.numcgm = oe.numcgm
             WHERE  NOT	EXISTS(	SELECT 	1
                                   FROM 	licitacao.cotacao_licitacao
                                  WHERE  cotacao_licitacao.cod_licitacao = ll.cod_licitacao
                                    AND 	cotacao_licitacao.cod_modalidade = ll.cod_modalidade
                                    AND  cotacao_licitacao.cod_entidade = ll.cod_entidade
                                    AND  cotacao_licitacao.exercicio_licitacao = ll.exercicio
                                ) 	AND
                      diff_datas_em_dias(now()::date,le.dt_abertura_propostas::date) > 2 AND
        le.exercicio_licitacao = '".$filtros['exercicio']."' and  NOT EXISTS (   SELECT  1
                             FROM  licitacao.edital_anulado
                            WHERE  edital_anulado.num_edital = le.num_edital
                              AND  edital_anulado.exercicio = le.exercicio
                       )

        AND  EXISTS ( SELECT 1
            FROM licitacao.edital_impugnado
            LEFT JOIN licitacao.anulacao_impugnacao_edital
              ON anulacao_impugnacao_edital.num_edital = edital_impugnado.num_edital
             AND anulacao_impugnacao_edital.exercicio = edital_impugnado.exercicio
             AND anulacao_impugnacao_edital.cod_processo = edital_impugnado.cod_processo
             AND anulacao_impugnacao_edital.exercicio_processo = edital_impugnado.exercicio_processo
           WHERE edital_impugnado.num_edital = le.num_edital
             AND edital_impugnado.exercicio = le.exercicio
             AND anulacao_impugnacao_edital.num_edital IS NULL
        )";

        if (isset($filtros['num_edital'])) {
            $stSql.=  "AND le.num_edital = '".$filtros['num_edital']."'             \n";
        }

        $stSql .= "
        ORDER BY
        le.exercicio DESC,
        le.num_edital,
        ll.exercicio DESC,
        ll.cod_entidade,
        ll.cod_licitacao,
        ll.cod_modalidade
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return array
     */
    public function recuperaItensEdital($codMapa, $exercicio)
    {
        $sql = " select mapa.cod_mapa
                , mapa.exercicio
                , mapa_item.cod_item
                , mapa_item.cod_entidade
                , sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0) as quantidade
                , sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total),0) as vl_total
                , mapa_item.lote
                , ( sum(mapa_item.vl_total)::numeric  / coalesce(sum(mapa_item.quantidade),1.0)::numeric )::numeric(14,2) as valor_referencia
                , 0.00 as valor_unitario
                , 0.00 as valor_total
                , catalogo_item.descricao_resumida
                , catalogo_item.descricao
                , unidade_medida.nom_unidade
             from compras.mapa
       inner join compras.mapa_item
               on mapa_item.cod_mapa = mapa.cod_mapa
              and mapa_item.exercicio = mapa.exercicio
        LEFT JOIN compras.mapa_item_anulacao
               ON mapa_item_anulacao.exercicio             = mapa_item.exercicio
              AND mapa_item_anulacao.cod_mapa              = mapa_item.cod_mapa
              AND mapa_item_anulacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
              AND mapa_item_anulacao.cod_entidade          = mapa_item.cod_entidade
              AND mapa_item_anulacao.cod_solicitacao       = mapa_item.cod_solicitacao
              AND mapa_item_anulacao.cod_centro            = mapa_item.cod_centro
              AND mapa_item_anulacao.cod_item              = mapa_item.cod_item
              AND mapa_item_anulacao.lote                  = mapa_item.lote
       inner join almoxarifado.catalogo_item
               on catalogo_item.cod_item = mapa_item.cod_item
       inner join administracao.unidade_medida
               on catalogo_item.cod_unidade  = unidade_medida.cod_unidade
              and catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
       where mapa.cod_mapa = $codMapa
       and mapa.exercicio = '".$exercicio."'
       group by mapa.cod_mapa
               ,mapa.exercicio
               ,mapa_item.cod_item
               ,mapa_item.cod_entidade
               ,mapa_item.lote
               ,catalogo_item.descricao_resumida
               ,catalogo_item.descricao
               ,unidade_medida.nom_unidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param int        $codMapa
     * @param int        $codItem
     * @param string|int $exercicio
     * @param int        $codEntidade
     *
     * @return array
     */
    public function montaRecuperaComplementoItemMapa($codMapa, $codItem, $exercicio, $codEntidade)
    {
        $sql = <<<SQL
SELECT solicitacao_item.complemento
FROM compras.mapa_item
  INNER JOIN compras.solicitacao_item
    ON (solicitacao_item.exercicio = mapa_item.exercicio
        AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
        AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
        AND solicitacao_item.cod_centro = mapa_item.cod_centro
        AND solicitacao_item.cod_item = mapa_item.cod_item
    )
WHERE mapa_item.cod_mapa = :cod_mapa 
  AND mapa_item.cod_item = :cod_item
  AND mapa_item.exercicio = :exercicio
  AND mapa_item.cod_entidade = :cod_entidade
GROUP BY mapa_item.cod_item, solicitacao_item.complemento;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_mapa' => $codMapa,
            'cod_item' => $codItem,
            'exercicio' => $exercicio,
            'cod_entidade' => $codEntidade
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param $filtros
     * @return array
     */
    public function getEditalPassivelSuspensao($filtros)
    {
        $stSql = "
        SELECT le.num_edital                                                        
	         , cp.descricao                                                         
	         , le.exercicio                                                         
	         , le.cod_entidade                                                      
	         , ll.cod_licitacao||'/'||ll.exercicio as num_licitacao                 
	         , ll.cod_entidade                                                      
	         , cgm.nom_cgm as entidade                                              
	         , ll.cod_modalidade                                                    
	         , ll.cod_licitacao                                                     
	         , ll.cod_processo                                                      
	         , ll.exercicio_processo                                                
	         , le.cod_modalidade                                                    
	         , ll.cod_mapa                                                          
	         , le.dt_entrega_propostas                                              
	         , le.hora_entrega_propostas                                            
	         , le.local_entrega_propostas                                           
	         , le.local_abertura_propostas                                          
	         , le.dt_abertura_propostas                                             
	         , le.hora_abertura_propostas                                           
	         , le.condicoes_pagamento                                               
	         , le.dt_validade_proposta                                              
	         , le.dt_validade_proposta-le.dt_entrega_propostas as qtd_dias_validade 
	      FROM licitacao.edital as le                                               
	INNER JOIN licitacao.licitacao ll                                               
	        ON le.cod_licitacao   = ll.cod_licitacao                                
	       AND le.cod_modalidade  = ll.cod_modalidade                               
	       AND le.cod_entidade    = ll.cod_entidade                                 
	       AND le.exercicio       = ll.exercicio                                    
	INNER JOIN licitacao.comissao_licitacao as cl                                   
	        ON cl.cod_licitacao  = ll.cod_licitacao                                 
	       AND cl.cod_modalidade = ll.cod_modalidade                                
	       AND cl.cod_entidade   = ll.cod_entidade                                  
	       AND cl.exercicio      = ll.exercicio                                     
	INNER JOIN compras.modalidade as cp                                             
	        ON ll.cod_modalidade = cp.cod_modalidade                                
	INNER JOIN orcamento.entidade as oe                                             
	        ON oe.cod_entidade = le.cod_entidade                                    
	       AND oe.exercicio    = le.exercicio                                       
	INNER JOIN sw_cgm as cgm                                                        
	        ON oe.numcgm = cgm.numcgm                                               
	     WHERE 1=1                                                                  
	 AND le.exercicio_licitacao = '".$filtros['exercicio']."' AND le.cod_entidade in ( ".$filtros['cod_entidade'].") 
	            AND NOT EXISTS (
	                                SELECT  1
	                                  FROM  Licitacao.edital_anulado
	                                 WHERE  le.num_edital = edital_anulado.num_edital
	                                   AND  le.exercicio = edital_anulado.exercicio
	                           )
	         AND NOT EXISTS         
	
	                       (    SELECT  1
	                              FROM  licitacao.edital_suspenso
	                             WHERE  le.num_edital = edital_suspenso.num_edital
	                               AND  le.exercicio = edital_suspenso.exercicio
	                       )
        ";

        if (isset($filtros['num_edital'])) {
            $stSql.=  "AND le.num_edital = '".$filtros['num_edital']."'             \n";
        }

        $stSql .= "
        ORDER BY
        le.exercicio DESC,
        le.num_edital,
        ll.exercicio DESC,
        ll.cod_entidade,
        ll.cod_licitacao,
        ll.cod_modalidade
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }


    /**
     * @param int $codMapa
     * @param string|int $exercicio
     *
     * @return array
     */
    public function montaRecuperaDotacaoEdital($codMapa, $exercicio)
    {
        $sql = <<<SQL
 SELECT
  conta_despesa.cod_estrutural,
  conta_despesa.descricao,
  pao.nom_pao
FROM
  compras.solicitacao_item_dotacao
  , compras.mapa_item
  , compras.mapa
  , orcamento.despesa
  , orcamento.conta_despesa
  , orcamento.pao
WHERE
  mapa.cod_mapa = mapa_item.cod_mapa
  AND mapa.exercicio = mapa_item.exercicio
  AND mapa_item.exercicio_solicitacao = solicitacao_item_dotacao.exercicio
  AND mapa_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
  AND mapa_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
  AND mapa_item.cod_centro = solicitacao_item_dotacao.cod_centro
  AND mapa_item.cod_item = solicitacao_item_dotacao.cod_item
  AND solicitacao_item_dotacao.cod_despesa = despesa.cod_despesa
  AND solicitacao_item_dotacao.exercicio = despesa.exercicio
  AND despesa.exercicio = conta_despesa.exercicio
  AND despesa.cod_conta = conta_despesa.cod_conta
  AND despesa.num_pao = pao.num_pao
  AND despesa.exercicio = pao.exercicio
  AND mapa.cod_mapa = :cod_mapa
  AND mapa.exercicio = :exercicio
GROUP BY
conta_despesa.cod_estrutural
, conta_despesa.descricao
, pao.nom_pao;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_mapa' => $codMapa,
            'exercicio' => $exercicio,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param int $codMapa
     * @param string|int $exercicio
     * @param int $codEntidade
     * @param int $codLicitacao
     *
     * @return array
     */
    public function montaRecuperaDocumentosLicitacao($codMapa, $exercicio, $codEntidade, $codLicitacao)
    {
        $sql = <<<SQL
SELECT
  ld.cod_documento,
  d.nom_documento,
  ld.cod_licitacao,
  ld.cod_modalidade,
  ld.cod_entidade,
  ld.exercicio
FROM licitacao.licitacao_documentos AS ld
  , licitacao.documento AS d
WHERE ld.cod_documento = d.cod_documento
      AND ld.cod_modalidade = :cod_modalidade
      AND ld.exercicio = :exercicio
      AND ld.cod_entidade = :cod_entidade
      AND ld.cod_licitacao = :cod_licitacao
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_modalidade' => $codMapa,
            'exercicio' => $exercicio,
            'cod_entidade' => $codEntidade,
            'cod_licitacao' => $codLicitacao
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param null $params
     * @return array
     */
    public function getEditalELicitacaoNaoAnulados($params = null)
    {
        $andWhere = "";
        if (isset($params['exercicio'])  && $params['exercicio'] != "") {
            $andWhere .= " AND le.exercicio_licitacao = '".$params['exercicio']."' ";
        }

        if (isset($params['processo'])  && $params['processo'] != "") {
            $andWhere .= " AND ll.cod_processo = '".$params['processo']."' ";
        }

        if (isset($params['mapa'])  && $params['mapa'] != "") {
            $andWhere .= " AND ll.cod_mapa = '".$params['mapa']."' ";
        }

        $sql = "select
                    le.num_edital,
                    cp.descricao,
                    le.exercicio,
                    le.cod_entidade,
                    ll.cod_licitacao || '/' || ll.exercicio as num_licitacao,
                    ll.cod_entidade,
                    cgm.nom_cgm as entidade,
                    ll.cod_modalidade,
                    ll.cod_licitacao,
                    ll.cod_processo,
                    ll.exercicio_processo,
                    le.cod_modalidade,
                    ll.cod_mapa,
                    le.dt_entrega_propostas,
                    le.hora_entrega_propostas,
                    le.local_entrega_propostas,
                    le.local_abertura_propostas,
                    le.dt_abertura_propostas,
                    le.hora_abertura_propostas,
                    le.condicoes_pagamento,
                    le.dt_validade_proposta,
                    le.dt_validade_proposta - le.dt_entrega_propostas as qtd_dias_validade
                from
                    licitacao.edital as le inner join licitacao.licitacao ll on
                    le.cod_licitacao = ll.cod_licitacao
                    and le.cod_modalidade = ll.cod_modalidade
                    and le.cod_entidade = ll.cod_entidade
                    and le.exercicio = ll.exercicio inner join licitacao.comissao_licitacao as cl on
                    cl.cod_licitacao = ll.cod_licitacao
                    and cl.cod_modalidade = ll.cod_modalidade
                    and cl.cod_entidade = ll.cod_entidade
                    and cl.exercicio = ll.exercicio inner join compras.modalidade as cp on
                    ll.cod_modalidade = cp.cod_modalidade inner join orcamento.entidade as oe on
                    oe.cod_entidade = le.cod_entidade
                    and oe.exercicio = le.exercicio inner join sw_cgm as cgm on
                    oe.numcgm = cgm.numcgm
                where
                    1 = 1
                    ".$andWhere."
                     -- O Edital não pode estar anulado.          
                    and not exists(
                        select
                            1
                        from
                            licitacao.edital_anulado
                        where
                            edital_anulado.num_edital = le.num_edital
                            and edital_anulado.exercicio = le.exercicio
                    ) 
                    -- A Licitação não pode estar anulada.            
                    and not exists(
                        select
                            1
                        from
                            licitacao.licitacao_anulada
                        where
                            licitacao_anulada.cod_licitacao = ll.cod_licitacao
                            and licitacao_anulada.cod_modalidade = ll.cod_modalidade
                            and licitacao_anulada.cod_entidade = ll.cod_entidade
                            and licitacao_anulada.exercicio = ll.exercicio
                    )
                order by
                    le.exercicio desc,
                    le.num_edital,
                    ll.exercicio desc,
                    ll.cod_entidade,
                    ll.cod_licitacao,
                    ll.cod_modalidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
