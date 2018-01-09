<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class GrupoRepository extends AbstractRepository
{
    /**
     * Retorna o proximo codigo do grupo.
     *
     * @param string $campo
     * @param array  $params
     *
     * @return int
     */
    public function nextVal($campo, array $params = [])
    {
        return parent::nextVal($campo);
    }
}
