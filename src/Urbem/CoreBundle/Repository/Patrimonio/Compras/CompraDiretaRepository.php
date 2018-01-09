<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CompraDiretaRepository extends AbstractRepository
{
    public function getRecuperaTodos($codMapa, $exercicio)
    {
        $sql = "
          SELECT  * FROM compras.compra_direta
                WHERE NOT EXISTS ( SELECT 1
                             FROM compras.compra_direta_anulacao
                            WHERE compra_direta_anulacao.cod_compra_direta  = compra_direta.cod_compra_direta
                              AND compra_direta_anulacao.cod_entidade       = compra_direta.cod_entidade
                              AND compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
                              AND compra_direta_anulacao.cod_modalidade     = compra_direta.cod_modalidade     )
          AND compra_direta.cod_mapa       =  " . $codMapa . "
          AND compra_direta.exercicio_mapa = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $codModalidade
     * @return int
     */
    public function getNextCodCompraDireta($codEntidade, $exercicioEntidade, $codModalidade)
    {
        return $this->nextVal(
            'cod_compra_direta',
            [
                'cod_entidade' => $codEntidade,
                'exercicio_entidade' => $exercicioEntidade,
                'cod_modalidade' => $codModalidade,
            ]
        );
    }


    public function getRecuperaNaoHomologados()
    {
        $sql = "
          SELECT * FROM compras.compra_direta compra
        WHERE NOT EXISTS ( SELECT 1
                          FROM compras.homologacao homologacao
                         WHERE homologacao.cod_compra_direta = compra.cod_compra_direta
                           AND homologacao.cod_entidade = compra.cod_entidade
                           AND homologacao.cod_modalidade = compra.cod_modalidade
                      )
       AND NOT EXISTS ( SELECT 1
                          FROM compras.compra_direta_anulacao anulacao
                         WHERE anulacao.cod_compra_direta = compra.cod_compra_direta
                           AND anulacao.cod_entidade = compra.cod_entidade
                           AND anulacao.cod_modalidade = compra.cod_modalidade
                      )";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $exercicio
     * @param $cod_entidade
     * @param $cod_modalidade
     * @param $cod_compra_direta
     */
    public function montaRecuperaItensComStatus($exercicio, $cod_entidade, $cod_modalidade, $cod_compra_direta)
    {
        $stSql = "
            select homologacao.num_homologacao
            , homologacao.cod_tipo_documento
            , homologacao.timestamp
            , homologacao.cod_tipo_documento
            , homologacao.cod_documento
            , compra_direta.cod_compra_direta
            , compra_direta.cod_modalidade
            , compra_direta.cod_entidade
            , compra_direta.exercicio_entidade
            , cotacao_item.exercicio as exercicio_cotacao
            , julgamento_item.exercicio as julgamento_item_exercicio
            , homologacao.lote
            , homologacao.cod_cotacao
            , homologacao.cgm_fornecedor
            , homologacao.cod_item
            , homologacao.homologado
            , sw_cgm.nom_cgm
            , cotacao_item.quantidade
            , cotacao_fornecedor_item.vl_cotacao
            , catalogo_item.descricao_resumida
            , catalogo_item.descricao
            , homologacao.homologado
            , julgamento_item.exercicio
            , julgamento_item.cod_cotacao
            , julgamento_item.cod_item
            , julgamento_item.lote
            , julgamento_item.cgm_fornecedor
            , mapa_item.exercicio
            , mapa_item.cod_mapa
            ,  case when ( not homologacao.homologado or homologacao.homologado is null )
                 then 'A Homologar'
               else  case when not exists ( select 1
                               from empenho.item_pre_empenho_julgamento
                              where item_pre_empenho_julgamento.exercicio   = julgamento_item.exercicio
                            and item_pre_empenho_julgamento.cod_cotacao     = julgamento_item.cod_cotacao
                            and item_pre_empenho_julgamento.cod_item        = julgamento_item.cod_item
                            and item_pre_empenho_julgamento.lote            = julgamento_item.lote
                            and item_pre_empenho_julgamento.cgm_fornecedor  = julgamento_item.cgm_fornecedor )
                            then 'Homologado'
                            else 'Homologado e Autorizado ' || autorizacao_empenho.cod_autorizacao||'/'||autorizacao_empenho.exercicio
               end
               end as status
             from compras.julgamento_item
           inner join compras.cotacao_item
               on cotacao_item.exercicio   = julgamento_item.exercicio
              and cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
              and cotacao_item.lote        = julgamento_item.lote
              and cotacao_item.cod_item    = julgamento_item.cod_item
           inner join compras.cotacao
               on cotacao.cod_cotacao = cotacao_item.cod_cotacao
              and cotacao.exercicio   = cotacao_item.exercicio
           inner join compras.cotacao_fornecedor_item
               on cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
              and cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
              and cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
              and cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
              and cotacao_fornecedor_item.lote           = julgamento_item.lote
           inner join compras.mapa_cotacao
               on mapa_cotacao.cod_cotacao       = cotacao.cod_cotacao
              and mapa_cotacao.exercicio_cotacao = cotacao.exercicio
           inner join compras.mapa
               on mapa.cod_mapa  = mapa_cotacao.cod_mapa
              and mapa.exercicio = mapa_cotacao.exercicio_mapa
           inner join compras.mapa_item
               on mapa_item.cod_mapa  = mapa.cod_mapa
              and mapa_item.exercicio = mapa.exercicio
              and mapa_item.cod_item  = cotacao_fornecedor_item.cod_item
              and mapa_item.lote      = cotacao_fornecedor_item.lote
           inner join compras.compra_direta
               on compra_direta.cod_mapa       = mapa.cod_mapa
              and compra_direta.exercicio_mapa = mapa.exercicio
        left join compras.mapa_item_anulacao
               on mapa_item.exercicio             = mapa_item_anulacao.exercicio
              and mapa_item.exercicio_solicitacao = mapa_item_anulacao.exercicio_solicitacao
              and mapa_item.cod_mapa              = mapa_item_anulacao.cod_mapa
              and mapa_item.cod_entidade          = mapa_item_anulacao.cod_entidade
              and mapa_item.cod_solicitacao       = mapa_item_anulacao.cod_solicitacao
              and mapa_item.cod_centro  	  = mapa_item_anulacao.cod_centro
              and mapa_item.lote        	  = mapa_item_anulacao.lote
              and mapa_item.cod_item   	          = mapa_item_anulacao.cod_item
           inner join almoxarifado.catalogo_item
               on catalogo_item.cod_item = julgamento_item.cod_item
           inner join sw_cgm
               on sw_cgm.numcgm = julgamento_item.cgm_fornecedor
        left join compras.homologacao
               on homologacao.exercicio   = julgamento_item.exercicio
              and homologacao.cod_cotacao = julgamento_item.cod_cotacao
              and homologacao.lote        = julgamento_item.lote
              and homologacao.cod_item    = julgamento_item.cod_item
              and homologacao.cgm_fornecedor = julgamento_item.cgm_fornecedor
      LEFT JOIN empenho.item_pre_empenho_julgamento
                ON item_pre_empenho_julgamento.exercicio_julgamento = julgamento_item.exercicio
              AND item_pre_empenho_julgamento.cod_cotacao = julgamento_item.cod_cotacao
              AND item_pre_empenho_julgamento.cod_item = julgamento_item.cod_item
              AND item_pre_empenho_julgamento.lote = julgamento_item.lote
              AND item_pre_empenho_julgamento.cgm_fornecedor = julgamento_item.cgm_fornecedor
      LEFT JOIN empenho.item_pre_empenho
                ON item_pre_empenho.cod_pre_empenho = item_pre_empenho_julgamento.cod_pre_empenho
              AND item_pre_empenho.exercicio = item_pre_empenho_julgamento.exercicio
              AND item_pre_empenho.num_item = item_pre_empenho_julgamento.num_item
      LEFT JOIN empenho.pre_empenho
                ON pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
              AND pre_empenho.exercicio = item_pre_empenho.exercicio
      LEFT JOIN empenho.autorizacao_empenho
                ON autorizacao_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
              AND autorizacao_empenho.exercicio = pre_empenho.exercicio
              where 1 =1
              ";

        if ($exercicio) {
            $stSql .= "and compra_direta.exercicio_entidade = '" . $exercicio . "' \n";
        }
        if ($cod_entidade) {
            $stSql .= "and compra_direta.cod_entidade   = " . $cod_entidade . " \n";
        }
        if ($cod_modalidade) {
            $stSql .= "and compra_direta.cod_modalidade = " . $cod_modalidade . " \n";
        }
        if ($cod_compra_direta) {
            $stSql .= "and compra_direta.cod_compra_direta  = " . $cod_compra_direta . " \n";
        }

        $stSql .= "
         group by
               homologacao.num_homologacao
             , homologacao.cod_tipo_documento
             , homologacao.timestamp
             , homologacao.cod_tipo_documento
             , homologacao.cod_documento
             , compra_direta.cod_compra_direta
             , compra_direta.cod_modalidade
             , compra_direta.cod_entidade
             , compra_direta.exercicio_entidade
             , cotacao_item.exercicio
             , julgamento_item.exercicio
             , homologacao.lote
             , homologacao.cod_cotacao
             , homologacao.cgm_fornecedor
             , homologacao.cod_item
             , homologacao.homologado
             , sw_cgm.nom_cgm
             , cotacao_item.quantidade
             , cotacao_fornecedor_item.vl_cotacao
             , catalogo_item.descricao_resumida
             , catalogo_item.descricao
             , homologacao.homologado
             , julgamento_item.exercicio
             , julgamento_item.cod_cotacao
             , julgamento_item.cod_item
             , julgamento_item.lote
             , julgamento_item.cgm_fornecedor
             , mapa_item.exercicio
             , mapa_item.cod_mapa
             , autorizacao_empenho.cod_autorizacao
             , autorizacao_empenho.exercicio
            order by julgamento_item.cod_item;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getJulgamentoPropostas($exercicio)
    {
        $sql = "
          SELECT  compra_direta.cod_compra_direta
	                 ,  compra_direta.cod_modalidade
	                 ,  modalidade.descricao AS modalidade
	                 ,  compra_direta.cod_entidade
	                 ,  sw_cgm.nom_cgm AS entidade
	                 ,  entidade.exercicio AS entidade_exercicio
	                 ,  compra_direta.exercicio_entidade
	                 ,  TO_CHAR(compra_direta.timestamp,'dd/mm/yyyy') as data
	                 ,  TO_CHAR(compra_direta.timestamp,'HH24:MI') as hora
	                 ,  compra_direta.cod_mapa
	                 ,  compra_direta.exercicio_mapa
	                 ,  mapa.cod_tipo_licitacao
	                 ,  tipo_objeto.descricao as desc_tipo_objeto
	                 ,  objeto.descricao as desc_objeto
	                 ,  compra_direta.timestamp
	                 ,  mapa_cot.exercicio_cotacao
	                 ,  mapa_cot.cod_cotacao
	                 , homologadas.homologado
	              FROM  compras.compra_direta
	        INNER JOIN  compras.mapa
	                ON  mapa.cod_mapa = compra_direta.cod_mapa
	               AND  mapa.exercicio = compra_direta.exercicio_mapa
	        INNER JOIN  orcamento.entidade
	                ON  entidade.cod_entidade = compra_direta.cod_entidade
	               AND  entidade.exercicio = compra_direta.exercicio_entidade
	        INNER JOIN  sw_cgm
	                ON  sw_cgm.numcgm = entidade.numcgm
	        INNER JOIN  compras.modalidade
	                ON  modalidade.cod_modalidade = compra_direta.cod_modalidade
	        INNER JOIN  compras.tipo_objeto
	                ON  tipo_objeto.cod_tipo_objeto = compra_direta.cod_tipo_objeto
	        INNER JOIN  compras.objeto
	                ON  objeto.cod_objeto = compra_direta.cod_objeto
	        INNER JOIN  compras.mapa_cotacao as mapa_cot
	                ON  mapa.cod_mapa       = mapa_cot.cod_mapa
	               AND  mapa.exercicio      = mapa_cot.exercicio_mapa
	            LEFT JOIN (SELECT  homologacao.cod_compra_direta
	                                       , homologacao.cod_entidade
	                                       , homologacao.exercicio_compra_direta
	                                       , homologacao.cod_modalidade
	                                       , homologacao.homologado
	                               FROM compras.homologacao
	                        GROUP BY  homologacao.cod_compra_direta
	                                       , homologacao.cod_entidade
	                                       , homologacao.exercicio_compra_direta
	                                       , homologacao.cod_modalidade
	                                       , homologacao.homologado
	                            ) AS homologadas
	                       ON homologadas.cod_compra_direta = compra_direta.cod_compra_direta
	                      AND homologadas.cod_entidade = compra_direta.cod_entidade
	                      AND homologadas.exercicio_compra_direta = compra_direta.exercicio_entidade
	                      AND homologadas.cod_modalidade = compra_direta.cod_modalidade WHERE
	             NOT EXISTS  (  SELECT  1
	                              FROM  compras.compra_direta_anulacao
	                             WHERE  compra_direta_anulacao.cod_modalidade = compra_direta.cod_modalidade
	                               AND  compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
	                               AND  compra_direta_anulacao.cod_entidade = compra_direta.cod_entidade
	                               AND  compra_direta_anulacao.cod_compra_direta = compra_direta.cod_compra_direta
	                         )
	            ----- este filtro serve para exlcuir da listagem os mapas que forem por lote ou global e tenha fornecedores que não cotaram todos os itens de um lote para o qual fizeram proposta
	             AND ( mapa.cod_tipo_licitacao = 1 OR NOT EXISTS ( SELECT lotes.*
	                                                                 FROM ( select cotacao_item.exercicio
	                                                                               , cotacao_item.cod_cotacao
	                                                                               , cotacao_item.lote
	                                                                               , count ( cotacao_item.cod_item ) as qtd_itens
	                                                                            from compras.cotacao_item
	                                                                          group by cotacao_item.exercicio
	                                                                               , cotacao_item.cod_cotacao
	                                                                               , cotacao_item.lote ) as lotes
	                                                                   join ( select cotacao_fornecedor_item.exercicio
	                                                                               , cotacao_fornecedor_item.cod_cotacao
	                                                                               , cotacao_fornecedor_item.lote
	                                                                               , cotacao_fornecedor_item.cgm_fornecedor
	                                                                               , count ( cotacao_fornecedor_item.cod_item ) as qtd_itens
	                                                                            from compras.cotacao_fornecedor_item
	                                                                          group by cotacao_fornecedor_item.exercicio
	                                                                               ,   cotacao_fornecedor_item.cod_cotacao
	                                                                               ,   cotacao_fornecedor_item.lote
	                                                                               , cotacao_fornecedor_item.cgm_fornecedor ) as fornecedor_lotes
	                                                                     on ( lotes.exercicio   = fornecedor_lotes.exercicio
	                                                                    and   lotes.cod_cotacao = fornecedor_lotes.cod_cotacao
	                                                                    and   lotes.lote        = fornecedor_lotes.lote    )
	                                                                  where lotes.qtd_itens > fornecedor_lotes.qtd_itens
	                                                                    and lotes.cod_cotacao = mapa_cot.cod_cotacao
	                                                                    and lotes.exercicio   = mapa_cot.exercicio_cotacao )  )
	             AND NOT EXISTS
	                        (
	                            select 1
	                              from compras.mapa_cotacao
	                              join compras.cotacao
	                                on ( mapa_cotacao.cod_cotacao       = cotacao.cod_cotacao
	                               and   mapa_cotacao.exercicio_cotacao = cotacao.exercicio )
	                              join empenho.item_pre_empenho_julgamento
	                                on ( cotacao.exercicio   = item_pre_empenho_julgamento.exercicio_julgamento
	                               and   cotacao.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao )
	                             where mapa.cod_mapa = mapa_cotacao.cod_mapa
	                               and mapa.exercicio = mapa_cotacao.exercicio_mapa
	                        )
	             AND NOT EXISTS
	                        (
	                            SELECT  1
	                              FROM  compras.cotacao_anulada
	                             WHERE  mapa_cot.cod_cotacao       = cotacao_anulada.cod_cotacao
	                               AND  mapa_cot.exercicio_cotacao = cotacao_anulada.exercicio
	                        ) AND compra_direta.exercicio_entidade = '" . $exercicio . "'
	        ORDER BY    compra_direta.cod_entidade
	               ,    compra_direta.timestamp DESC
	               ,    compra_direta.cod_compra_direta ASC

        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getListagemCompraDiretaEmissaoEmpenho($exercicio)
    {
        $sql = "SELECT DISTINCT
	                compra_direta.cod_compra_direta
	                 ,  compra_direta.timestamp
	                 ,  compra_direta.cod_modalidade
	                 ,  modalidade.descricao AS modalidade
	                 ,  compra_direta.cod_entidade
	                 ,  sw_cgm.nom_cgm AS entidade
	                 ,  TO_CHAR(compra_direta.timestamp,'dd/mm/yyyy') as data
	                 ,  TO_CHAR(compra_direta.dt_entrega_proposta,'dd/mm/yyyy') as dt_entrega
	                 ,  TO_CHAR(compra_direta.dt_validade_proposta,'dd/mm/yyyy') as dt_validade
	                 ,  compra_direta.condicoes_pagamento
	                 ,  compra_direta.prazo_entrega
	                 ,  compra_direta.cod_mapa
	                 ,  compra_direta.exercicio_mapa
	                 ,  compra_direta.cod_tipo_objeto
	                 ,  compra_direta.exercicio_entidade
	                 ,  tipo_objeto.descricao as tipo_objeto
	                 ,  compra_direta.cod_objeto
	                 ,  objeto.descricao as objeto
	              FROM  compras.compra_direta
	        INNER JOIN  orcamento.entidade
	                ON  entidade.cod_entidade = compra_direta.cod_entidade
	               AND  entidade.exercicio    = compra_direta.exercicio_entidade
	        INNER JOIN  sw_cgm
	                ON  sw_cgm.numcgm = entidade.numcgm
	        INNER JOIN  compras.modalidade
	                ON  modalidade.cod_modalidade = compra_direta.cod_modalidade
	        INNER JOIN  compras.tipo_objeto
	                ON  compra_direta.cod_tipo_objeto = tipo_objeto.cod_tipo_objeto
	        INNER JOIN  compras.objeto
	                ON  compra_direta.cod_objeto = objeto.cod_objeto
	        INNER JOIN  compras.mapa_cotacao
	                ON  mapa_cotacao.cod_mapa       = compra_direta.cod_mapa
	               AND  mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
	        INNER JOIN  compras.cotacao
	                ON  cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
	               AND  cotacao.exercicio   = mapa_cotacao.exercicio_cotacao
	        INNER JOIN compras.homologacao
	                ON homologacao.cod_compra_direta = compra_direta.cod_compra_direta
	               AND homologacao.cod_entidade      = compra_direta.cod_entidade
	               AND homologacao.cod_modalidade    = compra_direta.cod_modalidade
	               AND homologacao.exercicio         = '" . $exercicio . "'
	         WHERE  EXISTS  ( SELECT *
	                           FROM compras.julgamento_item
	                           JOIN compras.julgamento
	                             ON julgamento.exercicio   = julgamento_item.exercicio
	                            AND julgamento.cod_cotacao = julgamento_item.cod_cotacao
	                           JOIN compras.cotacao
	                             ON cotacao.exercicio   = julgamento.exercicio
	                            AND cotacao.cod_cotacao = julgamento.cod_cotacao
	                           JOIN compras.mapa
	                             ON mapa.exercicio = mapa_cotacao.exercicio_mapa
	                            AND mapa.cod_mapa  = mapa_cotacao.cod_mapa
	                      LEFT JOIN (SELECT item_pre_empenho_julgamento.cod_cotacao
	                                      , item_pre_empenho_julgamento.exercicio_julgamento
	                                      , item_pre_empenho_julgamento.cod_item
	                                      , item_pre_empenho_julgamento.lote
	                                   FROM empenho.item_pre_empenho_julgamento
	                                ) AS itens_julgamento
	                             ON itens_julgamento.exercicio_julgamento = julgamento_item.exercicio
	                            AND itens_julgamento.cod_cotacao          = julgamento_item.cod_cotacao
	                            AND itens_julgamento.cod_item             = julgamento_item.cod_item
	                            AND itens_julgamento.lote                 = julgamento_item.lote
	                          WHERE itens_julgamento.cod_cotacao IS NULL
	                            AND julgamento_item.cod_cotacao = mapa_cotacao.cod_cotacao
	                            AND julgamento_item.exercicio   = mapa_cotacao.exercicio_cotacao
	                        )
	        AND NOT EXISTS (
	                        SELECT  1
	                            FROM  compras.compra_direta_anulacao
	                            WHERE  compra_direta_anulacao.cod_compra_direta = compra_direta.cod_compra_direta
	                            AND  compra_direta_anulacao.cod_entidade = compra_direta.cod_entidade
	                            AND  compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
	                            AND  compra_direta_anulacao.cod_modalidade = compra_direta.cod_modalidade
	                   )
	        -- Não pode existir uma cotação anulada.
	        AND NOT EXISTS (
	                        SELECT  1
	                            FROM  compras.cotacao_anulada
	                            WHERE  cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
	                            AND  cotacao_anulada.exercicio   = cotacao.exercicio
	                   )
	         and to_date( compra_direta.timestamp::VARCHAR, 'yyyy' ) =  to_date ( '" . $exercicio . "' , 'yyyy' )
	                AND homologacao.homologado = true
	        ORDER BY    compra_direta.cod_entidade
	               ,    compra_direta.timestamp DESC
	               ,    compra_direta.cod_compra_direta ASC

        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $cod_compra_direta
     * @param $cod_modalidade
     * @param $cod_entidade
     * @param $exercicio_entidade
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaMapaCompraDiretaJulgada($cod_compra_direta, $cod_modalidade, $cod_entidade, $exercicio_entidade)
    {
        $stSql = "
            SELECT  compra_direta.cod_mapa
                 ,  compra_direta.exercicio_mapa
                 ,  objeto.descricao AS objeto
              FROM  compras.compra_direta
        INNER JOIN  compras.objeto
                ON  objeto.cod_objeto = compra_direta.cod_objeto
        INNER JOIN  compras.mapa_cotacao
                ON  mapa_cotacao.cod_mapa = compra_direta.cod_mapa
               AND  mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
        INNER JOIN  compras.cotacao
                ON  mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
               AND  mapa_cotacao.exercicio_cotacao = cotacao.exercicio
        INNER JOIN  compras.julgamento
                ON  cotacao.exercicio = julgamento.exercicio
               AND  cotacao.cod_cotacao = julgamento.cod_cotacao
             WHERE  NOT EXISTS (    SELECT  1
                                      FROM  compras.compra_direta_anulacao
                                     WHERE  compra_direta_anulacao.cod_modalidade = compra_direta.cod_modalidade
                                       AND  compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
                                       AND  compra_direta_anulacao.cod_entidade = compra_direta.cod_entidade
                                       AND  compra_direta_anulacao.cod_compra_direta = compra_direta.cod_compra_direta
                               )
                -- Não pode existir uma cotação anulada.
                AND NOT EXISTS (
                                    SELECT  1
                                      FROM  compras.cotacao_anulada
                                     WHERE  cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
                                       AND  cotacao_anulada.exercicio   = cotacao.exercicio
                               )

        ";
        if ($cod_compra_direta) {
            $stSql .= " AND compra_direta.cod_compra_direta = " . $cod_compra_direta . " ";
        }
        if ($cod_modalidade) {
            $stSql .= " AND compra_direta.cod_modalidade = " . $cod_modalidade . " ";
        }
        if ($cod_entidade) {
            $stSql .= " AND compra_direta.cod_entidade = " . $cod_entidade . " ";
        }
        if ($exercicio_entidade) {
            $stSql .= " AND compra_direta.exercicio_entidade = '" . $exercicio_entidade . "' ";
        }


        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return string
     */
    public function montaRecuperaItensAgrupadosAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        $stSql = "
         select  cotacao_fornecedor_item.cgm_fornecedor as fornecedor
                  , solicitacao_item_dotacao.cod_despesa
                  , solicitacao_item_dotacao.cod_conta
                  , solicitacao_item_dotacao.cod_entidade
                  , sw_cgm.nom_cgm as nom_entidade
                  , vw_classificacao_despesa.mascara_classificacao
                  , compra_direta.cod_modalidade
                  , despesa.num_orgao
                  , despesa.num_unidade
                  , objeto.cod_objeto
                  , objeto.descricao as desc_objeto
                  , 0 as historico
                  , 0 as cod_tipo
                  , false as implantado
                  , sum(( cotacao_fornecedor_item.vl_cotacao / cotacao_item.quantidade ) * mapa_item_dotacao.quantidade)::numeric(14,2) as reserva
              from
                  compras.compra_direta
                  inner join compras.mapa_cotacao
                          on mapa_cotacao.cod_mapa = compra_direta.cod_mapa
                         and mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
                  inner join compras.objeto
                          on objeto.cod_objeto = compra_direta.cod_objeto
                  inner join compras.cotacao
                          on cotacao.cod_cotacao    = mapa_cotacao.cod_cotacao
                         and cotacao.exercicio      = mapa_cotacao.exercicio_cotacao
                  inner join compras.cotacao_item
                          on cotacao_item.cod_cotacao   = cotacao.cod_cotacao
                         and cotacao_item.exercicio     = cotacao.exercicio
                  inner join compras.cotacao_fornecedor_item
                          on cotacao_item.cod_cotacao          = cotacao_fornecedor_item.cod_cotacao
                         and cotacao_item.exercicio            = cotacao_fornecedor_item.exercicio
                         and cotacao_item.cod_item             = cotacao_fornecedor_item.cod_item
                         and cotacao_item.lote                 = cotacao_fornecedor_item.lote
                  inner join compras.julgamento_item
                          on julgamento_item.exercicio = cotacao_fornecedor_item.exercicio
                         and julgamento_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                         and julgamento_item.cod_item = cotacao_fornecedor_item.cod_item
                         and julgamento_item.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                         and julgamento_item.lote = cotacao_fornecedor_item.lote
                  inner join compras.mapa_item
                          on mapa_cotacao.cod_mapa      = mapa_item.cod_mapa
                         and mapa_cotacao.exercicio_mapa= mapa_item.exercicio
                         and mapa_item.cod_item      = cotacao_fornecedor_item.cod_item
                         and mapa_item.lote          = cotacao_fornecedor_item.lote
                  inner join compras.mapa_item_dotacao
                          on mapa_item_dotacao.exercicio             = mapa_item.exercicio
                         and mapa_item_dotacao.cod_mapa              = mapa_item.cod_mapa
                         and mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                         and mapa_item_dotacao.cod_entidade          = mapa_item.cod_entidade
                         and mapa_item_dotacao.cod_solicitacao       = mapa_item.cod_solicitacao
                         and mapa_item_dotacao.cod_centro            = mapa_item.cod_centro
                         and mapa_item_dotacao.cod_item              = mapa_item.cod_item
                         and mapa_item_dotacao.lote                  = mapa_item.lote
                  inner join compras.mapa_solicitacao
                          on mapa_solicitacao.exercicio             = mapa_item.exercicio
                         and mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                         and mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                         and mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                         and mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                  inner join compras.solicitacao_homologada
                          on solicitacao_homologada.exercicio       = mapa_solicitacao.exercicio_solicitacao
                         and solicitacao_homologada.cod_entidade    = mapa_solicitacao.cod_entidade
                         and solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                  inner join compras.solicitacao
                          on solicitacao.exercicio       = solicitacao_homologada.exercicio
                         and solicitacao.cod_entidade    = solicitacao_homologada.cod_entidade
                         and solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                  inner join compras.solicitacao_item
                          on solicitacao_item.exercicio          = mapa_item.exercicio
                         and solicitacao_item.cod_entidade       = mapa_item.cod_entidade
                         and solicitacao_item.cod_solicitacao    = mapa_item.cod_solicitacao
                         and solicitacao_item.cod_centro         = mapa_item.cod_centro
                         and solicitacao_item.cod_item           = mapa_item.cod_item
                         and solicitacao_item.exercicio          = solicitacao.exercicio
                         and solicitacao_item.cod_entidade       = solicitacao.cod_entidade
                         and solicitacao_item.cod_solicitacao    = solicitacao.cod_solicitacao
                  inner join compras.solicitacao_item_dotacao
                          on solicitacao_item.exercicio        = solicitacao_item_dotacao.exercicio
                         and solicitacao_item.cod_entidade     = solicitacao_item_dotacao.cod_entidade
                         and solicitacao_item.cod_solicitacao  = solicitacao_item_dotacao.cod_solicitacao
                         and solicitacao_item.cod_centro       = solicitacao_item_dotacao.cod_centro
                         and solicitacao_item.cod_item         = solicitacao_item_dotacao.cod_item
                         and mapa_item_dotacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa
                  inner join orcamento.despesa
                          on despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
                         and despesa.exercicio = solicitacao_item_dotacao.exercicio
                  inner join orcamento.vw_classificacao_despesa
                          on solicitacao_item_dotacao.cod_conta =  vw_classificacao_despesa.cod_conta
                         and solicitacao_item_dotacao.exercicio =  vw_classificacao_despesa.exercicio
                  inner join orcamento.entidade
                          on entidade.cod_entidade = solicitacao_item_dotacao.cod_entidade
                         and entidade.exercicio = solicitacao_item_dotacao.exercicio
                  inner join sw_cgm
                          on sw_cgm.numcgm = entidade.numcgm
                       where compra_direta.cod_compra_direta is not null
                         and julgamento_item.ordem = 1
                     AND  compra_direta.cod_compra_direta  = " . $codCompraDireta . "
                     AND  compra_direta.cod_modalidade     = " . $codModalidade . "
                     AND  compra_direta.cod_entidade       = " . $codEntidade . "
                     AND  compra_direta.exercicio_entidade = '" . $exercicioEntidade . "'
                     -- Não pode existir uma cotação anulada.
                    AND NOT EXISTS
                        (
                            SELECT  1
                                          FROM  compras.cotacao_anulada
                                         WHERE  cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
                        AND  cotacao_anulada.exercicio   = cotacao.exercicio
                                      )";

        $stSql .= "
            group by cotacao_fornecedor_item.cgm_fornecedor
            , vw_classificacao_despesa.mascara_classificacao
            , solicitacao_item_dotacao.cod_despesa
            , solicitacao_item_dotacao.cod_conta
            , solicitacao_item_dotacao.cod_entidade
            , nom_entidade
            , compra_direta.cod_modalidade
            , despesa.num_orgao
            , despesa.num_unidade
            , objeto.cod_objeto
            , objeto.descricao;
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function montaRecuperaItensAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $fornecedor, $codDespesa, $codConta)
    {
        $stSql = "
           select distinct
                  cotacao_item.cod_cotacao
                , cotacao_item.exercicio
                , cotacao_item.cod_item
                , cotacao_item.lote
                , solicitacao_item.exercicio as exercicio_solicitacao
                , cotacao_fornecedor_item.cgm_fornecedor as fornecedor
                , solicitacao_item_dotacao.quantidade as qtd_solicitada
                , solicitacao_item.cod_solicitacao
                , solicitacao_item_dotacao.cod_despesa
                , solicitacao_item_dotacao.cod_conta
                , solicitacao_item_dotacao.cod_centro
                , mapa_item_dotacao.quantidade as qtd_mapa
                , cotacao_item.quantidade as qtd_cotacao
                , solicitacao_item_dotacao.vl_reserva
                , cotacao_fornecedor_item.vl_cotacao
                , catalogo_item.descricao_resumida
                , catalogo_item.descricao as descricao_completa
                , unidade_medida.cod_unidade
                , unidade_medida.cod_grandeza
                , unidade_medida.nom_unidade
                , unidade_medida.simbolo
                , mapa.cod_mapa
                , mapa.exercicio as exercicio_mapa
                , mapa_item_reserva.cod_reserva
                , case
                when    (
                            (
                                solicitacao_item_dotacao.quantidade
                                -
                                coalesce(solicitacao_item_anulacao.quantidade,0.00)
                                -
                                (
                                   select sum(quantidade)
                                     from compras.mapa_item_dotacao
                                     where exercicio       = solicitacao_item_dotacao.exercicio
                                       and cod_entidade    = solicitacao_item_dotacao.cod_entidade
                                       and cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                                       and cod_centro      = solicitacao_item_dotacao.cod_centro
                                       and cod_item        = solicitacao_item_dotacao.cod_item
                                       and cod_despesa     = solicitacao_item_dotacao.cod_despesa
                                       and cod_conta       = solicitacao_item_dotacao.cod_conta
                                  group by cod_solicitacao , cod_entidade, exercicio
                                )
                            )
                            =
                            0
                        ) then
                    0::numeric(14,2)
                else
                        (
                            (
                                solicitacao_item_dotacao.quantidade
                                -
                                coalesce(solicitacao_item_anulacao.quantidade,0.00)
                                -
                                (
                                   select coalesce(sum(quantidade),0.00)
                                     from compras.mapa_item_dotacao
                                     where exercicio       = solicitacao_item_dotacao.exercicio
                                       and cod_entidade    = solicitacao_item_dotacao.cod_entidade
                                       and cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                                       and cod_centro      = solicitacao_item_dotacao.cod_centro
                                       and cod_item        = solicitacao_item_dotacao.cod_item
                                       and cod_despesa     = solicitacao_item_dotacao.cod_despesa
                                       and cod_conta       = solicitacao_item_dotacao.cod_conta
                                  group by cod_solicitacao , cod_entidade, exercicio
                                )
                            )::numeric(14,2)
                            *
                            (
                                cotacao_fornecedor_item.vl_cotacao
                                /
                                mapa_item_dotacao.quantidade
                            )::numeric(14,2)
                        )::numeric(14,2)
              end as nova_reserva_solicitacao
              from
                  compras.compra_direta
                  inner join compras.mapa_cotacao
                          on mapa_cotacao.cod_mapa = compra_direta.cod_mapa
                         and mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
                  inner join compras.mapa
                          on mapa.cod_mapa = mapa_cotacao.cod_mapa
                         and mapa.exercicio = mapa_cotacao.exercicio_mapa
                  inner join compras.objeto
                          on objeto.cod_objeto = compra_direta.cod_objeto
                  inner join compras.cotacao
                          on cotacao.cod_cotacao    = mapa_cotacao.cod_cotacao
                         and cotacao.exercicio      = mapa_cotacao.exercicio_cotacao
                  inner join compras.cotacao_item
                          on cotacao_item.cod_cotacao   = cotacao.cod_cotacao
                         and cotacao_item.exercicio     = cotacao.exercicio
                  inner join compras.cotacao_fornecedor_item
                          on cotacao_item.cod_cotacao          = cotacao_fornecedor_item.cod_cotacao
                         and cotacao_item.exercicio            = cotacao_fornecedor_item.exercicio
                         and cotacao_item.cod_item             = cotacao_fornecedor_item.cod_item
                         and cotacao_item.lote                 = cotacao_fornecedor_item.lote
                  inner join compras.julgamento_item
                          on julgamento_item.exercicio = cotacao_fornecedor_item.exercicio
                         and julgamento_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                         and julgamento_item.cod_item = cotacao_fornecedor_item.cod_item
                         and julgamento_item.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                         and julgamento_item.lote = cotacao_fornecedor_item.lote
                  inner join compras.mapa_item
                          on mapa_cotacao.cod_mapa      = mapa_item.cod_mapa
                         and mapa_cotacao.exercicio_mapa= mapa_item.exercicio
                         and mapa_item.cod_item      = cotacao_fornecedor_item.cod_item
                         and mapa_item.lote          = cotacao_fornecedor_item.lote
                  inner join compras.mapa_item_dotacao
                          on mapa_item.exercicio              = mapa_item_dotacao.exercicio
                         and mapa_item.cod_mapa               = mapa_item_dotacao.cod_mapa
                         and mapa_item.exercicio_solicitacao  = mapa_item_dotacao.exercicio_solicitacao
                         and mapa_item.cod_entidade           = mapa_item_dotacao.cod_entidade
                         and mapa_item.cod_solicitacao        = mapa_item_dotacao.cod_solicitacao
                         and mapa_item.cod_centro             = mapa_item_dotacao.cod_centro
                         and mapa_item.cod_item               = mapa_item_dotacao.cod_item
                  inner join compras.mapa_solicitacao
                          on mapa_solicitacao.exercicio             = mapa_item.exercicio
                         and mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                         and mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                         and mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                         and mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                  inner join compras.solicitacao_homologada
                          on solicitacao_homologada.exercicio       = mapa_solicitacao.exercicio_solicitacao
                         and solicitacao_homologada.cod_entidade    = mapa_solicitacao.cod_entidade
                         and solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                  inner join compras.solicitacao
                          on solicitacao.exercicio       = solicitacao_homologada.exercicio
                         and solicitacao.cod_entidade    = solicitacao_homologada.cod_entidade
                         and solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                  inner join compras.solicitacao_item
                          on solicitacao_item.exercicio          = mapa_item.exercicio
                         and solicitacao_item.cod_entidade       = mapa_item.cod_entidade
                         and solicitacao_item.cod_solicitacao    = mapa_item.cod_solicitacao
                         and solicitacao_item.cod_centro         = mapa_item.cod_centro
                         and solicitacao_item.cod_item           = mapa_item.cod_item
                         and solicitacao_item.exercicio          = solicitacao.exercicio
                         and solicitacao_item.cod_entidade       = solicitacao.cod_entidade
                         and solicitacao_item.cod_solicitacao    = solicitacao.cod_solicitacao
                  inner join compras.solicitacao_item_dotacao
                          on solicitacao_item_dotacao.exercicio          = solicitacao_item.exercicio
                         and solicitacao_item_dotacao.cod_entidade       = solicitacao_item.cod_entidade
                         and solicitacao_item_dotacao.cod_solicitacao    = solicitacao_item.cod_solicitacao
                         and solicitacao_item_dotacao.cod_centro         = solicitacao_item.cod_centro
                         and solicitacao_item_dotacao.cod_item           = solicitacao_item.cod_item
                         and solicitacao_item_dotacao.cod_despesa        = mapa_item_dotacao.cod_despesa
                         and solicitacao_item_dotacao.cod_conta          = mapa_item_dotacao.cod_conta
                   left join compras.solicitacao_item_anulacao
                          on solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                         and solicitacao_item_anulacao.cod_entidade  = solicitacao_item.cod_entidade
                         and solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                         and solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                         and solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
                  inner join almoxarifado.catalogo_item
                          on catalogo_item.cod_item = solicitacao_item.cod_item
                  inner join administracao.unidade_medida
                          on unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
                         and unidade_medida.cod_unidade = catalogo_item.cod_unidade
                  inner join compras.mapa_item_reserva
                          on mapa_item_dotacao.exercicio             = mapa_item_reserva.exercicio_mapa
                         and mapa_item_dotacao.cod_mapa              = mapa_item_reserva.cod_mapa
                         and mapa_item_dotacao.exercicio_solicitacao = mapa_item_reserva.exercicio_solicitacao
                         and mapa_item_dotacao.cod_entidade          = mapa_item_reserva.cod_entidade
                         and mapa_item_dotacao.cod_solicitacao       = mapa_item_reserva.cod_solicitacao
                         and mapa_item_dotacao.cod_centro            = mapa_item_reserva.cod_centro
                         and mapa_item_dotacao.cod_item              = mapa_item_reserva.cod_item
                         and mapa_item_dotacao.lote                  = mapa_item_reserva.lote
                         and mapa_item_dotacao.cod_despesa           = mapa_item_reserva.cod_despesa
                         and mapa_item_dotacao.cod_conta             = mapa_item_reserva.cod_conta
                         and mapa_item.lote                  = mapa_item_reserva.lote
                       where compra_direta.cod_compra_direta is not null
                            and julgamento_item.ordem = 1
                     AND  compra_direta.cod_compra_direta  = " . $codCompraDireta . "
                     AND  compra_direta.cod_modalidade     = " . $codModalidade . "
                     AND  compra_direta.cod_entidade       = " . $codEntidade . "
                     AND  compra_direta.exercicio_entidade = '" . $exercicioEntidade . "'
                     and cotacao_fornecedor_item.cgm_fornecedor = " . $fornecedor . "
                     and solicitacao_item_dotacao.cod_despesa = " . $codDespesa . "
                     and solicitacao_item_dotacao.cod_conta = " . $codConta . "
                           AND  NOT EXISTS
                    (
                        SELECT  1
                                                   FROM  compras.cotacao_anulada
                                                  WHERE  cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
                    AND  cotacao_anulada.exercicio   = cotacao.exercicio
                                                ) ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        $sql = "
        select cotacao_item.cod_cotacao
                       , cotacao_item.exercicio
                       , cotacao_item.cod_item
                       , cotacao_item.lote
                       , cotacao_fornecedor_item.cgm_fornecedor as fornecedor
                       , cotacao_fornecedor_item.lote
                       , solicitacao_item_dotacao.cod_despesa
                       , solicitacao_item_dotacao.cod_conta
                       , solicitacao.cod_solicitacao
                       , solicitacao_item.exercicio as exercicio_solicitacao
                       , solicitacao_item_dotacao.cod_entidade
                       , sw_cgm.nom_cgm as nom_entidade
                       , vw_classificacao_despesa.mascara_classificacao
                       , compra_direta.cod_modalidade
                       , despesa.num_orgao
                       , despesa.num_unidade
                       , objeto.cod_objeto
                       , objeto.descricao as desc_objeto
                       , 0 as historico
                       , 0 as cod_tipo
                       , false as implantado
                       , (( sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade) ) * (sum(mapa_item_dotacao.quantidade) - coalesce (sum(mapa_item_anulacao.quantidade),0)))::numeric(14,2) as reserva
                       , (sum(mapa_item_dotacao.quantidade) - coalesce (sum(mapa_item_anulacao.quantidade),0))::numeric(14,2) as qtd_cotacao
                       , (( sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade) ) * (sum(mapa_item_dotacao.quantidade) - coalesce (sum(mapa_item_anulacao.quantidade),0)))::numeric(14,2) as vl_cotacao
                       , catalogo_item.descricao_resumida
                       , catalogo_item.descricao as descricao_completa
                       , unidade_medida.cod_unidade
                       , unidade_medida.cod_grandeza
                       , unidade_medida.nom_unidade
                       , unidade_medida.simbolo
                       , mapa.cod_mapa
                       , mapa.exercicio as exercicio_mapa
                       , solicitacao_item.complemento
                       , solicitacao_item.cod_centro
                    from compras.compra_direta
                   inner join compras.mapa_cotacao
                           on mapa_cotacao.cod_mapa = compra_direta.cod_mapa
                          and mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
                   inner join compras.mapa
                           on mapa.cod_mapa = mapa_cotacao.cod_mapa
                          and mapa.exercicio = mapa_cotacao.exercicio_mapa
                   inner join compras.objeto
                           on objeto.cod_objeto = compra_direta.cod_objeto
                   inner join compras.cotacao
                           on cotacao.cod_cotacao    = mapa_cotacao.cod_cotacao
                          and cotacao.exercicio      = mapa_cotacao.exercicio_cotacao
                   inner join compras.cotacao_item
                           on cotacao_item.cod_cotacao   = cotacao.cod_cotacao
                          and cotacao_item.exercicio     = cotacao.exercicio
                   inner join compras.cotacao_fornecedor_item
                           on cotacao_item.cod_cotacao          = cotacao_fornecedor_item.cod_cotacao
                          and cotacao_item.exercicio            = cotacao_fornecedor_item.exercicio
                          and cotacao_item.cod_item             = cotacao_fornecedor_item.cod_item
                          and cotacao_item.lote                 = cotacao_fornecedor_item.lote
                   inner join compras.julgamento_item
                           on julgamento_item.exercicio = cotacao_fornecedor_item.exercicio
                          and julgamento_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                          and julgamento_item.cod_item = cotacao_fornecedor_item.cod_item
                          and julgamento_item.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                          and julgamento_item.lote = cotacao_fornecedor_item.lote
                   inner join compras.mapa_item
                           on mapa_cotacao.cod_mapa      = mapa_item.cod_mapa
                          and mapa_cotacao.exercicio_mapa= mapa_item.exercicio
                          and mapa_item.cod_item      = cotacao_fornecedor_item.cod_item
                          and mapa_item.lote          = cotacao_fornecedor_item.lote
                    inner join compras.mapa_item_dotacao
                           on mapa_item_dotacao.exercicio             = mapa_item.exercicio
                          and mapa_item_dotacao.cod_mapa              = mapa_item.cod_mapa
                          and mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                          and mapa_item_dotacao.cod_entidade          = mapa_item.cod_entidade
                          and mapa_item_dotacao.cod_solicitacao       = mapa_item.cod_solicitacao
                          and mapa_item_dotacao.cod_centro            = mapa_item.cod_centro
                          and mapa_item_dotacao.cod_item              = mapa_item.cod_item
                          and mapa_item_dotacao.lote                  = mapa_item.lote
                    LEFT JOIN compras.mapa_item_anulacao
                           ON mapa_item_anulacao.exercicio             = mapa_item_dotacao.exercicio
                          AND mapa_item_anulacao.cod_mapa              = mapa_item_dotacao.cod_mapa
                          AND mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                          AND mapa_item_anulacao.cod_entidade          = mapa_item_dotacao.cod_entidade
                          AND mapa_item_anulacao.cod_solicitacao       = mapa_item_dotacao.cod_solicitacao
                          AND mapa_item_anulacao.cod_centro            = mapa_item_dotacao.cod_centro
                          AND mapa_item_anulacao.cod_item              = mapa_item_dotacao.cod_item
                          AND mapa_item_anulacao.lote                  = mapa_item_dotacao.lote
                          AND mapa_item_anulacao.cod_conta             = mapa_item_dotacao.cod_conta
                          AND mapa_item_anulacao.cod_despesa           = mapa_item_dotacao.cod_despesa
                   inner join compras.mapa_solicitacao
                           on mapa_solicitacao.exercicio             = mapa_item.exercicio
                          and mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                          and mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                          and mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                          and mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                   inner join compras.solicitacao_homologada
                           on solicitacao_homologada.exercicio       = mapa_solicitacao.exercicio_solicitacao
                          and solicitacao_homologada.cod_entidade    = mapa_solicitacao.cod_entidade
                          and solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                   inner join compras.solicitacao
                           on solicitacao.exercicio       = solicitacao_homologada.exercicio
                          and solicitacao.cod_entidade    = solicitacao_homologada.cod_entidade
                          and solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                   inner join compras.solicitacao_item
                           on solicitacao_item.exercicio          = mapa_item.exercicio
                          and solicitacao_item.cod_entidade       = mapa_item.cod_entidade
                          and solicitacao_item.cod_solicitacao    = mapa_item.cod_solicitacao
                          and solicitacao_item.cod_centro         = mapa_item.cod_centro
                          and solicitacao_item.cod_item           = mapa_item.cod_item
                          and solicitacao_item.exercicio          = solicitacao.exercicio
                          and solicitacao_item.cod_entidade       = solicitacao.cod_entidade
                          and solicitacao_item.cod_solicitacao    = solicitacao.cod_solicitacao
                   inner join almoxarifado.catalogo_item
                           on catalogo_item.cod_item = solicitacao_item.cod_item
                   inner join administracao.unidade_medida
                           on unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
                          and unidade_medida.cod_unidade = catalogo_item.cod_unidade
                   inner join compras.solicitacao_item_dotacao
                           on solicitacao_item.exercicio        = solicitacao_item_dotacao.exercicio
                          and solicitacao_item.cod_entidade     = solicitacao_item_dotacao.cod_entidade
                          and solicitacao_item.cod_solicitacao  = solicitacao_item_dotacao.cod_solicitacao
                          and solicitacao_item.cod_centro       = solicitacao_item_dotacao.cod_centro
                          and solicitacao_item.cod_item         = solicitacao_item_dotacao.cod_item
                          and mapa_item_dotacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa
                   inner join orcamento.despesa
                           on despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
                          and despesa.exercicio = solicitacao_item_dotacao.exercicio
                   inner join orcamento.vw_classificacao_despesa
                           on solicitacao_item_dotacao.cod_conta =  vw_classificacao_despesa.cod_conta
                          and solicitacao_item_dotacao.exercicio =  vw_classificacao_despesa.exercicio
                   inner join orcamento.entidade
                           on entidade.cod_entidade = solicitacao_item_dotacao.cod_entidade
                          and entidade.exercicio = solicitacao_item_dotacao.exercicio
                   inner join sw_cgm
                           on sw_cgm.numcgm = entidade.numcgm
                   where compra_direta.cod_compra_direta is not null
                     and julgamento_item.ordem = 1
                       AND  compra_direta.cod_compra_direta  = " . $codCompraDireta . "
                     AND  compra_direta.cod_modalidade     = " . $codModalidade . "
                     AND  compra_direta.cod_entidade       = " . $codEntidade . "
                     AND  compra_direta.exercicio_entidade = '" . $exercicioEntidade . "'
                     group by cotacao_fornecedor_item.cgm_fornecedor
                           , vw_classificacao_despesa.mascara_classificacao
                           , cotacao_fornecedor_item.lote
                           , solicitacao_item_dotacao.cod_despesa
                           , solicitacao_item_dotacao.cod_conta
                           , solicitacao_item_dotacao.cod_entidade
                           , nom_entidade
                           , compra_direta.cod_modalidade
                           , despesa.num_orgao
                           , despesa.num_unidade
                           , objeto.cod_objeto
                           , objeto.descricao
                           , cotacao_item.cod_cotacao
                           , cotacao_item.exercicio
                           , cotacao_item.cod_item
                           , cotacao_item.lote
                           , catalogo_item.descricao_resumida
                           , catalogo_item.descricao
                           , unidade_medida.cod_unidade
                           , unidade_medida.cod_grandeza
                           , unidade_medida.nom_unidade
                           , unidade_medida.simbolo
                           , mapa.cod_mapa
                           , mapa.exercicio
                           , solicitacao_item.exercicio
                           , cotacao_item.quantidade
                           , solicitacao_item.complemento
                           , solicitacao_item.cod_centro
                           , solicitacao.cod_solicitacao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param $exercicio
     * @return ProxyQueryInterface
     */
    public function getJulgamento(ProxyQueryInterface $proxyQuery, $exercicio)
    {
        $proxyQuery
            ->join(
                'CoreBundle:Compras\Mapa',
                'm',
                'WITH',
                'm.codMapa = o.codMapa AND  m.exercicio = o.exercicioMapa'
            )
            ->join(
                'CoreBundle:Compras\MapaCotacao',
                'mc',
                'WITH',
                'mc.codMapa = m.codMapa AND  mc.exercicioMapa = m.exercicio'
            )
            ->where('NOT EXISTS (SELECT 1 FROM CoreBundle:Compras\CotacaoAnulada ca 
                WHERE mc.codCotacao = ca.codCotacao AND mc.exercicioCotacao = ca.exercicio)')
            ->orWhere(
                'm.codTipoLicitacao = \'1\'',
                'NOT EXISTS (SELECT 1
                            FROM CoreBundle:Compras\CotacaoItem ci
                            JOIN CoreBundle:Compras\CotacaoFornecedorItem cfi
                             WITH (ci.exercicio = cfi.exercicio AND ci.codCotacao = cfi.codCotacao AND ci.lote = cfi.lote)
                            WHERE ci.codCotacao = mc.codCotacao AND ci.exercicio   = mc.exercicioCotacao
                            HAVING COUNT(ci.codItem) > COUNT(cfi.codItem)                              
                            )'
            )
            ->andWhere('NOT EXISTS (SELECT 1
                      FROM CoreBundle:Compras\MapaCotacao mc1
                      JOIN CoreBundle:Compras\Cotacao c
                        WITH ( mc1.codCotacao = c.codCotacao AND mc1.exercicioCotacao = c.exercicio )
                      JOIN CoreBundle:Empenho\ItemPreEmpenhoJulgamento ipej
                        WITH ( c.exercicio = ipej.exercicioJulgamento AND c.codCotacao = ipej.codCotacao )
                      WHERE m.codMapa = mc1.codMapa
                        AND m.exercicio = mc1.exercicioMapa
                      )')
            ->andWhere('NOT EXISTS (SELECT  1
                      FROM  CoreBundle:Compras\CotacaoAnulada ca1
                     WHERE  mc.codCotacao = ca1.codCotacao
                       AND  mc.exercicioCotacao = ca1.exercicio
                     )')
            ->andWhere('o.exercicioEntidade = ?1')
            ->setParameter(1, $exercicio);

        return $proxyQuery;
    }
}
