<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoPeriodoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodRegistro()
    {
        return $this->nextVal('cod_registro');
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function montaRecuperaRegistrosDeEventos($stFiltro = false)
    {
        $sql = "
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

        /*    if ($this->getDado("desdobramento")) {
                $sql .= "       AND (trim(evento_calculado.desdobramento) = '' OR evento_calculado.desdobramento = NULL) ";
            }*/

        $sql .= "  LEFT JOIN folhapagamento.registro_evento_parcela
                       ON ultimo_registro_evento.cod_evento = registro_evento_parcela.cod_evento
                      AND ultimo_registro_evento.cod_registro = registro_evento_parcela.cod_registro
                      AND ultimo_registro_evento.timestamp = registro_evento_parcela.timestamp

                    WHERE evento_evento.timestamp = ( SELECT timestamp
                                                       FROM folhapagamento.evento_evento as evento_evento_interno
                                                      WHERE evento_evento_interno.cod_evento = evento.cod_evento
                                                   ORDER BY timestamp DESC
                                                      LIMIT 1 )";

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param array|int $numcgm
     * @return array
     */
    public function montaRecuperaContratosAutomaticos($codPeriodoMovimentacao, $numcgm)
    {
        $sql = "
        SELECT registro_evento_periodo.cod_contrato
           , registro
           , sw_cgm.numcgm
           , sw_cgm.nom_cgm
        FROM folhapagamento.registro_evento_periodo
           , folhapagamento.registro_evento
           , folhapagamento.ultimo_registro_evento
               , (SELECT servidor_contrato_servidor.cod_contrato
                       , servidor.numcgm
                    FROM pessoal.servidor_contrato_servidor
                       , pessoal.servidor
                   WHERE servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                   UNION
                  SELECT contrato_pensionista.cod_contrato
                       , pensionista.numcgm
                    FROM pessoal.contrato_pensionista
                       , pessoal.pensionista
                   WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                     AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente) as servidor_contrato_servidor
           , pessoal.contrato
           , sw_cgm
       WHERE registro_evento_periodo.cod_registro = registro_evento.cod_registro
         AND registro_evento.cod_registro = ultimo_registro_evento.cod_registro
         AND registro_evento_periodo.cod_contrato  = servidor_contrato_servidor.cod_contrato
         AND servidor_contrato_servidor.cod_contrato = contrato.cod_contrato
         AND servidor_contrato_servidor.numcgm = sw_cgm.numcgm
         AND cod_periodo_movimentacao = '$codPeriodoMovimentacao'";
        if ($numcgm) {
            $sql .= " AND sw_cgm.numcgm IN (" . $numcgm . ")";
        }
         $sql .= "
         AND contrato.cod_contrato NOT IN (SELECT cod_contrato FROM pessoal.contrato_servidor_caso_causa)
    GROUP BY registro_evento_periodo.cod_contrato
           , registro
           , sw_cgm.numcgm
           , sw_cgm.nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $stCodContratos
     * @param $stTipoFolha
     * @param $inCodComplementar
     * @param $entidade
     * @return mixed
     */
    public function deletarInformacoesCalculo($stCodContratos, $stTipoFolha, $inCodComplementar, $entidade)
    {
        $sql = sprintf(
            "
                SELECT public.deletarinformacoescalculo('%s','%s',%d,'%s') as retorno
            ",
            $stCodContratos,
            $stTipoFolha,
            $inCodComplementar,
            $entidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $result = array_shift($result);

        return $result;
    }

    /**
     * @param $cod_contrato
     * @param $tipo
     * @param $erro
     * @param $entidade
     * @param $exercicio
     * @return mixed
     */
    public function calculaFolha($cod_contrato, $tipo, $erro, $entidade, $exercicio)
    {
        $query = $this->_em->getConnection()->prepare("SELECT public.calculafolha(:cod_contrato,:tipo,:erro,:entidade,:exercicio) as retorno");
        $query->bindValue(':cod_contrato', $cod_contrato, \PDO::PARAM_STR);
        $query->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
        $query->bindValue(':erro', $erro, \PDO::PARAM_STR);
        $query->bindValue(':entidade', $entidade, \PDO::PARAM_STR);
        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        $result = array_shift($result);

        return $result;
    }
}
