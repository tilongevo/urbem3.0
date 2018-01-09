<?php

namespace Urbem\CoreBundle\Repository;

/**
 * Class SwProcessoRepository
 *
 * @package Urbem\CoreBundle\Repository
 */
class SwProcessoRepository extends AbstractRepository
{
    /**
     * @param string $exercicio
     *
     * @return int
     */
    public function nextCodProcesso($exercicio)
    {
        return parent::nextVal('cod_processo', [
            'ano_exercicio' => $exercicio
        ]);
    }

    /**
     * @return array
     */
    public function getListaDeProcessosNaoConfidenciais()
    {
        $sql = <<<SQL
SELECT 
  cod_processo ,
  ano_exercicio ,
  array_to_string(array_agg(nom_cgm), ', ') AS nom_cgm ,
  nom_classificacao ,
  nom_assunto ,
  TIMESTAMP FROM
  ( SELECT sw_processo.cod_processo , sw_processo.ano_exercicio , sw_cgm.nom_cgm , sw_classificacao.nom_classificacao , sw_assunto.nom_assunto , sw_processo.TIMESTAMP
    FROM sw_processo
      INNER JOIN sw_processo_interessado ON sw_processo_interessado.cod_processo = sw_processo.cod_processo
                                            AND sw_processo_interessado.ano_exercicio = sw_processo.ano_exercicio
      LEFT JOIN sw_assunto_atributo_valor ON sw_assunto_atributo_valor.cod_processo = sw_processo.cod_processo
                                             AND sw_assunto_atributo_valor.exercicio = sw_processo.ano_exercicio
      INNER JOIN sw_cgm ON sw_cgm.numcgm = sw_processo_interessado.numcgm
      INNER JOIN sw_assunto ON sw_assunto.cod_assunto = sw_processo.cod_assunto
                               AND sw_assunto.cod_classificacao = sw_processo.cod_classificacao
      INNER JOIN sw_classificacao ON sw_classificacao.cod_classificacao = sw_assunto.cod_classificacao
      INNER JOIN sw_situacao_processo ON sw_situacao_processo.cod_situacao = sw_processo.cod_situacao
      INNER JOIN sw_ultimo_andamento ON sw_processo.cod_processo = sw_ultimo_andamento.cod_processo
                                        AND sw_processo.ano_exercicio = sw_ultimo_andamento.ano_exercicio
    WHERE sw_processo.confidencial = 'f'
    UNION 
    -- SELECT QUE RETORNA QUAL SETOR FOI O RESPONSÁVEL PELO CADASTRO DO PROCESSO
    -- QUANDO O MESMO FOR CONFIDENCIAL.
    SELECT sw_processo.cod_processo , sw_processo.ano_exercicio , sw_cgm.nom_cgm , sw_classificacao.nom_classificacao , sw_assunto.nom_assunto , sw_processo.TIMESTAMP
    FROM sw_processo
      INNER JOIN
      ( SELECT MIN(sw_andamento.cod_andamento) AS cod_andamento, sw_andamento.cod_processo, sw_andamento.ano_exercicio
        FROM sw_andamento
        GROUP BY sw_andamento.cod_processo, sw_andamento.ano_exercicio ) AS max_andamento_recebido ON sw_processo.cod_processo = max_andamento_recebido.cod_processo
                                                                                                      AND sw_processo.ano_exercicio = max_andamento_recebido.ano_exercicio
      INNER JOIN sw_andamento ON sw_andamento.cod_processo = max_andamento_recebido.cod_processo
                                 AND sw_andamento.ano_exercicio = max_andamento_recebido.ano_exercicio
                                 AND sw_andamento.cod_andamento = max_andamento_recebido.cod_andamento
      INNER JOIN sw_processo_interessado ON sw_processo_interessado.cod_processo = sw_processo.cod_processo
                                            AND sw_processo_interessado.ano_exercicio = sw_processo.ano_exercicio
      LEFT JOIN sw_processo_confidencial ON sw_processo_confidencial.cod_processo = sw_processo.cod_processo
                                            AND sw_processo_confidencial.ano_exercicio = sw_processo.ano_exercicio
      LEFT JOIN sw_assunto_atributo_valor ON sw_assunto_atributo_valor.cod_processo = sw_processo.cod_processo
                                             AND sw_assunto_atributo_valor.exercicio = sw_processo.ano_exercicio
      INNER JOIN sw_cgm ON sw_cgm.numcgm = sw_processo_interessado.numcgm
      INNER JOIN sw_assunto ON sw_assunto.cod_assunto = sw_processo.cod_assunto
                               AND sw_assunto.cod_classificacao = sw_processo.cod_classificacao
      INNER JOIN sw_classificacao ON sw_classificacao.cod_classificacao = sw_assunto.cod_classificacao
      INNER JOIN sw_situacao_processo ON sw_situacao_processo.cod_situacao = sw_processo.cod_situacao
      INNER JOIN sw_ultimo_andamento ON sw_processo.cod_processo = sw_ultimo_andamento.cod_processo
                                        AND sw_processo.ano_exercicio = sw_ultimo_andamento.ano_exercicio
    WHERE sw_processo.confidencial = 't'
          AND (sw_andamento.cod_orgao = 0
               OR sw_processo_confidencial.numcgm = 1)
    UNION 
    -- SELECT QUE RETORNA EM QUAL SETOR SE ENCONTRA O PROCESSO NAQUELE MOMENTO
    -- QUANDO O MESMO FOR CONFIDENCIAL.
    SELECT sw_processo.cod_processo , sw_processo.ano_exercicio , sw_cgm.nom_cgm , sw_classificacao.nom_classificacao , sw_assunto.nom_assunto , sw_processo.TIMESTAMP
    FROM sw_processo
      INNER JOIN
      ( SELECT sw_andamento.cod_andamento, sw_andamento.cod_processo, sw_andamento.ano_exercicio
        FROM sw_andamento
          INNER JOIN sw_recebimento ON sw_andamento.cod_processo = sw_recebimento.cod_processo
                                       AND sw_andamento.ano_exercicio = sw_recebimento.ano_exercicio
                                       AND sw_andamento.cod_andamento = sw_recebimento.cod_andamento
        GROUP BY sw_andamento.cod_andamento, sw_andamento.cod_processo, sw_andamento.ano_exercicio ) AS max_andamento_recebido ON sw_processo.cod_processo = max_andamento_recebido.cod_processo
                                                                                                                                  AND sw_processo.ano_exercicio = max_andamento_recebido.ano_exercicio
      INNER JOIN sw_andamento ON sw_andamento.cod_processo = max_andamento_recebido.cod_processo
                                 AND sw_andamento.ano_exercicio = max_andamento_recebido.ano_exercicio
                                 AND sw_andamento.cod_andamento = max_andamento_recebido.cod_andamento
      INNER JOIN sw_processo_interessado ON sw_processo_interessado.cod_processo = sw_processo.cod_processo
                                            AND sw_processo_interessado.ano_exercicio = sw_processo.ano_exercicio
      LEFT JOIN sw_processo_confidencial ON sw_processo_confidencial.cod_processo = sw_processo.cod_processo
                                            AND sw_processo_confidencial.ano_exercicio = sw_processo.ano_exercicio
      LEFT JOIN sw_assunto_atributo_valor ON sw_assunto_atributo_valor.cod_processo = sw_processo.cod_processo
                                             AND sw_assunto_atributo_valor.exercicio = sw_processo.ano_exercicio
      INNER JOIN sw_cgm ON sw_cgm.numcgm = sw_processo_interessado.numcgm
      INNER JOIN sw_assunto ON sw_assunto.cod_assunto = sw_processo.cod_assunto
                               AND sw_assunto.cod_classificacao = sw_processo.cod_classificacao
      INNER JOIN sw_classificacao ON sw_classificacao.cod_classificacao = sw_assunto.cod_classificacao
      INNER JOIN sw_situacao_processo ON sw_situacao_processo.cod_situacao = sw_processo.cod_situacao
      INNER JOIN sw_ultimo_andamento ON sw_processo.cod_processo = sw_ultimo_andamento.cod_processo
                                        AND sw_processo.ano_exercicio = sw_ultimo_andamento.ano_exercicio
    WHERE sw_processo.confidencial = 't'
          AND sw_andamento.cod_orgao = 0
          AND (sw_andamento.cod_orgao = 0
               OR sw_processo_confidencial.numcgm = 1)) AS resultado
GROUP BY cod_processo ,
  ano_exercicio ,
  nom_classificacao ,
  nom_assunto ,
  TIMESTAMP
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto)
    {
        $sql = "
          SELECT
                      P.cod_processo
            ,  P.ano_exercicio
            ,  P.cod_classificacao
            ,  P.cod_assunto
            ,  P.cod_usuario
            ,  P.cod_situacao
                   ,  P.timestamp
                   ,  P.observacoes
                   ,  P.confidencial
                   ,  P.resumo_assunto
            ,  P.cod_processo||'/'||P.ano_exercicio as cod_processo_completo
            ,  A.nom_assunto
            ,  C.nom_classificacao
            ,  TO_CHAR(P.timestamp,'dd/mm/yyyy') as inclusao
            ,  G.nom_cgm
            ,  G.numcgm
            FROM   sw_processo              as P
            ,  sw_assunto               as A
            ,  sw_classificacao         as C
            ,  sw_cgm                   as G
            ,  sw_processo_interessado  as PI
            WHERE  P.cod_assunto       = A.cod_assunto
            AND  P.cod_classificacao = C.cod_classificacao
            AND  C.cod_classificacao = A.cod_classificacao
                 AND  PI.ano_exercicio = P.ano_exercicio
                 AND  PI.cod_processo  = P.cod_processo
            AND  PI.numcgm		   = G.numcgm
            AND P.cod_classificacao = $codClassificacao  AND P.cod_assunto = $codAssunto" ;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getSwProcessos($paramsWhere)
    {
        $sql = sprintf(
            "select 
                sw_processo.cod_processo AS codProcesso, 
                sw_processo.ano_exercicio AS anoProcesso, 
                sw_assunto.nom_assunto AS nomAssunto
            from 
                sw_processo 
                inner join sw_assunto 
                on sw_processo.cod_assunto = sw_assunto.cod_assunto 
            WHERE 
                %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param string $anoExercicio Exercicio do Processo Superior
     * @param int    $codProcesso  Código do Processo Superior
     * @param int    $codOrgao     Código do Órgão em Vigencia
     * @param int    $codSitucao   Código da Situação em que se encontra o Processo Anterior
     *
     * @return array
     */
    public function getProcessosFilhosApensar($anoExercicio, $codProcesso, $codOrgao, $codSitucao)
    {
        $sql = <<<SQL
SELECT
  sw_processo.ano_exercicio,
  sw_processo.cod_processo
FROM public.sw_processo
  , public.sw_ultimo_andamento
  , public.sw_classificacao
  , public.sw_assunto
  , public.sw_cgm
  , public.sw_situacao_processo
  , public.sw_processo_interessado
WHERE sw_processo.cod_classificacao = sw_assunto.cod_classificacao
      AND sw_processo.cod_assunto = sw_assunto.cod_assunto
      AND sw_processo_interessado.ano_exercicio = sw_processo.ano_exercicio
      AND sw_processo_interessado.cod_processo = sw_processo.cod_processo
      AND sw_processo_interessado.numcgm = sw_cgm.numcgm
      AND sw_processo.cod_situacao = sw_situacao_processo.cod_situacao
      AND sw_ultimo_andamento.ano_exercicio = sw_processo.ano_exercicio
      AND sw_ultimo_andamento.cod_processo = sw_processo.cod_processo
      AND sw_assunto.cod_classificacao = sw_classificacao.cod_classificacao
      AND NOT (sw_processo.ano_exercicio = :ano_exercicio
               AND sw_processo.cod_processo = :cod_processo)
      AND sw_ultimo_andamento.cod_orgao IN (SELECT cod_orgao
                                            FROM organograma.vw_orgao_nivel
                                            WHERE orgao_reduzido LIKE (
                                                                        SELECT DISTINCT (vw_orgao_nivel.orgao_reduzido)
                                                                        FROM organograma.vw_orgao_nivel
                                                                        WHERE vw_orgao_nivel.cod_orgao = :cod_orgao
                                                                      ) || '%'
                                            GROUP BY cod_orgao)
      AND sw_situacao_processo.cod_situacao = :cod_situacao
EXCEPT
SELECT
  sw_processo.ano_exercicio,
  sw_processo.cod_processo
FROM public.sw_processo
  , public.sw_ultimo_andamento
  , public.sw_classificacao
  , public.sw_assunto
  , public.sw_cgm
  , public.sw_situacao_processo
  , (SELECT
       cod_processo_pai,
       exercicio_pai
     FROM sw_processo_apensado
     WHERE timestamp_desapensamento IS NULL
     GROUP BY cod_processo_pai
       , exercicio_pai) AS processo_pai
  , public.sw_processo_interessado
WHERE sw_processo.cod_classificacao = sw_assunto.cod_classificacao
      AND sw_processo.cod_assunto = sw_assunto.cod_assunto
      AND sw_processo_interessado.ano_exercicio = sw_processo.ano_exercicio
      AND sw_processo_interessado.cod_processo = sw_processo.cod_processo
      AND sw_processo_interessado.numcgm = sw_cgm.numcgm
      AND sw_processo.cod_situacao = sw_situacao_processo.cod_situacao
      AND sw_ultimo_andamento.ano_exercicio = sw_processo.ano_exercicio
      AND sw_ultimo_andamento.cod_processo = sw_processo.cod_processo
      AND sw_assunto.cod_classificacao = sw_classificacao.cod_classificacao
      AND processo_pai.exercicio_pai = sw_processo.ano_exercicio
      AND processo_pai.cod_processo_pai = sw_processo.cod_processo
      AND sw_ultimo_andamento.cod_orgao = :cod_orgao
ORDER BY ano_exercicio, cod_processo;
SQL;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute([
            'ano_exercicio' => $anoExercicio,
            'cod_processo' => $codProcesso,
            'cod_orgao' => $codOrgao,
            'cod_situacao' => $codSitucao
        ]);

        return $query->fetchAll();
    }

    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('SwProcesso');

        $orx = $qb->expr()->orX();

        $like = $qb->expr()->like('string(SwProcesso.codProcesso)', ':term');
        $orx->add($like);

        $like = $qb->expr()->like('SwProcesso.anoExercicio', ':term');
        $orx->add($like);

        $like = $qb->expr()->like("CONCAT(string(SwProcesso.codProcesso), '/', SwProcesso.anoExercicio)", ':term');
        $orx->add($like);

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('SwProcesso.codProcesso');
        $qb->setMaxResults(10);

        return $qb;
    }
}
