<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;

/**
 * Class RotaRepository
 *
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class RotaRepository extends ORM\EntityRepository
{
    /**
     * @param $rotaSuperior
     *
     * @return array
     */
    public function findByRotaSuperior($rotaSuperior)
    {
        $sql = sprintf(
            "
            SELECT concat(r2.traducao_rota, ' > ' , r1.traducao_rota) AS descricao_rota, r1.cod_rota 
            FROM administracao.rota r1 JOIN administracao.rota r2 ON (r1.rota_superior = r2.descricao_rota)
            WHERE r1.rota_superior like '%%_%s_%%'",
            $rotaSuperior
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
