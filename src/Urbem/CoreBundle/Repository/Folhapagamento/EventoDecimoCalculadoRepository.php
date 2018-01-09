<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class EventoDecimoCalculadoRepository extends AbstractRepository
{
    /**
     * Retorna os Eventos de Décimo Terceiro calculados
     *
     * @param  array $params
     *
     * @return \PDO::FETCH_OBJ
     */
    public function getEventosCalculados(array $params)
    {
        $sql = "
        SELECT
            evento_decimo_calculado.*,
            evento.descricao,
            evento.codigo,
            evento.natureza,
            getDesdobramentoDecimo (evento_decimo_calculado.desdobramento, '') AS desdobramento_texto,
            evento.descricao AS nom_evento
        FROM
            folhapagamento.evento_decimo_calculado,
            folhapagamento.registro_evento_decimo,
            folhapagamento.evento
        WHERE
            evento_decimo_calculado.cod_registro = registro_evento_decimo.cod_registro
            AND evento_decimo_calculado.cod_evento = registro_evento_decimo.cod_evento
            AND evento_decimo_calculado.timestamp_registro = registro_evento_decimo.timestamp
            AND evento_decimo_calculado.desdobramento = registro_evento_decimo.desdobramento
            AND evento_decimo_calculado.cod_evento = evento.cod_evento
            AND cod_contrato = :codContrato
            AND cod_periodo_movimentacao = :codPeriodoMovimentacao
        ORDER BY
            evento_decimo_calculado.cod_evento
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($params);
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

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
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculoDecimo(
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
        $stSql = "select recuperaRotuloValoresAcumuladosCalculoDecimo(
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
   SELECT evento_decimo_calculado.*                                                            
         , evento.descricao                                                                     
         , evento.codigo                                                                        
         , evento.natureza                                                                      
         , getDesdobramentoDecimo(evento_decimo_calculado.desdobramento,'" . $entidade . "') as desdobramento_texto 
         , evento.descricao as nom_evento                                                       
      FROM folhapagamento.evento_decimo_calculado                                               
         , folhapagamento.registro_evento_decimo                                                
         , folhapagamento.evento                                                                
     WHERE evento_decimo_calculado.cod_registro = registro_evento_decimo.cod_registro           
       AND evento_decimo_calculado.cod_evento = registro_evento_decimo.cod_evento               
       AND evento_decimo_calculado.timestamp_registro = registro_evento_decimo.timestamp        
       AND evento_decimo_calculado.desdobramento = registro_evento_decimo.desdobramento         
       AND evento_decimo_calculado.cod_evento = evento.cod_evento";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
