<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\Ordem;

class OrdemRepository extends ORM\EntityRepository
{
    public function getEmpenhoInfo($empenho)
    {
        list($codEmpenho, $exercicio, $codEntidade) = explode('~', $empenho);

        $sql = "
            SELECT
              tabela.*
            from
              (
                select
                  empenho.cod_empenho,
                  empenho.exercicio as exercicio_empenho,
                  empenho.cod_entidade,
                  sw_cgm.nom_cgm as entidade,
                  case
                    when item_pre_empenho_julgamento.cod_mapa is null then pre_empenho.cgm_beneficiario
                    else item_pre_empenho_julgamento.cgm_fornecedor
                  end as cgm_fornecedor,
                  case
                    when item_pre_empenho_julgamento.cod_mapa is null then cgm_beneficiario.nom_cgm
                    else item_pre_empenho_julgamento.nom_cgm
                  end as fornecedor,
                  pre_empenho.cod_pre_empenho,
                  empenho.fn_consultar_valor_empenhado(
                    pre_empenho.exercicio,
                    empenho.cod_empenho,
                    empenho.cod_entidade
                  ) as vl_empenhado,
                  empenho.fn_consultar_valor_empenhado_anulado(
                    pre_empenho.exercicio,
                    empenho.cod_empenho,
                    empenho.cod_entidade
                  ) as vl_empenhado_anulado,
                  empenho.fn_consultar_valor_liquidado(
                    pre_empenho.exercicio,
                    empenho.cod_empenho,
                    empenho.cod_entidade
                  ) as vl_liquidado,
                  empenho.fn_consultar_valor_liquidado_anulado(
                    pre_empenho.exercicio,
                    empenho.cod_empenho,
                    empenho.cod_entidade
                  ) as vl_liquidado_anulado,
                  pre_empenho.cod_pre_empenho
                from
                  empenho.empenho 
                  inner join orcamento.entidade on
                   empenho.cod_entidade = entidade.cod_entidade
                        and empenho.exercicio = entidade.exercicio 
                        inner join sw_cgm_pessoa_juridica on
                  entidade.numcgm = sw_cgm_pessoa_juridica.numcgm 
                  inner join empenho.pre_empenho on
                  empenho.exercicio = pre_empenho.exercicio
                  and empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
                  inner join empenho.pre_empenho_despesa on
                  pre_empenho_despesa.exercicio = pre_empenho.exercicio
                  and pre_empenho_despesa.cod_pre_empenho = pre_empenho.cod_pre_empenho 
                  left join empenho.autorizacao_empenho on
                  autorizacao_empenho.exercicio = pre_empenho.exercicio
                  and autorizacao_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
                  
                  inner join empenho.item_pre_empenho on
                  item_pre_empenho.exercicio = pre_empenho.exercicio
                  and item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
                  
                  inner join sw_cgm as cgm_beneficiario on
                  pre_empenho.cgm_beneficiario = cgm_beneficiario.numcgm left join(
                    select
                      item_pre_empenho_julgamento.*,
                      catalogo_item.cod_tipo
                    from
                      empenho.item_pre_empenho_julgamento 
                      inner join almoxarifado.catalogo_item on
                      item_pre_empenho_julgamento.cod_item = catalogo_item.cod_item
                  ) as julgamento on
                  item_pre_empenho.cod_pre_empenho = julgamento.cod_pre_empenho
                  and item_pre_empenho.exercicio = julgamento.exercicio
                  and item_pre_empenho.num_item = julgamento.num_item left join almoxarifado.catalogo_item on
                  item_pre_empenho.cod_item = catalogo_item.cod_item left join
                  (
                    select
                      item_pre_empenho_julgamento.*,
                      case
                        when item_pre_empenho_julgamento.cod_item is not null then true
                        else false
                      end as bo_compras_licitacao,
                      mapa.exercicio as exercicio_mapa,
                      mapa.cod_mapa,
                      sw_cgm.nom_cgm
                    from
                      empenho.item_pre_empenho_julgamento 
                      inner join almoxarifado.catalogo_item on
                      item_pre_empenho_julgamento.cod_item = catalogo_item.cod_item
                      -- and catalogo_item.cod_tipo <> 3 
                      inner join compras.julgamento_item on
                      item_pre_empenho_julgamento.exercicio_julgamento = julgamento_item.exercicio
                      and item_pre_empenho_julgamento.cod_cotacao = julgamento_item.cod_cotacao
                      and item_pre_empenho_julgamento.cod_item = julgamento_item.cod_item
                      and item_pre_empenho_julgamento.lote = julgamento_item.lote
                      and item_pre_empenho_julgamento.cgm_fornecedor = julgamento_item.cgm_fornecedor
                      and julgamento_item.ordem = 1 
                      inner join sw_cgm on
                      julgamento_item.cgm_fornecedor = sw_cgm.numcgm 
                      inner join 
                      (
                        select
                          cotacao.*
                        from
                          compras.cotacao left join compras.cotacao_anulada on
                          cotacao.exercicio = cotacao_anulada.exercicio
                          and cotacao.cod_cotacao = cotacao_anulada.cod_cotacao
                        where
                          cotacao_anulada.cod_cotacao is null
                      ) as cotacao on
                      item_pre_empenho_julgamento.cod_cotacao = cotacao.cod_cotacao
                      and item_pre_empenho_julgamento.exercicio = cotacao.exercicio 
                      inner join compras.mapa_cotacao on
                      cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
                      and cotacao.exercicio = mapa_cotacao.exercicio_cotacao 
                      inner join compras.mapa on
                      mapa_cotacao.exercicio_mapa = mapa.exercicio
                      and mapa_cotacao.cod_mapa = mapa.cod_mapa
                  ) as item_pre_empenho_julgamento on
                  item_pre_empenho.cod_pre_empenho = item_pre_empenho_julgamento.cod_pre_empenho
                  and item_pre_empenho.exercicio = item_pre_empenho_julgamento.exercicio
                  and item_pre_empenho.num_item = item_pre_empenho_julgamento.num_item left join
                  (
                    select
                      compra_direta.*
                    from
                      compras.compra_direta left join compras.compra_direta_anulacao on
                      compra_direta_anulacao.cod_modalidade = compra_direta.cod_modalidade
                      and compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
                      and compra_direta_anulacao.cod_entidade = compra_direta.cod_entidade
                      and compra_direta_anulacao.cod_compra_direta = compra_direta.cod_compra_direta
                    where
                      compra_direta_anulacao.cod_compra_direta is null
                  ) as compra_direta on
                  item_pre_empenho_julgamento.exercicio_mapa = compra_direta.exercicio_mapa
                  and item_pre_empenho_julgamento.cod_mapa = compra_direta.cod_mapa left join
                  (
                    select
                      licitacao.*
                    from
                      licitacao.licitacao left join licitacao.licitacao_anulada on
                      licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
                      and licitacao_anulada.exercicio = licitacao.exercicio
                      and licitacao_anulada.cod_entidade = licitacao.cod_entidade
                      and licitacao_anulada.cod_licitacao = licitacao.cod_licitacao
                    where
                      licitacao_anulada.cod_licitacao is null
                  ) as licitacao on
                  item_pre_empenho_julgamento.exercicio_mapa = licitacao.exercicio_mapa
                  and item_pre_empenho_julgamento.cod_mapa = licitacao.cod_mapa left join licitacao.edital on
                  licitacao.cod_licitacao = edital.cod_licitacao
                  and licitacao.cod_modalidade = edital.cod_modalidade
                  and licitacao.cod_entidade = edital.cod_entidade
                  and licitacao.exercicio = edital.exercicio_licitacao left join licitacao.participante on
                  licitacao.cod_licitacao = participante.cod_licitacao
                  and licitacao.cod_entidade = participante.cod_entidade
                  and licitacao.exercicio = participante.exercicio left join compras.objeto as objeto_licitacao on
                  licitacao.cod_objeto = objeto_licitacao.cod_objeto left join compras.objeto as objeto_compra_direta on
                  compra_direta.cod_objeto = objeto_compra_direta.cod_objeto 
                  left join compras.modalidade as modalidade_licitacao on
                  licitacao.cod_modalidade = modalidade_licitacao.cod_modalidade 
                  left join compras.modalidade as modalidade_compra_direta on
                  compra_direta.cod_modalidade = modalidade_compra_direta.cod_modalidade
                  left join sw_cgm as sw_cgm on 
                  sw_cgm.numcgm = entidade.numcgm
                where
                  (
                    --SE FOR LICITAÇÃO OU COMPRA DIRETA
                    (
                      licitacao.cod_licitacao is not null
                      or compra_direta.cod_compra_direta is not null
                    ) 
                    --OU NÃO POSSUI MAPA E COD_ITEM EM PRE_EMPENHO É NULO
             --OU NÃO POSSUI MAPA E O TIPO DE ITEM DO PRE_EMPENHO É IGUAL AO TIPO DE ORDEM(COMPRA OU SERVIÇO)
                    or(
                      (
                        item_pre_empenho_julgamento.cod_mapa is null
                        and julgamento.cod_item is null
                      )
                      and(
                        (
                          item_pre_empenho.cod_item is not null
                          and catalogo_item.cod_tipo is not null
                          -- and catalogo_item.cod_tipo <> 3
                        )
                        or(
                          item_pre_empenho.cod_item is null
                        )
                      )
                    )
                  )
                  and empenho.cod_empenho = {$codEmpenho}
                  and empenho.exercicio = '{$exercicio}'
                  and empenho.cod_entidade = {$codEntidade}
                  and item_pre_empenho.num_item = 1
                group by
                  item_pre_empenho.cod_pre_empenho,
                  empenho.cod_empenho,
                  empenho.exercicio,
                  empenho.cod_entidade,
                  sw_cgm_pessoa_juridica.nom_fantasia,
                  pre_empenho_despesa.cod_despesa,
                  empenho.dt_empenho,
                  empenho.dt_vencimento,
                  licitacao.cod_licitacao,
                  compra_direta.cod_compra_direta,
                  licitacao.exercicio,
                  licitacao.cod_objeto,
                  compra_direta.cod_objeto,
                  objeto_licitacao.descricao,
                  licitacao.cod_modalidade,
                  modalidade_licitacao.descricao,
                  edital.condicoes_pagamento,
                  edital.local_entrega_material,
                  licitacao.cod_licitacao,
                  item_pre_empenho_julgamento.cgm_fornecedor,
                  item_pre_empenho_julgamento.nom_cgm,
                  objeto_compra_direta.descricao,
                  compra_direta.cod_modalidade,
                  modalidade_compra_direta.descricao,
                  compra_direta.condicoes_pagamento,
                  pre_empenho.exercicio,
                  pre_empenho.cgm_beneficiario,
                  cgm_beneficiario.nom_cgm,
                  item_pre_empenho_julgamento.cod_mapa,
                  item_pre_empenho_julgamento.exercicio_mapa,
                  pre_empenho.cod_pre_empenho,
                  sw_cgm.nom_cgm
                  -- NÃO PODE LISTAR OS EMPENHOS QUE JÁ ESTÃO COM TODOS OS ITENS USADOS POR ALGUMA ORDEM DE COMPRA
                having
                  (
                    select
                      sum( coalesce( item_pre_empenho.quantidade, 0 ) ) - coalesce(
                        (
                          select
                            sum( ordem_item.quantidade )
                          from
                            compras.ordem 
                            inner join compras.ordem_item on
                            ordem_item.exercicio = ordem.exercicio
                            and ordem_item.cod_entidade = ordem.cod_entidade
                            and ordem_item.cod_ordem = ordem.cod_ordem
                            and ordem_item.tipo = ordem.tipo
                          where
                            not exists(
                              select
                                1
                              from
                                compras.ordem_item_anulacao
                              where
                                ordem_item_anulacao.exercicio = ordem_item.exercicio
                                and ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                                and ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                                and ordem_item_anulacao.num_item = ordem_item.num_item
                                and ordem_item_anulacao.cod_pre_empenho = ordem_item.cod_pre_empenho
                                and ordem_item_anulacao.tipo = ordem_item.tipo
                            )
                            and ordem.exercicio_empenho = empenho.exercicio
                            and ordem.cod_entidade = empenho.cod_entidade
                            and ordem.cod_empenho = empenho.cod_empenho
                        ),
                        0
                      )
                  ) > 0 -- PARA NÃO PEGAR OS EMPENHOS TOTALMENTE ANULADOS
                  and(
                    sum( item_pre_empenho.vl_total ) - coalesce(
                      (
                        select
                          sum( empenho_anulado_item.vl_anulado )
                        from
                          empenho.empenho_anulado_item
                        where
                          empenho_anulado_item.exercicio = empenho.exercicio
                          and empenho_anulado_item.cod_entidade = empenho.cod_entidade
                          and empenho_anulado_item.cod_empenho = empenho.cod_empenho
                      ),
                      0.00
                    )
                  ) > 0.00
                order by
                  empenho.cod_empenho desc,
                  empenho.exercicio,
                  empenho.cod_entidade,
                  empenho.cod_empenho
              ) as tabela
            where
              (
                tabela.vl_empenhado - tabela.vl_empenhado_anulado
              ) >(
                tabela.vl_liquidado - tabela.vl_liquidado_anulado
              );
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $params
     * @param $limit
     * @return array
     */
    public function getEmpenhosAtivos($exercicio, $params, $limit)
    {
        $sql = "
          SELECT
            tabela.*
          from
            (
              select
                /*DISTINCT*/
                empenho.cod_empenho,
                empenho.exercicio as exercicio_empenho,
                empenho.cod_entidade,
                empenho.fn_consultar_valor_empenhado(
                  pre_empenho.exercicio,
                  empenho.cod_empenho,
                  empenho.cod_entidade
                ) as vl_empenhado,
                empenho.fn_consultar_valor_empenhado_anulado(
                  pre_empenho.exercicio,
                  empenho.cod_empenho,
                  empenho.cod_entidade
                ) as vl_empenhado_anulado,
                empenho.fn_consultar_valor_liquidado(
                  pre_empenho.exercicio,
                  empenho.cod_empenho,
                  empenho.cod_entidade
                ) as vl_liquidado,
                empenho.fn_consultar_valor_liquidado_anulado(
                  pre_empenho.exercicio,
                  empenho.cod_empenho,
                  empenho.cod_entidade
                ) as vl_liquidado_anulado
              from
                empenho.empenho inner join orcamento.entidade on
                empenho.cod_entidade = entidade.cod_entidade
                and empenho.exercicio = entidade.exercicio inner join sw_cgm_pessoa_juridica on
                entidade.numcgm = sw_cgm_pessoa_juridica.numcgm inner join empenho.pre_empenho on
                empenho.exercicio = pre_empenho.exercicio
                and empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho inner join empenho.pre_empenho_despesa on
                pre_empenho_despesa.exercicio = pre_empenho.exercicio
                and pre_empenho_despesa.cod_pre_empenho = pre_empenho.cod_pre_empenho left join empenho.autorizacao_empenho on
                autorizacao_empenho.exercicio = pre_empenho.exercicio
                and autorizacao_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho inner join empenho.item_pre_empenho on
                item_pre_empenho.exercicio = pre_empenho.exercicio
                and item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
                inner join almoxarifado.marca on item_pre_empenho.cod_marca = marca.cod_marca inner join sw_cgm as cgm_beneficiario on
                pre_empenho.cgm_beneficiario = cgm_beneficiario.numcgm left join(
                  select
                    item_pre_empenho_julgamento.*,
                    catalogo_item.cod_tipo
                  from
                    empenho.item_pre_empenho_julgamento inner join almoxarifado.catalogo_item on
                    item_pre_empenho_julgamento.cod_item = catalogo_item.cod_item
                ) as julgamento on
                item_pre_empenho.cod_pre_empenho = julgamento.cod_pre_empenho
                and item_pre_empenho.exercicio = julgamento.exercicio
                and item_pre_empenho.num_item = julgamento.num_item left join almoxarifado.catalogo_item on
                item_pre_empenho.cod_item = catalogo_item.cod_item left join(
                  select
                    item_pre_empenho_julgamento.*,
                    case
                      when item_pre_empenho_julgamento.cod_item is not null then true
                      else false
                    end as bo_compras_licitacao,
                    mapa.exercicio as exercicio_mapa,
                    mapa.cod_mapa,
                    sw_cgm.nom_cgm
                  from
                    empenho.item_pre_empenho_julgamento inner join almoxarifado.catalogo_item on
                    item_pre_empenho_julgamento.cod_item = catalogo_item.cod_item
                    -- and catalogo_item.cod_tipo <> 3 
                    inner join compras.julgamento_item on
                    item_pre_empenho_julgamento.exercicio_julgamento = julgamento_item.exercicio
                    and item_pre_empenho_julgamento.cod_cotacao = julgamento_item.cod_cotacao
                    and item_pre_empenho_julgamento.cod_item = julgamento_item.cod_item
                    and item_pre_empenho_julgamento.lote = julgamento_item.lote
                    and item_pre_empenho_julgamento.cgm_fornecedor = julgamento_item.cgm_fornecedor
                    and julgamento_item.ordem = 1 inner join sw_cgm on
                    julgamento_item.cgm_fornecedor = sw_cgm.numcgm inner join(
                      select
                        cotacao.*
                      from
                        compras.cotacao left join compras.cotacao_anulada on
                        cotacao.exercicio = cotacao_anulada.exercicio
                        and cotacao.cod_cotacao = cotacao_anulada.cod_cotacao
                      where
                        cotacao_anulada.cod_cotacao is null
                    ) as cotacao on
                    item_pre_empenho_julgamento.cod_cotacao = cotacao.cod_cotacao
                    and item_pre_empenho_julgamento.exercicio = cotacao.exercicio inner join compras.mapa_cotacao on
                    cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
                    and cotacao.exercicio = mapa_cotacao.exercicio_cotacao inner join compras.mapa on
                    mapa_cotacao.exercicio_mapa = mapa.exercicio
                    and mapa_cotacao.cod_mapa = mapa.cod_mapa
                ) as item_pre_empenho_julgamento on
                item_pre_empenho.cod_pre_empenho = item_pre_empenho_julgamento.cod_pre_empenho
                and item_pre_empenho.exercicio = item_pre_empenho_julgamento.exercicio
                and item_pre_empenho.num_item = item_pre_empenho_julgamento.num_item left join(
                  select
                    compra_direta.*
                  from
                    compras.compra_direta left join compras.compra_direta_anulacao on
                    compra_direta_anulacao.cod_modalidade = compra_direta.cod_modalidade
                    and compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
                    and compra_direta_anulacao.cod_entidade = compra_direta.cod_entidade
                    and compra_direta_anulacao.cod_compra_direta = compra_direta.cod_compra_direta
                  where
                    compra_direta_anulacao.cod_compra_direta is null
                ) as compra_direta on
                item_pre_empenho_julgamento.exercicio_mapa = compra_direta.exercicio_mapa
                and item_pre_empenho_julgamento.cod_mapa = compra_direta.cod_mapa left join(
                  select
                    licitacao.*
                  from
                    licitacao.licitacao left join licitacao.licitacao_anulada on
                    licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
                    and licitacao_anulada.exercicio = licitacao.exercicio
                    and licitacao_anulada.cod_entidade = licitacao.cod_entidade
                    and licitacao_anulada.cod_licitacao = licitacao.cod_licitacao
                  where
                    licitacao_anulada.cod_licitacao is null
                ) as licitacao on
                item_pre_empenho_julgamento.exercicio_mapa = licitacao.exercicio_mapa
                and item_pre_empenho_julgamento.cod_mapa = licitacao.cod_mapa left join licitacao.edital on
                licitacao.cod_licitacao = edital.cod_licitacao
                and licitacao.cod_modalidade = edital.cod_modalidade
                and licitacao.cod_entidade = edital.cod_entidade
                and licitacao.exercicio = edital.exercicio_licitacao left join licitacao.participante on
                licitacao.cod_licitacao = participante.cod_licitacao
                and licitacao.cod_entidade = participante.cod_entidade
                and licitacao.exercicio = participante.exercicio left join compras.objeto as objeto_licitacao on
                licitacao.cod_objeto = objeto_licitacao.cod_objeto left join compras.objeto as objeto_compra_direta on
                compra_direta.cod_objeto = objeto_compra_direta.cod_objeto left join compras.modalidade as modalidade_licitacao on
                licitacao.cod_modalidade = modalidade_licitacao.cod_modalidade left join compras.modalidade as modalidade_compra_direta on
                compra_direta.cod_modalidade = modalidade_compra_direta.cod_modalidade
              where
                (
                  --SE FOR LICITAÇÃO OU COMPRA DIRETA
          (
                    licitacao.cod_licitacao is not null
                    or compra_direta.cod_compra_direta is not null
                  ) --OU NÃO POSSUI MAPA E COD_ITEM EM PRE_EMPENHO É NULO
           --OU NÃO POSSUI MAPA E O TIPO DE ITEM DO PRE_EMPENHO É IGUAL AO TIPO DE ORDEM(COMPRA OU SERVIÇO)
                  or(
                    (
                      item_pre_empenho_julgamento.cod_mapa is null
                      and julgamento.cod_item is null
                    )
                    and(
                      (
                        item_pre_empenho.cod_item is not null
                        and catalogo_item.cod_tipo is not null
                        -- and catalogo_item.cod_tipo <> 3
                      )
                      or
                      (
                        item_pre_empenho.cod_item is null
                      )
                    )
                  )
                )
                ";

        if ($exercicio) {
            $sql .= " and empenho.exercicio = '$exercicio'";
        }

        $sql .= "
                and item_pre_empenho.num_item = 1
              group by
                item_pre_empenho.cod_pre_empenho,
                empenho.cod_empenho,
                empenho.exercicio,
                empenho.cod_entidade,
                sw_cgm_pessoa_juridica.nom_fantasia,
                pre_empenho_despesa.cod_despesa,
                empenho.dt_empenho,
                empenho.dt_vencimento,
                licitacao.cod_licitacao,
                compra_direta.cod_compra_direta,
                licitacao.exercicio,
                licitacao.cod_objeto,
                compra_direta.cod_objeto,
                objeto_licitacao.descricao,
                licitacao.cod_modalidade,
                modalidade_licitacao.descricao,
                edital.condicoes_pagamento,
                edital.local_entrega_material,
                licitacao.cod_licitacao,
                item_pre_empenho_julgamento.cgm_fornecedor,
                item_pre_empenho_julgamento.nom_cgm,
                objeto_compra_direta.descricao,
                compra_direta.cod_modalidade,
                modalidade_compra_direta.descricao,
                compra_direta.condicoes_pagamento,
                pre_empenho.exercicio,
                pre_empenho.cgm_beneficiario,
                cgm_beneficiario.nom_cgm,
                item_pre_empenho_julgamento.cod_mapa,
                item_pre_empenho_julgamento.exercicio_mapa,
                pre_empenho.cod_pre_empenho -- NÃO PODE LISTAR OS EMPENHOS QUE JÁ ESTÃO COM TODOS OS ITENS USADOS POR ALGUMA ORDEM DE COMPRA
              having
                (
                  select
                    sum( coalesce( item_pre_empenho.quantidade, 0 ) ) - coalesce(
                      (
                        select
                          sum( ordem_item.quantidade )
                        from
                          compras.ordem inner join compras.ordem_item on
                          ordem_item.exercicio = ordem.exercicio
                          and ordem_item.cod_entidade = ordem.cod_entidade
                          and ordem_item.cod_ordem = ordem.cod_ordem
                          and ordem_item.tipo = ordem.tipo
                        where
                          not exists(
                            select
                              1
                            from
                              compras.ordem_item_anulacao
                            where
                              ordem_item_anulacao.exercicio = ordem_item.exercicio
                              and ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                              and ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                              and ordem_item_anulacao.num_item = ordem_item.num_item
                              and ordem_item_anulacao.cod_pre_empenho = ordem_item.cod_pre_empenho
                              and ordem_item_anulacao.tipo = ordem_item.tipo
                          )
                          and ordem.exercicio_empenho = empenho.exercicio
                          and ordem.cod_entidade = empenho.cod_entidade
                          and ordem.cod_empenho = empenho.cod_empenho
                      ),
                      0
                    )
                ) > 0 -- PARA NÃO PEGAR OS EMPENHOS TOTALMENTE ANULADOS
                and(
                  sum( item_pre_empenho.vl_total ) - coalesce(
                    (
                      select
                        sum( empenho_anulado_item.vl_anulado )
                      from
                        empenho.empenho_anulado_item
                      where
                        empenho_anulado_item.exercicio = empenho.exercicio
                        and empenho_anulado_item.cod_entidade = empenho.cod_entidade
                        and empenho_anulado_item.cod_empenho = empenho.cod_empenho
                    ),
                    0.00
                  )
                ) > 0.00
              order by
                empenho.cod_empenho desc,
                empenho.exercicio,
                empenho.cod_entidade,
                empenho.cod_empenho
            ) as tabela
          where
            (
              tabela.vl_empenhado - tabela.vl_empenhado_anulado
            ) >(
              tabela.vl_liquidado - tabela.vl_liquidado_anulado
            )
            {$params}
            {$limit};
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getItemPreEmpenho($exercicio, $codEmpenho, $codEntidade, $numItem)
    {
        $sql="
          SELECT empenho.cod_empenho
               , pre_empenho.cod_pre_empenho
               , CASE WHEN item_pre_empenho.cod_item IS NOT NULL
                      THEN item_pre_empenho.cod_item 
                      ELSE item_pre_empenho_julgamento.cod_item
                 END AS cod_item
               , item_pre_empenho.num_item
               , item_pre_empenho.nom_item
               , item_pre_empenho.quantidade
               , item_pre_empenho.exercicio
               , ( item_pre_empenho.quantidade - COALESCE(ordem.quantidade,0) ) AS oc_saldo
               , COALESCE(ordem.quantidade,0) AS oc_quantidade_atendido
               , COALESCE(ordem.vl_total,0) AS oc_vl_atendido
               , ROUND(item_pre_empenho.vl_total / item_pre_empenho.quantidade,2) AS vl_unitario
               , ( ROUND( (item_pre_empenho.vl_total - SUM(COALESCE(empenho_anulado_item.vl_anulado,0)) - SUM(COALESCE(nota_liquidacao_item.vl_total,0)) - SUM(COALESCE(nota_liquidacao_item_anulado.vl_anulado,0)))  / item_pre_empenho.quantidade,2 ) * ( item_pre_empenho.quantidade - COALESCE(ordem.quantidade,0) ) ) AS oc_vl_total
               , CASE WHEN item_pre_empenho_julgamento.cod_item IS NULL AND ordem.cod_item IS NULL THEN TRUE
                      ELSE FALSE
                 END AS bo_centro_marca
               
              , CASE WHEN ordem.cod_item IS NULL 
                     THEN catalogo_item.cod_item
                     ELSE ordem.cod_item 
                END AS cod_item_ordem
              , CASE WHEN ordem.cod_marca IS NULL 
                     THEN cotacao_fornecedor_item.cod_marca
                     ELSE ordem.cod_marca 
                END AS cod_marca_ordem
              , CASE WHEN ordem.cod_centro IS NULL 
                     THEN solicitacao_item_dotacao.cod_centro
                     ELSE ordem.cod_centro
                END AS cod_centro_ordem
              , CASE WHEN centro_custo.descricao IS NULL 
                     THEN centro_custo_marca.descricao
                     ELSE centro_custo.descricao
                END AS nom_centro_ordem
              , CASE WHEN marca.descricao IS NULL 
                     THEN marca_ordem.descricao
                     ELSE marca.descricao
                END AS nom_marca_ordem
              , item_pre_empenho.cod_centro AS cod_centro_empenho
              , centro_custo_empenho.descricao AS nom_centro_empenho
  
                FROM empenho.empenho
  
          INNER JOIN empenho.pre_empenho
                  ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                 AND pre_empenho.exercicio       = empenho.exercicio
  
          INNER JOIN empenho.item_pre_empenho
                  ON item_pre_empenho.exercicio       = pre_empenho.exercicio
                 AND item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
                 
          LEFT JOIN empenho.pre_empenho_despesa
                 ON pre_empenho_despesa.exercicio       = item_pre_empenho.exercicio       
                AND pre_empenho_despesa.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
  
           LEFT JOIN empenho.item_pre_empenho_julgamento
                  ON item_pre_empenho_julgamento.exercicio       = item_pre_empenho.exercicio
                 AND item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                 AND item_pre_empenho_julgamento.num_item        = item_pre_empenho.num_item
  
           LEFT JOIN empenho.empenho_anulado_item
                  ON empenho_anulado_item.exercicio       = item_pre_empenho.exercicio
                 AND empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                 AND empenho_anulado_item.num_item        = item_pre_empenho.num_item
  
           LEFT JOIN empenho.nota_liquidacao_item
                  ON nota_liquidacao_item.exercicio       = item_pre_empenho.exercicio
                 AND nota_liquidacao_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                 AND nota_liquidacao_item.num_item        = item_pre_empenho.num_item
  
           LEFT JOIN empenho.nota_liquidacao_item_anulado
                  ON nota_liquidacao_item_anulado.exercicio       = nota_liquidacao_item.exercicio
                 AND nota_liquidacao_item_anulado.cod_nota        = nota_liquidacao_item.cod_nota
                 AND nota_liquidacao_item_anulado.num_item        = nota_liquidacao_item.num_item
                 AND nota_liquidacao_item_anulado.exercicio_item  = nota_liquidacao_item.exercicio_item
                 AND nota_liquidacao_item_anulado.cod_pre_empenho = nota_liquidacao_item.cod_pre_empenho
                 AND nota_liquidacao_item_anulado.cod_entidade    = nota_liquidacao_item.cod_entidade
          
           LEFT JOIN  (  SELECT  SUM( ordem_item.quantidade - COALESCE(ordem_item_anulacao.quantidade,0) ) AS quantidade
                              ,  SUM( ordem_item.vl_total - COALESCE(ordem_item_anulacao.vl_total,0) ) AS vl_total
                              ,  ordem.exercicio_empenho
                              ,  ordem.cod_empenho
                              ,  ordem.cod_entidade
                              ,  ordem_item.num_item
                              ,  ordem_item.cod_item
                              ,  ordem_item.cod_marca
                              ,  ordem_item.cod_centro
                           FROM  compras.ordem
                     INNER JOIN  compras.ordem_item
                             ON  ordem_item.exercicio = ordem.exercicio
                            AND  ordem_item.cod_entidade = ordem.cod_entidade
                            AND  ordem_item.cod_ordem = ordem.cod_ordem
                            AND  ordem_item.tipo = ordem.tipo
                      LEFT JOIN  compras.ordem_item_anulacao
                             ON  ordem_item_anulacao.exercicio = ordem_item.exercicio
                            AND  ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                            AND  ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                            AND  ordem_item_anulacao.num_item = ordem_item.num_item
                            AND  ordem_item_anulacao.cod_pre_empenho = ordem_item.cod_pre_empenho
                            AND  ordem_item_anulacao.tipo = ordem_item.tipo
                          WHERE  NOT EXISTS (SELECT 1
                                               FROM compras.ordem_anulacao
                                              WHERE ordem_anulacao.exercicio = ordem.exercicio
                                                AND ordem_anulacao.cod_entidade = ordem.cod_entidade
                                                AND ordem_anulacao.cod_ordem = ordem.cod_ordem
                                                AND ordem_anulacao.tipo = ordem.tipo
                                              )
                       GROUP BY  ordem.exercicio_empenho, ordem.cod_empenho, ordem.cod_entidade, ordem_item.num_item, ordem_item.cod_item, ordem_item.cod_marca, ordem_item.cod_centro 
                   ) AS ordem
                  ON ordem.exercicio_empenho = empenho.exercicio
                 AND ordem.cod_empenho       = empenho.cod_empenho
                 AND ordem.cod_entidade      = empenho.cod_entidade
                 AND ordem.num_item          = item_pre_empenho.num_item
                 
          LEFT JOIN almoxarifado.catalogo_item
                  ON item_pre_empenho_julgamento.cod_item = catalogo_item.cod_item 
                  OR ( item_pre_empenho.cod_item = catalogo_item.cod_item AND item_pre_empenho_julgamento.cod_item IS NULL)
  
           LEFT JOIN almoxarifado.marca
                  ON marca.cod_marca = ordem.cod_marca
  
           LEFT JOIN almoxarifado.centro_custo
                  ON centro_custo.cod_centro = ordem.cod_centro
  
           LEFT JOIN almoxarifado.centro_custo AS centro_custo_empenho
                  ON centro_custo_empenho.cod_centro = item_pre_empenho.cod_centro
                  
           LEFT JOIN compras.mapa_item_dotacao
                  ON mapa_item_dotacao.exercicio   = item_pre_empenho_julgamento.exercicio                 
                 AND mapa_item_dotacao.cod_item    = item_pre_empenho_julgamento.cod_item   
                 AND mapa_item_dotacao.cod_despesa = pre_empenho_despesa.cod_despesa
                 AND mapa_item_dotacao.exercicio   = pre_empenho_despesa.exercicio
                 
           LEFT JOIN compras.solicitacao_item_dotacao
                  ON solicitacao_item_dotacao.exercicio       = mapa_item_dotacao.exercicio_solicitacao
                 AND solicitacao_item_dotacao.cod_entidade    = mapa_item_dotacao.cod_entidade    
                 AND solicitacao_item_dotacao.cod_solicitacao = mapa_item_dotacao.cod_solicitacao 
                 AND solicitacao_item_dotacao.cod_centro      = mapa_item_dotacao.cod_centro      
                 AND solicitacao_item_dotacao.cod_item        = mapa_item_dotacao.cod_item            
                 AND solicitacao_item_dotacao.cod_conta       = mapa_item_dotacao.cod_conta       
                 AND solicitacao_item_dotacao.cod_despesa     = mapa_item_dotacao.cod_despesa 
  
           LEFT JOIN compras.julgamento_item
                  ON julgamento_item.exercicio      = item_pre_empenho_julgamento.exercicio_julgamento
                 AND julgamento_item.cod_cotacao    = item_pre_empenho_julgamento.cod_cotacao
                 AND julgamento_item.cod_item       = item_pre_empenho_julgamento.cod_item
                 AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
                 AND julgamento_item.lote           = item_pre_empenho_julgamento.lote
  
           LEFT JOIN compras.cotacao_fornecedor_item
                  ON cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
                 AND cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
                 AND cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
                 AND cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
                 AND cotacao_fornecedor_item.lote           = julgamento_item.lote
  
           LEFT JOIN almoxarifado.catalogo_item_marca
                  ON catalogo_item_marca.cod_item  = cotacao_fornecedor_item.cod_item
                 AND catalogo_item_marca.cod_marca = cotacao_fornecedor_item.cod_marca
  
           LEFT JOIN almoxarifado.centro_custo AS centro_custo_marca
                  ON centro_custo_marca.cod_centro = solicitacao_item_dotacao.cod_centro
  
           LEFT JOIN almoxarifado.marca AS marca_ordem
                  ON marca_ordem.cod_marca = cotacao_fornecedor_item.cod_marca                                   
               WHERE empenho.cod_empenho  = $codEmpenho
                 AND empenho.exercicio    = '$exercicio'
                 AND empenho.cod_entidade = $codEntidade
                 AND item_pre_empenho.num_item = 1
                  AND (item_pre_empenho.quantidade - COALESCE(ordem.quantidade,0)) > 0
                  AND (item_pre_empenho.vl_total - (COALESCE(nota_liquidacao_item.vl_total,0) - COALESCE(nota_liquidacao_item_anulado.vl_anulado,0)) > 0)
                  AND (ROUND( ( item_pre_empenho.vl_total - COALESCE(empenho_anulado_item.vl_anulado,0 ) ) / item_pre_empenho.quantidade,2 ) > 0)
  
            GROUP BY empenho.cod_empenho
                   , pre_empenho.cod_pre_empenho
                   , item_pre_empenho.cod_item
                   , item_pre_empenho_julgamento.cod_item
                   , item_pre_empenho.num_item
                   , item_pre_empenho.nom_item
                   , item_pre_empenho.quantidade
                   , item_pre_empenho.exercicio
                   , item_pre_empenho.vl_total
                   , ordem.quantidade
                   , ordem.vl_total
                   , ordem.cod_item
                   , ordem.cod_marca
                   , ordem.cod_centro
                   , centro_custo.descricao
                   , marca.descricao
                   , item_pre_empenho.cod_centro
                   , centro_custo_empenho.descricao
                   , catalogo_item.cod_item
                   , cotacao_fornecedor_item.cod_marca
                   , solicitacao_item_dotacao.cod_centro
                   , centro_custo_marca.descricao
                   , marca_ordem.descricao
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getItemPreEmpenhoInfos($exercicio, $codPreEmpenho, $numItem)
    {
        $sql = "
          SELECT   item_pre_empenho.num_item
                   ,  item_pre_empenho.cod_pre_empenho
                   ,  item_pre_empenho.exercicio
                   ,  CASE WHEN ( catalogo_item.descricao is null )
                           THEN empenho_diverso.descricao
                           ELSE catalogo_item.descricao
                      END AS descricao
                   ,  CASE WHEN ( julgada.nom_unidade is null )
                           THEN empenho_diverso.nom_unidade
                           ELSE julgada.nom_unidade
                      END AS nom_unidade
                   ,  CASE WHEN ( julgada.nom_grandeza is null )
                           THEN empenho_diverso.nom_grandeza
                           ELSE julgada.nom_grandeza
                      END AS nom_grandeza
                   ,  CASE WHEN ( julgada.cod_item is null )
                           THEN item_pre_empenho.cod_item
                           ELSE julgada.cod_item
                      END AS cod_item
                   ,  CASE WHEN julgada.cod_item IS NOT NULL THEN FALSE
                           WHEN ordem_item.cod_centro IS NULL AND ordem_item.cod_marca IS NULL THEN TRUE
                           ELSE FALSE
                      END AS bo_centro_marca
                   ,CASE WHEN ordem_item.cod_item IS NULL 
                          THEN julgada.cod_item
                          ELSE ordem_item.cod_item
                    END AS cod_item_ordem
                   ,CASE WHEN ordem_item.cod_marca IS NULL 
                          THEN julgada.cod_marca
                          ELSE ordem_item.cod_marca
                    END AS cod_marca_ordem
                   ,CASE WHEN ordem_item.cod_centro IS NULL 
                          THEN julgada.cod_centro
                          ELSE ordem_item.cod_centro
                    END AS cod_centro_ordem
                   ,CASE WHEN centro_custo.descricao IS NULL 
                          THEN julgada.descricao_centro_custo
                          ELSE centro_custo.descricao
                    END AS nom_centro_ordem
                   ,CASE WHEN marca.descricao IS NULL 
                          THEN julgada.descricao_marca_ordem
                          ELSE marca.descricao
                   END AS nom_marca_ordem
                   ,  item_pre_empenho.cod_centro AS cod_centro_empenho
                   ,  centro_custo_empenho.descricao AS nom_centro_empenho
                   ,  julgada.cod_centro AS cod_centro_solicitacao
                FROM  empenho.pre_empenho
          INNER JOIN  empenho.item_pre_empenho
                  ON  item_pre_empenho.exercicio = pre_empenho.exercicio
                 AND  item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
           LEFT JOIN  ( SELECT  item_pre_empenho_julgamento.exercicio
                               ,  item_pre_empenho_julgamento.cod_pre_empenho
                               ,  item_pre_empenho_julgamento.num_item
                               ,  item_pre_empenho_julgamento.cgm_fornecedor
                               ,  catalogo_item.cod_item
                               ,  catalogo_item.descricao
                               ,  unidade_medida.nom_unidade
                               ,  grandeza.nom_grandeza
                               ,  solicitacao_item.cod_centro
                               , cotacao_fornecedor_item.cod_marca
                               , centro_custo.descricao AS descricao_centro_custo
                               , marca.descricao as descricao_marca_ordem
                            FROM  empenho.item_pre_empenho_julgamento
                      INNER JOIN  almoxarifado.catalogo_item
                              ON  catalogo_item.cod_item = item_pre_empenho_julgamento.cod_item
                      INNER JOIN  administracao.unidade_medida
                              ON  unidade_medida.cod_unidade = catalogo_item.cod_unidade
                             AND  unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
                      INNER JOIN  administracao.grandeza
                              ON  grandeza.cod_grandeza = catalogo_item.cod_grandeza
                       LEFT JOIN  compras.julgamento_item
                              ON  julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
                             AND  julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
                             AND  julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
                             AND  julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
                             AND  julgamento_item.lote = item_pre_empenho_julgamento.lote
  
                       LEFT JOIN  compras.mapa_cotacao
                              ON  mapa_cotacao.exercicio_cotacao = julgamento_item.exercicio
                             AND  mapa_cotacao.cod_cotacao = julgamento_item.cod_cotacao
  
                       LEFT JOIN  compras.mapa_solicitacao
                              ON  mapa_solicitacao.exercicio = mapa_cotacao.exercicio_mapa
                             AND  mapa_solicitacao.cod_mapa = mapa_cotacao.cod_mapa
  
                       LEFT JOIN  compras.solicitacao_item
                              ON  solicitacao_item.exercicio = mapa_solicitacao.exercicio_solicitacao
                             AND  solicitacao_item.cod_entidade = mapa_solicitacao.cod_entidade
                             AND  solicitacao_item.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                             AND  solicitacao_item.cod_item = julgamento_item.cod_item
  
                       LEFT JOIN compras.cotacao_fornecedor_item
                           ON cotacao_fornecedor_item.exercicio           = julgamento_item.exercicio
                          AND cotacao_fornecedor_item.cod_cotacao         = julgamento_item.cod_cotacao
                          AND cotacao_fornecedor_item.cod_item            = julgamento_item.cod_item
                          AND cotacao_fornecedor_item.cgm_fornecedor      = julgamento_item.cgm_fornecedor
                          AND cotacao_fornecedor_item.lote                = julgamento_item.lote
  
                       LEFT JOIN almoxarifado.catalogo_item_marca
                          ON catalogo_item_marca.cod_item         = cotacao_fornecedor_item.cod_item
                          AND catalogo_item_marca.cod_marca       = cotacao_fornecedor_item.cod_marca
                       
                       LEFT JOIN almoxarifado.centro_custo
                              ON centro_custo.cod_centro = solicitacao_item.cod_centro
                       
                       LEFT JOIN almoxarifado.marca
                          ON  marca.cod_marca = cotacao_fornecedor_item.cod_marca
  
                      ) AS julgada
                  ON  julgada.exercicio = item_pre_empenho.exercicio
                 AND  julgada.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                 AND  julgada.num_item = item_pre_empenho.num_item
                 AND  julgada.cgm_fornecedor = pre_empenho.cgm_beneficiario
  
           LEFT JOIN  ( SELECT  item_pre_empenho.exercicio
                               ,  item_pre_empenho.cod_pre_empenho
                               ,  item_pre_empenho.num_item
                               ,  item_pre_empenho.nom_item AS descricao
                               ,  unidade_medida.nom_unidade
                               ,  grandeza.nom_grandeza
                            FROM  empenho.item_pre_empenho
                      INNER JOIN  administracao.unidade_medida
                              ON  unidade_medida.cod_unidade = item_pre_empenho.cod_unidade
                             AND  unidade_medida.cod_grandeza = item_pre_empenho.cod_grandeza
                      INNER JOIN  administracao.grandeza
                              ON  grandeza.cod_grandeza = item_pre_empenho.cod_grandeza
                      ) AS empenho_diverso
                  ON  empenho_diverso.exercicio = item_pre_empenho.exercicio
                 AND  empenho_diverso.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                 AND  empenho_diverso.num_item = item_pre_empenho.num_item
  
          INNER JOIN  empenho.empenho
                  ON  pre_empenho.exercicio = empenho.exercicio
                 AND  pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
  
           LEFT JOIN  ( SELECT ordem_item.cod_item
                             , ordem_item.cod_marca
                             , ordem_item.cod_centro
                             , ordem_item.cod_entidade
                             , ordem_item.num_item
                             , ordem.cod_empenho
                             , ordem.exercicio_empenho
                          FROM compras.ordem
                    INNER JOIN compras.ordem_item
                            ON ordem_item.exercicio = ordem.exercicio
                           AND ordem_item.cod_entidade = ordem.cod_entidade
                           AND ordem_item.cod_ordem = ordem.cod_ordem
                           AND ordem_item.tipo = ordem.tipo
                     LEFT JOIN compras.ordem_item_anulacao
                            ON ordem_item_anulacao.exercicio = ordem_item.exercicio
                           AND ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                           AND ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                           AND ordem_item_anulacao.exercicio_pre_empenho = ordem_item.exercicio_pre_empenho
                           AND ordem_item_anulacao.cod_pre_empenho = ordem_item.cod_pre_empenho
                           AND ordem_item_anulacao.num_item = ordem_item.num_item
                           AND ordem_item_anulacao.tipo = ordem_item.tipo
                         WHERE ordem_item_anulacao.num_item IS NULL
                      GROUP BY ordem_item.cod_item
                             , ordem_item.cod_marca
                             , ordem_item.cod_centro
                             , ordem_item.cod_entidade
                             , ordem_item.num_item
                             , ordem.cod_empenho
                             , ordem.exercicio_empenho
                   )  AS ordem_item
                  ON  ordem_item.cod_empenho = empenho.cod_empenho
                 AND  ordem_item.exercicio_empenho = empenho.exercicio
                 AND  ordem_item.cod_entidade = empenho.cod_entidade
                 AND  ordem_item.num_item = item_pre_empenho.num_item
                 
           LEFT JOIN  almoxarifado.catalogo_item
                  ON  catalogo_item.cod_item = julgada.cod_item
                  OR  (catalogo_item.cod_item = item_pre_empenho.cod_item AND julgada.cod_item IS NULL)   
                  OR  (catalogo_item.cod_item = ordem_item.cod_item AND item_pre_empenho.cod_item IS NULL AND julgada.cod_item IS NULL)
  
           LEFT JOIN  almoxarifado.marca
                  ON  marca.cod_marca = ordem_item.cod_marca
  
           LEFT JOIN  almoxarifado.centro_custo
                  ON  centro_custo.cod_centro = ordem_item.cod_centro
  
           LEFT JOIN  almoxarifado.centro_custo as centro_custo_empenho
                  ON  centro_custo_empenho.cod_centro = item_pre_empenho.cod_centro
  
               WHERE  pre_empenho.exercicio = '$exercicio'
                 AND  pre_empenho.cod_pre_empenho = $codPreEmpenho
                 AND  item_pre_empenho.num_item = 1
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function updateItemPreEmpenho($params)
    {
        $sql = "
          UPDATE 
            empenho.item_pre_empenho 
          SET
            cod_item = ".$params['codItem'].",
            cod_centro = ".$params['codCentro'].",
            cod_marca = ".$params['codMarca']."
          WHERE
            cod_item_pre_empenho = ".$params['codItemPreEmpenho']."
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        return $query->execute();
    }

    /**
     * @param Ordem $ordem
     */
    public function removeOrdemItem($ordem)
    {
        $sql = "
            DELETE FROM compras.ordem_item
            WHERE exercicio = '{$ordem->getExercicio()}'
                AND cod_ordem = {$ordem->getCodOrdem()}
                AND cod_entidade = {$ordem->getCodEntidade()}
                AND tipo = '{$ordem->getTipo()}';";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
    }

    /**
     * @param string $exercicio
     * @throws \Doctrine\DBAL\DBALException
     * @return array
     */
    public function listaEntradaComprasOrdem($exercicio)
    {
        $sql = "
            SELECT
              ordem.cod_ordem,
              ordem.exercicio,
              ordem.cod_autorizacao || '/' || ordem.exercicio AS cod_autorizacao,
              ordem.cod_empenho,
              ordem.cod_entidade,
              ordem.nom_entidade,
              ordem.exercicio_empenho,
              ordem.cgm_beneficiario,
              ordem.nom_cgm,
              TO_CHAR(ordem.timestamp, 'dd/mm/yyyy')          AS dt_ordem,
              SUM(ordem.vl_total)                             AS vl_total
            FROM (SELECT
                    pre_empenho.cgm_beneficiario,
                    ordem_item.exercicio,
                    ordem_item.cod_entidade,
                    entidade_cgm.nom_cgm       AS nom_entidade,
                    ordem_item.cod_ordem,
                    autorizacao_empenho.cod_autorizacao,
                    ordem.cod_empenho,
                    ordem.exercicio_empenho,
                    ordem.timestamp,
                    ordem.tipo,
                    fornecedor.nom_cgm,
                    SUM(ordem_item.vl_total)   AS vl_total,
                    SUM(ordem_item.quantidade) AS quantidade
                  FROM compras.ordem
                    INNER JOIN compras.ordem_item
                      ON ordem_item.exercicio = ordem.exercicio
                         AND ordem_item.cod_entidade = ordem.cod_entidade
                         AND ordem_item.cod_ordem = ordem.cod_ordem
                         AND ordem_item.tipo = ordem.tipo
                    INNER JOIN orcamento.entidade
                      ON entidade.exercicio = ordem_item.exercicio
                         AND entidade.cod_entidade = ordem.cod_entidade
                    INNER JOIN public.sw_cgm AS entidade_cgm
                      ON entidade_cgm.numcgm = entidade.numcgm
                    INNER JOIN empenho.item_pre_empenho
                      ON item_pre_empenho.exercicio = ordem.exercicio_empenho
                         AND item_pre_empenho.cod_pre_empenho = ordem_item.cod_pre_empenho
                         AND item_pre_empenho.num_item = ordem_item.num_item
                    INNER JOIN empenho.pre_empenho
                      ON pre_empenho.exercicio = item_pre_empenho.exercicio
                         AND pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                    LEFT JOIN empenho.autorizacao_empenho
                      ON pre_empenho.exercicio = autorizacao_empenho.exercicio
                         AND pre_empenho.cod_pre_empenho = autorizacao_empenho.cod_pre_empenho
                         AND autorizacao_empenho.cod_entidade = ordem.cod_entidade
                    INNER JOIN empenho.empenho
                      ON empenho.exercicio = pre_empenho.exercicio
                         AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
                         AND empenho.cod_entidade = ordem.cod_entidade
                    LEFT JOIN empenho.empenho_anulado_item
                      ON empenho_anulado_item.exercicio = item_pre_empenho.exercicio
                         AND empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                         AND empenho_anulado_item.cod_entidade = ordem.cod_entidade
                         AND empenho_anulado_item.num_item = item_pre_empenho.num_item
                    INNER JOIN public.sw_cgm AS fornecedor
                      ON fornecedor.numcgm = pre_empenho.cgm_beneficiario
                  WHERE ordem.tipo = 'C'
                        AND (ROUND((item_pre_empenho.vl_total - COALESCE(empenho_anulado_item.vl_anulado, 0)) /
                                   item_pre_empenho.quantidade, 2) > 0)
                  GROUP BY pre_empenho.cgm_beneficiario
                    , ordem_item.exercicio
                    , ordem_item.cod_entidade
                    , entidade_cgm.nom_cgm
                    , ordem_item.cod_ordem
                    , ordem.cod_empenho
                    , autorizacao_empenho.cod_autorizacao
                    , ordem.exercicio_empenho
                    , ordem.timestamp
                    , ordem.tipo
                    , fornecedor.nom_cgm
                 ) AS ordem
            WHERE NOT EXISTS(SELECT 1
                             FROM compras.ordem_anulacao
                             WHERE ordem_anulacao.exercicio = ordem.exercicio
                                   AND ordem_anulacao.cod_entidade = ordem.cod_entidade
                                   AND ordem_anulacao.cod_ordem = ordem.cod_ordem
                                   AND ordem_anulacao.tipo = ordem.tipo
                  )
                  AND ordem.exercicio = :exercicio
            GROUP BY ordem.cod_ordem
              , ordem.exercicio
              , ordem.cod_entidade
              , ordem.tipo
              , ordem.nom_entidade
              , ordem.cod_autorizacao
              , ordem.cod_empenho
              , ordem.exercicio_empenho
              , ordem.cgm_beneficiario
              , ordem.nom_cgm
              , ordem.timestamp
            HAVING (
                     SUM(ordem.quantidade)
                     - coalesce((
                                  SELECT SUM(lancamento_material.quantidade)
                                  FROM compras.nota_fiscal_fornecedor
                                    , almoxarifado.natureza_lancamento
                                    , almoxarifado.lancamento_material
                                    , compras.nota_fiscal_fornecedor_ordem
                                  WHERE nota_fiscal_fornecedor.exercicio_lancamento = natureza_lancamento.exercicio_lancamento
                                        AND nota_fiscal_fornecedor.num_lancamento = natureza_lancamento.num_lancamento
                                        AND nota_fiscal_fornecedor.cod_natureza = natureza_lancamento.cod_natureza
                                        AND nota_fiscal_fornecedor.tipo_natureza = natureza_lancamento.tipo_natureza
                                        AND natureza_lancamento.exercicio_lancamento = lancamento_material.exercicio_lancamento
                                        AND natureza_lancamento.num_lancamento = lancamento_material.num_lancamento
                                        AND natureza_lancamento.cod_natureza = lancamento_material.cod_natureza
                                        AND natureza_lancamento.tipo_natureza = lancamento_material.tipo_natureza
                                        AND nota_fiscal_fornecedor.cod_nota = nota_fiscal_fornecedor_ordem.cod_nota
                                        AND nota_fiscal_fornecedor.cgm_fornecedor = nota_fiscal_fornecedor_ordem.cgm_fornecedor
                                        AND nota_fiscal_fornecedor_ordem.exercicio = ordem.exercicio
                                        AND nota_fiscal_fornecedor_ordem.tipo = ordem.tipo
                                        AND nota_fiscal_fornecedor_ordem.cod_entidade = ordem.cod_entidade
                                        AND nota_fiscal_fornecedor_ordem.cod_ordem = ordem.cod_ordem
                                ), 0.00)
                   ) > 0
            ORDER BY ordem.cod_ordem, ordem.exercicio;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute(['exercicio' => $exercicio]);
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getValorAtendido($exercicio, $codEntidade)
    {
        $sql = "
         SELECT SUM(lancamento_material.valor_mercado) as vl_total_atendido
	                     FROM compras.ordem
	               INNER JOIN compras.nota_fiscal_fornecedor_ordem
	                       ON nota_fiscal_fornecedor_ordem.cod_ordem = ordem.cod_ordem
	                      AND nota_fiscal_fornecedor_ordem.exercicio = ordem.exercicio_empenho
	                      AND nota_fiscal_fornecedor_ordem.cod_entidade = ordem.cod_entidade
	                      AND nota_fiscal_fornecedor_ordem.tipo = ordem.tipo
	               INNER JOIN compras.nota_fiscal_fornecedor
	                       ON nota_fiscal_fornecedor_ordem.cod_nota = nota_fiscal_fornecedor.cod_nota
	                      AND nota_fiscal_fornecedor_ordem.cgm_fornecedor = nota_fiscal_fornecedor.cgm_fornecedor
	               INNER JOIN almoxarifado.natureza_lancamento
	                       ON natureza_lancamento.exercicio_lancamento = nota_fiscal_fornecedor.exercicio_lancamento
	                      AND natureza_lancamento.num_lancamento = nota_fiscal_fornecedor.num_lancamento
	                      AND natureza_lancamento.cod_natureza = nota_fiscal_fornecedor.cod_natureza
	                      AND natureza_lancamento.tipo_natureza = nota_fiscal_fornecedor.tipo_natureza
	               INNER JOIN almoxarifado.lancamento_material
	                       ON lancamento_material.exercicio_lancamento = natureza_lancamento.exercicio_lancamento
	                      AND lancamento_material.num_lancamento = natureza_lancamento.num_lancamento
	                      AND lancamento_material.cod_natureza = natureza_lancamento.cod_natureza
	                      AND lancamento_material.tipo_natureza = natureza_lancamento.tipo_natureza
	               WHERE ordem.tipo = 'C'  AND ordem.exercicio = '".$exercicio."'
	 AND ordem.cod_entidade IN ( $codEntidade )
	 AND ordem.cod_ordem = 1
	 GROUP BY ordem.cod_ordem, ordem.exercicio;

        ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param string $tipo
     * @param string $exercicio
     * @param int $codOrdem
     * @param int $codEntidade
     * @param int|null $codItem
     * @return array|object
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaItensNotaOrdemCompra($tipo, $exercicio, $codOrdem, $codEntidade, $codItem = null)
    {
        $sql = "
        SELECT ordem_item.exercicio
                 , ordem_item.cod_entidade
                 , ordem_item.cod_ordem
                 , ordem_item.cod_pre_empenho
                 , ordem_item.num_item
                 , ordem.exercicio_empenho
                 , item_pre_empenho.nom_item
                 , unidade_medida.nom_unidade
                 , centro_custo.cod_centro
                 , centro_custo.nom_centro
                 , centro_custo.cod_item
                 , catalogo.ativo
                 , ( ordem_item.quantidade - COALESCE(ordem_item_anulacao.quantidade,0) ) AS solicitado_oc
                 , COALESCE(lancamento_material.quantidade, 0) AS atendido_oc
                 , ( ordem_item.quantidade - COALESCE(ordem_item_anulacao.quantidade,0) ) - (COALESCE(lancamento_material.quantidade, 0)) AS qtde_disponivel_oc
                 , ((item_pre_empenho.vl_total - COALESCE(SUM(empenho_anulado_item.vl_anulado),0))/ item_pre_empenho.quantidade) as vl_empenhado
            FROM compras.ordem
            INNER JOIN compras.ordem_item
                    ON ordem_item.cod_entidade = ordem.cod_entidade
                   AND ordem_item.exercicio = ordem.exercicio
                   AND ordem_item.cod_ordem = ordem.cod_ordem
                   AND ordem_item.tipo      = ordem.tipo
            LEFT JOIN compras.ordem_item_anulacao
                    ON ordem_item_anulacao.exercicio = ordem_item.exercicio
                   AND ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                   AND ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                   AND ordem_item_anulacao.num_item = ordem_item.num_item
                   AND ordem_item_anulacao.tipo = ordem_item.tipo
            INNER JOIN empenho.item_pre_empenho
                    ON item_pre_empenho.exercicio = ordem.exercicio_empenho
                   AND item_pre_empenho.cod_pre_empenho = ordem_item.cod_pre_empenho
                   AND item_pre_empenho.num_item = ordem_item.num_item
            LEFT JOIN empenho.empenho_anulado_item
                    ON empenho_anulado_item.exercicio = item_pre_empenho.exercicio
                   AND empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                   AND empenho_anulado_item.cod_entidade = ordem.cod_entidade
                   AND empenho_anulado_item.num_item = item_pre_empenho.num_item
            LEFT JOIN (SELECT item_pre_empenho_julgamento.exercicio
                             , item_pre_empenho_julgamento.cod_pre_empenho
                             , item_pre_empenho_julgamento.num_item
                             , item_pre_empenho_julgamento.cod_item
                             , centro_custo.cod_centro
                             , centro_custo.descricao AS nom_centro
                          FROM empenho.item_pre_empenho_julgamento
                    INNER JOIN compras.julgamento_item
                            ON julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
                           AND julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
                           AND julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
                           AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
                           AND julgamento_item.lote = item_pre_empenho_julgamento.lote
                    INNER JOIN compras.mapa_cotacao
                            ON mapa_cotacao.cod_cotacao = julgamento_item.cod_cotacao
                           AND mapa_cotacao.exercicio_cotacao = julgamento_item.exercicio
                    INNER JOIN compras.mapa_item
                            ON mapa_item.exercicio = mapa_cotacao.exercicio_mapa
                           AND mapa_item.cod_mapa = mapa_cotacao.cod_mapa
                           AND mapa_item.cod_item = julgamento_item.cod_item
                    INNER JOIN almoxarifado.centro_custo
                            ON centro_custo.cod_centro = mapa_item.cod_centro
                         WHERE julgamento_item.ordem = 1
                     UNION ALL
                        SELECT ordem_item.exercicio
                             , ordem_item.cod_pre_empenho
                             , ordem_item.num_item
                             , ordem_item.cod_item
                             , centro_custo.cod_centro
                             , centro_custo.descricao AS nom_centro
                          FROM compras.ordem_item
                     LEFT JOIN compras.ordem_item_anulacao
                            ON ordem_item_anulacao.exercicio = ordem_item.exercicio
                           AND ordem_item_anulacao.cod_entidade = ordem_item.cod_entidade
                           AND ordem_item_anulacao.cod_ordem = ordem_item.cod_ordem
                           AND ordem_item_anulacao.exercicio_pre_empenho = ordem_item.exercicio_pre_empenho
                           AND ordem_item_anulacao.cod_pre_empenho = ordem_item.cod_pre_empenho
                           AND ordem_item_anulacao.num_item = ordem_item.num_item
                           AND ordem_item_anulacao.tipo = ordem_item.tipo
                     LEFT JOIN empenho.item_pre_empenho_julgamento
                            ON item_pre_empenho_julgamento.exercicio = ordem_item.exercicio
                           AND item_pre_empenho_julgamento.cod_pre_empenho = ordem_item.cod_pre_empenho
                           AND item_pre_empenho_julgamento.num_item = ordem_item.num_item
                    INNER JOIN almoxarifado.centro_custo
                            ON centro_custo.cod_centro = ordem_item.cod_centro
                         WHERE ordem_item_anulacao.cod_ordem IS NULL
                           AND item_pre_empenho_julgamento.num_item IS NULL
                           AND ordem_item.tipo = :tipo
                      GROUP BY ordem_item.exercicio
                             , ordem_item.cod_pre_empenho
                             , ordem_item.num_item
                             , ordem_item.cod_item
                             , centro_custo.cod_centro
                             , centro_custo.descricao
                       ) AS  centro_custo
                    ON centro_custo.exercicio = item_pre_empenho.exercicio
                   AND centro_custo.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                   AND centro_custo.num_item = item_pre_empenho.num_item
            LEFT JOIN ( SELECT cod_item
                              , ativo
                           FROM almoxarifado.catalogo_item
                       ) as catalogo
                    ON ( catalogo.cod_item = centro_custo.cod_item )
            LEFT JOIN ( 	SELECT lancamento_material.cod_item
                                 , SUM( lancamento_material.quantidade ) AS quantidade
                                 , nota_fiscal_fornecedor_ordem.exercicio AS exercicio
                                 , nota_fiscal_fornecedor_ordem.cod_ordem
                                 , nota_fiscal_fornecedor_ordem.cod_entidade
                              FROM compras.nota_fiscal_fornecedor
                        INNER JOIN almoxarifado.lancamento_material
                                ON lancamento_material.exercicio_lancamento = nota_fiscal_fornecedor.exercicio_lancamento
                               AND lancamento_material.cod_natureza         = nota_fiscal_fornecedor.cod_natureza
                               AND lancamento_material.tipo_natureza        = nota_fiscal_fornecedor.tipo_natureza
                               AND lancamento_material.num_lancamento       = nota_fiscal_fornecedor.num_lancamento
                        INNER JOIN almoxarifado.catalogo_item
                                ON catalogo_item.cod_item = lancamento_material.cod_item
                        INNER JOIN compras.nota_fiscal_fornecedor_ordem
                                ON nota_fiscal_fornecedor_ordem.cod_nota = nota_fiscal_fornecedor.cod_nota
                               AND nota_fiscal_fornecedor_ordem.cgm_fornecedor = nota_fiscal_fornecedor.cgm_fornecedor
                          GROUP BY lancamento_material.cod_item
                                 , nota_fiscal_fornecedor_ordem.exercicio
                                 , nota_fiscal_fornecedor_ordem.cod_ordem
                                 , nota_fiscal_fornecedor_ordem.cod_entidade
                      ) AS lancamento_material
                    ON lancamento_material.exercicio    = ordem.exercicio
                   AND lancamento_material.cod_ordem    = ordem.cod_ordem
                   AND lancamento_material.cod_entidade = ordem.cod_entidade
                   AND lancamento_material.cod_item     = centro_custo.cod_item
            INNER JOIN administracao.unidade_medida
                    ON unidade_medida.cod_grandeza = item_pre_empenho.cod_grandeza
                   AND unidade_medida.cod_unidade = item_pre_empenho.cod_unidade
            WHERE (ROUND( ( item_pre_empenho.vl_total - COALESCE(empenho_anulado_item.vl_anulado,0 ) ) / item_pre_empenho.quantidade,2 ) > 0)
                   AND ordem.exercicio = :exercicio
                   AND ordem.cod_ordem = :cod_ordem
                   AND ordem.cod_entidade = :cod_entidade
                   AND ordem.tipo = :tipo
        ";

        $params = [
            'exercicio' => $exercicio,
            'cod_ordem' => $codOrdem,
            'cod_entidade' => $codEntidade,
            'tipo' => $tipo
        ];

        if ($codItem) {
            $sql .= " AND centro_custo.cod_item = :cod_item ";
            $params['cod_item'] = $codItem;
        }

        $conn = $this->_em->getConnection();

        $sql .= "GROUP BY ordem_item.exercicio
            , ordem_item.cod_entidade
            , ordem_item.cod_ordem
            , ordem_item.cod_pre_empenho
            , ordem_item.num_item
            , ordem.exercicio_empenho
            , item_pre_empenho.nom_item
            , unidade_medida.nom_unidade
            , centro_custo.cod_centro
            , centro_custo.nom_centro
            , centro_custo.cod_item
            , ordem_item.quantidade
            , ordem_item_anulacao.quantidade
            , lancamento_material.quantidade
            , item_pre_empenho.vl_total
            , catalogo.ativo
            , item_pre_empenho.quantidade;";

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaComprasOrdem($paramsWhere)
    {
        $sql = sprintf(
            "select * from compras.ordem WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
