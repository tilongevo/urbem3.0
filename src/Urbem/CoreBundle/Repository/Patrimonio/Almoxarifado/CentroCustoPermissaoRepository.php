<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 25/07/16
 * Time: 11:42
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class CentroCustoPermissaoRepository extends ORM\EntityRepository
{
    public function consultaCentroCustoPermissao($cod_centro, $numcgm)
    {
        $sql = "
        SELECT
            *
        FROM almoxarifado.centro_custo_permissao
        WHERE cod_centro = $cod_centro AND numcgm = $numcgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function deleteAllCentroCustoPermissaoByCgm($numcgm)
    {
        $sql = "
        DELETE
        FROM almoxarifado.centro_custo_permissao
        WHERE numcgm = $numcgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getPermissaoUsuario($entidades, $codigo, $descricao, $numCgm)
    {
        $sql = "
           SELECT centro_custo.cod_centro,        
                  centro_custo.descricao,        
                  TO_CHAR(centro_custo.dt_vigencia, 'dd/mm/yyyy') as dt_vigencia,        
                  responsavel.numcgm,        
                  centro_custo_entidade.cod_entidade,        
                  cgm_entidade.nom_cgm AS desc_entidade,              
                  sw_cgm.nom_cgm        
             FROM almoxarifado.centro_custo        
             JOIN almoxarifado.centro_custo_permissao as responsavel ON (responsavel.cod_centro = centro_custo.cod_centro )   
             JOIN almoxarifado.centro_custo_permissao  ON (centro_custo_permissao.cod_centro = centro_custo.cod_centro )   
             LEFT JOIN almoxarifado.centro_custo_entidade  ON (centro_custo_entidade.cod_centro  = centro_custo.cod_centro), 
                  orcamento.entidade,                                       
                  sw_cgm,                                                   
                  sw_cgm as cgm_entidade                                          
            WHERE centro_custo_entidade.cod_entidade = entidade.cod_entidade      
              AND centro_custo_entidade.exercicio    = entidade.exercicio         
              AND cgm_entidade.numcgm    = entidade.numcgm                        
              AND responsavel.numcgm      = sw_cgm.numcgm                         
              AND responsavel.responsavel = true 
        
        ";

        if ($entidades) {
            if ($codigo) {
                $sql  .= " AND centro_custo_permissao.cod_centro = "  . $codigo ;
            }

            $sql  .= " AND centro_custo_entidade.cod_entidade in ("  . implode(',', $entidades) . ")";
        }
        if ($descricao) {
            $sql  .= " AND descricao ilike '"  . $descricao . "'";
        }
        $sql .= " AND centro_custo_permissao.numcgm = "  . $numCgm;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}
