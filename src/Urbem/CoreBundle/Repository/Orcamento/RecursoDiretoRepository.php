<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

class RecursoDiretoRepository extends ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findByUniqueRecursoDireto()
    {
        $query = $this->_em->getConnection()->prepare(
            "select distinct(cod_recurso), concat(cod_recurso, ' - ', nom_recurso) as recurso from orcamento.recurso_direto order by 2"
        );

        $query->execute();
        return $query->fetchAll();
    }
}
