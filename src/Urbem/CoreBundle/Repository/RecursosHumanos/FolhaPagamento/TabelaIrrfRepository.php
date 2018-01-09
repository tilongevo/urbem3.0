<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class TabelaIrrfRepository extends AbstractRepository
{
    /**
     * @param $timestamp
     * @return int
     */
    public function getProximoCodTabela($timestamp)
    {
        return $this->nextVal('cod_tabela', ['timestamp' => $timestamp]);
    }

    /**
     * @return array
     */
    public function getTabelaIrrfYear()
    {
        $sql = "
            SELECT tabela_irrf.cod_tabela                                
	     , tabela_irrf.vl_dependente                             
	     , tabela_irrf.vl_limite_isencao                         
	     , tabela_irrf.timestamp                                 
	     , to_char(tabela_irrf.vigencia,'dd/mm/yyyy') as vigencia
	  FROM folhapagamento.tabela_irrf                            
	     , (  SELECT cod_tabela                                  
	               , vigencia                                    
	               , max(timestamp) as timestamp                 
	            FROM folhapagamento.tabela_irrf                  
	        GROUP BY cod_tabela                                  
	               , vigencia) as max_tabela_irrf                
	 WHERE tabela_irrf.cod_tabela = max_tabela_irrf.cod_tabela   
	   AND tabela_irrf.timestamp  = max_tabela_irrf.timestamp    
	   AND tabela_irrf.vigencia  = max_tabela_irrf.vigencia;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @return array
     */
    public function montaRecuperaUltimaVigencia()
    {
        $sql = sprintf(
            "select max(vigencia) as vigencia from folhapagamento.tabela_irrf;"
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
