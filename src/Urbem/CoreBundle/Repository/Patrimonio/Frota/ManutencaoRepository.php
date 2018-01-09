<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ManutencaoRepository extends AbstractRepository
{
    /**
     * Pega o próximo identificador disponível
     *
     * @deprecated
     * @param  string $complemento
     * @return int $result identifier
     */
    public function getAvailableIdentifier($complemento = '')
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT COALESCE(MAX(cod_manutencao), 0) AS CODIGO 
            FROM frota.manutencao
            " . $complemento
        );

        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @param  string $exercicio
     * @return int $result identifier
     */
    public function getNextCodManutencao($exercicio)
    {
        return parent::nextVal('cod_manutencao', ['exercicio' => $exercicio]);
    }
}
