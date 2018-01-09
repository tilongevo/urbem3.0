<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use PDO;
use Doctrine\ORM\EntityManagerInterface;

class ExportarDirfRepository
{
    const BD_FUNCTION_DIRF_PRESTADORES_REDUZIDA = 'dirf_prestadores_servico_reduzida';
    const BD_FUNCTION_DIRF_PRESTADORES_REDUZIDA_PAGAMENTOS = 'dirf_prestadores_servico_reduzida_pagamentos';
    
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @param array $where
     * @param array $param
     * @return mixed
     */
    public function getRelacionamento(Array $where = [], Array $params = [])
    {
        $sql = "
        SELECT
            configuracao_dirf.*,
            (
                SELECT
                    nom_cgm
                FROM
                    sw_cgm
                WHERE
                    sw_cgm.numcgm = configuracao_dirf.responsavel_prefeitura
            ) AS responsavel_prefeitura_nome
            , (
                SELECT
                    nom_cgm
                FROM
                    sw_cgm
                WHERE
                    sw_cgm.numcgm = configuracao_dirf.responsavel_entrega
            ) AS responsavel_entrega_nome,
                natureza_estabelecimento.descricao
        FROM
            ima.configuracao_dirf,
            ima.natureza_estabelecimento
        WHERE
            configuracao_dirf.cod_natureza = natureza_estabelecimento.cod_natureza
        ";
        
        $hasParams = (count($where) && count($params));
        
        if ($hasParams) {
            $whereStr = implode(' AND ', $where);
            $sql .= " AND ". $whereStr;
        }
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        if ($hasParams) {
            foreach ($params as $key => $value) {
                $sth->bindValue($key, $value);
            }
        }
        
        $sth->execute();
        
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param array $where
     * @param array $params
     * @return mixed
     */
    public function getRelacionamentoPlanos(Array $where = [], Array $params = [])
    {
        $sql = "
        SELECT
            configuracao_dirf_plano.*,
            sw_cgm_pessoa_juridica.numcgm,
            sw_cgm_pessoa_juridica.cnpj,
            sw_cgm.nom_cgm,
            evento.codigo,
            evento.descricao
        FROM
          ima.configuracao_dirf_plano
        INNER JOIN
            sw_cgm_pessoa_juridica
            ON
            configuracao_dirf_plano.numcgm = sw_cgm_pessoa_juridica.numcgm
        INNER JOIN
            sw_cgm
            ON
            sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
        INNER JOIN
            folhapagamento.evento
            ON
            configuracao_dirf_plano.cod_evento = evento.cod_evento
        ";
        
        $hasParams = (count($where) && count($params));
        
        if ($hasParams) {
            $sql .= " WHERE ";
            $sql .= implode(' AND ', $where);
        }
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        if ($hasParams) {
            foreach ($params as $key => $value) {
                $sth->bindValue($key, $value);
            }
        }
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param array $where
     * @param array $param
     * @return mixed
     */
    public function getTodosPlanos(Array $where = [], Array $params = [])
    {
        $sql = "
        SELECT
	       exercicio,
	       numcgm,
	       registro_ans,
	       cod_evento
    	FROM
	       ima.configuracao_dirf_plano 
        ";
        
        $hasParams = (count($where) && count($params));
        
        if ($hasParams) {
            $sql .= " WHERE ";
            $sql .= implode(' AND ', $where);
        }
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        if ($hasParams) {
            foreach ($params as $key => $value) {
                $sth->bindValue($key, $value);
            }
        }
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $entidade
     * @param int $anoExercicio
     * @param string $tipoFiltro
     * @param string $codigos
     * @return mixed
     */
    public function exportarDirf($entidade, $anoExercicio, $tipoFiltro, $codigos){
        $sql = "
        SELECT
            uso_declarante,
            sequencia,
            nome_beneficiario,
            beneficiario,
            ident_especializacao,
            codigo_retencao,
            ident_especie_beneficiario,
            jan
            fev,
            mar,
            abr,
            mai,
            jun,
            jul,
            ago,
            set,
            out,
            nov,
            dez,
            dec
        FROM
            dirf_reduzida(:entidade, :anoExercicio, :tipoFiltro, :codigos)
        ORDER BY
            codigo_retencao, ident_especie_beneficiario
        ";
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':entidade', $entidade, PDO::PARAM_STR);
        $sth->bindValue(':anoExercicio', $anoExercicio, PDO::PARAM_STR);
        $sth->bindValue(':tipoFiltro', $tipoFiltro, PDO::PARAM_STR);
        $sth->bindValue(':codigos', $codigos, PDO::PARAM_STR);
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $entidade
     * @param int $anoExercicio
     * @param int $anoExercicioAnterior
     * @param string $tipoFiltro
     * @param string $codigos
     * @return mixed
     */
    public function exportarDirfPagamento($entidade, $anoExercicio, $anoExercicioAnterior, $tipoFiltro, $codigos)
    {
        $sql = "
        SELECT
            uso_declarante,
            sequencia,
            nome_beneficiario,
            beneficiario,
            ident_especializacao,
            codigo_retencao,
            ident_especie_beneficiario,
            CASE WHEN ident_especializacao = '0' THEN
         	   (
             	   SELECT
                       dez
             	   FROM dirf_reduzida(
                       :entidade,
                       :anoExercicioAnterior,
                       'contrato_todos',
                       (SELECT cod_contrato::VARCHAR FROM pessoal.contrato WHERE registro = uso_declarante)
                   )
             	   WHERE ident_especializacao = '0'
             	   ORDER BY codigo_retencao, ident_especie_beneficiario
         	   )
         	   WHEN ident_especializacao = '1' THEN
         	   (
             	   SELECT
                       dez
             	   FROM dirf_reduzida(
                 	   :entidade,
                       :anoExercicio,
                       'contrato_todos',
                       (SELECT cod_contrato::VARCHAR FROM pessoal.contrato WHERE registro = uso_declarante)
             	   )
             	   WHERE ident_especializacao = '1'
             	   ORDER BY codigo_retencao, ident_especie_beneficiario
         	   )
       	    END AS jan,
            jan as fev,
            fev as mar,
            mar as abr,
            abr as mai,
            mai as jun,
            jun as jul,
            jul as ago,
            ago as set,
            set as out,
            out as nov,
            nov as dez,
            dec
    	FROM dirf_reduzida(
       	    :entidade,
            :anoExercicio,
            :tipoFiltro,
            :codigos
    	)
    	ORDER BY
            codigo_retencao, ident_especie_beneficiario
        ";
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':entidade', $entidade, PDO::PARAM_STR);
        $sth->bindValue(':anoExercicio', $anoExercicio, PDO::PARAM_STR);
        $sth->bindValue(':anoExercicioAnterior', $anoExercicioAnterior, PDO::PARAM_STR);
        $sth->bindValue(':tipoFiltro', $tipoFiltro, PDO::PARAM_STR);
        $sth->bindValue(':codigos', $codigos, PDO::PARAM_STR);
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $entidade
     * @param int $codEntidade
     * @param int $anoCompetencia
     * @return mixed
     */
    public function exportarDirfPrestadores($entidade, $codEntidade, $anoCompetencia, $anoCompetenciaAnterior)
    {
        $sql = "
        SELECT
            uso_declarante,
            sequencia,
            remove_acentos(nome_beneficiario) as nome_beneficiario,
            beneficiario,
            ident_especializacao,
            codigo_retencao,
            ident_especie_beneficiario,                                                                                                            
            CASE 
                WHEN ident_especializacao = '0' THEN                                                                                           
                (                                                                                           
                    SELECT 
                        dez                                                                                           
                    FROM 
                        dirf_prestadores_servico_reduzida(                                                                                           
                            :entidade,
                            :codEntidade,
                            :anoExercicioAnterior
                        )                                                                                           
                    WHERE ident_especializacao = '0'
                    ORDER BY  codigo_retencao, ident_especie_beneficiario
                )                                                                                           
                WHEN ident_especializacao = '1' THEN
                (                                                                                           
                    SELECT 
                        dez                                                                                           
                    FROM 
                        dirf_prestadores_servico_reduzida(                                                                                           
                            :entidade,
                            :codEntidade,
                            :anoExercicioAnterior
                        )
                    WHERE ident_especializacao = '0'
                    ORDER BY  codigo_retencao, ident_especie_beneficiario
                )
            END AS jan,
            jan AS fev,
            fev AS mar,
            mar AS abr,
            abr AS mai,
            mai AS jun,
            jun AS jul,
            jul AS ago,
            ago AS set,
            set AS out,
            out AS nov,
            nov AS dez,
            dec
        FROM 
            dirf_prestadores_servico_reduzida(:entidade, :codEntidade, :anoExercicio)
        ORDER BY 
            codigo_retencao, ident_especie_beneficiario
        ";
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':entidade', $entidade, PDO::PARAM_STR);
        $sth->bindValue(':codEntidade', $codEntidade, PDO::PARAM_INT);
        $sth->bindValue(':anoExercicio', $anoCompetencia, PDO::PARAM_STR);
        $sth->bindValue(':anoExercicioAnterior', $anoCompetenciaAnterior, PDO::PARAM_STR);
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $entidade
     * @param int $codEntidade
     * @param int $anoCompetencia
     * @return mixed
     */
    public function exportarPorFuncao($funcao, $entidade, $codEntidade, $anoCompetencia)
    {
        $sql = "
        SELECT 
            uso_declarante,
            sequencia,
            nome_beneficiario,
            beneficiario,
            ident_especializacao,
            codigo_retencao,
            ident_especie_beneficiario,
            jan,
            fev,
            mar,
            abr,
            mai,
            jun,
            jul,
            ago,
            set,
            out,
            nov,
            dez,
            dec
        FROM
            ".$funcao."(:entidade, :codEntidade, :anoExercicio)
        ORDER BY 
            codigo_retencao, ident_especie_beneficiario
        ";
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':entidade', $entidade, PDO::PARAM_STR);
        $sth->bindValue(':codEntidade', $codEntidade, PDO::PARAM_INT);
        $sth->bindValue(':anoExercicio', $anoCompetencia, PDO::PARAM_STR);
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * @param string $entidade
     * @param string $tipoFiltro
     * @param string $valores
     * @param int $anoExercicio
     * @param int $codEvento
     * @param int $anoAnterior
     * @return array
     */
    public function getPlanoSaudeDirfPlano($entidade, $tipoFiltro, $valores, $anoExercicio, $codEvento, $anoAnterior = '', Array $where = [])
    {
        $sql = "
        SELECT DISTINCT
            registro,
            cod_contrato,
            nom_cgm,
            numcgm,
            cpf,
            sum(valor) AS valor
        FROM
           dirfplanosaude(:entidade, :tipoFiltro, :valores, :anoExercicio, :codEvento, :anoAnterior)
        GROUP BY
            registro, cod_contrato, nom_cgm, numcgm, cpf 
        ";
        
        if (count($where)) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", $where);
        }
        
        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($sql);
        
        $sth->bindValue(':entidade', $entidade, PDO::PARAM_STR);
        $sth->bindValue(':tipoFiltro', $tipoFiltro, PDO::PARAM_STR);
        $sth->bindValue(':valores', $valores, PDO::PARAM_STR);
        $sth->bindValue(':anoExercicio', $anoExercicio, PDO::PARAM_STR);
        $sth->bindValue(':codEvento', $codEvento, PDO::PARAM_INT);
        $sth->bindValue(':anoAnterior', $anoAnterior, PDO::PARAM_STR);
        
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
