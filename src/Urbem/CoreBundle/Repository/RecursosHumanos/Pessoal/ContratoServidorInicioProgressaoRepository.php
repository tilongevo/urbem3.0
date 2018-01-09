<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ContratoServidorInicioProgressaoRepository extends ORM\EntityRepository
{
    /**
     * @param $codContrato
     * @return mixed
     */
    public function consultaDataInicioProgressaoMaxTimestamp($codContrato)
    {
        $sql = "SELECT to_char(inicio_progressao.dt_inicio_progressao,'dd/mm/yyyy') as dt_inicio_progressao  
                  FROM pessoal.contrato_servidor_inicio_progressao as inicio_progressao  
                     , (  SELECT cod_contrato                                            
                               , max(timestamp) as timestamp                             
                            FROM pessoal.contrato_servidor_inicio_progressao             
                        GROUP BY cod_contrato) as max_inicio_progressao                  
                 WHERE inicio_progressao.cod_contrato = max_inicio_progressao.cod_contrato 
                   AND inicio_progressao.timestamp    = max_inicio_progressao.timestamp  
                 AND inicio_progressao.cod_contrato = ".$codContrato;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}
