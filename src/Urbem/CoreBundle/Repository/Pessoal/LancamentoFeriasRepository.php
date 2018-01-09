<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class LancamentoFeriasRepository extends AbstractRepository
{
    /**
     * @param $codFerias
     * @param null $filtro
     * @return array
     */
    public function recuperaLancamentoFerias($codFerias, $filtro = null)
    {
        $sql = "
               SELECT lancamento_ferias.*                                                      
                    , to_char(lancamento_ferias.dt_inicio,'dd/mm/yyyy') as dt_inicio_formatado 
                    , to_char(lancamento_ferias.dt_fim,'dd/mm/yyyy') as dt_fim_formatado       
                    , lote_ferias_lote.cod_lote                                                
                    , ferias.cod_contrato                                              
                 FROM pessoal.lancamento_ferias               
            LEFT JOIN pessoal.lote_ferias_lote                
                   ON lote_ferias_lote.cod_ferias = lancamento_ferias.cod_ferias       
                    , pessoal.ferias                          
                    , pessoal.servidor_contrato_servidor      
                    , pessoal.servidor                        
                WHERE ferias.cod_ferias = lancamento_ferias.cod_ferias                 
                  AND ferias.cod_contrato = servidor_contrato_servidor.cod_contrato    
                  AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                  AND lancamento_ferias.cod_ferias = $codFerias
        ";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
