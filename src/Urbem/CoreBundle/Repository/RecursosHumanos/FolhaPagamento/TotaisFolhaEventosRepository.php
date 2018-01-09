<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class TotaisFolhaEventosRepository extends ORM\EntityRepository
{
    public function consultaTotaisFolhaEventos($object)
    {
        $sql = "
        SELECT
            *
        FROM folhapagamento.totais_folha_eventos
        WHERE cod_configuracao = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0) {
            $this->deleteTotaisFolhaEventos($object);
        }

        return $result;
    }

    public function deleteTotaisFolhaEventos($object)
    {
        $sql = "
        DELETE
        FROM folhapagamento.totais_folha_eventos
        WHERE cod_configuracao = $object";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
