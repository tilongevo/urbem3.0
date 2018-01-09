<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class PensaoEventoRepository extends ORM\EntityRepository
{
    public function consultaPensaoEvento($object)
    {
        $sql = "
        SELECT
            *
        FROM folhapagamento.pensao_evento
        WHERE id = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0){
            $this->deletePensaoEvento($object);
        }

        return $result;
    }

    public function deletePensaoEvento($object)
    {
        $sql = "
        DELETE
        FROM folhapagamento.pensao_evento
        WHERE id = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
