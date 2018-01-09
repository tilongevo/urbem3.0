<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\AbstractRepository;

class RegistroEventoComplementarRepository extends AbstractRepository
{
    /**
     * @param $codPeriodoMovimentacao
     * @param $codComplementar
     * @return array
     */
    public function recuperaContratosComRegistroDeEventoReduzido($codPeriodoMovimentacao, $codComplementar)
    {
        $stSql = "SELECT servidor_pensionista.*
      FROM (SELECT servidor_contrato_servidor.cod_contrato
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
               AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente) as servidor_pensionista
     WHERE NOT EXISTS (SELECT 1
                         FROM pessoal.contrato_servidor_caso_causa
                        WHERE servidor_pensionista.cod_contrato = contrato_servidor_caso_causa.cod_contrato)
       AND EXISTS (SELECT 1
                     FROM folhapagamento.registro_evento_complementar
                    WHERE servidor_pensionista.cod_contrato = registro_evento_complementar.cod_contrato
                      AND registro_evento_complementar.cod_periodo_movimentacao = " . $codPeriodoMovimentacao . "
                      AND registro_evento_complementar.cod_complementar = " . $codComplementar . ")";

        $stSql .= " ORDER BY cod_contrato;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @return array
     */
    public function montaDeletarRegistro($codRegistro, $codEvento, $desdobramento, $timestamp)
    {
        $queryc = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stEntidade','');");
        $queryc->execute();
        $querys = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stTipoFolha','C');");
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
     * @param integer $codEvento
     * @param integer $codConfiguracao
     * @return int
     */
    public function getNextCodRegistro($codEvento, $codConfiguracao)
    {
        return $this->nextVal('cod_registro', [
            'cod_evento' => $codEvento,
            'cod_configuracao' => $codConfiguracao
        ]);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $codComplementar
     * @param $codContrato
     * @return array
     */
    public function montaRecuperaRegistrosEventoDoContrato($codPeriodoMovimentacao, $codComplementar, $codContrato)
    {
        $stSql = "SELECT registro_evento_complementar.*
	        , registro_evento_complementar_parcela.parcela
	        , evento.cod_evento
	        , evento.codigo
	        , trim(evento.descricao) as descricao
	        , evento.natureza
	        , evento.tipo
	        , evento.fixado
	        , evento.limite_calculo
	        , evento.apresenta_parcela
	        , evento.observacao
	        , CASE WHEN evento.descricao_configuracao = 'Férias' THEN
	             CASE evento_complementar_calculado.desdobramento
	                 WHEN 'A' THEN 'Abono Férias'
	                 WHEN 'F' THEN 'Férias no Mês'
	                 WHEN 'D' THEN 'Adiant. Férias'
	                 ELSE 'Férias' END
	          ELSE evento.descricao_configuracao END AS descricao_configuracao
	        , evento_complementar_calculado.desdobramento
	        , evento.evento_sistema
	        , contrato.registro
	     FROM folhapagamento.registro_evento_complementar
	LEFT JOIN folhapagamento.evento_complementar_calculado
	       ON registro_evento_complementar.cod_registro     = evento_complementar_calculado.cod_registro
	      AND registro_evento_complementar.timestamp        = evento_complementar_calculado.timestamp_registro
	      AND registro_evento_complementar.cod_evento       = evento_complementar_calculado.cod_evento
	      AND registro_evento_complementar.cod_configuracao = evento_complementar_calculado.cod_configuracao
	LEFT JOIN folhapagamento.registro_evento_complementar_parcela
	       ON registro_evento_complementar.cod_registro     = registro_evento_complementar_parcela.cod_registro
	      AND registro_evento_complementar.timestamp        = registro_evento_complementar_parcela.timestamp
	      AND registro_evento_complementar.cod_evento       = registro_evento_complementar_parcela.cod_evento
	      AND registro_evento_complementar.cod_configuracao = registro_evento_complementar_parcela.cod_configuracao
	LEFT JOIN pessoal.contrato
	       ON registro_evento_complementar.cod_contrato     = contrato.cod_contrato
	LEFT JOIN (SELECT evento.*
	                , evento_evento.observacao
	                , configuracao_evento.descricao as descricao_configuracao
	                , configuracao_evento.cod_configuracao
	             FROM folhapagamento.evento
	                , folhapagamento.evento_evento
	                , (  SELECT cod_evento
	                          , max(timestamp) as timestamp
	                       FROM folhapagamento.evento_evento
	                    GROUP BY cod_evento) as max_evento_evento
	                , folhapagamento.evento_configuracao_evento
	                , folhapagamento.configuracao_evento
	            WHERE evento.cod_evento                         = evento_evento.cod_evento
	              AND evento_evento.cod_evento                  = max_evento_evento.cod_evento
	              AND evento_evento.timestamp                   = max_evento_evento.timestamp
	              AND evento_evento.cod_evento                  = evento_configuracao_evento.cod_evento
	              AND evento_evento.timestamp                   = evento_configuracao_evento.timestamp
	              AND evento_configuracao_evento.cod_configuracao = configuracao_evento.cod_configuracao) as evento
	       ON registro_evento_complementar.cod_evento       = evento.cod_evento
	      AND registro_evento_complementar.cod_configuracao = evento.cod_configuracao
	        , folhapagamento.ultimo_registro_evento_complementar
	    WHERE registro_evento_complementar.timestamp        = ultimo_registro_evento_complementar.timestamp
	      AND registro_evento_complementar.cod_registro     = ultimo_registro_evento_complementar.cod_registro
	      AND registro_evento_complementar.cod_evento       = ultimo_registro_evento_complementar.cod_evento
	      AND registro_evento_complementar.cod_configuracao = ultimo_registro_evento_complementar.cod_configuracao
	 AND registro_evento_complementar.cod_periodo_movimentacao = $codPeriodoMovimentacao
	 AND registro_evento_complementar.cod_complementar = $codComplementar
	 AND registro_evento_complementar.cod_contrato = $codContrato";

        $stSql .= " ORDER BY cod_contrato;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }
}
