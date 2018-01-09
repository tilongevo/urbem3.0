<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class GrupoCreditoRepository extends AbstractRepository
{
    /**
     * @return mixed
     */
    public function getNextVal($exercicio)
    {
        return $this->nextVal("cod_grupo", ['ano_exercicio' => $exercicio]);
    }

    /**
     * @return array
     */
    public function getGrupoCredito()
    {

        $sql = "SELECT                                          
                     acg.*,                                      
                     CASE                                        
                        WHEN                                     
                            acf.cod_grupo IS NULL                
                        THEN                                     
                            ''                                   
                        ELSE                                     
                            '!! ATENÇÃO !! - Há Um ou Mais Calendários Fiscal vinculados a este grupo' 
                    END AS calendario                            
                    , regra_desoneracao_grupo.cod_funcao AS cod_des
                               , funcao.nom_funcao AS func_des             
                    FROM arrecadacao.grupo_credito as acg            
                 LEFT JOIN
                                arrecadacao.regra_desoneracao_grupo
                            ON
                                regra_desoneracao_grupo.cod_grupo = acg.cod_grupo
                                AND regra_desoneracao_grupo.ano_exercicio = acg.ano_exercicio
                
                            LEFT JOIN
                                administracao.funcao
                            ON
                                funcao.cod_modulo = 25
                                AND funcao.cod_biblioteca = 2
                                AND funcao.cod_funcao = regra_desoneracao_grupo.cod_funcao LEFT JOIN                                   
                         arrecadacao.calendario_fiscal as acf    
                     ON                                          
                         acf.cod_grupo = acg.cod_grupo           
                     and acf.ano_exercicio = acg.ano_exercicio   
	             ORDER BY acg.cod_grupo";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
