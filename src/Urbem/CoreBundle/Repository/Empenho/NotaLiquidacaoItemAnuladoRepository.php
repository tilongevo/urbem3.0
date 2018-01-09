<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;

class NotaLiquidacaoItemAnuladoRepository extends ORM\EntityRepository
{
    /**
     * @param $codPreEmpenho
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getItensAnulados($codPreEmpenho, $exercicio)
    {
        $qb = $this->createQueryBuilder('nlia');

        $qb->leftJoin(
            'Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem',
            'nli',
            'WITH',
            'nlia.codPreEmpenho = nli.codPreEmpenho AND nlia.codEntidade = nli.codEntidade 
            AND nlia.exercicio = nli.exercicio AND nlia.numItem = nli.numItem
            AND nlia.codNota = nli.codNota'
        );

        $qb->join(
            'Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho',
            'ipe',
            'WITH',
            'ipe.exercicio = nli.exercicio AND ipe.numItem = nli.numItem AND nli.codPreEmpenho = ipe.codPreEmpenho'
        );

        $qb->where('ipe.codPreEmpenho = :codPreEmpenho');
        $qb->setParameter('codPreEmpenho', $codPreEmpenho);

        $qb->andWhere('ipe.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->select('nlia.numItem, ipe.nomItem, ipe.vlTotal as empenhado, nli.vlTotal as liquidado, nlia.vlAnulado as anulado');

        return $qb;
    }
}
