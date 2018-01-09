<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class CotacaoFornecedorItemRepository extends ORM\EntityRepository
{
    /**
     * @param $cod_cotacao
     * @param $exercicio
     * @param $cod_item
     * @param $cgm_fornecedor
     * @param $lote
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaItensFornecedor($cod_cotacao, $exercicio, $cod_item, $cgm_fornecedor, $lote)
    {
        $stSql  = "
            SELECT cotacao_fornecedor_item.*
                 , marca.descricao
              FROM compras.cotacao_fornecedor_item
        INNER JOIN almoxarifado.marca
                ON cotacao_fornecedor_item.cod_marca = marca.cod_marca
             WHERE cod_cotacao = ".$cod_cotacao."
               AND exercicio = '".$exercicio."'
               AND cod_item = ".$cod_item."
               AND cgm_fornecedor = ".$cgm_fornecedor."
               AND lote = ".$lote."
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $cod_item
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaValorItemUltimaCompra($cod_item, $exercicio)
    {
        $stSql = "SELECT
                            CAST
                            (
                                COALESCE((item_pre_empenho.vl_total / item_pre_empenho.quantidade),0) as numeric(14,2)
                            ) as vl_unitario_ultima_compra

                    FROM    empenho.item_pre_empenho_julgamento
                          , empenho.item_pre_empenho
                          , empenho.pre_empenho
                          , empenho.empenho
                   WHERE  item_pre_empenho_julgamento.cod_item        = ".$cod_item ."
                     AND  item_pre_empenho_julgamento.exercicio       = '".$exercicio."'
                     AND  item_pre_empenho_julgamento.num_item        = item_pre_empenho.num_item
                     AND  item_pre_empenho_julgamento.exercicio       = item_pre_empenho.exercicio
                     AND  item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                     AND  item_pre_empenho.exercicio                  = empenho.exercicio
                     AND  item_pre_empenho.cod_pre_empenho            = empenho.cod_pre_empenho
                     AND  pre_empenho.cod_pre_empenho                 = item_pre_empenho.cod_pre_empenho
                     AND  pre_empenho.exercicio                       = item_pre_empenho.exercicio
                     AND  empenho.cod_pre_empenho                     = pre_empenho.cod_pre_empenho
                     AND  empenho.exercicio                           = pre_empenho.exercicio
          AND NOT EXISTS
                       (
                            SELECT  1
                              FROM  empenho.empenho_anulado_item
                             WHERE  empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                               AND  empenho_anulado_item.exercicio       = item_pre_empenho.exercicio
                               AND  empenho_anulado_item.num_item        = item_pre_empenho.num_item
                       )
                ORDER BY  empenho.cod_empenho DESC limit 1";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $exercicioMapa
     * @param $codMapa
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaItensCotacaoJulgadosCompraDireta($exercicioMapa, $codMapa)
    {
        $stSql = "
                     SELECT catalogo_item.descricao_resumida
                          , catalogo_item.descricao as descricao_completa
                          , cotacao_item.cod_item
                          , cotacao_item.quantidade
                          , cotacao_item.lote
                          , cotacao_item.cod_cotacao
                          , mapa_cotacao.cod_mapa
                          , mapa_cotacao.exercicio_mapa as exercicio
                          , cotacao_fornecedor_item.vl_cotacao
                       FROM compras.cotacao_item
                 INNER JOIN almoxarifado.catalogo_item
                         ON cotacao_item.cod_item = catalogo_item.cod_item
                 INNER JOIN compras.cotacao_fornecedor_item
                         ON cotacao_fornecedor_item.exercicio   = cotacao_item.exercicio
                        AND cotacao_fornecedor_item.cod_cotacao = cotacao_item.cod_cotacao
                        AND cotacao_fornecedor_item.cod_item    = cotacao_item.cod_item
                        AND cotacao_fornecedor_item.lote        = cotacao_item.lote
                 INNER JOIN compras.mapa_cotacao
                         ON cotacao_item.cod_cotacao = mapa_cotacao.cod_cotacao
                        AND cotacao_item.exercicio   = mapa_cotacao .exercicio_cotacao
                 INNER JOIN compras.julgamento_item
                         ON cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
                        AND cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
                        AND cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
                        AND cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
                        AND cotacao_fornecedor_item.lote           = julgamento_item.lote
                 INNER JOIN compras.mapa
                         ON mapa_cotacao.cod_mapa       = mapa.cod_mapa
                        AND mapa_cotacao.exercicio_mapa = mapa.exercicio
                 INNER JOIN compras.mapa_item
                         ON mapa_item.exercicio = mapa.exercicio
                        AND mapa_item.cod_mapa  = mapa.cod_mapa
                        AND mapa_item.cod_item  = cotacao_fornecedor_item.cod_item
                        AND mapa_item.lote      = cotacao_fornecedor_item.lote
                 INNER JOIN compras.mapa_solicitacao
                         ON mapa_solicitacao.exercicio             = mapa_item.exercicio
                        AND mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                        AND mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                        AND mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                        AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                 WHERE  mapa_cotacao.exercicio_mapa = '".$exercicioMapa."'
                          AND  mapa_cotacao.cod_mapa = $codMapa
                          AND  julgamento_item.ordem = 1
                          --   Não pode existir uma cotação anulada.
                          AND  NOT EXISTS (
                                            SELECT  1
                                              FROM  compras.cotacao_anulada
                                             WHERE  cotacao_anulada.cod_cotacao = cotacao_item.cod_cotacao
                                               AND  cotacao_anulada.exercicio   = cotacao_item.exercicio
                                         )
                        GROUP BY catalogo_item.descricao_resumida
                            , catalogo_item.descricao
                            , cotacao_item.cod_item
                            , cotacao_item.quantidade
                            , cotacao_item.lote
                            , cotacao_item.cod_cotacao
                            , mapa_cotacao.cod_mapa
                            , mapa_cotacao.exercicio_mapa
                            , cotacao_fornecedor_item.vl_cotacao
                     ORDER BY cotacao_item.cod_item
                 ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
