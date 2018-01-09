<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RescisaoContratoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $numContrato
     * @return int
     */
    public function getProximoNumRescisao($exercicio, $numContrato)
    {
        return $this->nextVal('num_rescisao', ['exercicio' => $exercicio, 'num_contrato' => $numContrato]);
    }
}
