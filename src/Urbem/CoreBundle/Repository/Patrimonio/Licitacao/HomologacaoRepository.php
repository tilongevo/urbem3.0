<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;

class HomologacaoRepository extends ORM\EntityRepository
{

    /**
     * @param $codLicitacao
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaItensComStatus($codLicitacao, $codModalidade, $codEntidade, $exercicio)
    {
        $sql = "
            select homologacao.num_homologacao
                     , homologacao.cod_tipo_documento
                     , homologacao.cod_documento
                     , adjudicacao.cod_licitacao
                     , adjudicacao.cod_modalidade
                     , adjudicacao.cod_entidade
                     , adjudicacao.num_adjudicacao
                     , adjudicacao.timestamp as timestamp_adjudicacao
                     , homologacao.timestamp as timestamp_homologacao
                     , adjudicacao.exercicio_licitacao
                     , adjudicacao.lote
                     , adjudicacao.cod_cotacao
                     , adjudicacao.exercicio_cotacao
                     , adjudicacao.cgm_fornecedor
                     , sw_cgm.nom_cgm
                     , mapa_item.exercicio as exercicio_mapa
                     , mapa_item.cod_mapa
                     , cotacao_item.quantidade
                     , cotacao_fornecedor_item.vl_cotacao
                     --, sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0) as quantidade
                     , publico.fn_numeric_br(sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total),0)) as vl_total
                     , ((sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total),0)) / (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0)))::numeric(14,2) as vl_unitario_referencia
                     , adjudicacao.cod_item
                     , catalogo_item.descricao_resumida
                     , catalogo_item.descricao
                     , case when ( not homologacao.num_adjudicacao_anulada is null )
                            then 'Anulada'
                            else case when ( not homologacao.homologado or homologacao.homologado is null )
                                      then 'A Homologar'
                                      else  case when not exists ( select 1
                                                                  from empenho.item_pre_empenho_julgamento
                                                                 where item_pre_empenho_julgamento.exercicio       = julgamento_item.exercicio
                                                                   and item_pre_empenho_julgamento.cod_cotacao     = julgamento_item.cod_cotacao
                                                                   and item_pre_empenho_julgamento.cod_item        = julgamento_item.cod_item
                                                                   and item_pre_empenho_julgamento.lote            = julgamento_item.lote
                                                                   and item_pre_empenho_julgamento.cgm_fornecedor  = julgamento_item.cgm_fornecedor )
                                                 then 'Homologado'
                                                 else 'Homologado e Autorizado '|| autorizacao_empenho.cod_autorizacao||'/'||autorizacao_empenho.exercicio
                                            end
                                 end
                       end as status
                     , adjudicacao.adjudicado
                     , homologacao.homologado
                     , homologacao.motivo as justificativa_anulacao
                     , homologacao.revogacao
                     , homologacao.num_adjudicacao_anulada
                  from (
                               select adjudicacao.num_adjudicacao
                                    , adjudicacao.timestamp
                                    , adjudicacao.cod_licitacao
                                    , adjudicacao.cod_modalidade
                                    , adjudicacao.cod_entidade
                                    , adjudicacao.exercicio_licitacao
                                    , adjudicacao.lote
                                    , adjudicacao.cod_cotacao
                                    , adjudicacao.cgm_fornecedor
                                    , adjudicacao.cod_item
                                    , adjudicacao.exercicio_cotacao
                                    , adjudicacao.cod_documento
                                    , adjudicacao.cod_tipo_documento
                                    , adjudicacao.adjudicado
                                 from licitacao.adjudicacao
                            left join licitacao.adjudicacao_anulada
                                   on adjudicacao_anulada.num_adjudicacao       = adjudicacao.num_adjudicacao
                                  and adjudicacao_anulada.cod_entidade          = adjudicacao.cod_entidade
                                  and adjudicacao_anulada.cod_modalidade        = adjudicacao.cod_modalidade
                                  and adjudicacao_anulada.cod_licitacao         = adjudicacao.cod_licitacao
                                  and adjudicacao_anulada.exercicio_licitacao   = adjudicacao.exercicio_licitacao
                                  and adjudicacao_anulada.cod_item              = adjudicacao.cod_item
                                  and adjudicacao_anulada.cgm_fornecedor        = adjudicacao.cgm_fornecedor
                                  and adjudicacao_anulada.cod_cotacao           = adjudicacao.cod_cotacao
                                  and adjudicacao_anulada.lote                  = adjudicacao.lote
                                  and adjudicacao_anulada.exercicio_cotacao     = adjudicacao.exercicio_cotacao
                                where adjudicacao_anulada.num_adjudicacao is null
                       ) as adjudicacao
                  join compras.cotacao_item
                    on cotacao_item.exercicio   = adjudicacao.exercicio_cotacao
                   and cotacao_item.cod_cotacao = adjudicacao.cod_cotacao
                   and cotacao_item.lote        = adjudicacao.lote
                   and cotacao_item.cod_item    = adjudicacao.cod_item
                  join compras.cotacao
                    on cotacao.cod_cotacao = cotacao_item.cod_cotacao
                   and cotacao.exercicio = cotacao_item.exercicio
                  join compras.mapa_cotacao
                    on mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
                   and mapa_cotacao.exercicio_cotacao = cotacao.exercicio
                  join compras.cotacao_fornecedor_item
                    on cotacao_fornecedor_item.exercicio      = adjudicacao.exercicio_cotacao
                   and cotacao_fornecedor_item.cod_cotacao    = adjudicacao.cod_cotacao
                   and cotacao_fornecedor_item.cod_item       = adjudicacao.cod_item
                   and cotacao_fornecedor_item.cgm_fornecedor = adjudicacao.cgm_fornecedor
                   and cotacao_fornecedor_item.lote           = adjudicacao.lote
                  join compras.mapa_item
                    on mapa_item.cod_mapa = mapa_cotacao.cod_mapa
                   and mapa_item.exercicio = mapa_cotacao.exercicio_mapa
                   and mapa_item.cod_item = cotacao_fornecedor_item.cod_item
                   and mapa_item.lote = cotacao_fornecedor_item.lote
                  left join compras.mapa_item_anulacao
                        on mapa_item.exercicio  = mapa_item_anulacao.exercicio
                       and mapa_item.exercicio_solicitacao  = mapa_item_anulacao.exercicio_solicitacao
                       and mapa_item.cod_mapa   = mapa_item_anulacao.cod_mapa
                       and mapa_item.cod_entidade   = mapa_item_anulacao.cod_entidade
                       and mapa_item.cod_solicitacao   = mapa_item_anulacao.cod_solicitacao
                       and mapa_item.cod_centro   = mapa_item_anulacao.cod_centro
                       and mapa_item.lote        = mapa_item_anulacao.lote
                       and mapa_item.cod_item   = mapa_item_anulacao.cod_item
                  join compras.julgamento_item
                    on ( cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
                   and   cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
                   and   cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
                   and   cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
                   and   cotacao_fornecedor_item.lote           = julgamento_item.lote )
                  join almoxarifado.catalogo_item
                    on catalogo_item.cod_item = adjudicacao.cod_item
                  join sw_cgm
                    on sw_cgm.numcgm = adjudicacao.cgm_fornecedor
                 left join (
                            select MAX(homologacao.num_homologacao) as num_homologacao
                                 , homologacao.cod_tipo_documento
                                 , homologacao.cod_documento
                                 , homologacao.cod_entidade
                                 , homologacao.cod_modalidade
                                 , homologacao.cod_licitacao
                                 , homologacao.exercicio_licitacao
                                 , homologacao.cod_item
                                 , homologacao.cgm_fornecedor
                                 , homologacao.cod_cotacao
                                 , homologacao.lote
                                 , homologacao.exercicio_cotacao
                                 , homologacao.num_adjudicacao
                                 , homologacao.homologado
                                 , homologacao_anulada.num_adjudicacao as num_adjudicacao_anulada
                                 , homologacao_anulada.motivo
                                 , homologacao_anulada.revogacao
                                 , MAX(homologacao.timestamp) as timestamp
                              from licitacao.homologacao
                           left join licitacao.homologacao_anulada
                                  on homologacao_anulada.num_homologacao       = homologacao.num_homologacao
                                 and homologacao_anulada.cod_licitacao         = homologacao.cod_licitacao
                                 and homologacao_anulada.cod_modalidade        = homologacao.cod_modalidade
                                 and homologacao_anulada.cod_entidade          = homologacao.cod_entidade
                                 and homologacao_anulada.num_adjudicacao       = homologacao.num_adjudicacao
                                 and homologacao_anulada.exercicio_licitacao   = homologacao.exercicio_licitacao
                                 and homologacao_anulada.lote                  = homologacao.lote
                                 and homologacao_anulada.cod_cotacao           = homologacao.cod_cotacao
                                 and homologacao_anulada.cgm_fornecedor        = homologacao.cgm_fornecedor
                                 and homologacao_anulada.cod_item              = homologacao.cod_item
                                 and homologacao_anulada.exercicio_cotacao     = homologacao.exercicio_cotacao
                         group by homologacao.cod_tipo_documento
                                    , homologacao.cod_documento
                                    , homologacao.cod_entidade
                                    , homologacao.cod_modalidade
                                    , homologacao.cod_licitacao
                                    , homologacao.exercicio_licitacao
                                    , homologacao.cod_item
                                    , homologacao.cgm_fornecedor
                                    , homologacao.cod_cotacao
                                    , homologacao.lote
                                    , homologacao.exercicio_cotacao
                                    , homologacao.num_adjudicacao
                                    , homologacao.homologado
                                    , homologacao_anulada.num_adjudicacao
                                    , homologacao_anulada.motivo
                                    , homologacao_anulada.revogacao
                       ) as homologacao
                    on homologacao.num_adjudicacao       = adjudicacao.num_adjudicacao
                   and homologacao.cod_entidade          = adjudicacao.cod_entidade
                   and homologacao.cod_modalidade        = adjudicacao.cod_modalidade
                   and homologacao.cod_licitacao         = adjudicacao.cod_licitacao
                   and homologacao.exercicio_licitacao   = adjudicacao.exercicio_licitacao
                   and homologacao.cod_item              = adjudicacao.cod_item
                   and homologacao.cgm_fornecedor        = adjudicacao.cgm_fornecedor
                   and homologacao.cod_cotacao           = adjudicacao.cod_cotacao
                   and homologacao.lote                  = adjudicacao.lote
                   and homologacao.exercicio_cotacao     = adjudicacao.exercicio_cotacao
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
          WHERE 1 = 1
          ";

        if ($codLicitacao) {
            $sql .="  and adjudicacao.cod_licitacao = ".$codLicitacao."\n";
        }

        if ($codModalidade) {
            $sql .="  and adjudicacao.cod_modalidade = ".$codModalidade."\n";
        }

        if ($codEntidade) {
            $sql .=" and adjudicacao.cod_entidade = ".$codEntidade."\n";
        }

        if ($exercicio) {
            $sql .=" and adjudicacao.exercicio_licitacao = '".$exercicio."'        \n";
        };
        $sql .="
           group by
              homologacao.num_homologacao
            , adjudicacao.cod_item
            , homologacao.cod_tipo_documento
            , homologacao.cod_documento
            , adjudicacao.cod_licitacao
            , adjudicacao.cod_modalidade
            , adjudicacao.cod_entidade
            , adjudicacao.num_adjudicacao
            , adjudicacao.timestamp
            , adjudicacao.exercicio_licitacao
            , adjudicacao.lote
            , adjudicacao.cod_cotacao
            , adjudicacao.exercicio_cotacao
            , adjudicacao.cgm_fornecedor
            , sw_cgm.nom_cgm
            , cotacao_item.quantidade
            , cotacao_fornecedor_item.vl_cotacao
            , catalogo_item.descricao_resumida
            , catalogo_item.descricao
            , adjudicacao.adjudicado
            , homologacao.homologado
            , homologacao.motivo
            , homologacao.revogacao
            , homologacao.num_adjudicacao_anulada
            , julgamento_item.exercicio
            , julgamento_item.cod_cotacao
            , julgamento_item.cod_item
            , julgamento_item.lote
            , julgamento_item.cgm_fornecedor
            , mapa_item.exercicio
            , mapa_item.cod_mapa
            , homologacao.timestamp
            , autorizacao_empenho.cod_autorizacao
            , autorizacao_empenho.exercicio
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
