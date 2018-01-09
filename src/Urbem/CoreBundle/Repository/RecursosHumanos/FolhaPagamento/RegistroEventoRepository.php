<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoRepository extends AbstractRepository
{
    /**
     * @param $codPeriodoMovimentacao
     * @param $contratos
     * @param bool $desdobramento
     * @return array
     */
    public function recuperaRegistrosDeEventos($codPeriodoMovimentacao, $contratos, $desdobramento = false)
    {
        $stSql = "
                SELECT registro_evento_periodo.*
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
                   AND ultimo_registro_evento.timestamp = evento_calculado.timestamp";

        if ($desdobramento) {
            $stSql .= "       AND (trim(evento_calculado.desdobramento) = '' OR evento_calculado.desdobramento = NULL) ";
        }

        $stSql .="  LEFT JOIN folhapagamento.registro_evento_parcela
                       ON ultimo_registro_evento.cod_evento = registro_evento_parcela.cod_evento
                      AND ultimo_registro_evento.cod_registro = registro_evento_parcela.cod_registro
                      AND ultimo_registro_evento.timestamp = registro_evento_parcela.timestamp

                    WHERE evento_evento.timestamp = ( SELECT timestamp
                                                       FROM folhapagamento.evento_evento as evento_evento_interno
                                                      WHERE evento_evento_interno.cod_evento = evento.cod_evento
                                                   ORDER BY timestamp DESC
                                                      LIMIT 1 )
                      AND registro_evento_periodo.cod_periodo_movimentacao = $codPeriodoMovimentacao
                      AND registro_evento_periodo.cod_contrato IN (".$contratos.")";

        $stSql .= " ORDER BY descricao;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $registro
     * @param $codigo
     *
     * @return array
     */
    public function recuperaEventosPorContratoEPeriodo($codPeriodoMovimentacao, $registro, $codigo)
    {
        $stSql = "
           SELECT registro_evento_periodo.cod_periodo_movimentacao
          , contrato.registro
          , evento.codigo
       FROM folhapagamento.registro_evento
       JOIN folhapagamento.ultimo_registro_evento
         ON registro_evento.cod_registro = ultimo_registro_evento.cod_registro
       JOIN folhapagamento.evento
         ON evento.cod_evento = registro_evento.cod_evento
       JOIN folhapagamento.registro_evento_periodo
         ON registro_evento_periodo.cod_registro = registro_evento.cod_registro
       JOIN folhapagamento.contrato_servidor_periodo
         ON contrato_servidor_periodo.cod_periodo_movimentacao = registro_evento_periodo.cod_periodo_movimentacao
        AND contrato_servidor_periodo.cod_contrato             = registro_evento_periodo.cod_contrato
       JOIN pessoal.contrato_servidor
         ON contrato_servidor.cod_contrato = contrato_servidor_periodo.cod_contrato
       JOIN pessoal.contrato
         ON contrato.cod_contrato = contrato_servidor.cod_contrato where 1 = 1
            AND registro_evento_periodo.cod_periodo_movimentacao = $codPeriodoMovimentacao
            AND contrato.registro = $registro
            AND evento.codigo = '".$codigo."'";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaRelacionamentoConfiguracao($stFiltro)
    {
        $stSql = "SELECT evento.*
             , evento_evento.observacao
             , evento_evento.valor_quantidade
             , configuracao_evento_caso.cod_caso
             , configuracao_evento_caso.cod_configuracao
             , configuracao_evento_caso.timestamp
          FROM folhapagamento.evento
    INNER JOIN folhapagamento.evento_evento
            ON evento.cod_evento = evento_evento.cod_evento
    INNER JOIN folhapagamento.configuracao_evento_caso
            ON evento_evento.cod_evento = configuracao_evento_caso.cod_evento
           AND evento_evento.timestamp = configuracao_evento_caso.timestamp
    INNER JOIN folhapagamento.configuracao_evento_caso_sub_divisao as sub_divisao
            ON configuracao_evento_caso.cod_caso          = sub_divisao.cod_caso
           AND configuracao_evento_caso.cod_evento        = sub_divisao.cod_evento
           AND configuracao_evento_caso.cod_configuracao  = sub_divisao.cod_configuracao
           AND configuracao_evento_caso.timestamp         = sub_divisao.timestamp
    INNER JOIN folhapagamento.configuracao_evento_caso_cargo as cargo
            ON configuracao_evento_caso.cod_caso          = cargo.cod_caso
           AND configuracao_evento_caso.cod_evento        = cargo.cod_evento
           AND configuracao_evento_caso.cod_configuracao  = cargo.cod_configuracao
           AND configuracao_evento_caso.timestamp         = cargo.timestamp
     LEFT JOIN folhapagamento.configuracao_evento_caso_especialidade as especialidade
            ON cargo.cod_caso                             = especialidade.cod_caso
           AND cargo.cod_evento                           = especialidade.cod_evento
           AND cargo.cod_configuracao                     = especialidade.cod_configuracao
           AND cargo.timestamp                            = especialidade.timestamp
           AND cargo.cod_cargo                            = especialidade.cod_cargo
        WHERE evento_evento.timestamp = ( SELECT timestamp
                                            FROM folhapagamento.evento_evento as evento_evento_interno
                                           WHERE evento_evento_interno.cod_evento = evento_evento.cod_evento
                                        ORDER BY timestamp desc
                                           LIMIT 1 )";

        if ($stFiltro) {
            $stSql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /*
     * @param null $filtro
     * @return array
     */
    public function recuperaRegistrosEventos($filtro = null)
    {
        $sql = "SELECT registro_evento.*                                                             
          FROM folhapagamento.registro_evento_periodo               
          JOIN folhapagamento.registro_evento                       
            ON registro_evento_periodo.cod_registro = registro_evento.cod_registro           
          JOIN folhapagamento.ultimo_registro_evento                
            ON registro_evento.cod_registro = ultimo_registro_evento.cod_registro";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
