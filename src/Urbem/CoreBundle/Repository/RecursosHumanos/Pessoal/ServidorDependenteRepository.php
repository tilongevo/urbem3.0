<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ServidorDependenteRepository extends ORM\EntityRepository
{
    public function getServidorDependente($codServidor)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.servidor_dependente s
        JOIN pessoal.dependente d on d.cod_dependente = s.cod_dependente
        JOIN sw_cgm c on c.numcgm = d.numcgm
        WHERE s.cod_servidor = $codServidor";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function consulta($codServidor)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.servidor_dependente
        WHERE cod_servidor = $codServidor";

        //dump($sql);
        //exit();

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0){
            $this->deleteServidorDependente($codServidor);
        }

        return $result;
    }

    public function deleteServidorDependente($codServidor)
    {
        $sql = "
        DELETE
        FROM pessoal.servidor_dependente
        WHERE cod_servidor = $codServidor";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
