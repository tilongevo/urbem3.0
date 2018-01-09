<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

class ContaReceitaRepository extends ORM\EntityRepository
{
    public function verificaClassificacao($exercicio, $codEstrutural)
    {
        $sql = sprintf(
            "SELECT
                    exercicio,
                    cod_conta,
                    cod_norma,
                    trim( descricao ) as descricao,
                    cod_estrutural as mascara_classificacao,
                    publico.fn_mascarareduzida(cod_estrutural) as mascara_classificacao_reduzida
                FROM
                    orcamento.conta_receita
                WHERE
                    exercicio IS NOT NULL
                    AND exercicio = '%s'
                    AND cod_estrutural NOT LIKE '9%%'
                    AND cod_estrutural = '%s'",
            $exercicio,
            $codEstrutural
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getMaxCodConta()
    {
        $sql = "SELECT MAX(cod_conta) FROM orcamento.conta_receita";

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getContaReceitaListByExercicio($exercicio)
    {
        $sql = sprintf(
            "SELECT conta_receita.cod_estrutural
               , conta_receita.descricao
               , receita.exercicio
               , receita.cod_conta
            FROM orcamento.receita
            INNER JOIN orcamento.conta_receita ON receita.cod_conta = conta_receita.cod_conta
                AND receita.exercicio = conta_receita.exercicio  
            WHERE receita.exercicio = '%s'
            GROUP BY conta_receita.cod_estrutural
                , conta_receita.descricao
                , receita.exercicio
                , receita.cod_conta
            ORDER BY conta_receita.cod_estrutural",
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @param $likeCodEstrutural
     * @return array
     */
    public function findClassificacaoPorExercicio($exercicio, $codEstrutural, $likeCodEstrutural)
    {
        $sql = "SELECT                                                                               
                 exercicio, cod_conta, cod_norma, trim(descricao) as descricao, cod_estrutural as mascara_classificacao                       
                 FROM                                                                                 
                     orcamento.conta_receita                                                      
                 WHERE                                                                                
                     exercicio IS NOT NULL                                                            
                 AND exercicio = :exercicio 
                 AND cod_estrutural = :codEstrutural
                  ";

        if (!empty($likeCodEstrutural)) {
            $sql .= " AND cod_estrutural not like :likeCodEstrutural ";
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEstrutural', $codEstrutural);
        if (!empty($likeCodEstrutural)) {
            $query->bindValue('likeCodEstrutural', $likeCodEstrutural . '%');
        }
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @param bool $dedutora
     * @return array
     */
    public function findAllReceita($exercicio, $codEstrutural, $dedutora = false)
    {
        $qb = $this->createQueryBuilder('r')
                ->where("r.exercicio = :exercicio")
                ->andWhere("r.exercicio IS NOT NULL")
            ;
        if ($dedutora) {
            $qb->andWhere("r.codEstrutural LIKE :codEstrutural");
        } else {
            $qb->andWhere("r.codEstrutural NOT LIKE :codEstrutural");
        }

        return $qb->setParameter('exercicio', $exercicio)
            ->setParameter('codEstrutural', $codEstrutural.'%')
            ->orderBy('r.codEstrutural', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
