<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CondicaoAssentamentoRepository extends AbstractRepository
{
    /**
     * @param $timestamp
     * @param $codAssentamento
     * @return int
     */
    public function getNextCodCondicao($timestamp, $codAssentamento)
    {
        return $this->nextVal('cod_condicao', ['timestamp' => $timestamp, 'cod_assentamento' => $codAssentamento]);
    }
}
