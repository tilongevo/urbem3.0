<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class SolicitacaoAnulacaoRepository extends ORM\EntityRepository
{
    public function getSolicitacoesParaAnulacao()
    {
        $sql = "
            -- QUERY RESPONSAVEL POR TRAZER TODAS AS SOLICITAÇÕES DE COMPRAS PARA A ANULAÇÃO
            select
                *
            from
                (
                    select
                        solicitacao.exercicio,
                        solicitacao.cod_solicitacao,
                        TO_CHAR(
                            solicitacao.timestamp,
                            'dd/mm/yyyy'
                        ) as data,
                        solicitacao.cod_objeto,
                        solicitacao.cod_entidade,
                        sw_cgm.nom_cgm,
                        sw_cgm.numcgm,
                        solicitacao.timestamp,
                        (
                            (
                                select
                                    sum( quantidade )
                                from
                                    compras.solicitacao_item
                                where
                                    compras.solicitacao.cod_solicitacao = compras.solicitacao_item.cod_solicitacao
                                    and solicitacao_item.exercicio = '2016'
                            ) -(
                                select
                                    coalesce(
                                        sum( quantidade ),
                                        0.0
                                    )
                                from
                                    compras.solicitacao_item_anulacao
                                where
                                    compras.solicitacao.cod_solicitacao = compras.solicitacao_item_anulacao.cod_solicitacao
                                    and solicitacao_item_anulacao.exercicio = '2016'
                            ) -(
                                select
                                    coalesce(
                                        sum( quantidade ),
                                        0.0
                                    )
                                from
                                    compras.mapa_item
                                where
                                    compras.solicitacao.cod_solicitacao = compras.mapa_item.cod_solicitacao
                                    and mapa_item.exercicio_solicitacao = '2016'
                            ) +(
                                select
                                    coalesce(
                                        sum( quantidade ),
                                        0.0
                                    )
                                from
                                    compras.mapa_item_anulacao
                                where
                                    compras.solicitacao.cod_solicitacao = compras.mapa_item_anulacao.cod_solicitacao
                                    and mapa_item_anulacao.exercicio_solicitacao = '2016'
                            )
                        ) as qtd_saldo,
                        mapa_solicitacao.cod_mapa,
                        mapa_item.cod_centro,
                        mapa_item.cod_item,
                        mapa_item.lote
                    from
                        orcamento.entidade,
                        sw_cgm,
                        compras.solicitacao join compras.solicitacao_item on
                        (
                            solicitacao.exercicio = solicitacao_item.exercicio
                            and solicitacao.cod_entidade = solicitacao_item.cod_entidade
                            and solicitacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                        ) left join compras.solicitacao_item_anulacao on
                        (
                            solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                            and solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
                            and solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                            and solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                            and solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
                        ) left join compras.mapa_item on
                        (
                            mapa_item.exercicio = solicitacao_item_anulacao.exercicio
                            and mapa_item.cod_entidade = solicitacao_item_anulacao.cod_entidade
                            and mapa_item.cod_solicitacao = solicitacao_item_anulacao.cod_solicitacao
                            and mapa_item.cod_centro = solicitacao_item_anulacao.cod_centro
                            and mapa_item.cod_item = solicitacao_item_anulacao.cod_item
                        ) left join compras.mapa_solicitacao on
                        (
                            mapa_solicitacao.exercicio = mapa_item.exercicio
                            and mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
                            and mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
                            and mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
                            and mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                        )
                    where
                        entidade.cod_entidade = solicitacao.cod_entidade
                        and entidade.exercicio = '2016'
                        and sw_cgm.numcgm = entidade.numcgm
                    group by
                        solicitacao.exercicio,
                        solicitacao.cod_entidade,
                        solicitacao.cod_solicitacao,
                        data,
                        solicitacao.cod_objeto,
                        sw_cgm.nom_cgm,
                        sw_cgm.numcgm,
                        solicitacao.timestamp,
                        mapa_solicitacao.cod_mapa,
                        mapa_item.cod_centro,
                        mapa_item.cod_item,
                        mapa_item.lote
                ) as solicitacao
            where
                qtd_saldo > 0
                and solicitacao.exercicio = '2016'
                and(
                    not exists(
                        select
                            *
                        from
                            compras.solicitacao_homologada
                        where
                            solicitacao_homologada.exercicio = solicitacao.exercicio
                            and solicitacao_homologada.cod_entidade = solicitacao.cod_entidade
                            and solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao
                    )
                    or exists(
                        select
                            *
                        from
                            compras.solicitacao_homologada_anulacao
                        where
                            solicitacao_homologada_anulacao.exercicio = solicitacao.exercicio
                            and solicitacao_homologada_anulacao.cod_entidade = solicitacao.cod_entidade
                            and solicitacao_homologada_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                    )
                    or exists(
                        select
                            *
                        from
                            compras.mapa_solicitacao_anulacao
                        where
                            mapa_solicitacao_anulacao.exercicio = solicitacao.exercicio
                            and mapa_solicitacao_anulacao.cod_mapa = solicitacao.cod_mapa
                            and mapa_solicitacao_anulacao.exercicio_solicitacao = solicitacao.exercicio
                            and mapa_solicitacao_anulacao.cod_entidade = solicitacao.cod_entidade
                            and mapa_solicitacao_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                    )
                )
                and not exists(
                    select
                        *
                    from
                        compras.mapa_item_anulacao
                    where
                        mapa_item_anulacao.exercicio = solicitacao.exercicio
                        and mapa_item_anulacao.cod_entidade = solicitacao.cod_entidade
                        and mapa_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                        and mapa_item_anulacao.cod_mapa = solicitacao.cod_mapa
                        and mapa_item_anulacao.cod_centro = solicitacao.cod_centro
                        and mapa_item_anulacao.cod_item = solicitacao.cod_item
                        and mapa_item_anulacao.exercicio_solicitacao = solicitacao.exercicio
                        and mapa_item_anulacao.lote = solicitacao.lote
                )
                and solicitacao.exercicio = '2016';
        ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
