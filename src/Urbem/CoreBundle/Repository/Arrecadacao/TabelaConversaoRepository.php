<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TabelaConversaoRepository
 * @package Urbem\CoreBundle\Repository\Arrecadacao
 */
class TabelaConversaoRepository extends AbstractRepository
{
    /**
     * @return mixed
     */
    public function getNextVal($exercicio)
    {
        return $this->nextVal("cod_tabela", ['exercicio' => $exercicio]);
    }

    /**
     * @return array|bool
     */
    public function getDistinctExercicios()
    {
        $distinct = $this
            ->createQueryBuilder('tb')
            ->addSelect('tb.exercicio')
            ->distinct(true)
            ->orderBy('tb.exercicio', 'ASC')
            ->getQuery()
            ->getResult();

        if (!count($distinct)) {
            return false;
        }

        $exercicios = array();

        foreach ($distinct as $key => $exercicio) {
            $exercicios[$exercicio['exercicio']] = $exercicio['exercicio'];
        }

        return $exercicios;
    }

    /**
     * @param $params
     * @return array
     */
    public function getTabelaConversaoJson($params)
    {
        $sql = sprintf(
            "
            SELECT
                cod_tabela,
                nome_tabela,
                exercicio,
                cod_modulo,
                parametro_1,
                parametro_2,
                parametro_3,
                parametro_4
            FROM arrecadacao.tabela_conversao
            WHERE %s;",
            implode(" AND ", $params)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
