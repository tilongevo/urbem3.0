<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ConfiguracaoEventosDescontoExternoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodConfiguracao()
    {
        return $this->nextVal('cod_configuracao');
    }
}
