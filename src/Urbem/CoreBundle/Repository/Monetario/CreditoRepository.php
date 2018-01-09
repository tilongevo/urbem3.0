<?php

namespace Urbem\CoreBundle\Repository\Monetario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class CreditoRepository extends AbstractRepository
{
    public function getCreditosJson($paramsWhere)
    {
        $sql = sprintf(
            "SELECT *
             FROM
                monetario.credito AS mc 
                INNER JOIN monetario.especie_credito AS me ON (
                    mc.cod_natureza = me.cod_natureza AND mc.cod_genero = me.cod_genero
                    AND mc.cod_especie = me.cod_especie)
                INNER JOIN monetario.genero_credito AS mg ON (me.cod_natureza = mg.cod_natureza AND me.cod_genero = mg.cod_genero) 
                INNER JOIN monetario.natureza_credito AS mn ON (mg.cod_natureza = mn.cod_natureza)
            WHERE %s;",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
