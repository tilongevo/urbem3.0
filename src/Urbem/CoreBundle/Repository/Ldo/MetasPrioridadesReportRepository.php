<?php

namespace Urbem\CoreBundle\Repository\Ldo;

use Doctrine\ORM;

class MetasPrioridadesReportRepository extends ORM\EntityRepository
{

    /**
     * @param $codPpa
     * @return array
     */
    public function findAllProgramasPorCodPpa($codPpa = null)
    {
        $where = "";
        if ($codPpa) {
            $where = " cod_ppa = :cod_ppa AND ";
        }

        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT DISTINCT 
                          num_programa	                  	                  
	                    , identificacao	                  
	                 FROM (
	                    ( SELECT LPAD(programa.num_programa::VARCHAR, 4, '0000') AS num_programa
	                           , programa.cod_programa
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
	                           , programa_dados.continuo AS bo_continuo
	                           , TO_CHAR( programa_temporario_vigencia.dt_inicial , 'DD/MM/YYYY') AS  dt_inicial
	                           , TO_CHAR( programa_temporario_vigencia.dt_final , 'DD/MM/YYYY') AS dt_final
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
	                          ON norma.cod_norma = programa_norma.cod_norma )
	                 ) AS tabela WHERE " . $where . "  ( ( ativo = 't' AND cod_ppa is not null ) OR (cod_ppa is null) )  ORDER BY num_programa
                 ")
        );
        if ($codPpa) {
            $query->bindValue('cod_ppa', $codPpa);
        }
        $query->execute();
        return $query->fetchAll();
    }


    public function findAllExercicioLdoPorCodPpa($codPpa = null)
    {

        $where = "";
        if ($codPpa) {
            $where = " AND ppa.cod_ppa = :cod_ppa ";
        }

        $query =  sprintf("SELECT ppa.cod_ppa
                          , ldo.ano
                          , (to_number(ppa.ano_inicio, '9999') + to_number(ldo.ano, '9') - 1) AS exercicio
                       FROM ldo.ldo
                 INNER JOIN ldo.homologacao
                         ON homologacao.cod_ppa = ldo.cod_ppa
                        AND homologacao.ano     = ldo.ano
                 INNER JOIN ppa.ppa
                         ON ppa.cod_ppa = ldo.cod_ppa
                        " . $where . "
                ");

        $query = $this->_em->getConnection()->prepare($query);
        if ($codPpa) {
            $query->bindValue('cod_ppa', $codPpa);
        }
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Query para teste do relatório
     * @param array $params
     * @return array
     */
    public function testQueryRelatorioOneFunction(array $params)
    {

        $query =  sprintf("SELECT LPAD(acao.cod_acao::VARCHAR,4,'0') AS cod_acao
                         , LPAD(acao.num_acao::VARCHAR,4,'0') AS num_acao
                         , acao_dados.titulo AS nom_acao
                         , LPAD(programa_dados.cod_programa::VARCHAR,4,'0') AS cod_programa
                         , LPAD(programa.num_programa::VARCHAR,4,'0') AS num_programa
                         , programa_dados.identificacao AS nom_programa
                         , (TO_NUMBER(ppa.ano_inicio,'9999') + TO_NUMBER(acao_validada.ano,'9999') - 1) AS ano
                         , acao_validada.quantidade
                         , acao_validada.valor
                         , acao_dados.cod_produto
                         , produto.descricao AS nom_produto
                         , acao_dados.cod_unidade_medida
                         , unidade_medida.nom_unidade
                         , acao_dados.cod_tipo
                      FROM ppa.acao
                INNER JOIN ppa.acao_dados
                        ON acao.cod_acao                    = acao_dados.cod_acao
                    AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
                INNER JOIN ldo.acao_validada
                        ON acao.cod_acao                    = acao_validada.cod_acao
                    AND acao.ultimo_timestamp_acao_dados = acao_validada.timestamp_acao_dados
                INNER JOIN ppa.programa
                        ON acao.cod_programa = programa.cod_programa
                INNER JOIN ppa.programa_dados
                        ON programa.cod_programa = programa_dados.cod_programa
                    AND programa.ultimo_timestamp_programa_dados = programa_dados.timestamp_programa_dados
                INNER JOIN ppa.programa_setorial
                        ON programa.cod_setorial = programa_setorial.cod_setorial
                INNER JOIN ppa.macro_objetivo
                        ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                INNER JOIN ppa.ppa
                        ON ppa.cod_ppa = macro_objetivo.cod_ppa
                 LEFT JOIN ppa.produto
                        ON acao_dados.cod_produto = produto.cod_produto
                 LEFT JOIN administracao.unidade_medida
                        ON acao_dados.cod_unidade_medida = unidade_medida.cod_unidade
                    AND acao_dados.cod_grandeza       = unidade_medida.cod_grandeza
                     WHERE ppa.cod_ppa = :cod_ppa
                    AND acao_validada.ano = :ano
                    AND ppa.fn_verifica_homologacao(ppa.cod_ppa)
                    AND programa.num_programa = :programa
                    AND acao.num_acao >= :acao_de
                    AND acao.num_acao <= :acao_ate
                ");

        list($codPpa, $ano, $programa, $acaoDe, $acaoAte) = $params;
        $query = $this->_em->getConnection()->prepare($query);
        $query->bindValue('cod_ppa', $codPpa);
        $query->bindValue('ano', $ano);
        $query->bindValue('programa', $programa);
        $query->bindValue('acao_de', $acaoDe);
        $query->bindValue('acao_ate', $acaoAte);
        $query->execute();
        return $query->fetchAll();
    }
}
