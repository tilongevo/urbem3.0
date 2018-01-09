<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class MapaItemReservaRepository extends ORM\EntityRepository
{
    /**
     * @param $stItens
     * @param $codMapa
     * @param $exercicioMapa
     * @param $codSolicitacao
     * @param $exercicioSolicitacao
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaReservas($stItens, $codMapa, $exercicioMapa, $codSolicitacao, $exercicioSolicitacao)
    {
        $stSql  = "SELECT
                      mapa_item_reserva.exercicio_reserva
        			  ,  mapa_item_reserva.cod_reserva
        			  ,  mapa_item_reserva.cod_despesa
        			  ,  mapa_item_reserva.cod_conta
        			  ,  mapa_item_reserva.cod_item
        			  ,  mapa_item_reserva.cod_centro
        			  ,  mapa_item_reserva.cod_entidade
        			  ,  solicitacao_homologada_reserva.cod_reserva as cod_reserva_solicitacao
        			  ,  solicitacao_homologada_reserva.exercicio   as exercicio_reserva_solicitacao
        			  ,  COALESCE(reserva_saldos_solicitacao.vl_reserva, 0.00) as vl_reserva_solicitacao
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
           		     ) as reserva_saldos_solicitacao
           	     ON  solicitacao_homologada_reserva.cod_reserva = reserva_saldos_solicitacao.cod_reserva
           	    AND  solicitacao_homologada_reserva.exercicio   = reserva_saldos_solicitacao.exercicio
           	    LEFT JOIN compras.mapa_cotacao
                                ON mapa_cotacao.cod_mapa = mapa_item_reserva.cod_mapa
                                   AND mapa_cotacao.exercicio_mapa = mapa_item_reserva.exercicio_mapa
                             LEFT JOIN compras.cotacao
                                ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
                                   AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
                             LEFT JOIN compras.cotacao_anulada
                                ON cotacao.cod_cotacao = cotacao_anulada.cod_cotacao
                                   AND cotacao.exercicio = cotacao_anulada.exercicio
                             LEFT JOIN compras.cotacao_item
                                ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
                                   AND cotacao.exercicio = cotacao_item.exercicio
                             LEFT JOIN compras.cotacao_fornecedor_item
                                ON cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
                                   AND cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                                   AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
                                   AND cotacao_item.lote = cotacao_fornecedor_item.lote
                            WHERE mapa_item_reserva.cod_item NOT IN (".$stItens.")
                                   AND mapa_item_reserva.cod_mapa = ".$codMapa."
                                   AND mapa_item_reserva.exercicio_mapa = '".$exercicioMapa."'
                                   AND mapa_item_reserva.cod_solicitacao = ".$codSolicitacao."
                                   AND mapa_item_reserva.exercicio_solicitacao = '".$exercicioSolicitacao."'
                                   AND cotacao_fornecedor_item.cod_cotacao IS NULL
                                   AND cotacao_anulada.cod_cotacao IS NULL
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
           	    ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
