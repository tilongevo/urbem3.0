<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class UltimoRegistroEventoRepository extends ORM\EntityRepository
{
    /**
     * @param $registro
     * @param bool $codPeriodoMovimentacao
     * @param bool $desdobramento
     * @return array
     */
    public function montaRecuperaRegistrosEventoDoContrato($registro, $codPeriodoMovimentacao = false, $desdobramento = false)
    {
        $stSql = "SELECT registro_evento_periodo.*
                     , registro_evento.*
                     , evento.codigo
                     , CASE evento_calculado.desdobramento
                       WHEN 'A' THEN trim(evento.descricao) || ' Abono Férias'
                       WHEN 'F' THEN trim(evento.descricao) || ' Férias no Mês'
                       WHEN 'D' THEN trim(evento.descricao) || ' Adiant. Férias'
                       ELSE trim(evento.descricao) END as descricao
                     , evento_calculado.desdobramento
                     , evento.tipo
                     , evento.fixado
                     , evento.natureza
                     , evento.limite_calculo
                     , evento.evento_sistema
                     , CASE evento.natureza
                       WHEN 'P' THEN 'Proventos'
                       WHEN 'D' THEN 'Descontos'
                       WHEN 'B' THEN 'Base'
                       END as proventos_descontos
                     , registro_evento_parcela.parcela
                     , registro_evento_parcela.mes_carencia
                     , registro
                     , evento_evento.observacao                     
                  FROM folhapagamento.ultimo_registro_evento
            INNER JOIN folhapagamento.registro_evento
                    ON ultimo_registro_evento.cod_evento = registro_evento.cod_evento
                   AND ultimo_registro_evento.cod_registro = registro_evento.cod_registro
                   AND ultimo_registro_evento.timestamp = registro_evento.timestamp
            INNER JOIN folhapagamento.evento
                    ON evento.cod_evento = registro_evento.cod_evento
            INNER JOIN folhapagamento.evento_evento
                    ON evento_evento.cod_evento = registro_evento.cod_evento
            INNER JOIN folhapagamento.registro_evento_periodo
                    ON registro_evento.cod_registro = registro_evento_periodo.cod_registro
            INNER JOIN pessoal.contrato
                    ON registro_evento_periodo.cod_contrato = contrato.cod_contrato
             LEFT JOIN folhapagamento.evento_calculado
                    ON ultimo_registro_evento.cod_evento = evento_calculado.cod_evento
                   AND ultimo_registro_evento.cod_registro = evento_calculado.cod_registro
                   AND ultimo_registro_evento.timestamp = evento_calculado.timestamp
                   LEFT JOIN folhapagamento.registro_evento_parcela
                       ON ultimo_registro_evento.cod_evento = registro_evento_parcela.cod_evento
                      AND ultimo_registro_evento.cod_registro = registro_evento_parcela.cod_registro
                      AND ultimo_registro_evento.timestamp = registro_evento_parcela.timestamp
                    WHERE evento_evento.timestamp = ( SELECT timestamp
                                                       FROM folhapagamento.evento_evento as evento_evento_interno
                                                      WHERE evento_evento_interno.cod_evento = evento.cod_evento
                                                   ORDER BY timestamp DESC
                                                      LIMIT 1 ) and contrato.registro = $registro";

        if ($codPeriodoMovimentacao) {
            $stSql .= " AND cod_periodo_movimentacao = $codPeriodoMovimentacao ";
        }

        if ($desdobramento) {
            $stSql .= " AND evento_calculado.desdobramento = $desdobramento ";
        } else {
            $stSql .= " AND evento_calculado.desdobramento is null ";
        }

        $stSql .= " ORDER BY descricao;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @param $tipo
     * @return array
     */
    public function montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $tipo)
    {
        $queryc = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stEntidade','');");
        $queryc->execute();
        $querys = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stTipoFolha',:tipo);");
        $querys->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
        $querys->execute();
        $query = $this->_em->getConnection()->prepare("SELECT public.deletarUltimoRegistroEvento(:codRegistro,:codEvento,:desdobramento,:timestamp)");
        $query->bindValue(':codRegistro', $codRegistro, \PDO::PARAM_STR);
        $query->bindValue(':codEvento', $codEvento, \PDO::PARAM_STR);
        $query->bindValue(':desdobramento', $desdobramento, \PDO::PARAM_STR);
        $query->bindValue(':timestamp', $timestamp, \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return array
     */
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        $sql = "SELECT ultimo_registro_evento.*                                                              
        FROM folhapagamento.ultimo_registro_evento                                                 
        , folhapagamento.registro_evento                                                        
        , folhapagamento.registro_evento_periodo                                                
        WHERE ultimo_registro_evento.cod_registro = registro_evento.cod_registro                    
        AND ultimo_registro_evento.cod_evento   = registro_evento.cod_evento                      
        AND ultimo_registro_evento.timestamp    = registro_evento.timestamp                       
        AND registro_evento.cod_registro = registro_evento_periodo.cod_registro";

        if ($filtro) {
            $sql .= $filtro;
        }

        if ($ordem) {
            $sql .= $ordem;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
