<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

class NotaLiquidacaoRepository extends ORM\EntityRepository
{
    public function getProximoCodNota($codEntidade, $exercicio)
    {
        $sql = sprintf(
            "
            SELECT COALESCE(MAX(cod_nota), 0) + 1 AS CODIGO 
            FROM empenho.nota_liquidacao
            WHERE cod_entidade = %d AND exercicio = '%s'",
            $codEntidade,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->codigo;
    }

    public function getByEmpenhoFromMGAsQueryBuilder($empenho = null)
    {
        $qb = $this->createQueryBuilder('NotaLiquidicao');

        if (null === $empenho) {
            $qb->andWhere('NotaLiquidicao.exercicio = :exercicio');
            $qb->setParameter('exercicio', '1');

            return $qb;
        }

        $qb->join('NotaLiquidicao.fkTcemgNotaFiscalEmpenhoLiquidacoes', 'fkTcemgNotaFiscalEmpenhoLiquidacoes');
        $qb->join('fkTcemgNotaFiscalEmpenhoLiquidacoes.fkEmpenhoEmpenho', 'fkEmpenhoEmpenho');

        $qb->andWhere('fkEmpenhoEmpenho.codEmpenho = :fkEmpenhoEmpenho_codEmpenho');
        $qb->andWhere('fkEmpenhoEmpenho.exercicio = :fkEmpenhoEmpenho_exercicio');
        $qb->andWhere('fkEmpenhoEmpenho.codEntidade = :fkEmpenhoEmpenho_codEntidade');

        if (true === is_string($empenho)) {
            $empenho = explode('~', $empenho);

            $qb->setParameter('fkEmpenhoEmpenho_codEmpenho', $empenho[0]);
            $qb->setParameter('fkEmpenhoEmpenho_exercicio', $empenho[1]);
            $qb->setParameter('fkEmpenhoEmpenho_codEntidade', $empenho[2]);

        } else {
            $qb->setParameter('fkEmpenhoEmpenho_codEmpenho', $empenho->getCodEmpenho());
            $qb->setParameter('fkEmpenhoEmpenho_exercicio', $empenho->getExercicio());
            $qb->setParameter('fkEmpenhoEmpenho_codEntidade', $empenho->getCodEntidade());
        }

        $qb->orderBy('fkEmpenhoEmpenho.codEmpenho');

        return $qb;
    }
}
