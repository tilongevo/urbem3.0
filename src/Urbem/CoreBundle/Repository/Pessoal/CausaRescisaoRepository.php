<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class CausaRescisaoRepository
 *
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class CausaRescisaoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodCausaRescisao()
    {
        return $this->nextVal('cod_causa_rescisao');
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function recuperaSefipRescisao($filtro)
    {
        $sql = <<<SQL
    SELECT causa_rescisao.cod_sefip_saida                                                            
      FROM pessoal.contrato_servidor_caso_causa                            
         , pessoal.caso_causa                                              
         , pessoal.causa_rescisao                                          
     WHERE contrato_servidor_caso_causa.cod_caso_causa = caso_causa.cod_caso_causa                   
       AND caso_causa.cod_causa_rescisao = causa_rescisao.cod_causa_rescisao
SQL;
        if ($filtro) {
            $sql .= $filtro;
        }


        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll(\PDO::FETCH_OBJ));
        $result = $queryResult;
        return $result;
    }
}
