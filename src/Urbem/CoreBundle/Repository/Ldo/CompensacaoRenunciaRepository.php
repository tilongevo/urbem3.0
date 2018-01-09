<?php

namespace Urbem\CoreBundle\Repository\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CompensacaoRenunciaRepository extends AbstractRepository
{
    /**
     * Retorna próximo codCompensacao a ser salvo
     * @param $codPpa
     * @param $ano
     * @return int
     */
    public function getLastCodCompensacao($codPpa, $ano)
    {
        return $this->nextVal(
            'cod_compensacao',
            array(
                'cod_ppa' => $codPpa,
                'ano' => $ano
            )
        );
    }
}
