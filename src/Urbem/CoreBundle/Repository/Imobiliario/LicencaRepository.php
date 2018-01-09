<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class LicencaRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getNextVal($exercicio)
    {
        return $this->nextVal("cod_licenca", ['exercicio' => $exercicio]);
    }

    public function getNextNumDocumento($exercicio)
    {
        $sql = "SELECT max( num_documento ) AS num_documento FROM imobiliario.licenca_documento WHERE licenca_documento.exercicio = :exercicio;";

        $query = $this->getEntityManager()->getConnection()->prepare($sql);
        $query->bindValue(":exercicio", $exercicio, \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $result->num_documento + 1;
    }
}
