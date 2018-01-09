<?php
namespace Urbem\CoreBundle\Repository\Beneficio;

use Urbem\CoreBundle\Repository\AbstractRepository;

class BeneficiarioRepository extends AbstractRepository
{
    /**
     * @param $paramsWhere
     *
     * @return array
     */
    public function recuperaBeneficiariosLayoutFornecedor($paramsWhere)
    {
        $sql = sprintf(
            " SELECT                           
                 CGM.numcgm                  
                 ,CGM.nom_cgm                 
             FROM                             
                 SW_CGM AS CGM                
             LEFT JOIN                        
                 sw_cgm_pessoa_fisica AS PF   
             ON                               
                 CGM.numcgm = PF.numcgm       
             LEFT JOIN                        
                 sw_cgm_pessoa_juridica AS PJ 
             ON                               
                 CGM.numcgm = PJ.numcgm       
             WHERE                            
                 CGM.numcgm <> 0              
             and exists ( select 1 from  beneficio.layout_fornecedor  as tabela_vinculo
                                             where tabela_vinculo.cgm_fornecedor = CGM.numcgm ) AND %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $stCondicao
     *
     * @return array
     */
    public function verificaPeriodoMovimentacao($stCondicao)
    {
        $sql = "SELECT *                                                                                                                                                                      
        FROM folhapagamento.periodo_movimentacao                                                                                                                                    
        INNER JOIN ( SELECT * FROM folhapagamento.periodo_movimentacao_situacao WHERE situacao = 'a' ORDER BY cod_periodo_movimentacao DESC LIMIT 1 ) AS max_periodo_movimentacao_situacao
          ON max_periodo_movimentacao_situacao.cod_periodo_movimentacao = periodo_movimentacao.cod_periodo_movimentacao";

        if ($stCondicao) {
            $sql .= $stCondicao;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll());
        $result = $queryResult;

        return $result;
    }
}
