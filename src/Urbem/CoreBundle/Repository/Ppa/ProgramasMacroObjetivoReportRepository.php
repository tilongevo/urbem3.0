<?php

namespace Urbem\CoreBundle\Repository\Ppa;

use Doctrine\ORM;

class ProgramasMacroObjetivoReportRepository extends ORM\EntityRepository
{
    /**
     * Busca os orgãos por exercicio
     * @param $exercicio
     * @return array
     */
    public function findAllOrgaoPorExercicio($exercicio)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT OO.exercicio,
                            OO.num_orgao,
	                        OO.num_orgao_mask,
	                        OO.nom_orgao
	                 FROM ( SELECT *
	                             , sw_fn_mascara_dinamica( '', ''||num_orgao ) as num_orgao_mask
	                          FROM orcamento.orgao) as OO
	                         WHERE true  AND OO.exercicio = :exercicio ORDER BY num_orgao")
        );
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        return $this->hydrate($query->fetchAll(), 'num_orgao', 'nom_orgao');
    }

    /**
     * Busca a unidade por exercicio e orgao
     * @param $exercicio
     * @param $orgao
     * @return array
     */
    public function findUnidadePorExercicioOrgao($exercicio, $orgao)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT unidade.nom_unidade
	                     , orgao.nom_orgao
	                     , unidade.*
	                 FROM (
	                        SELECT *
                              , sw_fn_mascara_dinamica( '', num_unidade::VARCHAR ) as num_unidade_mask
                              , sw_fn_mascara_dinamica('', num_orgao::VARCHAR )   as num_orgao_mask
                            FROM orcamento.unidade
	                       ) AS unidade
	            INNER JOIN orcamento.orgao
	                    ON unidade.exercicio = orgao.exercicio
	                   AND unidade.num_orgao = orgao.num_orgao 
                       AND  orgao.exercicio = :exercicio 
                       AND  orgao.num_orgao = :orgao
                       ORDER BY num_unidade")
        );
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('orgao', $orgao);
        $query->execute();
        return $this->hydrate($query->fetchAll(), 'num_unidade', 'nom_unidade');
    }


    /**
     * Trata para receber o array no formato esperado chave=>valor
     * @param $array
     * @param $chave
     * @param $valor
     * @return array
     */
    private function hydrate($array, $chave, $valor)
    {
        $retorno = [];
        if(!empty($array)){
            foreach ($array as $orgao) {
                $retorno[$orgao[$chave] .' - '.$orgao[$valor]] = $orgao[$chave];
            }
        }
        return $retorno;
    }


    /**
     * Metodo que restorna o resultado da consulta de uma das querys do arquivo  programasMacroobjetivo.rptdesign
     * @param $codPrograma
     * @return array
     */
    public function queryRelatorioOne($codPrograma)
    {

        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT  programa.cod_programa
                      ,   programa.num_programa
                      ,   programa_dados.identificacao
                      ,   programa_dados.num_orgao
                      ,   orgao.nom_orgao
                      ,   programa_dados.objetivo
                      ,   programa_dados.publico_alvo
                    FROM  ppa.programa
                      INNER JOIN  ppa.programa_dados
                        ON  programa_dados.cod_programa = programa.cod_programa
                    AND  programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                      INNER JOIN  orcamento.orgao
                        ON  orgao.exercicio = programa_dados.exercicio_unidade
                    AND  orgao.num_orgao = programa_dados.num_orgao
                    WHERE  programa.cod_programa = :cod_programa")
        );
        $query->bindValue('cod_programa', $codPrograma);
        $query->execute();
        return $query->fetchAll();
    }


    /**
     * Metodo que restorna o resultado da consulta de uma das querys do arquivo  programasMacroobjetivo.rptdesign
     * @param $codPrograma
     * @return array
     */
    public function queryRelatorioTwo($codPrograma)
    {

        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT  programa_indicadores.descricao
                    ,   to_char(programa_indicadores.dt_indice_recente, 'dd/mm/yyyy') AS data
                    ,   programa_indicadores.indice_recente
                    ,   programa_indicadores.indice_desejado
                    ,   unidade_medida.nom_unidade
                    ,   programa.cod_programa
                    ,   programa.num_programa
                    FROM  ppa.programa
                    INNER JOIN  ppa.programa_indicadores
                    ON  programa_indicadores.cod_programa              = programa.cod_programa
                    AND  programa_indicadores.timestamp_programa_dados  = programa.ultimo_timestamp_programa_dados
                    INNER JOIN  administracao.unidade_medida
                    ON  unidade_medida.cod_grandeza = programa_indicadores.cod_grandeza
                    AND  unidade_medida.cod_unidade  = programa_indicadores.cod_unidade
                    WHERE  programa.cod_programa = :cod_programa")
        );
        $query->bindValue('cod_programa', $codPrograma);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Metodo que restorna o resultado da consulta de uma das querys do arquivo  programasMacroobjetivo.rptdesign
     * @param $codPrograma
     * @return array
     */
    public function queryRelatorioThree($codPrograma)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT regiao.nome AS regionalizacao
                    , SUM(acao_quantidade.valor) AS valor_total
                    FROM ppa.acao
                    INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao		       = acao.cod_acao
                    AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    AND acao_dados.cod_tipo < 4
                    INNER JOIN ppa.regiao
                    ON regiao.cod_regiao = acao_dados.cod_regiao
                    INNER JOIN ppa.acao_quantidade
                    ON acao_quantidade.cod_acao 	            = acao.cod_acao
                    AND acao_quantidade.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    INNER JOIN ppa.programa
                    ON programa.cod_programa = acao.cod_programa
                    INNER JOIN ppa.programa_dados
                    ON programa_dados.cod_programa = programa.cod_programa
                    AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                    INNER JOIN ppa.programa_setorial
                    ON programa_setorial.cod_setorial = programa.cod_setorial
                    INNER JOIN ppa.macro_objetivo
                    ON macro_objetivo.cod_macro = programa_setorial.cod_macro
                    INNER JOIN ppa.ppa
                    ON ppa.cod_ppa = macro_objetivo.cod_ppa
                    LEFT JOIN ppa.ppa_precisao
                    ON ppa_precisao.cod_ppa = ppa.cod_ppa
                    WHERE programa.cod_programa = :cod_programa
                    GROUP BY regiao.nome
                    , ppa_precisao.cod_ppa")
        );
        $query->bindValue('cod_programa', $codPrograma);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Metodo que restorna o resultado da consulta de uma das querys do arquivo  programasMacroobjetivo.rptdesign
     * @param $codPrograma
     * @return array
     */
    public function queryRelatorioFour($codPrograma)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT acao_dados.cod_natureza
                    , acao_dados.cod_tipo_orcamento
                    , SUM(acao_quantidade.valor) AS valor_total
                    FROM ppa.acao
                    INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao		   = acao.cod_acao
                    AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    AND acao_dados.cod_tipo < 4
                    INNER JOIN ppa.acao_quantidade
                    ON acao_quantidade.cod_acao 	        = acao.cod_acao
                    AND acao_quantidade.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    INNER JOIN ppa.programa
                    ON programa.cod_programa = acao.cod_programa
                    INNER JOIN ppa.programa_dados
                    ON programa_dados.cod_programa = programa.cod_programa
                    AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                    INNER JOIN ppa.programa_setorial
                    ON programa_setorial.cod_setorial = programa.cod_setorial
                    INNER JOIN ppa.macro_objetivo
                    ON macro_objetivo.cod_macro = programa_setorial.cod_macro
                    INNER JOIN ppa.ppa
                    ON ppa.cod_ppa = macro_objetivo.cod_ppa
                    LEFT JOIN ppa.ppa_precisao
                    ON ppa_precisao.cod_ppa = ppa.cod_ppa
                    WHERE programa.cod_programa = :cod_programa
                    GROUP BY acao_dados.cod_natureza
                    , acao_dados.cod_tipo_orcamento
                    , ppa_precisao.cod_ppa")
        );
        $query->bindValue('cod_programa', $codPrograma);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codPpa
     * @param $num_orgao
     * @param $num_unidade
     * @return array
     */
    public function queryRelatorioFive($codPpa, $num_orgao, $num_unidade)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf("SELECT macro_objetivo.cod_macro
                    , macro_objetivo.descricao AS descricao_macro
                    , programa_setorial.cod_setorial
                    , programa_setorial.descricao AS descricao_setorial
                    , programa.cod_programa
                    , programa.num_programa
                    , programa_dados.cod_tipo_programa
                    , tipo_programa.descricao AS descricao_tipo_programa
                    FROM ppa.ppa
                    INNER JOIN ppa.macro_objetivo
                    ON macro_objetivo.cod_ppa = ppa.cod_ppa
                    INNER JOIN ppa.programa_setorial
                    ON programa_setorial.cod_macro = macro_objetivo.cod_macro
                    INNER JOIN ppa.programa
                    ON programa.cod_setorial = programa_setorial.cod_setorial
                    INNER JOIN ppa.programa_dados
                    ON programa_dados.cod_programa = programa.cod_programa
                    AND programa_dados.timestamp_programa_dados = programa.ultimo_timestamp_programa_dados
                    INNER JOIN ppa.tipo_programa
                    ON tipo_programa.cod_tipo_programa = programa_dados.cod_tipo_programa
                    INNER JOIN orcamento.unidade
                    ON unidade.exercicio = programa_dados.exercicio_unidade
                    AND unidade.num_unidade = programa_dados.num_unidade
                    AND unidade.num_orgao   = programa_dados.num_orgao
                    INNER JOIN orcamento.orgao
                    ON orgao.exercicio = unidade.exercicio
                    AND orgao.num_orgao = unidade.num_orgao
                    WHERE ppa.cod_ppa = :cod_ppa 
                    AND programa.ativo = 't'
                    AND orgao.num_orgao = :num_orgao
                    AND unidade.num_unidade = :num_unidade
                    AND EXISTS ( SELECT 1
                    FROM ppa.acao
                    INNER JOIN ppa.acao_dados
                    ON acao_dados.cod_acao = acao.cod_acao
                    AND acao_dados.timestamp_acao_dados = acao.ultimo_timestamp_acao_dados
                    WHERE acao.cod_programa = programa.cod_programa
                    AND acao_dados.cod_tipo < 4)
                    ORDER BY programa_dados.cod_tipo_programa
                    , macro_objetivo.cod_macro
                    , programa_setorial.cod_setorial
                    , programa.num_programa")
        );
        $query->bindValue('cod_ppa', $codPpa);
        $query->bindValue('num_orgao', $num_orgao);
        $query->bindValue('num_unidade', $num_unidade);
        $query->execute();
        return $query->fetchAll();
    }
}
