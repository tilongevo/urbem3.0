<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ContratoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $codEntidade
     * @return int
     */
    public function getProximoNumContrato($exercicio, $codEntidade)
    {
        return $this->nextVal('num_contrato', ['exercicio' => $exercicio, 'cod_entidade' => $codEntidade]);
    }
}
