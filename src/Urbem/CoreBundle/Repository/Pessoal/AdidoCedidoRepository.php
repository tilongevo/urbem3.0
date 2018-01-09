<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AdidoCedidoRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class AdidoCedidoRepository extends AbstractRepository
{
    /**
     * @param array $params
     * @return mixed
     */
    public function consultaAdidoCedidoLegado(array $params)
    {
        $params['exercicio'] = $params['exercicio'] . "-01-01";

        $sql = <<<SQL
SELECT
    adido_cedido.*,
    to_char(adido_cedido.dt_inicial,
        'dd/mm/yyyy') AS data_inicial,
    to_char(adido_cedido.dt_final,
        'dd/mm/yyyy') AS data_final,
    contrato.registro,
    sw_cgm.numcgm,
    sw_cgm.nom_cgm,
    vw_orgao_nivel.orgao,
    recuperaDescricaoOrgao (orgao.cod_orgao,
        :exercicio) AS descricao
FROM
    pessoal.adido_cedido
    INNER JOIN pessoal.contrato ON adido_cedido.cod_contrato = contrato.cod_contrato
    INNER JOIN pessoal.servidor_contrato_servidor ON contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
    INNER JOIN pessoal.servidor ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
    INNER JOIN sw_cgm ON servidor.numcgm = sw_cgm.numcgm
    INNER JOIN pessoal.contrato_servidor_orgao ON contrato_servidor_orgao.cod_contrato = servidor_contrato_servidor.cod_contrato
    INNER JOIN organograma.orgao ON contrato_servidor_orgao.cod_orgao = orgao.cod_orgao
    INNER JOIN organograma.vw_orgao_nivel ON orgao.cod_orgao = vw_orgao_nivel.cod_orgao
    WHERE
        adido_cedido.timestamp = (
            SELECT
                TIMESTAMP
            FROM
                pessoal.adido_cedido AS adido_cedido_interno
            WHERE
                adido_cedido_interno.cod_contrato = adido_cedido.cod_contrato
            ORDER BY
                TIMESTAMP DESC
            LIMIT 1)
        AND contrato_servidor_orgao.timestamp = (
            SELECT
                TIMESTAMP
            FROM
                pessoal.contrato_servidor_orgao AS contrato_servidor_orgao_interno
            WHERE
                contrato_servidor_orgao_interno.cod_contrato = contrato_servidor_orgao.cod_contrato
            ORDER BY
                TIMESTAMP DESC
            LIMIT 1)
        AND NOT EXISTS (
            SELECT
                *
            FROM
                pessoal.adido_cedido_excluido
            WHERE
                adido_cedido_excluido.cod_norma = adido_cedido.cod_norma
                AND adido_cedido_excluido.cod_contrato = adido_cedido.cod_contrato
                AND adido_cedido_excluido.timestamp_cedido_adido = adido_cedido.timestamp)
            AND contrato.cod_contrato = :cod_contrato
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function recuperaAdidosCedidosSEFIP()
    {
        $sql = <<<SQL
SELECT adido_cedido.cgm_cedente_cessionario                                                                                                
         , (SELECT cnpj FROM sw_cgm_pessoa_juridica WHERE numcgm = adido_cedido.cgm_cedente_cessionario) as cnpj                               
         , sw_cgm.nom_cgm                                                                                                                      
         , sw_cgm.logradouro                                                                                                                   
         , sw_cgm.numero                                                                                                                       
         , sw_cgm.complemento                                                                                                                  
         , sw_cgm.bairro                                                                                                                       
         , sw_cgm.cep                                                                                                                          
         , (SELECT nom_municipio FROM sw_municipio WHERE cod_municipio = sw_cgm.cod_municipio AND cod_uf = sw_cgm.cod_uf) as nom_municipio     
         , (SELECT sigla_uf FROM sw_uf WHERE cod_uf = sw_cgm.cod_uf) as sigla                                                                  
      FROM pessoal.adido_cedido                                                                                                                
         , (SELECT cod_contrato                                                                                                                
                 , max(timestamp) as timestamp                                                                                                 
              FROM pessoal.adido_cedido                                                                                                        
            GROUP BY cod_contrato) as max_adido_cedido                                                                                         
         , sw_cgm                                                                                                                              
     WHERE adido_cedido.cod_contrato = max_adido_cedido.cod_contrato                                                                           
       AND adido_cedido.timestamp    = max_adido_cedido.timestamp                                                                              
       AND adido_cedido.cgm_cedente_cessionario = sw_cgm.numcgm                                                                                
       AND NOT EXISTS (SELECT *                                                                                                                
                         FROM pessoal.adido_cedido_excluido                                                                                    
                        WHERE adido_cedido_excluido.cod_norma = adido_cedido.cod_norma                                                         
                          AND adido_cedido_excluido.cod_contrato = adido_cedido.cod_contrato                                                   
                          AND adido_cedido_excluido.timestamp_cedido_adido = adido_cedido.timestamp)                                           
       AND ((adido_cedido.tipo_cedencia = 'a' AND indicativo_onus = 'e') or                                                                    
            (adido_cedido.tipo_cedencia = 'c' AND indicativo_onus = 'c'))                                                                      
    GROUP BY adido_cedido.cgm_cedente_cessionario                                                                                              
           , sw_cgm.nom_cgm                                                                                                                    
           , sw_cgm.logradouro                                                                                                                 
           , sw_cgm.numero                                                                                                                     
           , sw_cgm.complemento                                                                                                                
           , sw_cgm.bairro                                                                                                                     
           , sw_cgm.cep                                                                                                                        
           , sw_cgm.cod_municipio                                                                                                              
           , sw_cgm.cod_uf
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filtro
     *
     * @return mixed
     */
    public function recuperaAdidosCedidosSEFIPContratos($filtro = false)
    {
        $sql = <<<SQL
SELECT adido_cedido.*                                              
     FROM pessoal.adido_cedido                                        
        , (SELECT cod_contrato                                        
                , max(timestamp) as timestamp                         
             FROM pessoal.adido_cedido                                
           GROUP BY cod_contrato) as max_adido_cedido                 
    WHERE adido_cedido.cod_contrato = max_adido_cedido.cod_contrato   
      AND adido_cedido.timestamp = max_adido_cedido.timestamp         
      AND NOT EXISTS (SELECT *                                                                                                                
                        FROM pessoal.adido_cedido_excluido                                                                                    
                       WHERE adido_cedido_excluido.cod_norma = adido_cedido.cod_norma                                                         
                         AND adido_cedido_excluido.cod_contrato = adido_cedido.cod_contrato                                                   
                         AND adido_cedido_excluido.timestamp_cedido_adido = adido_cedido.timestamp)       
SQL;

        if ($filtro) {
            $sql .= $filtro;
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}
