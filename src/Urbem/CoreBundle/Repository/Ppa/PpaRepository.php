<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Ppa\PpaPublicacao;

class PpaRepository extends ORM\EntityRepository
{
    public function getEstimativaReceita($codPpa)
    {
        $sql = sprintf(
            "
            SELECT *
            FROM ppa.fn_estimativa_receita_ppa(%d) AS retorno(
                cod_receita  integer,
                    descricao    character varying(80),
                    ano_1        numeric(14,2),
                    ano_2        numeric(14,2),
                    ano_3        numeric(14,2),
                    ano_4        numeric(14,2),
                    ano_1_ano_4  numeric(14,2)
                )",
            $codPpa
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @return mixed
     * @throws ORM\NonUniqueResultException
     */
    public function getPpaExercicio($exercicio)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.anoInicio <= :exercicio')
            ->andWhere('p.anoFinal >= :exercicio')
            ->setParameter('exercicio', $exercicio);

        return $query->getQuery()->getSingleResult();
    }

    /**
     * @param $params
     * @return array
     */
    public function getProgramasPpa($params)
    {
        $sql = sprintf(
            "SELECT LPAD(programa.num_programa::VARCHAR, 4, '0000') AS num_programa
                 , LPAD(programa.cod_programa::VARCHAR, 4, '0000') AS cod_programa
                 , ppa.cod_ppa
                 , ppa.ano_inicio
                 , ppa.ano_final
                 , programa_setorial.cod_setorial
                 , programa_setorial.descricao AS nom_setorial
                 , macro_objetivo.cod_macro
                 , macro_objetivo.descricao AS nom_macro
                 , programa_dados.identificacao
                 , programa_dados.justificativa
                 , programa_dados.diagnostico
                 , programa_dados.objetivo
                 , programa_dados.diretriz
                 , programa_dados.publico_alvo
                 , programa_dados.cod_tipo_programa
                 , programa_dados.exercicio_unidade
                 , programa_dados.num_orgao
                 , programa_dados.num_unidade
                 , tipo_programa.descricao AS nom_tipo_programa
                 , programa_norma.cod_norma
                 , norma.nom_norma
                 , norma.dt_publicacao
                 , ppa.ano_inicio ||' a '|| ppa.ano_final AS periodo
                 , CASE programa_dados.continuo
                      WHEN true  THEN 'Contínuo'
                      WHEN false THEN 'Temporário'
                   END AS continuo
                 , TO_CHAR( programa_temporario_vigencia.dt_inicial , 'DD/MM/YYYY') AS  dt_inicial
                 , TO_CHAR( programa_temporario_vigencia.dt_final , 'DD/MM/YYYY') AS dt_final
                 , programa_setorial.cod_setorial
                 , macro_objetivo.cod_macro
                 , programa.ativo
            FROM ppa.programa
            INNER JOIN ppa.programa_dados
                    ON programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                   AND programa_dados.cod_programa = programa.cod_programa
            INNER JOIN ppa.programa_setorial
                    ON programa_setorial.cod_setorial = programa.cod_setorial
            INNER JOIN ppa.macro_objetivo
                    ON macro_objetivo.cod_macro = programa_setorial.cod_macro
            INNER JOIN ppa.ppa
                    ON ppa.cod_ppa = macro_objetivo.cod_ppa
            INNER JOIN ppa.tipo_programa
                    ON tipo_programa.cod_tipo_programa = programa_dados.cod_tipo_programa
            LEFT JOIN ppa.programa_temporario_vigencia
                    ON programa_temporario_vigencia.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                   AND programa_temporario_vigencia.cod_programa = programa.cod_programa
            LEFT JOIN ppa.programa_norma
                    ON programa_norma.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                   AND programa_norma.cod_programa = programa.cod_programa
            LEFT JOIN normas.norma
                    ON norma.cod_norma = programa_norma.cod_norma
            WHERE ppa.cod_ppa = %d
            ORDER BY programa.cod_programa ",
            $params['ppa']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $params
     * @return array
     */
    public function getAcoesByPpaAndPrograma($params)
    {
        $sql = sprintf(
            "SELECT LPAD(acao.num_acao::VARCHAR,4,'0') AS num_acao
                 , LPAD(acao.cod_acao::VARCHAR,4,'0') AS cod_acao
                 , ppa.cod_ppa
                 , acao.ultimo_timestamp_acao_dados
                 , LPAD(programa.num_programa::VARCHAR,4,'0') AS num_programa
                 , LPAD(programa.cod_programa::VARCHAR,4,'0') AS cod_programa
                 , programa_dados.identificacao AS nom_programa
                 , programa_dados.cod_tipo_programa
                 , programa_setorial.cod_setorial
                 , macro_objetivo.cod_macro
                 , acao_dados.titulo
                 , acao_dados.descricao
                 , acao_dados.finalidade
                 , acao_dados.detalhamento
                 , acao_dados.cod_forma
                 , acao_dados.cod_tipo
                 , acao_dados.cod_natureza
                 , regiao.cod_regiao
                 , regiao.nome AS nom_regiao
                 , produto.cod_produto
                 , produto.descricao AS nom_produto
                 , acao_norma.cod_norma
                 , norma.nom_norma
                 , acao_dados.cod_tipo_orcamento
                 , funcao.cod_funcao
                 , funcao.descricao AS nom_funcao
                 , subfuncao.cod_subfuncao
                 , subfuncao.descricao AS nom_subfuncao
                 , acao_dados.cod_unidade_medida
                 , acao_dados.cod_grandeza
                 , acao_dados.valor_estimado
                 , acao_dados.meta_estimada
                 , LPAD(acao_unidade_executora.num_orgao::VARCHAR, length(orcamento.fn_masc_orgao(split_part(acao.ultimo_timestamp_acao_dados::VARCHAR, '-', 1))),'0') AS num_orgao
                 , LPAD(acao_unidade_executora.num_unidade::VARCHAR, length(orcamento.fn_masc_unidade(split_part(acao.ultimo_timestamp_acao_dados::VARCHAR, '-', 1))),'0') AS num_unidade
                 , tipo_acao.descricao AS nom_tipo_acao
                 , SUM(acao_quantidade.valor) AS valor_acao
                 , TO_CHAR(programa_temporario_vigencia.dt_inicial, 'dd/mm/yyyy') AS dt_inicial
                 , TO_CHAR(programa_temporario_vigencia.dt_final, 'dd/mm/yyyy') AS dt_final
                 , TO_CHAR(acao_periodo.data_inicio, 'dd/mm/yyyy') AS dt_inicial_acao
                 , TO_CHAR(acao_periodo.data_termino, 'dd/mm/yyyy') AS dt_final_acao
                 , programa_dados.continuo
            FROM ppa.acao
                INNER JOIN ppa.programa ON acao.cod_programa = programa.cod_programa
                INNER JOIN ppa.programa_dados ON programa.cod_programa = programa_dados.cod_programa
                    AND programa.ultimo_timestamp_programa_dados = programa_dados.timestamp_programa_dados
                INNER JOIN ppa.programa_setorial ON programa.cod_setorial = programa_setorial.cod_setorial
                INNER JOIN ppa.macro_objetivo ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                INNER JOIN ppa.ppa ON macro_objetivo.cod_ppa = ppa.cod_ppa
                INNER JOIN ppa.acao_dados ON acao.cod_acao = acao_dados.cod_acao
                    AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
                INNER JOIN ppa.regiao ON acao_dados.cod_regiao = regiao.cod_regiao
                LEFT JOIN ppa.produto ON acao_dados.cod_produto = produto.cod_produto
                INNER JOIN ppa.tipo_acao ON tipo_acao.cod_tipo = acao_dados.cod_tipo
                LEFT JOIN ppa.acao_norma ON acao.cod_acao = acao_norma.cod_acao
                    AND acao.ultimo_timestamp_acao_dados = acao_norma.timestamp_acao_dados
                LEFT JOIN normas.norma ON acao_norma.cod_norma = norma.cod_norma
                LEFT JOIN orcamento.funcao ON acao_dados.exercicio  = funcao.exercicio
                    AND acao_dados.cod_funcao = funcao.cod_funcao
                LEFT JOIN orcamento.subfuncao ON acao_dados.exercicio = subfuncao.exercicio
                    AND acao_dados.cod_subfuncao = subfuncao.cod_subfuncao
                INNER JOIN ppa.acao_unidade_executora ON acao_dados.cod_acao = acao_unidade_executora.cod_acao
                    AND acao_dados.timestamp_acao_dados = acao_unidade_executora.timestamp_acao_dados
                LEFT JOIN ppa.acao_quantidade ON acao_quantidade.cod_acao = acao_dados.cod_acao
                    AND acao_quantidade.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                LEFT JOIN ppa.acao_periodo ON acao_periodo.cod_acao = acao_dados.cod_acao
                    AND acao_periodo.timestamp_acao_dados = acao_dados.timestamp_acao_dados
                LEFT JOIN ppa.programa_temporario_vigencia ON programa_temporario_vigencia.cod_programa = programa_dados.cod_programa
                AND programa_temporario_vigencia.timestamp_programa_dados = programa_dados.timestamp_programa_dados
            WHERE  programa.num_programa = '%s' AND ppa.cod_ppa = %d 
            GROUP BY acao.num_acao
             , acao.cod_acao
             , ppa.cod_ppa
             , acao.ultimo_timestamp_acao_dados
             , programa.num_programa
             , programa.cod_programa
             , programa_dados.identificacao
             , programa_dados.cod_tipo_programa
             , programa_setorial.cod_setorial
             , macro_objetivo.cod_macro
             , acao_dados.titulo
             , acao_dados.descricao
             , acao_dados.finalidade
             , acao_dados.detalhamento
             , acao_dados.cod_forma
             , acao_dados.cod_tipo
             , acao_dados.cod_natureza
             , regiao.cod_regiao
             , regiao.nome
             , produto.cod_produto
             , produto.descricao 
             , acao_norma.cod_norma
             , norma.nom_norma
             , acao_dados.cod_tipo_orcamento
             , funcao.cod_funcao
             , funcao.descricao 
             , subfuncao.cod_subfuncao
             , subfuncao.descricao
             , acao_dados.cod_unidade_medida
             , acao_dados.cod_grandeza
             , acao_dados.valor_estimado
             , acao_dados.meta_estimada
             , acao_unidade_executora.num_orgao
             , acao_unidade_executora.num_unidade
             , programa_temporario_vigencia.dt_inicial
             , programa_temporario_vigencia.dt_final
             , programa_dados.continuo
             , acao_periodo.data_inicio
             , acao_periodo.data_termino
             , tipo_acao.descricao 
             ORDER BY acao.num_acao",
            $params['numPrograma'],
            $params['codPpa']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $params
     * @return array
     */
    public function getPpasByStatus($params)
    {
        $sql = sprintf(
            "SELECT ppa.cod_ppa
            FROM ppa.ppa
            WHERE ppa.fn_verifica_homologacao(ppa.cod_ppa) = '%s';",
            $params['homologado']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $codPpa
     * @return array
     */
    public function getDadosPpa($codPpa)
    {
        $sql = sprintf(
            "SELECT
                TO_CHAR(TO_DATE(ppa_encaminhamento.dt_encaminhamento::varchar, 'yyyy-mm-dd'), 'dd/mm/yyyy') as dtencaminhamento,
                TO_CHAR(TO_DATE(ppa_encaminhamento.dt_devolucao::varchar, 'yyyy-mm-dd'), 'dd/mm/yyyy') as dtdevolucao,
                periodicidade.nom_periodicidade AS nomperiodicidade,
                ppa.timestamp,
                CASE
                    WHEN ppa.fn_verifica_homologacao(ppa.cod_ppa)= true THEN 'Homologado'
                    ELSE 'Não Homologado'
                END AS status
            FROM ppa.ppa LEFT JOIN ppa.ppa_publicacao ON ppa_publicacao.cod_ppa = ppa.cod_ppa
                AND ppa_publicacao.timestamp =(
                SELECT
                    max( timestamp )
                FROM
                    ppa.ppa_publicacao
                WHERE
                    cod_ppa = ppa.cod_ppa
            )
            LEFT JOIN ppa.ppa_encaminhamento ON ppa_encaminhamento.cod_ppa = ppa_publicacao.cod_ppa 
                AND ppa_encaminhamento.timestamp = ppa_publicacao.timestamp
            LEFT JOIN ppa.periodicidade ON periodicidade.cod_periodicidade = ppa_encaminhamento.cod_periodicidade
            WHERE ppa.cod_ppa = %d;",
            $codPpa
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $res = $result->fetchAll();

        return array_shift($res);
    }

    /**
     * @param $params
     * @return array
     */
    public function getStatus($params)
    {
        $sql = sprintf(
            "SELECT *
            FROM ppa.fn_verifica_homologacao(%d);",
            $params['codPpa']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();

        return $result->fetchAll();
    }

    /**
     * @return array
     */
    public function getPpasHomologados()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin(PpaPublicacao::class, 'pp', 'WITH', 'p.codPpa = pp.codPpa');
        $qb->addGroupBy('p.codPpa');
        $qb->select('p.codPpa');
        $qb->orderBy('p.codPpa', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $anoInicio
     * @param $exercicio
     * @return mixed
     */
    public function fnGerarDadosPpa($anoInicio, $exercicio)
    {
        $sqlFunction = "SELECT ppa.fn_gerar_dados_ppa(:ano_inicio, :exercicio)";

        $query = $this->_em->getConnection()->prepare($sqlFunction);
        $query->bindValue('ano_inicio', (string) $anoInicio);
        $query->bindValue('exercicio', (string) $exercicio);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $anoInicio
     * @param $anoFinal
     * @return mixed
     */
    public function validaHomologacaoPorAno($anoInicio, $anoFinal)
    {
        $sql = "
            SELECT ppa.cod_ppa
                , ppa.ano_inicio
                , ppa.ano_final
                , ppa.ano_inicio||' a '||ppa.ano_final AS periodo
                , ppa.fn_verifica_homologacao(ppa.cod_ppa) AS homologado
             FROM ppa.ppa
            where ano_final >= :ano_final and ano_inicio <= :ano_inicio order by ppa.ano_inicio;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('ano_inicio', $anoInicio);
        $query->bindValue('ano_final', $anoFinal);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e');
        $qb->orderBy('e.anoInicio', 'ASC');

        return $qb;
    }
}
