<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ConstrucaoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->nextVal("cod_construcao");
    }

    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function cadastroImobiliario($inscricaoMunicipal)
    {
        $sql = sprintf("
            select
                *
            from
                imobiliario.fn_rl_cadastro_imobiliario(
                    ' AND I.inscricao_municipal = %s',
                    '',
                    'TRUE',
                    '
                            GROUP BY
                                inscricao_municipal
                        ',
                    '
                            GROUP BY
                                cod_lote
                        ',
                    '
                            GROUP BY
                                cod_construcao,
                                cod_tipo
                        '
                ) as retorno(
                    inscricao_municipal integer,
                    proprietario_cota text,
                    cod_lote integer,
                    dt_cadastro date,
                    tipo_lote text,
                    valor_lote varchar,
                    endereco varchar,
                    cep varchar,
                    cod_localizacao integer,
                    localizacao text,
                    cod_condominio integer,
                    creci varchar,
                    nom_bairro varchar,
                    logradouro text,
                    situacao text
                )
            order by
                inscricao_municipal
        ", $inscricaoMunicipal);

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function areaImovel($inscricaoMunicipal)
    {
        $sql = "
            SELECT                                                                                   
                imobiliario.fn_calcula_area_imovel( inscricao_municipal ) AS area_imovel,            
                imobiliario.fn_calcula_area_imovel_lote( inscricao_municipal ) AS area_imovel_lote,  
                imobiliario.fn_calcula_area_imovel_construcao( inscricao_municipal ) AS area_total   
            FROM                                                                                     
                imobiliario.imovel                                                                   
            WHERE                                                                                    
                inscricao_municipal = :inscricaoMunicipal
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function unidadeAutonoma($inscricaoMunicipal)
    {
        $sql = "
             SELECT                                                          
                 UA.*                                                        
             FROM                                                            
                 imobiliario.unidade_autonoma UA                             
             LEFT JOIN (                                                     
                SELECT                                                       
                    BAL.*                                                    
                FROM                                                         
                    imobiliario.baixa_unidade_autonoma AS BAL,               
                    (                                                        
                    SELECT                                                   
                        MAX (TIMESTAMP) AS TIMESTAMP,                        
                        inscricao_municipal,                                 
                        cod_tipo,                                            
                        cod_construcao                                       
                    FROM                                                     
                        imobiliario.baixa_unidade_autonoma                   
                    GROUP BY                                                 
                        inscricao_municipal,                                 
                        cod_tipo,                                            
                        cod_construcao                                       
                    ) AS BT                                                  
                WHERE                                                        
                    BAL.inscricao_municipal = BT.inscricao_municipal AND     
                    BAL.cod_tipo = BT.cod_tipo AND                           
                    BAL.cod_construcao = BT.cod_construcao AND               
                    BAL.timestamp = BT.timestamp                             
             ) bua                                                           
             ON                                                              
                bua.inscricao_municipal = ua.inscricao_municipal AND         
                bua.cod_tipo= ua.cod_tipo AND                                
                bua.cod_construcao = ua.cod_construcao                       
             WHERE                                                           
                ((bua.dt_inicio IS NULL) OR (bua.dt_inicio IS NOT NULL AND bua.dt_termino IS NOT NULL) AND bua.inscricao_municipal = ua.inscricao_municipal AND                        
                bua.cod_tipo= ua.cod_tipo AND                                
                bua.cod_construcao = ua.cod_construcao)                      
             AND ua.inscricao_municipal = :inscricaoMunicipal ORDER BY cod_construcao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @param array $where
     * @param array $param
     * @param string $order
     * @return array
     */
    public function getCaracteristicasEdificacao(Array $where = [], Array $param = [], $order = null)
    {
        $sql = "
        SELECT
            ic.cod_construcao,
            COALESCE( ice.cod_modulo, ico.cod_modulo, icc.cod_modulo) AS cod_modulo,
            COALESCE( ice.cod_atributo, ico.cod_atributo, icc.cod_atributo) AS cod_atributo,
            COALESCE( ice.cod_cadastro, ico.cod_cadastro, icc.cod_cadastro) AS cod_cadastro,
            COALESCE( ice.valor, ico.valor, icc.valor) AS valor
        FROM
            imobiliario.construcao AS ic
        LEFT JOIN (
            SELECT
                ice.cod_construcao,
                ice.cod_tipo,
                iat.cod_cadastro,
                iat.cod_atributo,
                iat.cod_modulo,
                (
                    SELECT
                        iatv.valor
                    FROM
                        imobiliario.atributo_tipo_edificacao_valor AS iatv
                    WHERE
                        iatv.cod_modulo = iat.cod_modulo
                        AND iatv.cod_cadastro = iat.cod_cadastro
                        AND iatv.cod_atributo = iat.cod_atributo
                        AND iatv.cod_tipo = iat.cod_tipo
                        AND iatv.cod_construcao = ice.cod_construcao
                    ORDER BY
                       iatv.timestamp DESC
                    LIMIT 1
                ) AS valor
            FROM
                imobiliario.construcao_edificacao AS ice
            INNER JOIN
                imobiliario.atributo_tipo_edificacao AS iat
            ON
                iat.cod_tipo = ice.cod_tipo
            AND iat.ativo = 't'
        )AS ice
        ON ice.cod_construcao = ic.cod_construcao
        LEFT JOIN
            (
                SELECT
                    iac.*
                FROM
                    imobiliario.construcao_outros AS ico
                INNER JOIN
                    imobiliario.atributo_construcao_outros_valor AS iac
                ON
                    iac.cod_construcao = ico.cod_construcao
            )AS ico
        ON
            ico.cod_construcao = ic.cod_construcao
        LEFT JOIN
            (
                SELECT
                    icc.cod_construcao,
                    iac.*
                FROM
                    imobiliario.construcao_condominio AS icc
                INNER JOIN
                    imobiliario.atributo_condominio_valor AS iac
                ON
                    iac.cod_condominio = icc.cod_condominio
            )AS icc
        ON
            icc.cod_construcao = ic.cod_construcao
        ";
        
        $whereStr = "";
        $orderStr = "";
        
        if (count($where)) {
            $whereStr = " WHERE ";
            $whereStr .= implode(" AND ", $where);
        }
        
        if (!is_null($order)) {
            $orderStr = " ORDER BY ".$order;
        }
        
        $sql .= $whereStr.$orderStr;
        
        $query = $this->_em->getConnection()->prepare($sql);
        
        foreach ($param as $key => $val) {
            $query->bindValue($key, $val, \PDO::PARAM_INT);
        }
        
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
