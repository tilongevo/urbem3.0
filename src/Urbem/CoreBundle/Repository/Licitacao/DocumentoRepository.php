<?php

namespace Urbem\CoreBundle\Repository\Licitacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class DocumentoRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class DocumentoRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAllTipoDocumento()
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.codDocumento', 'd.nomDocumento', 'tc.codigo')
            ->leftJoin('Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento', 'dp', 'WITH', 'dp.codDocUrbem = d.codDocumento')
            ->leftJoin('Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor', 'tc', 'WITH','tc.codigo = dp.codDocTce')
            ->orderBy('d.codDocumento');

        return $qb->getQuery()->getResult();
    }
}