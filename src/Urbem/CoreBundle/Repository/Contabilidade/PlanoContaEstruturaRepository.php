<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class PlanoContaEstruturaRepository
 * @package Urbem\CoreBundle\Repository\Contabilidade
 */
class PlanoContaEstruturaRepository extends AbstractRepository
{
    /**
     * @param $codGrupo
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findPlanoContasEstrutura($codGrupo)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.codUf = :codUf')
            ->andWhere('p.codPlano = :codPlano')
            ->andWhere('p.escrituracao = :escrituracao')
            ->setParameter('codUf', 11)
            ->setParameter('codPlano', 1)
            ->setParameter('escrituracao', 'S');

        /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCVincularPlanoContas.php */
        if($codGrupo == 4) {
            $qb->andWhere('(p.codigoEstrutural LIKE :codigoOne OR p.codigoEstrutural LIKE :codigoTwo)');
            $qb->setParameter('codigoOne', '3.5.2%');
            $qb->setParameter('codigoTwo', '4.%');
        } else {
            $qb->andWhere('p.codigoEstrutural LIKE :codGrupo');
            $qb->setParameter('codGrupo', $codGrupo . '.%');
        }
        $qb->orderBy('p.codigoEstrutural');

        return $qb;
    }
}
