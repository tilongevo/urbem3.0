<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class GrupoVencimentoRepository
 * @package Urbem\CoreBundle\Repository\Arrecadacao
 */
class GrupoVencimentoRepository extends AbstractRepository
{
    /**
     * @return mixed
     */
    public function getNextVal($exercicio, $codGrupo)
    {
        return $this->nextVal("cod_vencimento", ['ano_exercicio' => $exercicio, 'cod_grupo' => $codGrupo]);
    }
}
