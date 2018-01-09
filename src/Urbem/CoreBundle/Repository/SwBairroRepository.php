<?php

namespace Urbem\CoreBundle\Repository;

/**
 * Class SwBairroRepository
 *
 * @package Urbem\CoreBundle\Repository
 */
class SwBairroRepository extends AbstractRepository
{
    /**
     * @param string $campo
     * @param array $params
     * @return int
     */
    public function nextVal($campo, array $params = [])
    {
        return parent::nextVal($campo, $params);
    }

    /**
     * @param $params
     * @return array
     */
    public function filtraBairro($params)
    {

        $andWhere = "";
        if (isset($params['nomBairro']) && $params['nomBairro'] != "") {
            $andWhere .= sprintf(" AND UPPER( B.nom_bairro ) like UPPER( '%s%%' )", $params['nomBairro']);
        }

        if (isset($params['codMunicipio']) && $params['codMunicipio'] != "") {
            $andWhere .= sprintf(" AND M.cod_municipio = '%s'", $params['codMunicipio']);
        }

        if (isset($params['codUf']) && $params['codUf'] != "") {
            $andWhere .= sprintf(" AND M.cod_uf = '%s'", $params['codUf']);
        }

        if (isset($params['codBairroDe']) && $params['codBairroDe'] != "") {
            if (isset($params['codBairroAte']) && $params['codBairroAte'] != "") {
                $andWhere .= sprintf(" AND B.cod_bairro BETWEEN %s AND %s", $params['codBairroDe'], $params['codBairroAte']);
            } else {
                $andWhere .= sprintf(" AND B.cod_bairro >= %s", $params['codBairroDe']);
            }
        }

        if (isset($params['codBairroAte']) && $params['codBairroAte'] != "") {
            if (!(isset($params['codBairroDe']) && $params['codBairroDe'] != "")) {
                $andWhere .= sprintf(" AND B.cod_bairro <= %s", $params['codBairroAte']);
            }
        }

        $ordenacao = " ";
        if (isset($params['ordenacao']) && $params['ordenacao'] != "") {
            switch ($params['ordenacao']) {
                case 'codigo':
                    $ordenacao = " ORDER BY B.cod_bairro, U.cod_uf, M.cod_municipio";
                    break;
                case 'uf':
                    $ordenacao = " ORDER BY U.cod_uf, M.nom_municipio, B.nom_bairro";
                    break;
                case 'municipio':
                    $ordenacao = " ORDER BY M.nom_municipio, U.cod_uf, B.nom_bairro";
                    break;
                case 'bairro':
                    $ordenacao = " ORDER BY B.nom_bairro, U.cod_uf, M.nom_municipio, B.cod_bairro;";
                    break;
                default:
                    $ordenacao = " ORDER BY U.cod_uf, M.nom_municipio, B.nom_bairro";
                    break;
            }
        }

        $sql = sprintf("
          SELECT                                     
              B.*,                                  
              U.nom_uf,                             
              M.nom_municipio                      
          FROM                                   
              sw_bairro     AS B,       
              sw_uf         AS U,                        
              sw_municipio  AS M                     
          WHERE                                         
              B.cod_uf        = U.cod_uf        
              AND      
              B.cod_municipio = M.cod_municipio 
              AND      
              M.cod_uf        = U.cod_uf
          %s
          %s
        ", $andWhere, $ordenacao);

            $query = $this->_em->getConnection()->prepare($sql);

            $query->execute();
            return $query->fetchAll();
    }
}
