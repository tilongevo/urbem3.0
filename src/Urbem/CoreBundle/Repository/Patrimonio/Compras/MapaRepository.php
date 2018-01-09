<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class MapaRepository extends AbstractRepository
{
    public function montaRecuperaMapaSolicitacoes($codMapa = false, $exercicio = false)
    {
        $sql = "
        SELECT  DISTINCT solicitacao.exercicio
                       ,  solicitacao.cod_entidade
                       ,  sw_cgm.nom_cgm as nom_entidade
                       ,  solicitacao.cod_solicitacao
                       ,  TO_CHAR(solicitacao_homologada.timestamp,'dd/mm/yyyy') as data
                       ,  TO_CHAR(solicitacao.timestamp,'dd/mm/yyyy') as data_solicitacao
                       ,  mapa_solicitacao.exercicio_solicitacao as exercicio_solicitacao

                       -- TOTAL DA SOLICITAÇÃO (TOTAL - ANULAÇÃO)
                       ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.solicitacao_item
                             WHERE  solicitacao_item.exercicio       = solicitacao.exercicio
                               AND  solicitacao_item.cod_entidade    = solicitacao.cod_entidade
                               AND  solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
                          ) -
                          ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.solicitacao_item_anulacao
                             WHERE
                             -- solicitacao_item_anulacao.exercicio       = solicitacao.exercicio
                               -- AND
                               -- solicitacao_item_anulacao.cod_entidade    = solicitacao.cod_entidade
                               -- AND
                               solicitacao_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                          ) AS valor_total

                       -- TOTAL EM MAPA
                       ,  ( SELECT  COALESCE(SUM(vl_total), 0.00)
                              FROM  compras.mapa_item
                             WHERE  mapa_item.exercicio_solicitacao = solicitacao.exercicio
                               AND  mapa_item.cod_solicitacao       = solicitacao.cod_solicitacao
                               AND  mapa_item.cod_entidade          = solicitacao.cod_entidade
                          ) - COALESCE(anulacao.total_anulado, 0.00) AS total_mapas

                       -- TOTAL NESTE MAPA
                       ,  (total.total_mapa - total.total_mapa_anulado) as total_mapa
                       ,  COALESCE(anulacao.total_anulado, 0.00) as total_anulado
                       ,  COALESCE(total.total_mapa_anulado, 0.00) as total_mapa_anulado
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
                                    ) as total_mapa

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
                          ) as total
                      ON  mapa_solicitacao.exercicio_solicitacao = total.exercicio
                     AND  mapa_solicitacao.cod_entidade          = total.cod_entidade
                     AND  mapa_solicitacao.cod_solicitacao       = total.cod_solicitacao
                     AND  mapa_solicitacao.cod_mapa              = total.cod_mapa

               LEFT JOIN  (
                            SELECT  mapa_item_anulacao.exercicio_solicitacao
                                 ,  mapa_item_anulacao.cod_entidade
                                 ,  mapa_item_anulacao.cod_solicitacao
                                 ,  SUM(vl_total) as total_anulado

                              FROM  compras.mapa_item_anulacao

                          GROUP BY  exercicio_solicitacao
                                 ,  cod_entidade
                                 ,  cod_solicitacao
                          ) as anulacao
                      ON  solicitacao.cod_solicitacao = anulacao.cod_solicitacao
                     AND  solicitacao.exercicio       = anulacao.exercicio_solicitacao
                     AND  solicitacao.cod_entidade    = anulacao.cod_entidade

                   WHERE  1=1";

        if ($codMapa) {
            $sql .= " AND mapa_solicitacao.cod_mapa = $codMapa";
        }

        if ($exercicio) {
            $sql .= " AND solicitacao.exercicio = '$exercicio'";
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function recuperaMapasAnulacao($codMapa, $exercicio)
    {
        $sql = "
        select
	mapa.exercicio,
	mapa.cod_mapa,
	mapa.cod_objeto,
	mapa.timestamp,
	to_char(
		mapa.timestamp,
		'dd/mm/yyyy'
	) as data,
	mapa.cod_tipo_licitacao,
	total_mapa.total_quantidade_mapa,
	total_mapa.vl_total_mapa - coalesce(
		anulacao.vl_total_anulacao,
		0
	) as valor_total,
	coalesce(
		anulacao.quantidade_total_anulacao,
		0
	) as quantidade_total_anulacao,
	coalesce(
		anulacao.vl_total_anulacao,
		0
	) as vl_total_anulacao,
	substring( objeto.descricao, 1, 60 ) as descricao
from
	compras.mapa join(
		select
			mapa_item.exercicio,
			mapa_item.cod_mapa,
			sum( mapa_item.quantidade ) as total_quantidade_mapa,
			sum( mapa_item.vl_total ) as vl_total_mapa
		from
			compras.mapa_item
		group by
			mapa_item.exercicio,
			mapa_item.cod_mapa
	) as total_mapa on
	(
		total_mapa.exercicio = mapa.exercicio
		and total_mapa.cod_mapa = mapa.cod_mapa
	) join compras.objeto on
	(
		mapa.cod_objeto = objeto.cod_objeto
	) left join(
		select
			mapa_solicitacao_anulacao.exercicio,
			mapa_solicitacao_anulacao.cod_mapa,
			coalesce(
				sum( mapa_item_anulacao.quantidade ),
				'0'
			) as quantidade_total_anulacao,
			coalesce(
				sum( mapa_item_anulacao.vl_total ),
				'0'
			) as vl_total_anulacao
		from
			compras.mapa_solicitacao_anulacao join compras.mapa_item_anulacao on
			(
				mapa_item_anulacao.exercicio = mapa_solicitacao_anulacao.exercicio
				and mapa_item_anulacao.cod_mapa = mapa_solicitacao_anulacao.cod_mapa
				and mapa_item_anulacao.exercicio_solicitacao = mapa_solicitacao_anulacao.exercicio_solicitacao
				and mapa_item_anulacao.cod_entidade = mapa_solicitacao_anulacao.cod_entidade
				and mapa_item_anulacao.cod_solicitacao = mapa_solicitacao_anulacao.cod_solicitacao
				and mapa_item_anulacao.timestamp = mapa_solicitacao_anulacao.timestamp
			)
		group by
			mapa_solicitacao_anulacao.exercicio,
			mapa_solicitacao_anulacao.cod_mapa
	) as anulacao on
	(
		anulacao.exercicio = mapa.exercicio
		and anulacao.cod_mapa = mapa.cod_mapa
	)
where
	total_mapa.total_quantidade_mapa > coalesce(
		anulacao.quantidade_total_anulacao,
		0
	)
	and(
		total_mapa.vl_total_mapa - coalesce(
			anulacao.vl_total_anulacao,
			0
		)
	) > '0.00'
	and(
		not exists(
			select
				*
			from
				compras.compra_direta
			where
				compra_direta.exercicio_mapa = mapa.exercicio
				and compra_direta.cod_mapa = mapa.cod_mapa
				and not exists(
					select
						*
					from
						compras.compra_direta_anulacao
					where
						compra_direta.cod_compra_direta = compra_direta_anulacao.cod_compra_direta
						and compra_direta.cod_modalidade = compra_direta_anulacao.cod_modalidade
						and compra_direta.cod_entidade = compra_direta_anulacao.cod_entidade
						and compra_direta.exercicio_entidade = compra_direta_anulacao.exercicio_entidade
				)
		)
		and not exists(
			select
				*
			from
				licitacao.licitacao
			where
				licitacao.exercicio_mapa = mapa.exercicio
				and licitacao.cod_mapa = mapa.cod_mapa
				and not exists(
					select
						*
					from
						licitacao.licitacao_anulada
					where
						licitacao.cod_licitacao = licitacao_anulada.cod_licitacao
						and licitacao.cod_modalidade = licitacao_anulada.cod_modalidade
						and licitacao.cod_entidade = licitacao_anulada.cod_entidade
						and licitacao.exercicio = licitacao_anulada.exercicio
				)
		)
	)
	and(
		exists(
			select
				1
			from
				compras.compra_direta
			where
				compra_direta.exercicio_mapa = mapa.exercicio
				and compra_direta.cod_mapa = mapa.cod_mapa
		)
		or exists(
			select
				1
			from
				licitacao.licitacao
			where
				licitacao.exercicio_mapa = mapa.exercicio
				and licitacao.cod_mapa = mapa.cod_mapa
		)
	)
	and(
		exists(
			select
				1
			from
				compras.compra_direta join compras.compra_direta_anulacao on
				compra_direta.cod_compra_direta = compra_direta_anulacao.cod_compra_direta
				and compra_direta.cod_modalidade = compra_direta_anulacao.cod_modalidade
				and compra_direta.cod_entidade = compra_direta_anulacao.cod_entidade
				and compra_direta.exercicio_entidade = compra_direta_anulacao.exercicio_entidade
			where
				compra_direta.exercicio_mapa = mapa.exercicio
				and compra_direta.cod_mapa = mapa.cod_mapa
		)
		or exists(
			select
				1
			from
				licitacao.licitacao join licitacao.licitacao_anulada on
				licitacao.cod_licitacao = licitacao_anulada.cod_licitacao
				and licitacao.cod_modalidade = licitacao_anulada.cod_modalidade
				and licitacao.cod_entidade = licitacao_anulada.cod_entidade
				and licitacao.exercicio = licitacao_anulada.exercicio
			where
				licitacao.exercicio_mapa = mapa.exercicio
				and licitacao.cod_mapa = mapa.cod_mapa
		)
	)
	and(
		not exists(
			select
				1
			from
				compras.compra_direta as ccd join compras.mapa as cm on
				ccd.exercicio_mapa = cm.exercicio
				and ccd.cod_mapa = cm.cod_mapa join compras.mapa_cotacao as cmc on
				cmc.exercicio_cotacao = cm.exercicio
				and cmc.cod_mapa = cm.cod_mapa join compras.cotacao as c on
				c.exercicio = cmc.exercicio_cotacao
				and c.cod_cotacao = cmc.cod_cotacao join empenho.item_pre_empenho_julgamento as eipej on
				eipej.exercicio = c.exercicio
				and eipej.cod_cotacao = c.cod_cotacao join empenho.item_pre_empenho as eipe on
				eipe.cod_pre_empenho = eipej.cod_pre_empenho
				and eipe.exercicio = eipej.exercicio
				and eipe.num_item = eipej.num_item join empenho.pre_empenho as epe on
				epe.cod_pre_empenho = eipe.cod_pre_empenho
				and epe.exercicio = eipe.exercicio join empenho.autorizacao_empenho as eae on
				eae.exercicio = epe.exercicio
				and eae.cod_pre_empenho = epe.cod_pre_empenho
			where
				ccd.cod_mapa = mapa.cod_mapa
				and ccd.exercicio_mapa = mapa.exercicio
		)
		or exists(
			select
				1
			from
				compras.compra_direta as ccd join compras.mapa as cm on
				ccd.exercicio_mapa = cm.exercicio
				and ccd.cod_mapa = cm.cod_mapa join compras.mapa_cotacao as cmc on
				cmc.exercicio_cotacao = cm.exercicio
				and cmc.cod_mapa = cm.cod_mapa join compras.cotacao as c on
				c.exercicio = cmc.exercicio_cotacao
				and c.cod_cotacao = cmc.cod_cotacao join empenho.item_pre_empenho_julgamento as eipej on
				eipej.exercicio = c.exercicio
				and eipej.cod_cotacao = c.cod_cotacao join empenho.item_pre_empenho as eipe on
				eipe.cod_pre_empenho = eipej.cod_pre_empenho
				and eipe.exercicio = eipej.exercicio
				and eipe.num_item = eipej.num_item join empenho.pre_empenho as epe on
				epe.cod_pre_empenho = eipe.cod_pre_empenho
				and epe.exercicio = eipe.exercicio join empenho.autorizacao_empenho as eae on
				eae.exercicio = epe.exercicio
				and eae.cod_pre_empenho = epe.cod_pre_empenho join empenho.autorizacao_anulada as eaa on
				eaa.exercicio = eae.exercicio
				and eaa.cod_entidade = eae.cod_entidade
				and eaa.cod_autorizacao = eae.cod_autorizacao
			where
				ccd.cod_mapa = mapa.cod_mapa
				and ccd.exercicio_mapa = mapa.exercicio
		)
	)
	and mapa.exercicio = '" . $exercicio . "'
	and mapa.cod_mapa = $codMapa
order by
	mapa.cod_mapa desc;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = array_shift($query->fetchAll(\PDO::FETCH_OBJ));
        return $result;
    }

    public function montaRecuperaValoresTotaisSolicitacao($codSolicitacao = false, $exercicio = false, $codEntidade = false)
    {
        $stSql = " SELECT sum(vl_total) as total
           FROM compras.solicitacao_item ";
        if ($codSolicitacao) {
            $stSql .= " WHERE solicitacao_item.cod_solicitacao = $codSolicitacao";
        }
        if ($exercicio) {
            $stSql .= " AND solicitacao_item.exercicio = '" . $exercicio . "'";
        }
        if ($codEntidade) {
            $stSql .= " AND solicitacao_item.cod_entidade = $codEntidade";
        }
        $stSql .= " and not exists (select * from compras.solicitacao_item_anulacao
                       where solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                         and solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
                         and solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro)	";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @param $codMapa
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaMapaItemReserva($codSolicitacao, $codEntidade, $exercicio, $codMapa)
    {
        $stSql = "
            SELECT  mapa_item.cod_solicitacao
                 ,  mapa_item.exercicio
              FROM  compras.mapa_item
        INNER JOIN  compras.mapa_solicitacao
                ON  mapa_solicitacao.exercicio = mapa_item.exercicio
               AND  mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
               AND  mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND  mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
               AND  mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
        INNER JOIN  compras.solicitacao
                ON  solicitacao.exercicio = mapa_solicitacao.exercicio_solicitacao
               AND  solicitacao.cod_entidade = mapa_solicitacao.cod_entidade
               AND  solicitacao.cod_solicitacao = mapa_solicitacao.cod_solicitacao
             WHERE
        NOT EXISTS  (
                        SELECT  1
                          FROM  compras.mapa_item_reserva
                     LEFT JOIN  orcamento.reserva_saldos_anulada
                            ON  reserva_saldos_anulada.cod_reserva  = mapa_item_reserva.cod_reserva
                           AND  reserva_saldos_anulada.exercicio    = mapa_item_reserva.exercicio_reserva
                         WHERE  mapa_item_reserva.exercicio_mapa  = mapa_item.exercicio
                           AND  mapa_item_reserva.cod_entidade    = mapa_item.cod_entidade
                           AND  mapa_item_reserva.cod_solicitacao = mapa_item.cod_solicitacao
                           AND  mapa_item_reserva.cod_centro      = mapa_item.cod_centro
                           AND  mapa_item_reserva.cod_item        = mapa_item.cod_item
                           AND  mapa_item_reserva.cod_mapa        = mapa_item.cod_mapa
                           AND  mapa_item_reserva.exercicio_mapa  = mapa_item.exercicio
                           AND  reserva_saldos_anulada.cod_reserva IS NULL
                    )
               AND  mapa_item.cod_solicitacao = $codSolicitacao
               AND  mapa_item.cod_entidade    = $codEntidade
               AND  mapa_item.exercicio       = '" . $exercicio . "'
               AND  mapa_item.cod_mapa        = $codMapa
               AND  solicitacao.registro_precos = FALSE";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codMapa
     * @return bool
     * @throws \Doctrine\DBAL\DBALException[
     */
    public function hasAdjudicacao($exercicio, $codMapa)
    {
        $sql = 'select licitacao.exercicio
               , licitacao.cod_mapa
            from licitacao.licitacao
            join licitacao.cotacao_licitacao
              on ( licitacao.cod_licitacao  = cotacao_licitacao.cod_licitacao
                  and   licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
                  and   licitacao.cod_entidade   = cotacao_licitacao.cod_entidade
                  and   licitacao.exercicio      = cotacao_licitacao.exercicio_licitacao)
            join licitacao.adjudicacao
              on ( cotacao_licitacao.cod_licitacao       = adjudicacao.cod_licitacao
                  and   cotacao_licitacao.cod_modalidade      = adjudicacao.cod_modalidade
                  and   cotacao_licitacao.cod_entidade        = adjudicacao.cod_entidade
                  and   cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                  and   cotacao_licitacao.lote                = adjudicacao.lote
                  and   cotacao_licitacao.cod_cotacao         = adjudicacao.cod_cotacao
                  and   cotacao_licitacao.cod_item            = adjudicacao.cod_item
                  and   cotacao_licitacao.exercicio_cotacao   = adjudicacao.exercicio_cotacao
                  and   cotacao_licitacao.cgm_fornecedor      = adjudicacao.cgm_fornecedor)
          where not exists ( select *
                from licitacao.adjudicacao_anulada
                              where adjudicacao.num_adjudicacao       = adjudicacao_anulada.num_adjudicacao
            and adjudicacao.cod_entidade          = adjudicacao_anulada.cod_entidade
            and adjudicacao.cod_modalidade        = adjudicacao_anulada.cod_modalidade
            and adjudicacao.cod_licitacao         = adjudicacao_anulada.cod_licitacao
            and adjudicacao.exercicio_licitacao   = adjudicacao_anulada.exercicio_licitacao
            and adjudicacao.cod_item              = adjudicacao_anulada.cod_item
            and adjudicacao.cod_cotacao           = adjudicacao_anulada.cod_cotacao
            and adjudicacao.lote                  = adjudicacao_anulada.lote
            and adjudicacao.exercicio_cotacao     = adjudicacao_anulada.exercicio_cotacao
            and adjudicacao.cgm_fornecedor        = adjudicacao_anulada.cgm_fornecedor )
            and exercicio_mapa                    = :exercicio 
            and cod_mapa                          = :codMapa';

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa,
        ]);
        $result = $stmt->fetchAll();

        return !empty($result);
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function getProximoCodMapa($exercicio)
    {
        return $this->nextVal('cod_mapa', ['exercicio' => $exercicio]);
    }

    /**
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getMapasDisponiveisArray($exercicio)
    {
        $sql = "
        SELECT mapa.exercicio
	                         , mapa.cod_mapa
	                         , mapa.cod_objeto
	                         , mapa.timestamp
	                         , to_char( mapa.timestamp, 'dd/mm/yyyy' ) as data
	                         , mapa.cod_tipo_licitacao
	                      FROM compras.mapa
	                 LEFT JOIN compras.mapa_cotacao
	                        ON mapa_cotacao.cod_mapa  = mapa.cod_mapa
	                       AND mapa_cotacao.exercicio_mapa = mapa.exercicio
	                 LEFT JOIN empenho.item_pre_empenho_julgamento
	                        ON item_pre_empenho_julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
	                       AND item_pre_empenho_julgamento.exercicio   = mapa_cotacao.exercicio_cotacao
	                     WHERE 1=1
	                    -- Teste para não listar mapas que já tiveram autorização de empenho realizada,
	                    -- mesmo que a autorização tenha sido cancelada.
	                       AND item_pre_empenho_julgamento.cod_cotacao IS NULL
	                    ---- este sub select server pra verificar se existem itens não anulados para cada mapa
	                       AND EXISTS(SELECT mapa_item.exercicio
	                                       , mapa_item.cod_entidade
	                                       , mapa_item.cod_solicitacao
	                                       , mapa_item.cod_mapa
	                                       , mapa_item.exercicio_solicitacao
	                                       , mapa_item.cod_item
	                                    FROM compras.mapa_item
	                               LEFT JOIN (SELECT mapa_item_anulacao.exercicio
	                                               , mapa_item_anulacao.cod_entidade
	                                               , mapa_item_anulacao.cod_solicitacao
	                                               , mapa_item_anulacao.cod_mapa
	                                               , mapa_item_anulacao.cod_centro
	                                               , mapa_item_anulacao.cod_item
	                                               , mapa_item_anulacao.exercicio_solicitacao
	                                               , mapa_item_anulacao.lote
	                                               , SUM( mapa_item_anulacao.quantidade ) as quantidade
	                                               , SUM( mapa_item_anulacao.vl_total )  as vl_total
	                                            FROM compras.mapa_item_anulacao
	                                        GROUP BY mapa_item_anulacao.exercicio
	                                               , mapa_item_anulacao.cod_entidade
	                                               , mapa_item_anulacao.cod_solicitacao
	                                               , mapa_item_anulacao.cod_mapa
	                                               , mapa_item_anulacao.cod_centro
	                                               , mapa_item_anulacao.cod_item
	                                               , mapa_item_anulacao.exercicio_solicitacao
	                                               , mapa_item_anulacao.lote
	                                         ) as anulacao
	                                      ON mapa_item.exercicio             = anulacao.exercicio
	                                     AND mapa_item.cod_entidade          = anulacao.cod_entidade
	                                     AND mapa_item.cod_solicitacao       = anulacao.cod_solicitacao
	                                     AND mapa_item.cod_mapa              = anulacao.cod_mapa
	                                     AND mapa_item.cod_centro            = anulacao.cod_centro
	                                     AND mapa_item.cod_item              = anulacao.cod_item
	                                     AND mapa_item.exercicio_solicitacao = anulacao.exercicio_solicitacao
	                                     AND mapa_item.lote                  = anulacao.lote
	                                   WHERE mapa_item.quantidade > coalesce( anulacao.quantidade, 0 )
	                                     AND mapa_item.vl_total   > coalesce( anulacao.vl_total,   0 )
	                                     AND mapa_item.cod_mapa   = mapa.cod_mapa
	                                     AND mapa_item.exercicio  = mapa.exercicio)
	                    --- verificando se o mapa já foi usado em outro processo (licitacao)
	                       AND NOT EXISTS (SELECT licitacao.exercicio_mapa
	                                            , licitacao.cod_mapa
	                                         FROM licitacao.licitacao
	                                        WHERE NOT EXISTS (SELECT 1
	                                                            FROM licitacao.licitacao_anulada
	                                                           WHERE licitacao_anulada.cod_licitacao  = licitacao.cod_licitacao
	                                                             AND licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
	                                                             AND licitacao_anulada.cod_entidade   = licitacao.cod_entidade
	                                                             AND licitacao_anulada.exercicio      = licitacao.exercicio
	                                                         )
	                                          AND licitacao.exercicio_mapa = mapa.exercicio
	                                          AND licitacao.cod_mapa       = mapa.cod_mapa)
	                       AND NOT EXISTS (SELECT 1
	                                         FROM compras.compra_direta
	                                        WHERE NOT EXISTS (SELECT 1
	                                                            FROM compras.compra_direta_anulacao
	                                                           WHERE compra_direta_anulacao.cod_modalidade     = compra_direta.cod_modalidade
	                                                             AND compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
	                                                             AND compra_direta_anulacao.cod_entidade       = compra_direta.cod_entidade
	                                                             AND compra_direta_anulacao.cod_compra_direta  = compra_direta.cod_compra_direta
	                                                         )
	                                          AND compra_direta.cod_mapa       = mapa.cod_mapa
	                                          AND compra_direta.exercicio_mapa = mapa.exercicio)
	         and   mapa.exercicio = '" . $exercicio . "'
	 and not exists( SELECT
	                                       cotacao.cod_cotacao
	                                     , cotacao.exercicio
	                                     , max(cotacao.timestamp) as timestamp
	                                  FROM
	                                       compras.cotacao
	                                       INNER JOIN empenho.item_pre_empenho_julgamento
	                                               ON item_pre_empenho_julgamento.cod_cotacao = cotacao.cod_cotacao
	                                              AND item_pre_empenho_julgamento.exercicio   = cotacao.exercicio
	                                       INNER JOIN empenho.item_pre_empenho
	                                               ON item_pre_empenho.cod_pre_empenho = item_pre_empenho_julgamento.cod_pre_empenho
	                                              AND item_pre_empenho.exercicio       = item_pre_empenho_julgamento.exercicio
	                                              AND item_pre_empenho.num_item        = item_pre_empenho_julgamento.num_item
	                                       INNER JOIN empenho.pre_empenho
	                                               ON item_pre_empenho.exercicio = pre_empenho.exercicio
	                                              AND item_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
	                                       INNER JOIN empenho.autorizacao_empenho
	                                               ON autorizacao_empenho.exercicio       = pre_empenho.exercicio
	                                              AND autorizacao_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
	                                       INNER JOIN compras.mapa_cotacao
	                                               ON mapa_cotacao.exercicio_cotacao = cotacao.exercicio
	                                              AND mapa_cotacao.cod_cotacao       = cotacao.cod_cotacao
	                                 WHERE
	                                       mapa_cotacao.exercicio_mapa = mapa.exercicio
	                                   AND mapa_cotacao.cod_mapa       = mapa.cod_mapa
	                              GROUP BY
	                                       cotacao.exercicio
	                                     , cotacao.cod_cotacao )
	                GROUP BY mapa.exercicio
	                       , mapa.cod_mapa
	                       , mapa.cod_objeto
	                       , mapa.timestamp
	                       , mapa.cod_tipo_licitacao
	 ORDER by  mapa.exercicio,
	             mapa.cod_mapa;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function recuperMapaDisponiveisCompraDireta($exercicio)
    {
        $sql = "SELECT mapa.exercicio
	                         , mapa.cod_mapa
	                         , mapa.cod_objeto
	                         , mapa.timestamp
	                         , to_char( mapa.timestamp, 'dd/mm/yyyy' ) as data
	                         , mapa.cod_tipo_licitacao
	                      FROM compras.mapa
	                 LEFT JOIN compras.mapa_cotacao
	                        ON mapa_cotacao.cod_mapa  = mapa.cod_mapa
	                       AND mapa_cotacao.exercicio_mapa = mapa.exercicio
	                 LEFT JOIN empenho.item_pre_empenho_julgamento
	                        ON item_pre_empenho_julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
	                       AND item_pre_empenho_julgamento.exercicio   = mapa_cotacao.exercicio_cotacao
	                     WHERE 1=1
	                    -- Teste para não listar mapas que já tiveram autorização de empenho realizada,
	                    -- mesmo que a autorização tenha sido cancelada.
	                       AND item_pre_empenho_julgamento.cod_cotacao IS NULL
	                    ---- este sub select server pra verificar se existem itens não anulados para cada mapa
	                       AND EXISTS(SELECT mapa_item.exercicio
	                                       , mapa_item.cod_entidade
	                                       , mapa_item.cod_solicitacao
	                                       , mapa_item.cod_mapa
	                                       , mapa_item.exercicio_solicitacao
	                                       , mapa_item.cod_item
	                                    FROM compras.mapa_item
	                               LEFT JOIN (SELECT mapa_item_anulacao.exercicio
	                                               , mapa_item_anulacao.cod_entidade
	                                               , mapa_item_anulacao.cod_solicitacao
	                                               , mapa_item_anulacao.cod_mapa
	                                               , mapa_item_anulacao.cod_centro
	                                               , mapa_item_anulacao.cod_item
	                                               , mapa_item_anulacao.exercicio_solicitacao
	                                               , mapa_item_anulacao.lote
	                                               , SUM( mapa_item_anulacao.quantidade ) as quantidade
	                                               , SUM( mapa_item_anulacao.vl_total )  as vl_total
	                                            FROM compras.mapa_item_anulacao
	                                        GROUP BY mapa_item_anulacao.exercicio
	                                               , mapa_item_anulacao.cod_entidade
	                                               , mapa_item_anulacao.cod_solicitacao
	                                               , mapa_item_anulacao.cod_mapa
	                                               , mapa_item_anulacao.cod_centro
	                                               , mapa_item_anulacao.cod_item
	                                               , mapa_item_anulacao.exercicio_solicitacao
	                                               , mapa_item_anulacao.lote
	                                         ) as anulacao
	                                      ON mapa_item.exercicio             = anulacao.exercicio
	                                     AND mapa_item.cod_entidade          = anulacao.cod_entidade
	                                     AND mapa_item.cod_solicitacao       = anulacao.cod_solicitacao
	                                     AND mapa_item.cod_mapa              = anulacao.cod_mapa
	                                     AND mapa_item.cod_centro            = anulacao.cod_centro
	                                     AND mapa_item.cod_item              = anulacao.cod_item
	                                     AND mapa_item.exercicio_solicitacao = anulacao.exercicio_solicitacao
	                                     AND mapa_item.lote                  = anulacao.lote
	                                   WHERE mapa_item.quantidade > coalesce( anulacao.quantidade, 0 )
	                                     AND mapa_item.vl_total   > coalesce( anulacao.vl_total,   0 )
	                                     AND mapa_item.cod_mapa   = mapa.cod_mapa
	                                     AND mapa_item.exercicio  = mapa.exercicio
	                                 )
	                    --- verificando se o mapa já foi usado em outro processo (licitacao)
	                       AND NOT EXISTS (SELECT licitacao.exercicio_mapa
	                                            , licitacao.cod_mapa
	                                         FROM licitacao.licitacao
	                                        WHERE NOT EXISTS (SELECT 1
	                                                            FROM licitacao.licitacao_anulada
	                                                           WHERE licitacao_anulada.cod_licitacao  = licitacao.cod_licitacao
	                                                             AND licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
	                                                             AND licitacao_anulada.cod_entidade   = licitacao.cod_entidade
	                                                             AND licitacao_anulada.exercicio      = licitacao.exercicio
	                                                         )
	                                          AND licitacao.exercicio_mapa = mapa.exercicio
	                                          AND licitacao.cod_mapa       = mapa.cod_mapa
	                                      )
	                       AND NOT EXISTS (SELECT 1
	                                         FROM compras.compra_direta
	                                        WHERE NOT EXISTS (SELECT 1
	                                                            FROM compras.compra_direta_anulacao
	                                                           WHERE compra_direta_anulacao.cod_modalidade     = compra_direta.cod_modalidade
	                                                             AND compra_direta_anulacao.exercicio_entidade = compra_direta.exercicio_entidade
	                                                             AND compra_direta_anulacao.cod_entidade       = compra_direta.cod_entidade
	                                                             AND compra_direta_anulacao.cod_compra_direta  = compra_direta.cod_compra_direta
	                                                         )
	                                          AND compra_direta.cod_mapa       = mapa.cod_mapa
	                                          AND compra_direta.exercicio_mapa = mapa.exercicio
	                                      )
	                    --- verificando se todos os itens do mapa tem reserva de saldos
	                       AND NOT EXISTS (SELECT 1
	                                         FROM compras.mapa_item
--	                                        WHERE NOT EXISTS (SELECT 1
	                                        WHERE EXISTS (SELECT 1
	                                                            FROM compras.mapa_item_reserva
	                                                           WHERE mapa_item_reserva.exercicio_mapa        = mapa_item.exercicio
	                                                             AND mapa_item_reserva.cod_mapa              = mapa_item.cod_mapa
	                                                             AND mapa_item_reserva.exercicio_solicitacao = mapa_item.exercicio_solicitacao
	                                                             AND mapa_item_reserva.cod_entidade          = mapa_item.cod_entidade
	                                                             AND mapa_item_reserva.cod_solicitacao       = mapa_item.cod_solicitacao
	                                                             AND mapa_item_reserva.cod_centro            = mapa_item.cod_centro
	                                                             AND mapa_item_reserva.cod_item              = mapa_item.cod_item
	                                                             AND mapa_item_reserva.lote                  = mapa_item.lote
	                                                         )
	                                          --Se a Reserva for do tipo Rigida, é Obrigatório ter Reserva de Saldo
	                                          AND (SELECT valor
	                                                 FROM administracao.configuracao AS AC
	                                                WHERE AC.cod_modulo = 35
	                                                  AND AC.parametro = 'reserva_rigida'
	                                                  AND AC.exercicio = mapa.exercicio
	                                              ) = 'true'
	                                          AND mapa_item.exercicio = mapa.exercicio
	                                          AND mapa_item.cod_mapa  = mapa.cod_mapa
	                                      )
	         and   mapa.exercicio = '" . $exercicio . "'
	                GROUP BY mapa.exercicio
	                       , mapa.cod_mapa
	                       , mapa.cod_objeto
	                       , mapa.timestamp
	                       , mapa.cod_tipo_licitacao 
	 ORDER by  mapa.exercicio,
	             mapa.cod_mapa;";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Mapa');

        $orx = $qb->expr()->orX();

        $like = $qb->expr()->like('string(Mapa.codMapa)', ':term');
        $orx->add($like);

        $like = $qb->expr()->like('Mapa.exercicio', ':term');
        $orx->add($like);

        $like = $qb->expr()->like("CONCAT(string(Mapa.codMapa), '/', Mapa.exercicio)", ':term');
        $orx->add($like);

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Mapa.codMapa');
        $qb->setMaxResults(10);

        return $qb;
    }
}
