<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Repository\AbstractRepository;

class AssentamentoFaixaCorrecaoRepository extends AbstractRepository
{
    /**
     * Retorna o próximo valor do campo cod_faixa, por cod_assentamento
     * @param  integer $codAssentamento
     * @return integer
     */
    public function getProximoCodFaixa($codAssentamento)
    {
        return $this->nextVal(
            'cod_faixa',
            [
                'cod_assentamento' => $codAssentamento
            ]
        );
    }
}
