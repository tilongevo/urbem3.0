<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class HistoricoContabilRepository extends AbstractRepository
{
    public function findHistoricoContabil($exercicio, $nomHistorico)
    {
        $db = $this->createQueryBuilder('hc');
        $db->where("hc.exercicio = :exercicio");
        $db->andWhere("hc.codHistorico IS NOT NULL");
        $db->andWhere("hc.codHistorico != 1");

        if (is_numeric($nomHistorico)) {
            $db->andWhere("hc.codHistorico = :codHistorico");
            $db->setParameter('codHistorico', $nomHistorico);
        } else {
            $db->andWhere("lower(hc.nomHistorico) LIKE lower(:nomHistorico)");
            $db->setParameter('nomHistorico', '%'.$nomHistorico.'%');
        }

        $db ->setParameter('exercicio', $exercicio);
        $db->orderBy('hc.nomHistorico', 'ASC');

        return $db->getQuery()->getResult();
    }

    public function findAllHistoricoContabil($nomHistorico)
    {
        $db = $this->createQueryBuilder('hc')
            ->andWhere("hc.codHistorico IS NOT NULL")
            ->andWhere("lower(hc.nomHistorico) LIKE lower(:nomHistorico)")
            ->setParameter('nomHistorico', '%'.$nomHistorico.'%')
            ->orderBy('hc.nomHistorico', 'ASC');
        ;

        return $db->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getLastCodHistorico($exercicio)
    {
        return $this->nextVal(
            'cod_historico',
            array(
                'exercicio' => $exercicio
            )
        );
    }
}
