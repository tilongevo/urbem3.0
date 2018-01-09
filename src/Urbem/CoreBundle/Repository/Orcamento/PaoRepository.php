<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class PaoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     *
     * @return ORM\QueryBuilder
     */
    public function getListaOrcamentoPao($exercicio)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        return $qb;
    }

    /**
     * @return mixed
     */
    public function getProximoNumPao()
    {
        return $this->nextVal("num_pao");
    }

    /**
     * @param $stCondicao
     * @param $stGroupBy
     * @param $stOrdem
     *
     * @return mixed
     */
    public function recuperaPorNumPAODotacao($stCondicao, $stGroupBy, $stOrdem)
    {
        $sql = "
            SELECT sw_fn_mascara_dinamica('99.99.99.999.9999.9999', despesa.num_orgao||'.'||despesa.num_unidade||'.'||despesa.cod_funcao||'.'||despesa.cod_subfuncao||'.'||p_programa.num_programa||'.'||acao.num_acao) AS dotacao
                     , pao.exercicio
                     , pao.num_pao
                     , acao.num_acao
                     , acao_dados.titulo
                  FROM orcamento.despesa
            INNER JOIN orcamento.programa
                    ON programa.exercicio = despesa.exercicio
                   AND programa.cod_programa = despesa.cod_programa
            INNER JOIN orcamento.programa_ppa_programa
                    ON programa_ppa_programa.exercicio = programa.exercicio
                   AND programa_ppa_programa.cod_programa = programa.cod_programa
            INNER JOIN ppa.programa AS p_programa
                    ON p_programa.cod_programa = programa_ppa_programa.cod_programa_ppa
            INNER JOIN orcamento.pao
                    ON pao.exercicio = despesa.exercicio
                   AND pao.num_pao  = despesa.num_pao
            INNER JOIN orcamento.pao_ppa_acao
                    ON pao_ppa_acao.exercicio = pao.exercicio
                   AND pao_ppa_acao.num_pao = pao.num_pao
            INNER JOIN ppa.acao
                    ON acao.cod_acao = pao_ppa_acao.cod_acao
            INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao = acao.cod_acao
                   AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
        ";

        if ($stCondicao) {
            $sql .= $stCondicao;
        }

        if ($stGroupBy) {
            $sql .= $stGroupBy;
        }

        if ($stOrdem) {
            $sql .= $stOrdem;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = $query->fetchAll();
        $result = $queryResult;

        return $result;
    }
}
