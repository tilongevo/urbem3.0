<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM\EntityRepository;

/**
 * Class SociedadeRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class SociedadeRepository extends EntityRepository
{
    /**
     * @param $params
     * @return array
     */
    public function getSociedadeCadastroEconomico($params)
    {
        $sql = sprintf(
            "SELECT
                DISTINCT consulta.numcgm,
                consulta.nom_cgm,
                consulta.socio,
                sociedade.quota_socio
            FROM (
                SELECT
                    cesocio.numcgm,
                    cgm.nom_cgm,
                    cesocio.numcgm || ' - ' || cgm.nom_cgm AS socio,
                    max( cesocio.timestamp ) AS timestamp
                FROM economico.sociedade AS cesocio INNER JOIN sw_cgm AS cgm ON cgm.numcgm = cesocio.numcgm
                WHERE 
                    cesocio.inscricao_economica = %d
                    AND cesocio.numcgm IN (%d)
                GROUP BY 1, 2, 3
                ORDER BY cgm.nom_cgm
            ) AS consulta JOIN economico.sociedade ON sociedade.numcgm = consulta.numcgm
            AND sociedade.timestamp = consulta.timestamp
        ",
            $params['numSocios'],
            $params['numcgm']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
