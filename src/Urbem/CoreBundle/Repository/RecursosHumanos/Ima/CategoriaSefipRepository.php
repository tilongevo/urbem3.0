<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use Doctrine\ORM;

class CategoriaSefipRepository extends ORM\EntityRepository
{

    public function removeCategoriaSefip()
    {
        $conn = $this->_em->getConnection();

        $sql = "
        DELETE
        FROM
            ima.categoria_sefip;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return array
     */
    public function recuperaModalidades()
    {
        $stSql = <<<SQL
SELECT modalidade_recolhimento.sefip                                                
         , modalidade_recolhimento.cod_modalidade                                       
      FROM ima.categoria_sefip                                
         , ima.modalidade_recolhimento                        
         , pessoal.contrato_servidor                          
     WHERE categoria_sefip.cod_modalidade = modalidade_recolhimento.cod_modalidade      
       AND categoria_sefip.cod_categoria = contrato_servidor.cod_categoria              
    GROUP BY modalidade_recolhimento.sefip                                              
           , modalidade_recolhimento.cod_modalidade  
SQL;

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
