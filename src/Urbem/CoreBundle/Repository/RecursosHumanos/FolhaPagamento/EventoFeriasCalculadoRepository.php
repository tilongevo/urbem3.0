<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EventoFeriasCalculadoRepository extends ORM\EntityRepository
{
    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculoFerias(
    " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    )  order by codigo";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }


    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select recuperaRotuloValoresAcumuladosCalculoFerias(
     " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    ) as rotulo";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaEventosCalculados($filtro, $entidade)
    {
        $sql = "
      SELECT evento_ferias_calculado.*                                                                
        , evento.descricao                                                                          
        , evento.codigo                                                                             
        , evento.natureza                                                                           
        , getDesdobramentoFerias(evento_ferias_calculado.desdobramento,'" . $entidade . "') as desdobramento_texto      
        , evento.descricao as nom_evento                                                            
      FROM folhapagamento.registro_evento_ferias                                                    
          , folhapagamento.ultimo_registro_evento_ferias                                            
          , folhapagamento.evento_ferias_calculado                                                  
          , folhapagamento.evento                                                                   
      WHERE registro_evento_ferias.cod_registro = ultimo_registro_evento_ferias.cod_registro
    AND registro_evento_ferias.cod_evento   = ultimo_registro_evento_ferias.cod_evento
    AND registro_evento_ferias.timestamp    = ultimo_registro_evento_ferias.timestamp
    AND registro_evento_ferias.desdobramento = ultimo_registro_evento_ferias.desdobramento
    AND ultimo_registro_evento_ferias.cod_registro = evento_ferias_calculado.cod_registro
    AND ultimo_registro_evento_ferias.cod_evento   = evento_ferias_calculado.cod_evento
    AND ultimo_registro_evento_ferias.timestamp    = evento_ferias_calculado.timestamp_registro
    AND ultimo_registro_evento_ferias.desdobramento= evento_ferias_calculado.desdobramento
    AND evento_ferias_calculado.cod_evento = evento.cod_evento ";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
