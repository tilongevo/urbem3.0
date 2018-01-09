<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\SwCgm;

class ResponsavelTecnicoRepository extends ORM\EntityRepository
{
    public function getMaxSequenciaByCgm(SwCgm $cgm)
    {
        $sql = sprintf(
            "SELECT max(sequencia) as max_sequencia
            FROM economico.responsavel
            WHERE numcgm = %d",
            $cgm->getNumCgm()
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
