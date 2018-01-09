<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\MapaSolicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;

class MapaItemRepository extends ORM\EntityRepository
{
    /**
     * @param bool|int        $codSolicitacao
     * @param bool|int        $codEntidade
     * @param bool|string|int $exercicio
     * @param bool|int        $codItem
     * @param bool|int        $codCentro
     *
     * @return array
     */
    public function montaRecuperaIncluirSolicitacaoMapa($codSolicitacao = false, $codEntidade = false, $exercicio = false, $codItem = false, $codCentro = false)
    {
        $sql = <<<SQL
SELECT *
FROM
  (SELECT
     solicitacao_item.cod_solicitacao,
     solicitacao_item.exercicio                                               AS exercicio_solicitacao,
     solicitacao_item.cod_entidade,
     solicitacao_item.cod_item,
     catalogo_item.descricao                                                  AS nom_item,
     unidade_medida.nom_unidade,
     solicitacao_item.complemento,
     solicitacao_item.cod_centro,
     centro_custo.descricao                                                   AS centro_custo,
     coalesce(solicitacao_item_dotacao.vl_reserva, 0.00)                      AS vl_total,
     CASE
     WHEN solicitacao_item_dotacao IS NOT NULL
       THEN coalesce((solicitacao_item_dotacao.vl_reserva / solicitacao_item_dotacao.quantidade),
                     0.00) :: NUMERIC(14, 4)
     ELSE coalesce((solicitacao_item.vl_total / solicitacao_item.quantidade), 0.00) :: NUMERIC(14, 4)
     END                                                                      AS valor_unitario,
     CASE
     WHEN solicitacao_item_dotacao.cod_despesa IS NULL
       THEN (SELECT coalesce(sum(solicitacao_item_anulacao.vl_total), 0.00) AS vl_total
             FROM
               compras.solicitacao_item_anulacao
             WHERE
               solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
               AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item)
     ELSE (SELECT coalesce(sum(solicitacao_item_dotacao_anulacao.vl_anulacao), 0.00) AS vl_total
           FROM
             compras.solicitacao_item_dotacao_anulacao
           WHERE
             solicitacao_item_dotacao_anulacao.exercicio = solicitacao_item_dotacao.exercicio
             AND solicitacao_item_dotacao_anulacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
             AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
             AND solicitacao_item_dotacao_anulacao.cod_centro = solicitacao_item_dotacao.cod_centro
             AND solicitacao_item_dotacao_anulacao.cod_item = solicitacao_item_dotacao.cod_item
             AND solicitacao_item_dotacao_anulacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
             AND solicitacao_item_dotacao_anulacao.cod_conta = solicitacao_item_dotacao.cod_conta)
     END                                                                      AS valor_anulado,
     CASE
     WHEN solicitacao_item_dotacao.cod_despesa IS NULL
       THEN coalesce(solicitacao_item.quantidade, 0.00)
     ELSE coalesce(solicitacao_item_dotacao.quantidade, 0.00)
     END                                                                      AS quantidade,
     CASE
     WHEN solicitacao_item_dotacao.cod_despesa IS NULL
       THEN (SELECT coalesce(sum(solicitacao_item_anulacao.quantidade), 0.00) AS quantidade
             FROM
               compras.solicitacao_item_anulacao
             WHERE
               solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
               AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item)
     ELSE (SELECT coalesce(sum(solicitacao_item_dotacao_anulacao.quantidade), 0.00) AS quantidade
           FROM
             compras.solicitacao_item_dotacao_anulacao
           WHERE
             solicitacao_item_dotacao_anulacao.exercicio = solicitacao_item_dotacao.exercicio
             AND solicitacao_item_dotacao_anulacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
             AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
             AND solicitacao_item_dotacao_anulacao.cod_centro = solicitacao_item_dotacao.cod_centro
             AND solicitacao_item_dotacao_anulacao.cod_item = solicitacao_item_dotacao.cod_item
             AND solicitacao_item_dotacao_anulacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
             AND solicitacao_item_dotacao_anulacao.cod_conta = solicitacao_item_dotacao.cod_conta)
     END                                                                      AS quantidade_anulada,
     (SELECT coalesce(sum(lancamento_material.quantidade), 0.0) AS quantidade
      FROM
        almoxarifado.estoque_material
        INNER JOIN almoxarifado.lancamento_material ON
                                                      lancamento_material.cod_item = estoque_material.cod_item
                                                      AND lancamento_material.cod_marca = estoque_material.cod_marca
                                                      AND lancamento_material.cod_almoxarifado =
                                                          estoque_material.cod_almoxarifado
                                                      AND lancamento_material.cod_centro = estoque_material.cod_centro
      WHERE
        solicitacao_item.cod_item = estoque_material.cod_item
        AND solicitacao_item.cod_centro = estoque_material.cod_centro
        AND solicitacao.cod_almoxarifado = estoque_material.cod_almoxarifado) AS quantidade_estoque,
     reserva_saldos.cod_reserva,
     coalesce(reserva_saldos.vl_reserva, 0.00)                                AS vl_reserva,
     reserva_saldos.exercicio                                                 AS exercicio_reserva,
     despesa.cod_despesa                                                      AS cod_despesa,
     conta_despesa.descricao                                                  AS dotacao_nom_conta,
     desdobramento.cod_conta                                                  AS cod_conta,
     desdobramento.cod_estrutural,
     desdobramento.descricao                                                  AS nom_conta
   FROM
     compras.solicitacao_item
     INNER JOIN compras.solicitacao ON
                                      solicitacao.exercicio = solicitacao_item.exercicio
                                      AND solicitacao.cod_entidade = solicitacao_item.cod_entidade
                                      AND solicitacao.cod_solicitacao = solicitacao_item.cod_solicitacao
     INNER JOIN almoxarifado.catalogo_item ON
                                             solicitacao_item.cod_item = catalogo_item.cod_item
     INNER JOIN administracao.unidade_medida ON
                                               catalogo_item.cod_unidade = unidade_medida.cod_unidade
                                               AND catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
     INNER JOIN almoxarifado.centro_custo ON
                                            solicitacao_item.cod_centro = centro_custo.cod_centro
     LEFT JOIN compras.solicitacao_item_dotacao ON
                                                  solicitacao_item_dotacao.exercicio = solicitacao_item.exercicio
                                                  AND
                                                  solicitacao_item_dotacao.cod_entidade = solicitacao_item.cod_entidade
                                                  AND solicitacao_item_dotacao.cod_solicitacao =
                                                      solicitacao_item.cod_solicitacao
                                                  AND solicitacao_item_dotacao.cod_centro = solicitacao_item.cod_centro
                                                  AND solicitacao_item_dotacao.cod_item = solicitacao_item.cod_item
     --  BUSCANDO A RESERVA DE SALDOS
     LEFT JOIN compras.solicitacao_homologada_reserva ON
                                                        solicitacao_item_dotacao.exercicio =
                                                        solicitacao_homologada_reserva.exercicio
                                                        AND solicitacao_item_dotacao.cod_entidade =
                                                            solicitacao_homologada_reserva.cod_entidade
                                                        AND solicitacao_item_dotacao.cod_solicitacao =
                                                            solicitacao_homologada_reserva.cod_solicitacao
                                                        AND solicitacao_item_dotacao.cod_centro =
                                                            solicitacao_homologada_reserva.cod_centro
                                                        AND solicitacao_item_dotacao.cod_item =
                                                            solicitacao_homologada_reserva.cod_item
                                                        AND solicitacao_item_dotacao.cod_despesa =
                                                            solicitacao_homologada_reserva.cod_despesa
                                                        AND solicitacao_item_dotacao.cod_conta =
                                                            solicitacao_homologada_reserva.cod_conta
     --  BUSCANDO A DOTACAO
     LEFT JOIN orcamento.despesa ON
                                   solicitacao_item_dotacao.exercicio = despesa.exercicio
                                   AND solicitacao_item_dotacao.cod_despesa = despesa.cod_despesa
     --  BUSCANDO O DESDOBRAMENTO
     LEFT JOIN orcamento.conta_despesa ON
                                         conta_despesa.exercicio = despesa.exercicio
                                         AND conta_despesa.cod_conta = despesa.cod_conta
     LEFT JOIN orcamento.conta_despesa AS desdobramento ON
                                                          desdobramento.exercicio = solicitacao_item_dotacao.exercicio
                                                          AND
                                                          desdobramento.cod_conta = solicitacao_item_dotacao.cod_conta
     LEFT JOIN orcamento.reserva_saldos ON
                                          solicitacao_homologada_reserva.cod_reserva = reserva_saldos.cod_reserva
                                          AND solicitacao_homologada_reserva.exercicio = reserva_saldos.exercicio
SQL;
        $parameters = [];
        $where = [];

        if (false != $codSolicitacao) {
            $parameters[] = $codSolicitacao;
            $where[] = "solicitacao_item.cod_solicitacao = ?";
        }

        if (false != $codEntidade) {
            $parameters[] = $codEntidade;
            $where[] = "solicitacao_item.cod_entidade = ?";
        }

        if (false != $exercicio) {
            $parameters[] = $exercicio;
            $where[] = "solicitacao_item.exercicio = ?";
        }

        if (false != $codItem) {
            $parameters[] = $codItem;
            $where[] = "solicitacao_item.cod_item = ?";
        }

        if (false != $codCentro) {
            $parameters[] = $codCentro;
            $where[] = "solicitacao_item.cod_centro = ?";
        }

        $where = count($where) > 0 ? sprintf(' WHERE %s', implode(' AND ', $where)) : '';

        $sql .=  $where . ') AS solicitacao_item WHERE (quantidade - quantidade_anulada) > 0;';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($parameters);
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function montaRecuperaItensMapa($exercicio = false, $codMapa = false)
    {
        $sql = "
        select solicitacao_item.exercicio as exercicio_solicitacao
         , solicitacao_item.cod_entidade
         , solicitacao_item.cod_solicitacao
         , solicitacao_item.cod_item
         , catalogo_item.descricao as item
         , unidade_medida.nom_unidade
         , unidade_medida.cod_unidade
         , solicitacao_item.complemento
         , solicitacao_item.cod_centro
         , centro_custo.descricao as centro_custo
         , despesa.cod_despesa     as dotacao
         , conta_despesa.descricao as dotacao_nom_conta
         , desdobramento.cod_conta  as conta_despesa
         , desdobramento.descricao  as nom_conta
         , desdobramento.cod_estrutural
         --- quantidades/valores
         , solicitacao_item.quantidade as quantidade_solicitada
          ----- quantidade do mapa - anulação
         , mapa_item.quantidade  - coalesce( anulacao_mapa.quantidade  , 0 ) as quantidade_mapa
         , mapa_item.exercicio
         , mapa_item.lote
         --- quantidade atendida para o item neste e em outros mapas
        , ( solicitacao_item.quantidade -  total_mapas.quantidade + ( mapa_item.quantidade - coalesce( anulacao_mapa.quantidade, 0 ) ) ) as quantidade_maxima
         --- reserva de saldos
         , reserva_saldos.cod_reserva
         , reserva_saldos.exercicio as exercicio_reserva
         , coalesce(reserva_saldos.vl_reserva, 0.00) as vl_reserva
         , coalesce( (  SELECT sum(lancamento_material.quantidade) as quantidade
                          FROM almoxarifado.estoque_material
                          JOIN almoxarifado.lancamento_material
                            on ( lancamento_material.cod_item         = estoque_material.cod_item
                           AND   lancamento_material.cod_marca        = estoque_material.cod_marca
                           AND   lancamento_material.cod_almoxarifado = estoque_material.cod_almoxarifado
                           AND   lancamento_material.cod_centro       = estoque_material.cod_centro )
                         where solicitacao_item.cod_item    = estoque_material.cod_item
                           AND solicitacao_item.cod_centro  = estoque_material.cod_centro
                           AND solicitacao.cod_almoxarifado = estoque_material.cod_almoxarifado )
                       , 0.0 ) as quantidade_estoque
          , mapa_item.vl_total - coalesce ( anulacao_mapa.vl_total, 0 )   as valor_total_mapa
          , reserva_solicitacao.cod_reserva as cod_reserva_solicitacao
          , reserva_solicitacao.exercicio   as exercicio_reserva_solicitacao
          , reserva_solicitacao.vl_reserva  as vl_reserva_solicitacao
      from compras.solicitacao_item
      join compras.solicitacao
        on ( solicitacao.exercicio       = solicitacao_item.exercicio
       and   solicitacao.cod_entidade    = solicitacao_item.cod_entidade
       and   solicitacao.cod_solicitacao = solicitacao_item.cod_solicitacao)
      join almoxarifado.catalogo_item
        on ( solicitacao_item.cod_item = catalogo_item.cod_item )
      join administracao.unidade_medida
        on ( catalogo_item.cod_unidade  = unidade_medida.cod_unidade
       and   catalogo_item.cod_grandeza = unidade_medida.cod_grandeza )
      join almoxarifado.centro_custo
        on ( solicitacao_item.cod_centro = centro_custo.cod_centro )
      join compras.mapa_item
        on ( solicitacao_item.exercicio       = mapa_item.exercicio
       and   solicitacao_item.cod_entidade    = mapa_item.cod_entidade
       and   solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
       and   solicitacao_item.cod_centro      = mapa_item.cod_centro
       and   solicitacao_item.cod_item        = mapa_item.cod_item )
      join (select mapa_item.exercicio
                 , mapa_item.cod_entidade
                 , mapa_item.cod_solicitacao
                 , mapa_item.cod_centro
                 , mapa_item.cod_item
                 , sum ( mapa_item.quantidade ) as quantidade
            from compras.mapa_item
            group by mapa_item.exercicio
                   , mapa_item.cod_entidade
                   , mapa_item.cod_solicitacao
                   , mapa_item.cod_centro
                   , mapa_item.cod_item
           ) as total_mapas

        on ( total_mapas.exercicio       = solicitacao_item.exercicio       and   total_mapas.cod_entidade    = solicitacao_item.cod_entidade
       and   total_mapas.cod_solicitacao = solicitacao_item.cod_solicitacao
       and   total_mapas.cod_centro      = solicitacao_item.cod_centro
       and   total_mapas.cod_item        = solicitacao_item.cod_item )

     left join (  select solicitacao_homologada_reserva.exercicio
                         , solicitacao_homologada_reserva.cod_entidade
                         , solicitacao_homologada_reserva.cod_solicitacao
                         , solicitacao_homologada_reserva.cod_centro
                         , solicitacao_homologada_reserva.cod_item
                         , reserva_saldos.cod_reserva
                         , reserva_saldos.cod_despesa
                         , reserva_saldos.vl_reserva
                      from compras.solicitacao_homologada_reserva
                      join orcamento.reserva_saldos
                        on ( reserva_saldos.cod_reserva = solicitacao_homologada_reserva.cod_reserva
                       and   reserva_saldos.exercicio   = solicitacao_homologada_reserva.exercicio )
                      where not exists ( select 1
                                           from orcamento.reserva_saldos_anulada
                                          where reserva_saldos_anulada.cod_reserva = reserva_saldos.cod_reserva
                                            and reserva_saldos_anulada.exercicio   = reserva_saldos.exercicio )
                  ) as reserva_solicitacao
              on ( reserva_solicitacao.exercicio       = solicitacao_item.exercicio
             and   reserva_solicitacao.cod_entidade    = solicitacao_item.cod_entidade
             and   reserva_solicitacao.cod_solicitacao = solicitacao_item.cod_solicitacao
             and   reserva_solicitacao.cod_centro      = solicitacao_item.cod_centro
             and   reserva_solicitacao.cod_item        = solicitacao_item.cod_item  )

       left join compras.solicitacao_item_dotacao
              on ( solicitacao_item_dotacao.exercicio       = solicitacao_item.exercicio
               and solicitacao_item_dotacao.cod_entidade    = solicitacao_item.cod_entidade
               and solicitacao_item_dotacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               and solicitacao_item_dotacao.cod_centro      = solicitacao_item.cod_centro
               and solicitacao_item_dotacao.cod_item        = solicitacao_item.cod_item )
       --- buscando a dotacao
       left join orcamento.despesa
              on ( solicitacao_item_dotacao.exercicio   = despesa.exercicio
             and   solicitacao_item_dotacao.cod_despesa = despesa.cod_despesa )
       left join orcamento.conta_despesa
              on ( conta_despesa.exercicio    = despesa.exercicio
             AND   conta_despesa.cod_conta    = despesa.cod_conta )
       ---- buscando o desdobramento
       left join orcamento.conta_despesa as desdobramento
       on (    desdobramento.exercicio    = solicitacao_item_dotacao.exercicio
           AND desdobramento.cod_conta    = solicitacao_item_dotacao.cod_conta )

       ---- buscando a reserva de saldos
       left join compras.mapa_item_reserva
                   on ( mapa_item.exercicio               = mapa_item_reserva.exercicio_mapa
                  and   mapa_item.cod_mapa                = mapa_item_reserva.cod_mapa
                  and   mapa_item.exercicio_solicitacao   = mapa_item_reserva.exercicio_solicitacao
                  and   mapa_item.cod_entidade            = mapa_item_reserva.cod_entidade
                  and   mapa_item.cod_solicitacao         = mapa_item_reserva.cod_solicitacao
                  and   mapa_item.cod_centro              = mapa_item_reserva.cod_centro
                  and   mapa_item.cod_item                = mapa_item_reserva.cod_item
                  and   mapa_item.lote                    = mapa_item_reserva.lote
                        )
       left join orcamento.reserva_saldos
              on (mapa_item_reserva.cod_reserva       = reserva_saldos.cod_reserva
             and  mapa_item_reserva.exercicio_reserva = reserva_saldos.exercicio )
       ---- buscando as anulações
       left join ( select mapa_item_anulacao.exercicio
                        , mapa_item_anulacao.cod_entidade
                        , mapa_item_anulacao.cod_solicitacao
                        , mapa_item_anulacao.cod_mapa
                        , mapa_item_anulacao.cod_centro
                        , mapa_item_anulacao.cod_item
                        , mapa_item_anulacao.exercicio_solicitacao
                        , mapa_item_anulacao.lote
                        , sum( vl_total ) as vl_total
                        , sum ( quantidade ) as quantidade
                     from compras.mapa_item_anulacao
                  group by mapa_item_anulacao.exercicio
                         , mapa_item_anulacao.cod_entidade
                         , mapa_item_anulacao.cod_solicitacao
                         , mapa_item_anulacao.cod_mapa
                         , mapa_item_anulacao.cod_centro
                         , mapa_item_anulacao.cod_item
                         , mapa_item_anulacao.exercicio_solicitacao
                         , mapa_item_anulacao.lote ) as anulacao_mapa
              on ( anulacao_mapa.exercicio             = mapa_item.exercicio
             and   anulacao_mapa.cod_entidade          = mapa_item.cod_entidade
             and   anulacao_mapa.cod_solicitacao       = mapa_item.cod_solicitacao
             and   anulacao_mapa.cod_mapa              = mapa_item.cod_mapa
             and   anulacao_mapa.cod_centro            = mapa_item.cod_centro
             and   anulacao_mapa.cod_item              = mapa_item.cod_item
             and   anulacao_mapa.exercicio_solicitacao = mapa_item.exercicio_solicitacao
             and   anulacao_mapa.lote                  = mapa_item.lote  )
             where ( mapa_item.quantidade  - coalesce( anulacao_mapa.quantidade  , 0 ) ) > 0
        ";

        if ($exercicio) {
            $sql .= " and mapa_item.exercicio = '$exercicio'";
        }
        if ($codMapa) {
            $sql .= " and mapa_item.cod_mapa = $codMapa";
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = array_shift($query->fetchAll(\PDO::FETCH_OBJ));

        return $result;
    }

    public function montaRecuperaItensCompraDireta($codMapa, $exercicio)
    {
        $sql = " select mapa.cod_mapa
                , mapa.exercicio
                , mapa_item.exercicio_solicitacao
                , mapa_item.cod_solicitacao
                , mapa_item.cod_centro
                , mapa_item.cod_item
                , mapa_item.lote
                , unidade_medida.nom_unidade
                , (SELECT   descricao
                     FROM   almoxarifado.centro_custo
                    WHERE   centro_custo.cod_centro = mapa_item.cod_centro
                  ) AS centro_custo_descricao
                , mapa.cod_objeto
                , (SELECT   descricao
                     FROM   compras.objeto
                    WHERE   cod_objeto = mapa.cod_objeto
                  ) AS objeto_descricao
                , trim(catalogo_item.descricao_resumida) as descricao_resumida
                , trim(catalogo_item.descricao) as descricao_completa
                , trim(solicitacao_item.complemento) as complemento
                , sum( mapa_item.quantidade)	 as quantidade
                , sum( ( mapa_item.vl_total / mapa_item.quantidade )::numeric(14,2) ) as valor_unitario
                , sum( mapa_item.vl_total ) as valor_total
                , ( SELECT  sum(mapa_item_anulacao.vl_total)
                      FROM  compras.mapa_item_anulacao
                     WHERE  mapa_item_anulacao.cod_mapa = mapa.cod_mapa
                       AND  mapa_item_anulacao.exercicio = mapa.exercicio
                       AND  mapa_item_anulacao.cod_item = mapa_item.cod_item
                       AND  mapa_item_anulacao.cod_centro = mapa_item.cod_centro
                  ) as vl_total_anulado
                , sum( mapa_item.quantidade) - COALESCE (( SELECT  sum(mapa_item_anulacao.quantidade)
                      FROM  compras.mapa_item_anulacao
                     WHERE  mapa_item_anulacao.cod_mapa = mapa.cod_mapa
                       AND  mapa_item_anulacao.exercicio = mapa.exercicio
                       AND  mapa_item_anulacao.cod_item = mapa_item.cod_item
                       AND  mapa_item_anulacao.cod_centro = mapa_item.cod_centro
                  ),0) as quantidade_real
                , sum( mapa_item.vl_total ) - coalesce(( SELECT  sum(mapa_item_anulacao.vl_total)
                      FROM  compras.mapa_item_anulacao
                     WHERE  mapa_item_anulacao.cod_mapa = mapa.cod_mapa
                       AND  mapa_item_anulacao.exercicio = mapa.exercicio
                       AND  mapa_item_anulacao.cod_item = mapa_item.cod_item
                       AND  mapa_item_anulacao.cod_centro = mapa_item.cod_centro
                  ),0) as valor_total_real
             from compras.mapa
       inner join compras.mapa_item
               on mapa_item.cod_mapa = mapa.cod_mapa
              and mapa_item.exercicio = mapa.exercicio
       inner join compras.solicitacao_item
               on solicitacao_item.exercicio = mapa_item.exercicio
              and solicitacao_item.cod_entidade  = mapa_item.cod_entidade
              and solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
              and solicitacao_item.cod_centro = mapa_item.cod_centro
              and solicitacao_item.cod_item = mapa_item.cod_item
       inner join almoxarifado.catalogo_item
               on catalogo_item.cod_item = mapa_item.cod_item
       inner join administracao.unidade_medida
               on unidade_medida.cod_unidade = catalogo_item.cod_unidade
              and unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
         where mapa.cod_mapa =  $codMapa
        and mapa.exercicio ='" . $exercicio . "'
        group by mapa.cod_mapa, mapa.exercicio, mapa_item.exercicio_solicitacao, mapa_item.cod_solicitacao, mapa_item.lote, mapa_item.cod_item, mapa_item.cod_centro, mapa.cod_objeto, objeto_descricao, descricao_resumida, descricao_completa, solicitacao_item.complemento, unidade_medida.nom_unidade
        order by descricao_completa";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param integer $codMapa
     * @param string  $exercicio
     *
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaItensPropostaAgrupados($codMapa, $exercicio)
    {
        $stSql = "    SELECT mapa_itens.cod_mapa
                     , mapa_itens.exercicio
                     , mapa_itens.cod_item
                     , mapa_itens.lote
                     , TRIM(mapa_itens.descricao_resumida) AS descricao_resumida
                     , TRIM(mapa_itens.descricao) AS descricao
                     , 0.00 AS valor_unitario
                     , 0.00 AS valor_total
                     , 0.00 AS valor_referencia
                     , '' AS data_validade
                     , '' AS cod_marca
                     , '' AS desc_marca
                     , mapa_itens.quantidade - coalesce ( mapa_item_anulacao.quantidade, 0.0000 ) AS quantidade
                     , mapa_itens.vl_total   - coalesce ( mapa_item_anulacao.vl_total  , 0.00 ) AS vl_total
                     , ( (mapa_itens.vl_total   - coalesce ( mapa_item_anulacao.vl_total  , 0.00 )) / (mapa_itens.quantidade - coalesce ( mapa_item_anulacao.quantidade, 0.0000 )) ) AS vl_unit
                  FROM (
                       SELECT mapa.cod_mapa
                             , mapa.exercicio
                             , mapa_item.cod_item
                             , mapa_item.lote
                             , catalogo_item.descricao_resumida
                             , catalogo_item.descricao
                             , sum( coalesce( mapa_item.quantidade, 0.0000) ) AS quantidade
                             , sum( coalesce( mapa_item.vl_total, 0.00) )AS vl_total

                          FROM compras.mapa
                         INNER JOIN compras.mapa_item
                            ON mapa_item.cod_mapa  = mapa.cod_mapa
                           AND mapa_item.exercicio = mapa.exercicio
                          JOIN compras.mapa_solicitacao
                            ON mapa_solicitacao.exercicio             = mapa_item.exercicio
                           AND mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                           AND mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                           AND mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                           AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                         INNER JOIN almoxarifado.catalogo_item
                            ON catalogo_item.cod_item = mapa_item.cod_item
                         GROUP BY mapa.cod_mapa
                                     , mapa.exercicio
                                     , mapa_item.cod_item
                                     , mapa_item.lote
                                     , catalogo_item.descricao_resumida
                                     , catalogo_item.descricao

                         ) AS mapa_itens
                    ----- buscando as possiveis anulações
                    LEFT JOIN ( SELECT mapa_item_anulacao.cod_mapa
                                   , mapa_item_anulacao.exercicio
                                   , mapa_item_anulacao.cod_item
                                   , mapa_item_anulacao.lote
                                   , sum ( mapa_item_anulacao.vl_total   ) AS vl_total
                                   , sum ( mapa_item_anulacao.quantidade ) AS quantidade
                                FROM compras.mapa_item_anulacao
                              GROUP BY cod_mapa
                                     , exercicio
                                     , cod_item
                                     , lote ) AS mapa_item_anulacao
                         ON ( mapa_itens.cod_mapa  = mapa_item_anulacao.cod_mapa
                        AND   mapa_itens.exercicio = mapa_item_anulacao.exercicio
                        AND   mapa_itens.cod_item  = mapa_item_anulacao.cod_item
                        AND   mapa_itens.lote      = mapa_item_anulacao.lote
                            )
                WHERE mapa_itens.quantidade - coalesce ( mapa_item_anulacao.quantidade, 0 ) > 0  \n";
        if ($codMapa && $exercicio) {
            $stSql .= "    and mapa_itens.cod_mapa = " . $codMapa . "\n";
            $stSql .= "    and mapa_itens.exercicio = '" . $exercicio . "'\n";
        }
        $stSql .= "    ORDER BY mapa_itens.cod_item";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     *
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaMapaCotacaoValida($codMapa, $exercicio)
    {
        $stSql = "
            SELECT   mapa_cotacao.cod_mapa
                 , mapa_cotacao.exercicio_mapa
                 , mapa_cotacao.cod_cotacao
                 , mapa_cotacao.exercicio_cotacao
            FROM   compras.mapa_cotacao
            INNER JOIN   compras.cotacao
              ON   cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
             AND   cotacao.exercicio = mapa_cotacao.exercicio_cotacao";

        if ($codMapa && $exercicio) {
            $stSql .= " WHERE mapa_cotacao.cod_mapa = " . $codMapa . " AND mapa_cotacao.exercicio_mapa = '" . $exercicio . "'\n";
        }

        // Verifica se a cotação não está anulada (tabela compras.cotacao_anulada)
        $stSql .= " AND NOT EXISTS ( SELECT 1
                                       FROM compras.cotacao_anulada
                                      WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                                        AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
                                   ) ";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return array_shift($result);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getValorReferencia(array $params)
    {
        $sql = <<<SQL
SELECT CAST
       (
           ((sum(mapa_item.vl_total) - coalesce(sum(mapa_item_anulacao.vl_total), 0)) /
            (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0))) AS NUMERIC(14, 2)
       ) AS vl_referencia

FROM compras.mapa_item

  INNER JOIN compras.mapa
    ON mapa.cod_mapa = mapa_item.cod_mapa
       AND mapa.exercicio = mapa_item.exercicio

  LEFT JOIN compras.mapa_item_anulacao
    ON mapa_item_anulacao.exercicio = mapa_item.exercicio
       AND mapa_item_anulacao.cod_entidade = mapa_item.cod_entidade
       AND mapa_item_anulacao.cod_solicitacao = mapa_item.cod_solicitacao
       AND mapa_item_anulacao.cod_mapa = mapa_item.cod_mapa
       AND mapa_item_anulacao.cod_centro = mapa_item.cod_centro
       AND mapa_item_anulacao.cod_item = mapa_item.cod_item
       AND mapa_item_anulacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
       AND mapa_item_anulacao.lote = mapa_item.lote

WHERE mapa_item.cod_mapa = :cod_mapa
      AND mapa_item.exercicio = :exercicio
      AND mapa_item.cod_item = :cod_item

GROUP BY mapa_item.cod_item;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_mapa'  => $params['cod_mapa'],
            'exercicio' => $params['exercicio'],
            'cod_item'  => $params['cod_item'],
        ]);

        return $stmt->fetch();
    }

    /**
     * -    * @param $exercicio
     * -    * @param $codMapa
     * -    * @return array
     * -    * @throws \Doctrine\DBAL\DBALException
     * -    */
    public function getRecuperaReservas($exercicio, $codMapa)
    {
        $stSql = "SELECT
                     mapa_item_reserva.exercicio_reserva
       			  ,  mapa_item_reserva.cod_reserva
       			  ,  mapa_item_reserva.cod_despesa
       			  ,  mapa_item_reserva.cod_conta
       			  ,  mapa_item_reserva.cod_item
       			  ,  mapa_item_reserva.cod_centro
       			  ,  mapa_item_reserva.cod_entidade
       			  ,  solicitacao_homologada_reserva.cod_reserva AS cod_reserva_solicitacao
       			  ,  solicitacao_homologada_reserva.exercicio   AS exercicio_reserva_solicitacao
       			  ,  COALESCE(reserva_saldos_solicitacao.vl_reserva, 0.00) AS vl_reserva_solicitacao
       			  ,  reserva_saldos.vl_reserva
       		   FROM  compras.mapa_item_reserva
       	 INNER JOIN  orcamento.reserva_saldos
       			 ON  mapa_item_reserva.cod_reserva       = reserva_saldos.cod_reserva
       			AND  mapa_item_reserva.exercicio_reserva = reserva_saldos.exercicio
          LEFT JOIN  compras.solicitacao_homologada_reserva
        	     ON  mapa_item_reserva.exercicio_solicitacao = solicitacao_homologada_reserva.exercicio
        	    AND  mapa_item_reserva.cod_solicitacao       = solicitacao_homologada_reserva.cod_solicitacao
        	    AND  mapa_item_reserva.cod_entidade          = solicitacao_homologada_reserva.cod_entidade
        	    AND  mapa_item_reserva.cod_centro            = solicitacao_homologada_reserva.cod_centro
        	    AND  mapa_item_reserva.cod_item              = solicitacao_homologada_reserva.cod_item
        	    AND  mapa_item_reserva.cod_conta             = solicitacao_homologada_reserva.cod_conta
        	    AND  mapa_item_reserva.cod_despesa           = solicitacao_homologada_reserva.cod_despesa
          LEFT JOIN  (
            			SELECT  *
            			  FROM  orcamento.reserva_saldos
          	    		 WHERE  NOT EXISTS (
          		  							SELECT  1
          								  	  FROM  orcamento.reserva_saldos_anulada
          								     WHERE  reserva_saldos_anulada.cod_reserva = reserva_saldos.cod_reserva
          								  	   AND  reserva_saldos_anulada.exercicio   = reserva_saldos.exercicio
          			   				       )
          		     ) AS reserva_saldos_solicitacao
          	     ON  solicitacao_homologada_reserva.cod_reserva = reserva_saldos_solicitacao.cod_reserva
          	    AND  solicitacao_homologada_reserva.exercicio   = reserva_saldos_solicitacao.exercicio
          	     WHERE  mapa_item_reserva.cod_mapa       =  " . $codMapa . "
              AND  mapa_item_reserva.exercicio_mapa = '" . $exercicio . "'
         GROUP BY  mapa_item_reserva.exercicio_reserva
                ,  mapa_item_reserva.cod_reserva
                ,  mapa_item_reserva.cod_despesa
                ,  mapa_item_reserva.cod_conta
                ,  mapa_item_reserva.cod_item
                ,  mapa_item_reserva.cod_centro
                ,  mapa_item_reserva.cod_entidade
                ,  solicitacao_homologada_reserva.cod_reserva
                ,  solicitacao_homologada_reserva.exercicio
                ,  reserva_saldos_solicitacao.vl_reserva
                ,  reserva_saldos.vl_reserva
                ,  mapa_item_reserva.cod_despesa
                ,  mapa_item_reserva.cod_conta
          	     ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $queryFechAll = $query->fetchAll(\PDO::FETCH_OBJ);
        $result = array_shift($queryFechAll);

        return $result;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     *
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaInformacoesMapa($codMapa, $exercicio)
    {
        $sql = "SELECT   mapa.exercicio
	                   , mapa.cod_mapa
	                   , mapa.cod_objeto
	                   , mapa.timestamp
	                   , mapa.cod_tipo_licitacao
	                   , tipo_licitacao.descricao AS tipo_licitacao
	                   , solicitacao.registro_precos
	                FROM compras.mapa
              INNER JOIN compras.tipo_licitacao
                      ON ( mapa.cod_tipo_licitacao = tipo_licitacao.cod_tipo_licitacao )
	          INNER JOIN compras.mapa_solicitacao
	                  ON mapa_solicitacao.exercicio = mapa.exercicio
	                 AND mapa_solicitacao.cod_mapa  = mapa.cod_mapa
	          INNER JOIN compras.solicitacao_homologada
	                  ON solicitacao_homologada.exercicio       = mapa_solicitacao.exercicio_solicitacao
	                 AND solicitacao_homologada.cod_entidade    = mapa_solicitacao.cod_entidade
	                 AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
	          INNER JOIN compras.solicitacao
	                  ON solicitacao.exercicio       = solicitacao_homologada.exercicio
	                 AND solicitacao.cod_entidade    = solicitacao_homologada.cod_entidade
	                 AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
	               WHERE mapa.cod_mapa =  " . $codMapa . "
	                 AND mapa.exercicio = '" . $exercicio . "'
	               GROUP BY mapa.exercicio
	                       , mapa.cod_mapa
	                       , mapa.cod_objeto
	                       , mapa.timestamp
	                       , mapa.cod_tipo_licitacao
	                       , solicitacao.registro_precos
	                       , tipo_licitacao.cod_tipo_licitacao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $resultado = $query->fetchAll();
        $result = array_shift($resultado);

        return $result;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     *
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function somaValoresMapa($codMapa, $exercicio)
    {
        $sql = "
	        SELECT sum(vl_total) AS vlTotal FROM compras.mapa_item WHERE cod_mapa = " . $codMapa . " AND exercicio = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $resultado = $query->fetchAll();
        $result = array_shift($resultado);

        return $result;
    }

    /**
     * @param null|string $codSolicitacao
     * @param null|string $codEntidade
     * @param null|string $exercicioSolicitacao
     * @param null|string $codItem
     * @param null|string $codCentro
     * @param null|string $codMapa
     * @param null|string $exercicioMapa
     *
     * @return mixed
     */
    public function montaRecuperaItemSolicitacaoMapa($codSolicitacao = null, $codEntidade = null, $exercicioSolicitacao = null, $codItem = null, $codCentro = null, $codMapa = null, $exercicioMapa = null)
    {
        $sql = <<<SQL
SELECT
  cod_solicitacao,
  exercicio_solicitacao,
  cod_entidade,
  cod_item,
  nom_item,
  nom_unidade,
  complemento,
  cod_centro,
  centro_custo,
  CASE WHEN vl_total IS NOT NULL
    THEN vl_total
  ELSE vl_total_item
  END                                                                                                              AS vl_total,
  valor_unitario,
  valor_anulado,
  COALESCE(valor_unitario, 0.00) * (COALESCE(quantidade_mapa, 0.0000) - COALESCE(quantidade_mapa_anulada,
                                                                                 0.0000))                          AS valor_total_mapa,
  quantidade,
  quantidade_anulada,
  quantidade_estoque,
  quantidade_mapa,
  quantidade_mapa_anulada,
  quantidade_em_mapas,
  quantidade_anulada_em_mapas,
  ((quantidade - quantidade_anulada) - (quantidade_mapa -
                                        quantidade_mapa_anulada))                                                  AS quantidade_disponivel,
  (quantidade_mapa -
   quantidade_mapa_anulada)                                                                                        AS quantidade_maxima,
  (quantidade -
   quantidade_anulada)                                                                                             AS quantidade_solicitada
  --,  (quantidade_mapa - quantidade_mapa_anulada) as quantidade_atendida
  --,  ((quantidade - quantidade_anulada) - (quantidade_mapa - quantidade_mapa_anulada)) as quantidade_mapa
  ,
  vl_total_mapa_item,
  dotacao,
  dotacao_nom_conta,
  conta_despesa,
  nom_conta,
  cod_estrutural,
  vl_reserva,
  cod_reserva,
  exercicio_reserva,
  cod_conta,
  cod_despesa,
  lote,
  cod_reserva_solicitacao,
  exercicio_reserva_solicitacao,
  vl_reserva_solicitacao

FROM (SELECT
        solicitacao_item.exercicio                                                                        AS exercicio_solicitacao,
        solicitacao_item.cod_entidade,
        solicitacao_item.cod_solicitacao,
        solicitacao_item.cod_item,
        solicitacao_item.quantidade                                                                       AS quantidade_item,
        catalogo_item.descricao                                                                           AS nom_item,
        unidade_medida.nom_unidade,
        solicitacao_item.vl_total                                                                         AS vl_total_item,
        ((solicitacao_item.vl_total / solicitacao_item.quantidade) * solicitacao_item_dotacao.quantidade) AS vl_total,
        solicitacao_item.complemento,
        solicitacao_item.cod_centro,
        centro_custo.descricao                                                                            AS centro_custo

        -- VALOR UNITARIO DO ITEM NA SOLICITAÇÃO OU MAPA.
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NOT NULL
          THEN
            (mapa_item_dotacao.vl_dotacao / mapa_item_dotacao.quantidade)
        WHEN solicitacao_item_dotacao IS NOT NULL
          THEN
            (solicitacao_item_dotacao.vl_reserva / solicitacao_item_dotacao.quantidade)
        ELSE
          (solicitacao_item.vl_total / solicitacao_item.quantidade)
        END                                                                                               AS valor_unitario

        -- ,  (solicitacao_item.vl_total / solicitacao_item.quantidade) as valor_unitario

        -- QUANTIDADE DO ITEM NA SOLICITAÇÃO.
        ,
        CASE WHEN solicitacao_item_dotacao.cod_despesa IS NULL
          THEN
            COALESCE(solicitacao_item.quantidade, 0.00)
        ELSE
          COALESCE(solicitacao_item_dotacao.quantidade, 0.00)
        END                                                                                               AS quantidade
        -- QUANTIDADE ANULADA DO ITEM NA SOLICITAÇÃO
        ,
        CASE WHEN solicitacao_item_dotacao.cod_despesa IS NULL
          THEN
            (SELECT COALESCE(SUM(solicitacao_item_anulacao.quantidade), 0.00) AS quantidade
             FROM compras.solicitacao_item_anulacao
             WHERE solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                   AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
                   AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                   AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                   AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item)
        ELSE
          (SELECT COALESCE(SUM(solicitacao_item_dotacao_anulacao.quantidade), 0.00) AS quantidade
           FROM compras.solicitacao_item_dotacao_anulacao
           WHERE solicitacao_item_dotacao_anulacao.exercicio = solicitacao_item_dotacao.exercicio
                 AND solicitacao_item_dotacao_anulacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
                 AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                 AND solicitacao_item_dotacao_anulacao.cod_centro = solicitacao_item_dotacao.cod_centro
                 AND solicitacao_item_dotacao_anulacao.cod_item = solicitacao_item_dotacao.cod_item
                 AND solicitacao_item_dotacao_anulacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                 AND solicitacao_item_dotacao_anulacao.cod_conta = solicitacao_item_dotacao.cod_conta)
        END                                                                                               AS quantidade_anulada

        -- VALOR ANULADO DO ITEM NA SOLICITAÇÃO
        ,
        CASE WHEN solicitacao_item_dotacao.cod_despesa IS NULL
          THEN
            (SELECT COALESCE(SUM(solicitacao_item_anulacao.vl_total), 0.00) AS vl_total
             FROM compras.solicitacao_item_anulacao
             WHERE solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                   AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
                   AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                   AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                   AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item)
        ELSE
          (SELECT COALESCE(SUM(solicitacao_item_dotacao_anulacao.vl_anulacao), 0.00) AS vl_total
           FROM compras.solicitacao_item_dotacao_anulacao
           WHERE solicitacao_item_dotacao_anulacao.exercicio = solicitacao_item_dotacao.exercicio
                 AND solicitacao_item_dotacao_anulacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
                 AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                 AND solicitacao_item_dotacao_anulacao.cod_centro = solicitacao_item_dotacao.cod_centro
                 AND solicitacao_item_dotacao_anulacao.cod_item = solicitacao_item_dotacao.cod_item
                 AND solicitacao_item_dotacao_anulacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                 AND solicitacao_item_dotacao_anulacao.cod_conta = solicitacao_item_dotacao.cod_conta)
        END                                                                                               AS valor_anulado

        -- QUANTIDADE DO ITEM NO MAPA
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NOT NULL
          THEN
            (SELECT (COALESCE(SUM(mapa_item_dotacao.quantidade), 0.00)) AS quantidade
             FROM compras.mapa_item_dotacao
             WHERE mapa_item_dotacao.exercicio = solicitacao_item_dotacao.exercicio
                   AND mapa_item_dotacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
                   AND mapa_item_dotacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                   AND mapa_item_dotacao.cod_centro = solicitacao_item_dotacao.cod_centro
                   AND mapa_item_dotacao.cod_item = solicitacao_item_dotacao.cod_item
                   AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                   AND mapa_item_dotacao.cod_conta = solicitacao_item_dotacao.cod_conta
                   AND mapa_item_dotacao.cod_mapa = mapa_solicitacao.cod_mapa
                   AND mapa_item_dotacao.exercicio = mapa_solicitacao.exercicio)
        WHEN solicitacao_item_dotacao.cod_despesa IS NOT NULL
          THEN
            (SELECT (COALESCE(SUM(SID.quantidade), 0.00)) AS quantidade
             FROM compras.solicitacao_item_dotacao AS SID
             WHERE SID.exercicio = solicitacao_item_dotacao.exercicio
                   AND SID.cod_entidade = solicitacao_item_dotacao.cod_entidade
                   AND SID.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                   AND SID.cod_centro = solicitacao_item_dotacao.cod_centro
                   AND SID.cod_item = solicitacao_item_dotacao.cod_item
                   AND SID.cod_despesa = solicitacao_item_dotacao.cod_despesa
                   AND SID.cod_conta = solicitacao_item_dotacao.cod_conta)
        ELSE
          (SELECT (COALESCE(SUM(mapa_item.quantidade), 0.00)) AS quantidade
           FROM compras.mapa_item
           WHERE mapa_item.exercicio = solicitacao_item.exercicio
                 AND mapa_item.cod_entidade = solicitacao_item.cod_entidade
                 AND mapa_item.cod_solicitacao = solicitacao_item.cod_solicitacao
                 AND mapa_item.cod_centro = solicitacao_item.cod_centro
                 AND mapa_item.cod_item = solicitacao_item.cod_item
                 AND mapa_item.cod_mapa = mapa_solicitacao.cod_mapa
                 AND mapa_item.exercicio = mapa_solicitacao.exercicio)
        END                                                                                               AS quantidade_mapa

        -- QUANTIDADE ANULADA DO MAPA
        ,
        (SELECT (COALESCE(SUM(mapa_item_anulacao.quantidade), 0.00)) AS quantidade

         FROM compras.mapa_item_anulacao

           INNER JOIN compras.mapa_item_dotacao ON mapa_item_dotacao.exercicio = mapa_item_anulacao.exercicio
                                                   AND mapa_item_dotacao.cod_mapa = mapa_item_anulacao.cod_mapa
                                                   AND mapa_item_dotacao.exercicio_solicitacao =
                                                       mapa_item_anulacao.exercicio_solicitacao
                                                   AND mapa_item_dotacao.cod_entidade = mapa_item_anulacao.cod_entidade
                                                   AND mapa_item_dotacao.cod_solicitacao =
                                                       mapa_item_anulacao.cod_solicitacao
                                                   AND mapa_item_dotacao.cod_centro = mapa_item_anulacao.cod_centro
                                                   AND mapa_item_dotacao.cod_item = mapa_item_anulacao.cod_item
                                                   AND mapa_item_dotacao.lote = mapa_item_anulacao.lote
                                                   AND mapa_item_dotacao.cod_despesa = mapa_item_anulacao.cod_despesa
                                                   AND mapa_item_dotacao.cod_conta = mapa_item_anulacao.cod_conta

         WHERE mapa_item_dotacao.exercicio = solicitacao_item_dotacao.exercicio
               AND mapa_item_dotacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND mapa_item_dotacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
               AND mapa_item_dotacao.cod_centro = solicitacao_item_dotacao.cod_centro
               AND mapa_item_dotacao.cod_item = solicitacao_item_dotacao.cod_item
               AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
               AND mapa_item_dotacao.cod_conta = solicitacao_item_dotacao.cod_conta
               AND mapa_item_dotacao.cod_mapa = mapa_solicitacao.cod_mapa
               AND mapa_item_dotacao.exercicio =
                   mapa_solicitacao.exercicio)                                                            AS quantidade_mapa_anulada

        -- QUANTIDADE DO ITEM EM OUTROS MAPAS
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NULL
          THEN
            (SELECT (COALESCE(SUM(mapa_item.quantidade), 0.00)) AS quantidade
             FROM compras.mapa_item
             WHERE mapa_item.exercicio = solicitacao_item.exercicio
                   AND mapa_item.cod_entidade = solicitacao_item.cod_entidade
                   AND mapa_item.cod_solicitacao = solicitacao_item.cod_solicitacao
                   AND mapa_item.cod_centro = solicitacao_item.cod_centro
                   AND mapa_item.cod_item = solicitacao_item.cod_item
                   AND mapa_item.cod_mapa <> mapa_solicitacao.cod_mapa
                   AND mapa_item.exercicio = mapa_solicitacao.exercicio)
        ELSE
          (SELECT (COALESCE(SUM(mapa_item_dotacao.quantidade), 0.00)) AS quantidade
           FROM compras.mapa_item_dotacao
           WHERE mapa_item_dotacao.exercicio = solicitacao_item_dotacao.exercicio
                 AND mapa_item_dotacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
                 AND mapa_item_dotacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                 AND mapa_item_dotacao.cod_centro = solicitacao_item_dotacao.cod_centro
                 AND mapa_item_dotacao.cod_item = solicitacao_item_dotacao.cod_item
                 AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                 AND mapa_item_dotacao.cod_conta = solicitacao_item_dotacao.cod_conta
                 AND mapa_item_dotacao.cod_mapa <> mapa_solicitacao.cod_mapa
                 AND mapa_item_dotacao.exercicio = mapa_solicitacao.exercicio)
        END                                                                                               AS quantidade_em_mapas

        -- QUANTIDADE ANULADA EM OUTROS MAPAS
        ,
        (SELECT (COALESCE(SUM(mapa_item_anulacao.quantidade), 0.00)) AS quantidade
         FROM compras.mapa_item_anulacao
           INNER JOIN compras.mapa_item_dotacao
             ON mapa_item_dotacao.exercicio_solicitacao = mapa_item_anulacao.exercicio_solicitacao
                AND mapa_item_dotacao.cod_entidade = mapa_item_anulacao.cod_entidade
                AND mapa_item_dotacao.cod_solicitacao = mapa_item_anulacao.cod_solicitacao
                AND mapa_item_dotacao.cod_centro = mapa_item_anulacao.cod_centro
                AND mapa_item_dotacao.cod_item = mapa_item_anulacao.cod_item
                AND mapa_item_dotacao.lote = mapa_item_anulacao.lote
                AND mapa_item_dotacao.cod_despesa = mapa_item_anulacao.cod_despesa
                AND mapa_item_dotacao.cod_conta = mapa_item_anulacao.cod_conta
         WHERE mapa_item_dotacao.exercicio = solicitacao_item_dotacao.exercicio
               AND mapa_item_dotacao.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND mapa_item_dotacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
               AND mapa_item_dotacao.cod_centro = solicitacao_item_dotacao.cod_centro
               AND mapa_item_dotacao.cod_item = solicitacao_item_dotacao.cod_item
               AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
               AND mapa_item_dotacao.cod_conta =
                   solicitacao_item_dotacao.cod_conta)                                                    AS quantidade_anulada_em_mapas

        -- VALOR MAPEADO MENOS O VALOR ANULADO DO MAPA
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NOT NULL
          THEN
            COALESCE((SELECT (COALESCE(SUM(mapa_item.vl_total), 0.00)) -
                             (COALESCE(SUM(mapa_item_anulacao.vl_total), 0.00)) AS valor
                      FROM compras.mapa_item
                        LEFT JOIN compras.mapa_item_anulacao ON mapa_item.exercicio = mapa_item_anulacao.exercicio
                                                                AND mapa_item.cod_mapa = mapa_item_anulacao.cod_mapa
                                                                AND mapa_item.exercicio_solicitacao =
                                                                    mapa_item_anulacao.exercicio_solicitacao
                                                                AND mapa_item.cod_entidade =
                                                                    mapa_item_anulacao.cod_entidade
                                                                AND mapa_item.cod_solicitacao =
                                                                    mapa_item_anulacao.cod_solicitacao
                                                                AND
                                                                mapa_item.cod_centro = mapa_item_anulacao.cod_centro
                                                                AND mapa_item.cod_item = mapa_item_anulacao.cod_item
                                                                AND mapa_item.lote = mapa_item_anulacao.lote
                      WHERE mapa_item.exercicio = solicitacao_item.exercicio
                            AND mapa_item.cod_entidade = solicitacao_item.cod_entidade
                            AND mapa_item.cod_solicitacao = solicitacao_item.cod_solicitacao
                            AND mapa_item.cod_centro = solicitacao_item.cod_centro
                            AND mapa_item.cod_item = solicitacao_item.cod_item), 0.0)
        ELSE
          (SELECT (COALESCE(SUM(SID.vl_reserva), 0.00)) AS valor
           FROM compras.solicitacao_item_dotacao AS SID
           WHERE SID.exercicio = solicitacao_item_dotacao.exercicio
                 AND SID.cod_entidade = solicitacao_item_dotacao.cod_entidade
                 AND SID.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                 AND SID.cod_centro = solicitacao_item_dotacao.cod_centro
                 AND SID.cod_item = solicitacao_item_dotacao.cod_item
                 AND SID.cod_despesa = solicitacao_item_dotacao.cod_despesa
                 AND SID.cod_conta = solicitacao_item_dotacao.cod_conta)
        END                                                                                               AS vl_total_mapa_item

        -- QUANTIDADE EM ESTOQUE
        ,
        (SELECT COALESCE(SUM(lancamento_material.quantidade), 0.0) AS quantidade
         FROM almoxarifado.estoque_material
           INNER JOIN almoxarifado.lancamento_material ON lancamento_material.cod_item = estoque_material.cod_item
                                                          AND
                                                          lancamento_material.cod_marca = estoque_material.cod_marca
                                                          AND lancamento_material.cod_almoxarifado =
                                                              estoque_material.cod_almoxarifado
                                                          AND
                                                          lancamento_material.cod_centro = estoque_material.cod_centro
         WHERE solicitacao_item.cod_item = estoque_material.cod_item
               AND solicitacao_item.cod_centro = estoque_material.cod_centro
               AND solicitacao.cod_almoxarifado =
                   estoque_material.cod_almoxarifado)                                                     AS quantidade_estoque

        -- RECUPERA O COD_DESPESA
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NULL
          THEN
            solicitacao_item_dotacao.cod_despesa
        ELSE
          mapa_item_dotacao.cod_despesa
        END                                                                                               AS dotacao

        -- RECUPERA O COD_CONTA
        ,
        CASE WHEN mapa_item_dotacao.cod_despesa IS NULL
          THEN
            solicitacao_item_dotacao.cod_conta
        ELSE
          mapa_item_dotacao.cod_conta
        END                                                                                               AS conta_despesa,
        conta_despesa.descricao                                                                           AS dotacao_nom_conta,
        desdobramento.descricao                                                                           AS nom_conta,
        desdobramento.cod_estrutural,
        coalesce(reserva_saldos.vl_reserva, 0.00)                                                         AS vl_reserva,
        reserva_saldos.cod_reserva,
        reserva_saldos.exercicio                                                                          AS exercicio_reserva,
        desdobramento.cod_conta                                                                           AS cod_conta,
        despesa.cod_despesa                                                                               AS cod_despesa,
        mapa_item.lote

        -- RESERVAS DA SOLICITAÇÃO DE COMPRAS
        ,
        solicitacao_homologada_reserva.cod_reserva                                                        AS cod_reserva_solicitacao,
        solicitacao_homologada_reserva.exercicio                                                          AS exercicio_reserva_solicitacao,
        (SELECT vl_reserva
         FROM orcamento.reserva_saldos
         WHERE reserva_saldos.cod_reserva = solicitacao_homologada_reserva.cod_reserva
               AND reserva_saldos.exercicio =
                   solicitacao_homologada_reserva.exercicio)                                              AS vl_reserva_solicitacao

      FROM compras.mapa

        INNER JOIN compras.mapa_solicitacao ON mapa_solicitacao.exercicio = mapa.exercicio
                                               AND mapa_solicitacao.cod_mapa = mapa.cod_mapa

        INNER JOIN compras.mapa_item ON mapa_item.exercicio = mapa_solicitacao.exercicio
                                        AND mapa_item.cod_entidade = mapa_solicitacao.cod_entidade
                                        AND mapa_item.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                                        AND mapa_item.cod_mapa = mapa_solicitacao.cod_mapa
                                        AND mapa_item.exercicio_solicitacao = mapa_solicitacao.exercicio_solicitacao

        LEFT JOIN compras.mapa_item_dotacao ON mapa_item.exercicio = mapa_item_dotacao.exercicio
                                               AND mapa_item.cod_mapa = mapa_item_dotacao.cod_mapa
                                               AND mapa_item.exercicio_solicitacao =
                                                   mapa_item_dotacao.exercicio_solicitacao
                                               AND mapa_item.cod_entidade = mapa_item_dotacao.cod_entidade
                                               AND mapa_item.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
                                               AND mapa_item.cod_centro = mapa_item_dotacao.cod_centro
                                               AND mapa_item.cod_item = mapa_item_dotacao.cod_item
                                               AND mapa_item.lote = mapa_item_dotacao.lote

        INNER JOIN compras.solicitacao_item ON solicitacao_item.exercicio = mapa_item.exercicio
                                               AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
                                               AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
                                               AND solicitacao_item.cod_centro = mapa_item.cod_centro
                                               AND solicitacao_item.cod_item = mapa_item.cod_item

        LEFT JOIN compras.solicitacao_item_dotacao ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
                                                      AND solicitacao_item.cod_entidade =
                                                          solicitacao_item_dotacao.cod_entidade
                                                      AND solicitacao_item.cod_solicitacao =
                                                          solicitacao_item_dotacao.cod_solicitacao
                                                      AND
                                                      solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
                                                      AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
                                                      AND
                                                      mapa_item_dotacao.cod_conta = solicitacao_item_dotacao.cod_conta
                                                      AND mapa_item_dotacao.cod_despesa =
                                                          solicitacao_item_dotacao.cod_despesa

        INNER JOIN compras.solicitacao ON solicitacao.exercicio = solicitacao_item.exercicio
                                          AND solicitacao.cod_entidade = solicitacao_item.cod_entidade
                                          AND solicitacao.cod_solicitacao = solicitacao_item.cod_solicitacao

        INNER JOIN almoxarifado.catalogo_item ON solicitacao_item.cod_item = catalogo_item.cod_item

        INNER JOIN administracao.unidade_medida ON catalogo_item.cod_unidade = unidade_medida.cod_unidade
                                                   AND catalogo_item.cod_grandeza = unidade_medida.cod_grandeza

        INNER JOIN almoxarifado.centro_custo ON solicitacao_item.cod_centro = centro_custo.cod_centro

        LEFT JOIN compras.solicitacao_homologada_reserva
          ON solicitacao_homologada_reserva.exercicio = solicitacao_item_dotacao.exercicio
             AND solicitacao_homologada_reserva.cod_entidade = solicitacao_item_dotacao.cod_entidade
             AND solicitacao_homologada_reserva.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
             AND solicitacao_homologada_reserva.cod_centro = solicitacao_item_dotacao.cod_centro
             AND solicitacao_homologada_reserva.cod_item = solicitacao_item_dotacao.cod_item
             AND solicitacao_homologada_reserva.cod_conta = solicitacao_item_dotacao.cod_conta
             AND solicitacao_homologada_reserva.cod_despesa = solicitacao_item_dotacao.cod_despesa

        --  BUSCANDO A DOTACAO
        LEFT JOIN orcamento.despesa ON (mapa_item_dotacao.exercicio = despesa.exercicio
                                        AND mapa_item_dotacao.cod_despesa = despesa.cod_despesa)
                                       OR (solicitacao_item_dotacao.exercicio = despesa.exercicio
                                           AND solicitacao_item_dotacao.cod_despesa = despesa.cod_despesa)

        LEFT JOIN orcamento.conta_despesa ON conta_despesa.exercicio = despesa.exercicio
                                             AND conta_despesa.cod_conta = despesa.cod_conta

        --  BUSCANDO O DESDOBRAMENTO
        LEFT JOIN orcamento.conta_despesa AS desdobramento ON (mapa_item_dotacao.exercicio = desdobramento.exercicio
                                                               AND
                                                               mapa_item_dotacao.cod_conta = desdobramento.cod_conta)
                                                              OR (solicitacao_item_dotacao.exercicio =
                                                                  desdobramento.exercicio
                                                                  AND solicitacao_item_dotacao.cod_conta =
                                                                      desdobramento.cod_conta)

        --  BUSCANDO A RESERVA DE SALDOS
        LEFT JOIN compras.mapa_item_reserva ON mapa_item_reserva.exercicio_mapa = mapa_item_dotacao.exercicio
                                               AND mapa_item_reserva.cod_mapa = mapa_item_dotacao.cod_mapa
                                               AND mapa_item_reserva.exercicio_solicitacao =
                                                   mapa_item_dotacao.exercicio_solicitacao
                                               AND mapa_item_reserva.cod_entidade = mapa_item_dotacao.cod_entidade
                                               AND
                                               mapa_item_reserva.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
                                               AND mapa_item_reserva.cod_centro = mapa_item_dotacao.cod_centro
                                               AND mapa_item_reserva.cod_item = mapa_item_dotacao.cod_item
                                               AND mapa_item_reserva.lote = mapa_item_dotacao.lote
                                               AND mapa_item_reserva.cod_despesa = mapa_item_dotacao.cod_despesa
                                               AND mapa_item_reserva.cod_conta = mapa_item_dotacao.cod_conta

        LEFT JOIN orcamento.reserva_saldos ON (mapa_item_reserva.cod_reserva = reserva_saldos.cod_reserva
                                               AND mapa_item_reserva.exercicio_reserva = reserva_saldos.exercicio)
                                              OR (mapa_item_reserva.cod_reserva IS NULL
                                                  AND solicitacao_homologada_reserva.cod_reserva =
                                                      reserva_saldos.cod_reserva
                                                  AND
                                                  solicitacao_homologada_reserva.exercicio = reserva_saldos.exercicio)
SQL;

        $parameters = [];
        $where = [];

        if (!is_null($codSolicitacao)) {
            $parameters[] = $codSolicitacao;
            $where[] = "solicitacao_item.cod_solicitacao = ?";
        }

        if (!is_null($codEntidade)) {
            $parameters[] = $codEntidade;
            $where[] = "solicitacao_item.cod_entidade = ?";
        }

        if (!is_null($exercicioSolicitacao)) {
            $parameters[] = $exercicioSolicitacao;
            $where[] = "solicitacao_item.exercicio = ?";
        }

        if (!is_null($codItem)) {
            $parameters[] = $codItem;
            $where[] = "solicitacao_item.cod_item = ?";
        }

        if (!is_null($codCentro)) {
            $parameters[] = $codCentro;
            $where[] = "solicitacao_item.cod_centro = ?";
        }

        if (!is_null($codMapa)) {
            $parameters[] = $codMapa;
            $where[] = "mapa_solicitacao.cod_mapa = ?";
        }

        if (!is_null($exercicioMapa)) {
            $parameters[] = $exercicioMapa;
            $where[] = "mapa_solicitacao.exercicio = ?";
        }

        if (count($where) > 0) {
            $where = sprintf(' WHERE %s', implode(' AND ', $where));
        }

        $sql .= $where . ") AS itens WHERE (quantidade - quantidade_anulada) - (quantidade_em_mapas - quantidade_anulada_em_mapas) > 0;";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codDespesa
     *
     * @return mixed
     */
    public function montaRecuperaSaldoAnterior($exercicio, $codDespesa)
    {
        $sql = "SELECT COALESCE(empenho.fn_saldo_dotacao (:exercicio, :cod_despesa), 0) AS saldo_anterior";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'exercicio'   => $exercicio,
            'cod_despesa' => $codDespesa,
        ]);

        return $stmt->fetchColumn();
    }

    /**
     * @param int        $codItem
     * @param string|int $exercicio
     *
     * @return mixed
     */
    public function montaRecuperaValorItemUltimaCompra($codItem, $exercicio)
    {
        $sql = <<<SQL
SELECT CAST(COALESCE((item_pre_empenho.vl_total / item_pre_empenho.quantidade), 0) AS
            NUMERIC(14, 2)) AS vl_unitario_ultima_compra
FROM empenho.item_pre_empenho_julgamento, empenho.item_pre_empenho, empenho.pre_empenho, empenho.empenho
WHERE item_pre_empenho_julgamento.cod_item = ?
      AND item_pre_empenho_julgamento.exercicio = ?
      AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item
      AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio
      AND item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
      AND item_pre_empenho.exercicio = empenho.exercicio
      AND item_pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
      AND pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
      AND pre_empenho.exercicio = item_pre_empenho.exercicio
      AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
      AND empenho.exercicio = pre_empenho.exercicio
      AND NOT EXISTS(SELECT 1
                     FROM empenho.empenho_anulado_item
                     WHERE empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                           AND empenho_anulado_item.exercicio = item_pre_empenho.exercicio
                           AND empenho_anulado_item.num_item = item_pre_empenho.num_item)
ORDER BY empenho.cod_empenho DESC
LIMIT 1
SQL;
        $parameters = [$codItem, $exercicio];

        $conn = $this->_em->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->execute($parameters);

        $result = $stmt->fetch();

        return $result;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     *
     * @return mixed
     */
    public function montaRecuperaMapaSolicitacoes($codMapa, $exercicio)
    {
        $sql = "SELECT  solicitacao.exercicio
                       ,  solicitacao.cod_entidade
                       ,  sw_cgm.nom_cgm AS nom_entidade
                       ,  solicitacao.cod_solicitacao
                       ,  TO_CHAR(solicitacao_homologada.timestamp,'dd/mm/yyyy') AS data
                       ,  TO_CHAR(solicitacao.timestamp,'dd/mm/yyyy') AS data_solicitacao

                       -- TOTAL DA SOLICITAÇÃO (TOTAL - ANULAÇÃO)
                       ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.solicitacao_item
                             WHERE  solicitacao_item.exercicio       = solicitacao.exercicio
                               AND  solicitacao_item.cod_entidade    = solicitacao.cod_entidade
                               AND  solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
                          ) -
                          ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.solicitacao_item_anulacao
                             WHERE  solicitacao_item_anulacao.exercicio       = solicitacao.exercicio
                               AND  solicitacao_item_anulacao.cod_entidade    = solicitacao.cod_entidade
                               AND  solicitacao_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                          ) AS valor_total

                       -- TOTAL EM MAPA
                       ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.mapa_item
                             WHERE  mapa_item.exercicio_solicitacao = solicitacao.exercicio
                               AND  mapa_item.cod_solicitacao       = solicitacao.cod_solicitacao
                               AND  mapa_item.cod_entidade          = solicitacao.cod_entidade
                          ) - COALESCE(anulacao.total_anulado, 0.00) AS total_mapas

                       -- TOTAL NESTE MAPA
                       ,  (total.total_mapa - total.total_mapa_anulado) AS total_mapa
                       ,  COALESCE(anulacao.total_anulado, 0.00) AS total_anulado
                       ,  COALESCE(total.total_mapa_anulado, 0.00) AS total_mapa_anulado
                       ,  solicitacao.registro_precos

                    FROM  compras.solicitacao

              INNER JOIN  orcamento.entidade
                      ON  solicitacao.cod_entidade = entidade.cod_entidade
                     AND  solicitacao.exercicio    = entidade.exercicio

              INNER JOIN  sw_cgm
                      ON  entidade.numcgm = sw_cgm.numcgm

              INNER JOIN  compras.solicitacao_homologada
                      ON  solicitacao_homologada.exercicio       = solicitacao.exercicio
                     AND  solicitacao_homologada.cod_entidade    = solicitacao.cod_entidade
                     AND  solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao

              INNER JOIN  compras.mapa_solicitacao
                      ON  mapa_solicitacao.exercicio_solicitacao = solicitacao_homologada.exercicio
                     AND  mapa_solicitacao.cod_entidade          = solicitacao_homologada.cod_entidade
                     AND  mapa_solicitacao.cod_solicitacao       = solicitacao_homologada.cod_solicitacao

              INNER JOIN  (
                            SELECT  mapa_solicitacao.*
                                 -- TOTAL NESTE MAPA
                                 ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                                       FROM  compras.mapa_item
                                      WHERE  mapa_item.exercicio_solicitacao = mapa_solicitacao.exercicio_solicitacao
                                        AND  mapa_item.cod_solicitacao       = mapa_solicitacao.cod_solicitacao
                                        AND  mapa_item.cod_entidade          = mapa_solicitacao.cod_entidade
                                        AND  mapa_item.cod_mapa              = mapa_solicitacao.cod_mapa
                                        AND  mapa_item.exercicio             = mapa_solicitacao.exercicio
                                    ) AS total_mapa

                                 -- TOTAL ANULADO DESTE MAPA
                                 ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                                        FROM  compras.mapa_item_anulacao
                                       WHERE  mapa_item_anulacao.exercicio             = mapa_solicitacao.exercicio_solicitacao
                                         AND  mapa_item_anulacao.cod_entidade          = mapa_solicitacao.cod_entidade
                                         AND  mapa_item_anulacao.cod_solicitacao       = mapa_solicitacao.cod_solicitacao
                                         AND  mapa_item_anulacao.cod_mapa              = mapa_solicitacao.cod_mapa
                                         AND  mapa_item_anulacao.exercicio_solicitacao = mapa_solicitacao.exercicio_solicitacao
                                    ) AS total_mapa_anulado
                              FROM  compras.mapa_solicitacao
                          ) AS total
                      ON  mapa_solicitacao.exercicio_solicitacao = total.exercicio
                     AND  mapa_solicitacao.cod_entidade          = total.cod_entidade
                     AND  mapa_solicitacao.cod_solicitacao       = total.cod_solicitacao
                     AND  mapa_solicitacao.cod_mapa              = total.cod_mapa

               LEFT JOIN  (
                            SELECT  mapa_item_anulacao.exercicio_solicitacao
                                 ,  mapa_item_anulacao.cod_entidade
                                 ,  mapa_item_anulacao.cod_solicitacao
                                 ,  SUM(vl_total) AS total_anulado

                              FROM  compras.mapa_item_anulacao

                          GROUP BY  exercicio_solicitacao
                                 ,  cod_entidade
                                 ,  cod_solicitacao
                          ) AS anulacao
                      ON  solicitacao.cod_solicitacao = anulacao.cod_solicitacao
                     AND  solicitacao.exercicio       = anulacao.exercicio_solicitacao
                     AND  solicitacao.cod_entidade    = anulacao.cod_entidade

                   WHERE  1=1";

        $sql .= "     AND  mapa_solicitacao.cod_mapa  = " . $codMapa . "   \n";
        $sql .= "     AND  mapa_solicitacao.exercicio = '" . $exercicio . "' \n";
        $sql .= " ORDER BY  solicitacao.cod_solicitacao                   \n";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $resultado = $query->fetchAll();

        return $resultado;
    }

