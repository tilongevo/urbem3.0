<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class SequenciaCalculoRepository extends AbstractRepository
{
    public function deleteSequenciaCalculoEvento($object)
    {
        $sql = "
        DELETE
        FROM folhapagamento.sequencia_calculo_evento
        WHERE cod_evento = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function selectBasesEventoCriado($codBase)
    {
        $sql = "
        SELECT
            *
        FROM
            folhapagamento.bases_evento_criado
        WHERE
            cod_base = :codBase
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindParam(":codBase", $codBase);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return array_shift($result);
    }

    public function isUnique(array $params)
    {
        return parent::isUnique($params);
    }
}
