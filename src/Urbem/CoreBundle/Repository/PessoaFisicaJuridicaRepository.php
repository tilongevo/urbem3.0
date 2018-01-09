<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\ORM;

class PessoaFisicaJuridicaRepository extends ORM\EntityRepository
{
    public function findPessoaFisicaJuridica(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "select * from public.vw_pessoa_fisica_juridica WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
