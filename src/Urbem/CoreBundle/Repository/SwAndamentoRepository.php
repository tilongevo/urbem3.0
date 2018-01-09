<?php

namespace Urbem\CoreBundle\Repository;

/**
 * Class SwAndamentoRepository
 *
 * @package Urbem\CoreBundle\Repository
 */
class SwAndamentoRepository extends AbstractRepository
{
    /**
     * @param $codProcesso
     * @param $anoExercicio
     *
     * @return int
     */
    public function nextCodAndamento($codProcesso, $anoExercicio)
    {
        return $this->nextVal('cod_andamento', [
            'cod_processo' => $codProcesso,
            'ano_exercicio' => $anoExercicio
        ]);
    }
}
