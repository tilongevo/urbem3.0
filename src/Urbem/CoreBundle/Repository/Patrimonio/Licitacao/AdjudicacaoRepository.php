<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;

class AdjudicacaoRepository extends ORM\EntityRepository
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
             select adjudicacao.num_adjudicacao
             , licitacao.cod_entidade
             , licitacao.cod_modalidade
             , licitacao.cod_licitacao
             , licitacao.exercicio as licitacao_exercicio
             , cotacao_licitacao.exercicio_cotacao as cotacao_exercicio
             , cotacao_licitacao.cod_cotacao
             , cotacao_item.lote
             , cotacao_licitacao.cod_item
             , unidade_medida.nom_unidade
             , mapa_item.exercicio as exercicio_mapa
             , mapa_item.cod_mapa
             , cotacao_item.quantidade
             --, sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0) as quantidade
             , publico.fn_numeric_br(sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total),0)) as vl_total
             , publico.fn_numeric_br(julgamento_vencedor.vl_cotacao) as vl_cotacao
             , julgamento_vencedor.vl_cotacao / (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0))::numeric(14,2) as vl_unitario
             , ((sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total),0)) / (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade),0)))::numeric(14,2) as vl_unitario_referencia
             , catalogo_item.descricao_resumida
             , catalogo_item.descricao
             , julgamento_vencedor.cgm_fornecedor
             , adjudicacao.cod_documento
             , adjudicacao.cod_tipo_documento
             , case when homologacao.homologado = true then 'Homologado'
                    when homologacao.motivo is not null or adjudicacao.motivo is not null then 'Anulado'
                    when adjudicacao.adjudicado = true and adjudicacao.motivo is null then 'Adjudicado'
                    else 'A Adjudicar'
                end as status
             , adjudicacao.num_adjudicacao_anulada
             , case when adjudicacao.motivo is not null then adjudicacao.motivo
                      when homologacao.motivo is not null then homologacao.motivo
                      else null
                 end as justificativa_anulacao
          from licitacao.licitacao
          join (
                 select cod_licitacao, cod_modalidade, cod_entidade, exercicio_licitacao, lote, cod_cotacao, cod_item, exercicio_cotacao
                   from licitacao.cotacao_licitacao
                  group by cod_licitacao, cod_modalidade, cod_entidade, exercicio_licitacao, lote, cod_cotacao, cod_item, exercicio_cotacao
               ) as cotacao_licitacao
            on cotacao_licitacao.cod_licitacao       = licitacao.cod_licitacao
           and cotacao_licitacao.cod_modalidade      = licitacao.cod_modalidade
           and cotacao_licitacao.cod_entidade        = licitacao.cod_entidade
           and cotacao_licitacao.exercicio_licitacao = licitacao.exercicio
          join (
                 select julgamento_item.exercicio
                      , julgamento_item.cod_cotacao
                      , julgamento_item.cod_item
                      , julgamento_item.lote
                      , julgamento_item.cgm_fornecedor
                      , cotacao_fornecedor_item.vl_cotacao
                   from compras.julgamento_item
                   join compras.cotacao_fornecedor_item
                     on (     cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
                          and cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
                          and cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
                          and cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
                          and cotacao_fornecedor_item.lote           = julgamento_item.lote
                        )
                  where julgamento_item.ordem = 1
                ) as julgamento_vencedor
           on julgamento_vencedor.exercicio   = cotacao_licitacao.exercicio_cotacao
          and julgamento_vencedor.cod_cotacao = cotacao_licitacao.cod_cotacao
          and julgamento_vencedor.cod_item    = cotacao_licitacao.cod_item
          and julgamento_vencedor.lote        = cotacao_licitacao.lote

         join compras.mapa_item
           on mapa_item.exercicio  = licitacao.exercicio_mapa
          and mapa_item.cod_mapa   = licitacao.cod_mapa
          and mapa_item.cod_item   = cotacao_licitacao.cod_item

         left join compras.mapa_item_anulacao
           on mapa_item.exercicio  = mapa_item_anulacao.exercicio
          and mapa_item.exercicio_solicitacao  = mapa_item_anulacao.exercicio_solicitacao
          and mapa_item.cod_mapa   = mapa_item_anulacao.cod_mapa
          and mapa_item.cod_entidade   = mapa_item_anulacao.cod_entidade
          and mapa_item.cod_solicitacao   = mapa_item_anulacao.cod_solicitacao
          and mapa_item.cod_centro   = mapa_item_anulacao.cod_centro
          and mapa_item.lote        = mapa_item_anulacao.lote
          and mapa_item.cod_item   = mapa_item_anulacao.cod_item
         join almoxarifado.catalogo_item
           on catalogo_item.cod_item = cotacao_licitacao.cod_item
         join administracao.unidade_medida
           on catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
          and catalogo_item.cod_unidade = unidade_medida.cod_unidade
         join compras.cotacao_item
             on cotacao_item.exercicio   = cotacao_licitacao.exercicio_cotacao
           and cotacao_item.cod_cotacao = cotacao_licitacao.cod_cotacao
           and cotacao_item.lote        = cotacao_licitacao.lote
           and cotacao_item.cod_item    = cotacao_licitacao.cod_item
         left join (
                    select adjudicacao.num_adjudicacao
                           , adjudicacao.cod_licitacao
                           , adjudicacao.cod_modalidade
                           , adjudicacao.cod_entidade
                           , adjudicacao.lote
                           , adjudicacao.cod_cotacao
                           , adjudicacao.cgm_fornecedor
                           , adjudicacao.cod_item
                           , adjudicacao.exercicio_cotacao
                           , adjudicacao.cod_documento
                           , adjudicacao.cod_tipo_documento
                           , adjudicacao.adjudicado
                           , adjudicacao.timestamp
                           , adjudicacao_anulada.motivo
                           , adjudicacao_anulada.num_adjudicacao as num_adjudicacao_anulada
                        from licitacao.adjudicacao
                        left join licitacao.adjudicacao_anulada
                              on adjudicacao_anulada.num_adjudicacao       = adjudicacao.num_adjudicacao
                             and adjudicacao_anulada.cod_entidade          = adjudicacao.cod_entidade
                             and adjudicacao_anulada.cod_modalidade        = adjudicacao.cod_modalidade
                             and adjudicacao_anulada.cod_licitacao         = adjudicacao.cod_licitacao
                             and adjudicacao_anulada.cod_item              = adjudicacao.cod_item
                             and adjudicacao_anulada.cgm_fornecedor        = adjudicacao.cgm_fornecedor
                             and adjudicacao_anulada.cod_cotacao           = adjudicacao.cod_cotacao
                             and adjudicacao_anulada.lote                  = adjudicacao.lote
                             and adjudicacao_anulada.exercicio_cotacao     = adjudicacao.exercicio_cotacao
                           ) as adjudicacao
                          on adjudicacao.cod_licitacao       = cotacao_licitacao.cod_licitacao
                         and adjudicacao.cod_modalidade      = cotacao_licitacao.cod_modalidade
                         and adjudicacao.cod_entidade        = cotacao_licitacao.cod_entidade
                         and adjudicacao.lote                = cotacao_licitacao.lote
                         and adjudicacao.cod_cotacao         = cotacao_licitacao.cod_cotacao
                         and adjudicacao.cod_item            = cotacao_licitacao.cod_item
                         and adjudicacao.exercicio_cotacao   = cotacao_licitacao.exercicio_cotacao
         left join (
                      select homologacao.num_homologacao
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
                           , homologacao_anulada.motivo
                           , homologacao_anulada.revogacao
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
                    ) as homologacao
           on homologacao.num_adjudicacao       = adjudicacao.num_adjudicacao
          and homologacao.cod_entidade          = adjudicacao.cod_entidade
          and homologacao.cod_modalidade        = adjudicacao.cod_modalidade
          and homologacao.cod_licitacao         = adjudicacao.cod_licitacao
          and homologacao.cod_item              = adjudicacao.cod_item
          and homologacao.cgm_fornecedor        = adjudicacao.cgm_fornecedor
          and homologacao.cod_cotacao           = adjudicacao.cod_cotacao
          and homologacao.lote                  = adjudicacao.lote
          and homologacao.exercicio_cotacao     = adjudicacao.exercicio_cotacao
          WHERE 1 = 1
          ";

        if ($codLicitacao) {
            $sql .="  and licitacao.cod_licitacao = ".$codLicitacao."\n";
        }

        if ($codModalidade) {
            $sql .="  and licitacao.cod_modalidade = ".$codModalidade."\n";
        }

        if ($codEntidade) {
            $sql .=" and licitacao.cod_entidade = ".$codEntidade."\n";
        }

        if ($exercicio) {
            $sql .="    AND licitacao.exercicio = '".$exercicio."'        \n";
        };
        $sql .="
          group by  adjudicacao.num_adjudicacao
            , licitacao.cod_entidade
            , licitacao.cod_modalidade
            , licitacao.cod_licitacao
            , licitacao.exercicio
            , cotacao_licitacao.exercicio_cotacao
            , cotacao_licitacao.cod_cotacao
            , cotacao_item.lote
            , cotacao_licitacao.cod_item
            , julgamento_vencedor.vl_cotacao
            , catalogo_item.descricao_resumida
            , catalogo_item.descricao
            , julgamento_vencedor.cgm_fornecedor
            , adjudicacao.cod_documento
            , adjudicacao.cod_tipo_documento
            , homologacao.homologado
            , homologacao.motivo
            , adjudicacao.adjudicado
            , adjudicacao.num_adjudicacao_anulada
            , adjudicacao.motivo
            , homologacao.motivo
            , mapa_item.exercicio
            , mapa_item.cod_mapa
            , unidade_medida.nom_unidade
            , cotacao_item.quantidade
            order by cotacao_licitacao.cod_item
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
