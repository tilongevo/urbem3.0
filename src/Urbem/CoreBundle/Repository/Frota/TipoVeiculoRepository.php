<?php

namespace Urbem\CoreBundle\Repository\Frota;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TipoVeiculoRepository
 * @package Urbem\CoreBundle\Repository\Frota
 */
class TipoVeiculoRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findTipoVeiculoToArray()
    {
        $data = $this->createQueryBuilder('t')
            ->select('t.codTipo, t.nomTipo, t.placa, t.prefixo, v.codTipoTce, v.codSubtipoTce')
            ->leftJoin('Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo', 'v', 'WITH', 't.codTipo = v.codTipo')
            ->orderBy('t.codTipo')
            ->getQuery()
            ->getArrayResult();

        return $data;
    }
}