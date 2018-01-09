<?php

namespace Urbem\CoreBundle\Repository\Licitacao;

use Doctrine\ORM;

class VeiculosPublicidadeRepository extends ORM\EntityRepository
{
    public function carregaVeiculosPublicidadeJson($paramsWhere)
    {
        $sql = sprintf(
            "SELECT * FROM licitacao.veiculos_publicidade vp
            INNER JOIN sw_cgm cgm 
            ON cgm.numcgm = vp.numcgm
            INNER JOIN licitacao.tipo_veiculos_publicidade tvp
            ON tvp.cod_tipo_veiculos_publicidade = vp.cod_tipo_veiculos_publicidade 
            WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
