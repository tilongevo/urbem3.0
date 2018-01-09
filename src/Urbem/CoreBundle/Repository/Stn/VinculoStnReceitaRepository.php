<?php

namespace Urbem\CoreBundle\Repository\Stn;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class VinculoStnReceitaRepository
 * @package Urbem\CoreBundle\Repository\Stn
 */
class VinculoStnReceitaRepository extends AbstractRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAll()
    {
        $qb = $this->createQueryBuilder('VinculoStnReceita');
        $qb->innerJoin('\Urbem\CoreBundle\Entity\Orcamento\Receita', 'Receita', 'WITH', 'VinculoStnReceita.codReceita = Receita.codReceita AND VinculoStnReceita.exercicio = Receita.exercicio');
        $qb->innerJoin('Urbem\CoreBundle\Entity\Orcamento\ContaReceita', 'ContaReceita', 'WITH','Receita.codConta = ContaReceita.codConta AND ContaReceita.exercicio = Receita.exercicio');
        $qb->innerJoin('Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita', 'TipoVinculoStnReceita', 'WITH','VinculoStnReceita.codTipo = TipoVinculoStnReceita.codTipo');
        $qb->orderBy('TipoVinculoStnReceita.descricao', 'ASC');
        $qb->addOrderBy('VinculoStnReceita.codReceita', 'ASC');

        return $qb;
    }
}