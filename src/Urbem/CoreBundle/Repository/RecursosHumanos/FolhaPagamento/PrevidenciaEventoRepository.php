<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PrevidenciaEventoRepository extends AbstractRepository
{
    /**
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaEventosDePrevidenciaPorContrato($stFiltro)
    {
        $sql = "SELECT cod_evento                                        
    FROM folhapagamento.previdencia_evento                 
       , folhapagamento.previdencia_previdencia            
       , (  SELECT cod_previdencia                           
                 , max(timestamp) as timestamp               
              FROM folhapagamento.previdencia_previdencia    
          GROUP BY cod_previdencia) as max_previdencia_previdencia 
       , folhapagamento.previdencia                        
       , pessoal.contrato_servidor_previdencia             
       , (  SELECT cod_contrato                            
                 , max(timestamp) as timestamp               
              FROM pessoal.contrato_servidor_previdencia    
          GROUP BY cod_contrato) as max_contrato_servidor_previdencia 
    WHERE previdencia_evento.cod_previdencia = previdencia_previdencia.cod_previdencia 
     AND previdencia_evento.timestamp       = previdencia_previdencia.timestamp       
     AND previdencia_previdencia.cod_previdencia = previdencia.cod_previdencia        
     AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia 
     AND previdencia_previdencia.timestamp       = max_previdencia_previdencia.timestamp       
     AND previdencia.cod_previdencia             = contrato_servidor_previdencia.cod_previdencia 
     AND contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato 
     AND contrato_servidor_previdencia.timestamp    = max_contrato_servidor_previdencia.timestamp";

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        return $result;
    }
}