    /**
     * @param      $codSolicitacao
     * @param      $codEntidade
     * @param      $exercicioSolicitacao
     * @param      $codItem
     * @param      $codCentro
     * @param      $codMapa
     * @param      $exercicio
     * @param null $codDespesa
     * @param null $codConta
     *
     * @return array
     * @internal param $cod_despesa
     * @internal param $cod_conta
     */
    public function montaRecuperaQtdeAtendidaEmMapas($codSolicitacao, $codEntidade, $exercicioSolicitacao, $codItem, $codCentro, $codMapa = null, $exercicio = null, $codDespesa = null, $codConta = null)
    {
        $sql = <<<SQL
SELECT
      CASE WHEN SUM(mapa_item_dotacao.quantidade) IS NOT NULL THEN
        COALESCE(SUM(mapa_item_dotacao.quantidade), 0.0000) -
        COALESCE(SUM(
                     ( SELECT  SUM(mapa_item_anulacao.quantidade)
                       FROM  compras.mapa_item_anulacao
                       WHERE  mapa_item_anulacao.exercicio             = mapa_item_dotacao.exercicio
                              AND  mapa_item_anulacao.cod_mapa              = mapa_item_dotacao.cod_mapa
                              AND  mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                              AND  mapa_item_anulacao.cod_entidade          = mapa_item_dotacao.cod_entidade
                              AND  mapa_item_anulacao.cod_solicitacao       = mapa_item_dotacao.cod_solicitacao
                              AND  mapa_item_anulacao.cod_centro            = mapa_item_dotacao.cod_centro
                              AND  mapa_item_anulacao.cod_item              = mapa_item_dotacao.cod_item
                              AND  mapa_item_anulacao.lote                  = mapa_item_dotacao.lote
                              AND  mapa_item_anulacao.cod_conta             = mapa_item_dotacao.cod_conta
                              AND  mapa_item_anulacao.cod_despesa           = mapa_item_dotacao.cod_despesa )
                 ), 0.0000)
      ELSE
        COALESCE(SUM(mapa_item.quantidade), 0.0000) -
        COALESCE(SUM(
                     ( SELECT  SUM(mapa_item_anulacao.quantidade)
                       FROM  compras.mapa_item_anulacao
                       WHERE  mapa_item_anulacao.exercicio             = mapa_item_dotacao.exercicio
                              AND  mapa_item_anulacao.cod_mapa              = mapa_item_dotacao.cod_mapa
                              AND  mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                              AND  mapa_item_anulacao.cod_entidade          = mapa_item_dotacao.cod_entidade
                              AND  mapa_item_anulacao.cod_solicitacao       = mapa_item_dotacao.cod_solicitacao
                              AND  mapa_item_anulacao.cod_centro            = mapa_item_dotacao.cod_centro
                              AND  mapa_item_anulacao.cod_item              = mapa_item_dotacao.cod_item
                              AND  mapa_item_anulacao.lote                  = mapa_item_dotacao.lote
                              AND  mapa_item_anulacao.cod_conta             = mapa_item_dotacao.cod_conta
                              AND  mapa_item_anulacao.cod_despesa           = mapa_item_dotacao.cod_despesa )
                 ), 0.0000)
      END AS qtde_atendida
  ,  COALESCE(SUM(mapa_item_dotacao.quantidade), 0.0000) - COALESCE(SUM(
                                                                        ( SELECT  SUM(mapa_item_anulacao.quantidade)
                                                                          FROM  compras.mapa_item_anulacao
                                                                          WHERE  mapa_item_anulacao.exercicio             = mapa_item_dotacao.exercicio
                                                                                 AND  mapa_item_anulacao.cod_mapa              = mapa_item_dotacao.cod_mapa
                                                                                 AND  mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                                                                                 AND  mapa_item_anulacao.cod_entidade          = mapa_item_dotacao.cod_entidade
                                                                                 AND  mapa_item_anulacao.cod_solicitacao       = mapa_item_dotacao.cod_solicitacao
                                                                                 AND  mapa_item_anulacao.cod_centro            = mapa_item_dotacao.cod_centro
                                                                                 AND  mapa_item_anulacao.cod_item              = mapa_item_dotacao.cod_item
                                                                                 AND  mapa_item_anulacao.lote                  = mapa_item_dotacao.lote
                                                                                 AND  mapa_item_anulacao.cod_conta             = mapa_item_dotacao.cod_conta
                                                                                 AND  mapa_item_anulacao.cod_despesa           = mapa_item_dotacao.cod_despesa )
                                                                    ), 0.0000) AS qtde_em_mapas
  ,   SUM
      (
          ( SELECT  SUM(mapa_item_anulacao.quantidade)
            FROM  compras.mapa_item_anulacao
            WHERE  mapa_item_anulacao.exercicio             = mapa_item_dotacao.exercicio
                   AND  mapa_item_anulacao.cod_mapa              = mapa_item_dotacao.cod_mapa
                   AND  mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                   AND  mapa_item_anulacao.cod_entidade          = mapa_item_dotacao.cod_entidade
                   AND  mapa_item_anulacao.cod_solicitacao       = mapa_item_dotacao.cod_solicitacao
                   AND  mapa_item_anulacao.cod_centro            = mapa_item_dotacao.cod_centro
                   AND  mapa_item_anulacao.cod_item              = mapa_item_dotacao.cod_item
                   AND  mapa_item_anulacao.lote                  = mapa_item_dotacao.lote
                   AND  mapa_item_anulacao.cod_conta             = mapa_item_dotacao.cod_conta
                   AND  mapa_item_anulacao.cod_despesa           = mapa_item_dotacao.cod_despesa )
      ) AS qtde_anulado_em_mapas
FROM  compras.mapa_item
  INNER JOIN  compras.mapa_solicitacao
    ON  mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio
        AND  mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
        AND  mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
        AND  mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
        AND  mapa_solicitacao.exercicio             = mapa_item.exercicio
  LEFT JOIN  compras.mapa_item_dotacao
    ON  mapa_item_dotacao.exercicio             = mapa_item.exercicio
        AND  mapa_item_dotacao.cod_mapa              = mapa_item.cod_mapa
        AND  mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
        AND  mapa_item_dotacao.cod_entidade          = mapa_item.cod_entidade
        AND  mapa_item_dotacao.cod_solicitacao       = mapa_item.cod_solicitacao
        AND  mapa_item_dotacao.cod_centro            = mapa_item.cod_centro
        AND  mapa_item_dotacao.cod_item              = mapa_item.cod_item
        AND  mapa_item_dotacao.lote                  = mapa_item.lote
WHERE mapa_solicitacao.cod_solicitacao = :cod_solicitacao
  AND mapa_solicitacao.cod_entidade = :cod_entidade
  AND mapa_solicitacao.exercicio_solicitacao = :exercicio_solicitacao
  AND mapa_item.cod_item = :cod_item
  AND mapa_item.cod_centro = :cod_centro
SQL;

        $parameters = [
            'cod_solicitacao'       => $codSolicitacao,
            'cod_entidade'          => $codEntidade,
            'exercicio_solicitacao' => $exercicioSolicitacao,
            'cod_item'              => $codItem,
            'cod_centro'            => $codCentro,
        ];

        if (!is_null($codMapa)) {
            $sql .= " AND mapa_solicitacao.cod_mapa <> :cod_mapa";
            $parameters['cod_mapa'] = $codMapa;
        }

        if (!is_null($exercicio)) {
            $sql .= " AND mapa_solicitacao.exercicio = :exercicio";
            $parameters['exercicio'] = $exercicio;
        }

        if (!is_null($codDespesa)) {
            $sql .= " AND mapa_item_dotacao.cod_despesa = :cod_despesa";
            $parameters['cod_despesa'] = $codDespesa;
        }

        if (!is_null($codConta)) {
            $sql .= " AND mapa_item_dotacao.cod_conta = :cod_conta";
            $parameters['cod_conta'] = $codConta;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($parameters);

        $resultado = $query->fetchAll();
        $result = array_shift($resultado);

        return $result;
    }
}
