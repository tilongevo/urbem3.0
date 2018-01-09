<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class CorretagemRepository
 * @package Urbem\CoreBundle\Repository\Imobiliario
 */
class CorretagemRepository extends AbstractRepository
{
    /**
     * @param $params
     * @return array
     */
    public function getCorretagemReport($params)
    {
        $where = "";
        if (isset($params['nome']) && $params['nome'] != "") {
            $where .= sprintf(" AND UPPER ( CGM.nom_cgm ) like UPPER ('%s%%')", $params['nome']);
        }

        if (isset($params['cgmDe']) && !$params['cgmAte']) {
            $where .= sprintf(" AND CGM.numcgm >= %d", $params['cgmAte']);
        } elseif (isset($params['cgmDe']) && !$params['cgmDe'] && $params['cgmAte']) {
            $where .= sprintf(" AND CGM.numcgm =< %d", $params['cgmAte']);
        } elseif (isset($params['cgmDe']) && isset($params['cgmAte'])) {
            $where .= sprintf(" AND CGM.numcgm between %d AND %d", $params['cgmDe'], $params['cgmAte']);
        }

        if (isset($params['tipoCorretagem']) && $params['tipoCorretagem'] == "corretor") {
            $where .= " AND IM.numcgm IS NULL ";
        } elseif (isset($params['tipoCorretagem']) && $params['tipoCorretagem'] == "imobiliaria") {
            $where .= " AND COR.numcgm IS NULL ";
        }

        $orderBy = ' CGM.nom_cgm';
        if (isset($params['ordenacao']) && $params['ordenacao'] == 'cgm') {
            $orderBy = ' CGM.nom_cgm';
        } elseif (isset($params['ordenacao']) && $params['ordenacao'] == 'resp') {
            $orderBy = ' CGM_RESP.nom_cgm';
        }

        $sql = "
            SELECT
                CR.CRECI,
                CASE
                    WHEN IM.CRECI IS NOT NULL THEN IM.NUMCGM
                    WHEN COR.CRECI IS NOT NULL THEN COR.NUMCGM
                END AS NUMCGM,
                CASE
                    WHEN IM.CRECI IS NOT NULL THEN 'IMOBILIARIA'
                    WHEN COR.CRECI IS NOT NULL THEN 'CORRETOR'
                END AS TIPO_CORRETAGEM,
                CGM.NOM_CGM,
                CGM_RESP.NOM_CGM as NOM_CGM_RESP,
                CGM_RESP.NUMCGM as NUMCGM_RESP
            FROM
                imobiliario.corretagem AS CR LEFT JOIN imobiliario.imobiliaria AS IM ON CR.CRECI = IM.CRECI 
                LEFT JOIN imobiliario.corretor AS COR ON CR.CRECI = COR.CRECI 
                LEFT JOIN sw_cgm AS CGM ON IM.NUMCGM = CGM.NUMCGM OR COR.NUMCGM = CGM.NUMCGM 
                LEFT JOIN imobiliario.corretor AS COR2 ON IM.RESPONSAVEL = COR2.CRECI 
                LEFT JOIN sw_cgm AS CGM_RESP ON COR2.numcgm = CGM_RESP.NUMCGM
        ";

        if (isset($where)) {
            $sql .= sprintf("WHERE 1 = 1 %s", $where);
        }

        $sql .= sprintf("ORDER BY %s", $orderBy);

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
