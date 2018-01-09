<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FgtsEventoRepository extends AbstractRepository
{
    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaRelacionamento($stFiltro = false)
    {
        $sql = <<<SQL
SELECT fgts_evento.*                                        
        , trim(evento.descricao) as descricao                                     
        , evento.codigo                                        
     FROM folhapagamento.fgts_evento                           
        , (  SELECT cod_fgts                                   
                  , max(timestamp) as timestamp                
               FROM folhapagamento.fgts_evento                 
           GROUP BY cod_fgts) as max_fgts_evento               
        , folhapagamento.evento                                
    WHERE fgts_evento.cod_evento = evento.cod_evento           
      AND fgts_evento.cod_fgts   = max_fgts_evento.cod_fgts    
      AND fgts_evento.timestamp  = max_fgts_evento.timestamp
SQL;

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll(\PDO::FETCH_OBJ));
        $result = $queryResult;

        return $result;
    }
}
