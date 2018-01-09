<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ImovelFotoRepository extends AbstractRepository
{
    /**
     * @param int $inscricaoMunicipal
     * @return int
     */
    public function getNextVal($inscricaoMunicipal)
    {
        return $this->nextVal("cod_foto", ['inscricao_municipal' => $inscricaoMunicipal]);
    }
}
