<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Patrimonio;

use Doctrine\ORM;

class ApoliceRepository extends ORM\EntityRepository
{


    public function getApoliceBem($id)
    {
        $sql = "
            SELECT ab.cod_bem
            FROM   patrimonio.apolice a
                inner join patrimonio.apolice_bem ab
                    ON ab.cod_apolice = a.cod_apolice
            WHERE a.cod_apolice = $id;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function removeApoliceBem($id)
    {
            $sql = "DELETE FROM patrimonio.apolice_bem WHERE cod_apolice = $id ;";
            $query = $this->_em->getConnection()->prepare($sql);
            return $query->execute();
    }
}
