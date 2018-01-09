<?php

namespace Urbem\CoreBundle\Repository;

/**
 * Class SwCopiaDigitalRepository
 *
 * @package Urbem\CoreBundle\Repository
 */
class SwCopiaDigitalRepository extends AbstractRepository
{
    /**
     * @param string $exercicio
     *
     * @return int
     */
    public function nextCodCopia($exercicio)
    {
        return $this->nextVal('cod_copia', [
            'exercicio' => $exercicio
        ]);
    }
}
