<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class UltimoRegistroEventoDecimoRepository extends ORM\EntityRepository
{
    public function recuperaRegistrosDeEventoSemCalculo($filtro = false)
    {
        $stSql = "
        SELECT ultimo_registro_evento_decimo.*
         , registro_evento_decimo.cod_contrato
      FROM folhapagamento.ultimo_registro_evento_decimo
         , folhapagamento.registro_evento_decimo
     WHERE ultimo_registro_evento_decimo.cod_registro = registro_evento_decimo.cod_registro
       AND ultimo_registro_evento_decimo.cod_evento = registro_evento_decimo.cod_evento
       AND ultimo_registro_evento_decimo.timestamp = registro_evento_decimo.timestamp
       AND ultimo_registro_evento_decimo.cod_registro not in (SELECT cod_registro FROM folhapagamento.evento_decimo_calculado)";

        if (isset($filtro)) {
            $stSql .= $filtro;
        }
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function montaRecuperaRegistrosEventoDecimoDoContrato($codContrato, $codPeriodoMovimentacao)
    {
        $stSql = "SELECT ultimo_registro_evento_decimo.*                                                      
            , registro_evento_decimo.cod_contrato                                                  
         FROM folhapagamento.ultimo_registro_evento_decimo                                         
            , folhapagamento.registro_evento_decimo                                                
        WHERE ultimo_registro_evento_decimo.cod_registro = registro_evento_decimo.cod_registro     
          AND ultimo_registro_evento_decimo.cod_evento = registro_evento_decimo.cod_evento         
          AND ultimo_registro_evento_decimo.timestamp = registro_evento_decimo.timestamp
          AND cod_contrato = " . $codContrato . "
          AND cod_periodo_movimentacao = " . $codPeriodoMovimentacao . "
          ORDER BY ultimo_registro_evento_decimo.cod_registro
          ;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    public function montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade)
    {
        $queryc = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stEntidade','');");
        $queryc->execute();
        $querya = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stTipoFolha','D');");
        $querya->execute();
        $stSql = "SELECT deletarUltimoRegistroEvento(" . $codRegistro . "    \n";
        $stSql .= "                                  ," . $codEvento . "      \n";
        $stSql .= "                                 ,'" . $desdobramento . "'  \n";
        $stSql .= "                                 ,'" . $timestamp . "');    \n";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    public function montaDeletarUltimoRegistroEvento($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade)
    {
        $queryc = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stEntidade','');");
        $queryc->execute();
        $querya = $this->_em->getConnection()->prepare("SELECT criarBufferTexto('stTipoFolha','S');");
        $querya->execute();
        $stSql = "SELECT deletarUltimoRegistroEvento(" . $codRegistro . "    \n";
        $stSql .= "                                  ," . $codEvento . "      \n";
        $stSql .= "                                 ,'" . $desdobramento . "'  \n";
        $stSql .= "                                 ,'" . $timestamp . "');    \n";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    public function montaRecuperaRegistrosDeEventoSemCalculo($filtro = false)
    {
        $stSql = "SELECT ultimo_registro_evento_decimo.*                                                      \n";
        $stSql .= "     , registro_evento_decimo.cod_contrato                                                  \n";
        $stSql .= "  FROM folhapagamento.ultimo_registro_evento_decimo                                         \n";
        $stSql .= "     , folhapagamento.registro_evento_decimo                                                \n";
        $stSql .= " WHERE ultimo_registro_evento_decimo.cod_registro = registro_evento_decimo.cod_registro     \n";
        $stSql .= "   AND ultimo_registro_evento_decimo.cod_evento = registro_evento_decimo.cod_evento         \n";
        $stSql .= "   AND ultimo_registro_evento_decimo.timestamp = registro_evento_decimo.timestamp           \n";
        $stSql .= "   AND ultimo_registro_evento_decimo.cod_registro not in (SELECT cod_registro FROM folhapagamento.evento_decimo_calculado) \n";

        if (isset($filtro)) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }
}
