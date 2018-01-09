<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ItemPreEmpenhoRepository extends AbstractRepository
{
    /**
     * @param int $codPreEmpenho
     * @param string $exercicio
     * @return int
     */
    public function getProximoNumItem($codPreEmpenho, $exercicio)
    {
        return $this->nextVal(
            'num_item',
            [
                'cod_pre_empenho' => $codPreEmpenho,
                'exercicio' => $exercicio
            ]
        );
    }
}
