<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RescisaoConvenioRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $numConvenio
     * @return int
     */
    public function getProximoNumRescisao($exercicio, $numConvenio)
    {
        return $this->nextVal('num_rescisao', ['exercicio_convenio' => $exercicio, 'num_convenio' => $numConvenio]);
    }
}
