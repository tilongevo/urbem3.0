<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AcaoRepository
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class AcaoRepository extends AbstractRepository
{
    /**
     * @param array $filters
     * @return array
     */
    public function findAcao(array $filters = [])
    {

        $qb = $this->createQueryBuilder('a');

        $this->addFilterQueryBuilder($qb, $filters);

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $filters
     * @return QueryBuilder
     */
    protected function addFilterQueryBuilder(QueryBuilder $qb, array $filters)
    {
        foreach ($filters as $column => $value) {
            if (is_null($value) or empty($value)) {
                continue;
            }
            $qb->andWhere('a.' . $column . ' = :' . $column)->setParameter($column, $value);
        }

            return $qb;
    }

    /**
     * @param $codModulo
     * @param $codFuncionalidade
     * @return QueryBuilder
     */
    public function findStnAnexos($codModulo, $codFuncionalidade)
    {
        $qb = $this->createQueryBuilder('Acao');
        $qb->join('\Urbem\CoreBundle\Entity\Administracao\Funcionalidade', 'Funcionalidade', 'WITH', 'Acao.codFuncionalidade = Funcionalidade.codFuncionalidade');
        $qb->join('\Urbem\CoreBundle\Entity\Administracao\Modulo', 'Modulo', 'WITH', 'Funcionalidade.codModulo = Modulo.codModulo');
        $qb->join('\Urbem\CoreBundle\Entity\Administracao\Gestao', 'Gestao', 'WITH', 'Modulo.codGestao = Gestao.codGestao');
        $qb->join('\Urbem\CoreBundle\Entity\Administracao\Usuario', 'Usuario', 'WITH', 'Modulo.codResponsavel = Usuario.numcgm');
        $qb->where('Modulo.codModulo = :codModulo');
        $qb->andWhere('Acao.codFuncionalidade <> :codFuncionalidade');
        $qb->setParameter('codModulo', $codModulo);
        $qb->setParameter('codFuncionalidade', $codFuncionalidade);
        $qb->orderBy('Funcionalidade.codFuncionalidade', 'ASC');
        $qb->addOrderBy('Acao.nomAcao', 'ASC');

        return $qb;
    }
}