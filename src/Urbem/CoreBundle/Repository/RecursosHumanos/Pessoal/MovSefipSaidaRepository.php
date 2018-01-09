<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno;

/**
 * Class MovSefipSaidaRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal
 */
class MovSefipSaidaRepository extends ORM\EntityRepository
{
    /**
     * @return ORM\QueryBuilder
     */
    public function listaFkPessoalMovSefipSaida()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ret.codSefipSaida');
        $qb->from(MovSefipSaidaMovSefipRetorno::class, 'ret');

        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('mss')
            ->from(MovSefipSaida::class, 'mss')
            ->join('mss.fkPessoalSefip', 's')
            ->andWhere($qb2->expr()->notIn('mss.codSefipSaida', $qb->getDql()))
        ;

        return $qb2;
    }
}
