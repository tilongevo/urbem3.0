<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EventoRescisaoCalculadoRepository extends ORM\EntityRepository
{
    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculoRescisao(
    ".$codContrato.",
    ".$codPeriodoMovimentacao.",
    ".$numCgm.",
    '".$natureza."',
    '".$entidade."'
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
     * @return array
     */
    public function montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select recuperaRotuloValoresAcumuladosCalculoRescisao(
     ".$codContrato.",
    ".$codPeriodoMovimentacao.",
    ".$numCgm.",
    '".$natureza."',
    '".$entidade."'
    ) as rotulo";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * @param $filtroEvento
     * @param $ordemEvento
     * @return array
     */
    public function recuperaEventoRescisaoCalculado($filtroEvento, $ordemEvento = false)
    {
        $ordemEvento = $ordemEvento ? " ORDER BY ".$ordemEvento : " ORDER BY descricao ";

        $stSql = "
        SELECT evento_rescisao_calculado.*                                                                       
             , evento.descricao                                                                                 
             , evento.codigo                                                                                    
             , evento.natureza                                                                                  
             , getDesdobramentoRescisao(evento_rescisao_calculado.desdobramento, '') as desdobramento_texto         
             , evento.descricao as nom_evento                                                                   
          FROM folhapagamento.evento_rescisao_calculado                                                         
             INNER JOIN folhapagamento.registro_evento_rescisao
                ON registro_evento_rescisao.cod_registro     = evento_rescisao_calculado.cod_registro               
                AND registro_evento_rescisao.cod_evento       = evento_rescisao_calculado.cod_evento                 
                AND registro_evento_rescisao.desdobramento = evento_rescisao_calculado.desdobramento                 
                AND registro_evento_rescisao.timestamp        = evento_rescisao_calculado.timestamp_registro         
             INNER JOIN folhapagamento.ultimo_registro_evento_rescisao
                ON registro_evento_rescisao.cod_registro     = ultimo_registro_evento_rescisao.cod_registro         
                AND registro_evento_rescisao.cod_evento       = ultimo_registro_evento_rescisao.cod_evento           
                AND registro_evento_rescisao.desdobramento = ultimo_registro_evento_rescisao.desdobramento           
                AND registro_evento_rescisao.timestamp        = ultimo_registro_evento_rescisao.timestamp
             INNER JOIN folhapagamento.evento
                ON evento_rescisao_calculado.cod_evento = evento.cod_evento
         WHERE 1=1";

        $sql = $stSql.$filtroEvento.$ordemEvento;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
