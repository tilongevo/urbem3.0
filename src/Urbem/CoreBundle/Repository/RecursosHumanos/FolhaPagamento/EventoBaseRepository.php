<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class EventoBaseRepository extends AbstractRepository
{
    /**
     * @param $codEventos
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @return object
     */
    public function recuperaEventoBaseDesdobramento($eventos, $codContrato, $codPeriodoMovimentacao, $cod_configuracao_base = null)
    {
        $codEventos = '';
        foreach ($eventos as $evento) {
            $codEventos .= $evento['cod_evento'].',';
        }
        $codEventos = substr($codEventos, 0, strlen($codEventos)-1);

        $sql = "SELECT evento_base.cod_evento                                                               \n";
        $sql .= "     , evento_base.cod_evento_base                                                          \n";
        $sql .= "     , evento_base.cod_caso                                                                 \n";
        $sql .= "     , evento_base.cod_configuracao                                                         \n";
        $sql .= "     , TO_CHAR(evento_base.timestamp,'yyyy-mm-dd hh24:mi:ss.us') AS timestamp               \n";
        $sql .= "     , evento_base.cod_caso_base                                                            \n";
        $sql .= "     , evento_base.cod_configuracao_base                                                    \n";
        $sql .= "     , TO_CHAR(evento_base.timestamp_base,'yyyy-mm-dd hh24:mi:ss.us') AS timestamp_base     \n";
        $sql .= "     , trim(evento.descricao) as descricao_base                                             \n";
        $sql .= "     , (evento.codigo) as codigo_base                                                       \n";
        $sql .= "     , getDesdobramentoFerias(registro_evento_ferias.desdobramento,' ') as desdobramento_texto  \n";
        $sql .= "  FROM folhapagamento.evento_base                                                           \n";
        $sql .= "     ,(  SELECT cod_evento_base                                                             \n";
        $sql .= "              , cod_evento                                                                  \n";
        $sql .= "              , cod_configuracao_base                                                       \n";
        $sql .= "              , cod_configuracao                                                            \n";
        $sql .= "              , max(timestamp_base) as timestamp_base                                       \n";
        $sql .= "              , max(timestamp) as timestamp                                                 \n";
        $sql .= "           FROM folhapagamento.evento_base                                                  \n";

        if (!is_null($cod_configuracao_base)) {
            $sql .= " WHERE cod_configuracao_base = ".$cod_configuracao_base."         \n";
        }

        $sql .= "       GROUP BY cod_evento_base                                                             \n";
        $sql .= "              , cod_evento                                                                  \n";
        $sql .= "              , cod_configuracao_base                                                       \n";
        $sql .= "              , cod_configuracao                                                            \n";
        $sql .= "       ORDER BY cod_evento_base) as max_evento_base                                         \n";
        $sql .= "     , folhapagamento.evento                                                                \n";
        $sql .= "     , folhapagamento.registro_evento_ferias                                                \n";
        $sql .= "     , folhapagamento.ultimo_registro_evento_ferias                                         \n";
        $sql .= " WHERE evento_base.cod_evento_base = max_evento_base.cod_evento_base                        \n";
        $sql .= "   AND evento_base.timestamp_base  = max_evento_base.timestamp_base                         \n";
        $sql .= "   AND evento_base.cod_evento = max_evento_base.cod_evento                                  \n";
        $sql .= "   AND evento_base.timestamp  = max_evento_base.timestamp                                   \n";
        $sql .= "   AND evento_base.cod_configuracao_base = max_evento_base.cod_configuracao_base            \n";
        $sql .= "   AND evento_base.cod_configuracao      = max_evento_base.cod_configuracao                 \n";
        $sql .= "   AND evento_base.cod_evento_base       = evento.cod_evento                                \n";
        $sql .= "   AND registro_evento_ferias.cod_evento    = ultimo_registro_evento_ferias.cod_evento      \n";
        $sql .= "   AND registro_evento_ferias.cod_registro  = ultimo_registro_evento_ferias.cod_registro    \n";
        $sql .= "   AND registro_evento_ferias.timestamp     = ultimo_registro_evento_ferias.timestamp       \n";
        $sql .= "   AND registro_evento_ferias.desdobramento = ultimo_registro_evento_ferias.desdobramento   \n";
        $sql .= "   AND registro_evento_ferias.cod_evento = evento.cod_evento                                \n";
        $sql .= " AND evento_base.cod_evento IN ($codEventos)";
        $sql .= " AND evento_base.cod_configuracao = 2";
        $sql .= " AND registro_evento_ferias.cod_contrato = $codContrato";
        $sql .= " AND registro_evento_ferias.cod_periodo_movimentacao = $codPeriodoMovimentacao";
        $sql .= " ORDER BY cod_evento_base ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
