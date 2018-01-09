<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada;

/**
 * Class VwTransferenciaViewRepository
 * @package Urbem\CoreBundle\Repository\Financeiro\Tesouraria
 */
class VwTransferenciaViewRepository extends EntityRepository
{
    /**
     * @param $exercicio
     * @param $codBoletim
     * @param $dtBoletim
     * @param $codReciboExtra
     * @return array
     */
    public function getPagamentobyCodRecibo($exercicio, $codBoletim, $dtBoletim, $codReciboExtra)
    {
        $sql = "
        SELECT t.cod_lote, t.exercicio, t.cod_entidade, t.nom_entidade, t.tipo, t.cod_boletim, t.dt_boletim, t.cod_plano_credito, 
                t.nom_conta_credito, t.cod_plano_debito, t.nom_conta_debito,t.valor, t.valor_estornado, t.cod_recurso, orc.nom_recurso, cod_credor, nom_credor, t.cod_historico, 
                t.nom_historico, t.observacao, ext.cod_recibo_extra 
        FROM tesouraria.vw_transferencia t
        INNER JOIN  tesouraria.recibo_extra_recurso extrec
        ON t.cod_recurso = extrec.cod_recurso
        INNER JOIN tesouraria.recibo_extra ext
        ON  extrec.cod_recibo_extra = ext.cod_recibo_extra
        INNER JOIN orcamento.recurso orc
        ON t.cod_recurso = orc.cod_recurso
        WHERE t.cod_recurso IS NOT NULL
        AND t.exercicio = '{$exercicio}'
        AND t.cod_boletim = {$codBoletim}
        AND t.dt_boletim = '{$dtBoletim}'
        AND ext.cod_recibo_extra = {$codReciboExtra}
        GROUP BY t.cod_lote, t.exercicio, t.cod_entidade, t.nom_entidade, t.tipo, t.cod_boletim, t.dt_boletim, t.cod_plano_credito, 
        t.nom_conta_credito, t.cod_plano_debito, t.nom_conta_debito,t.valor, t.valor_estornado, t.cod_recurso, orc.nom_recurso, cod_credor, nom_credor, t.cod_historico, t.nom_historico, t.observacao, ext.cod_recibo_extra";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
