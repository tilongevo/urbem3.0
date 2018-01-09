<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EventoCalculadoRepository extends ORM\EntityRepository
{
    /**
     * @param $filtro
     * @param null $ordem
     * @return array
     */
    public function montaRecuperaEventosCalculados($filtro, $ordem = null)
    {
        $sql = "SELECT registro_evento_parcela.parcela as quantidade_parc                                      
             , evento_calculado.valor                                                                   
             , evento_calculado.quantidade                                                              
             , evento_calculado.cod_registro                                                            
             , ( CASE WHEN evento_calculado.desdobramento IS NOT NULL                                   
                         THEN evento.descricao ||' '|| getDesdobramentoSalario(evento_calculado.desdobramento,'') 
                         ELSE evento.descricao                                                          
               END ) as descricao                                                                       
             , evento.descricao as nom_evento                                                           
             , evento.cod_evento                                                                        
             , evento.codigo                                                                            
             , evento.natureza                                                                          
             , evento.apresentar_contracheque                                                           
             , evento_calculado.desdobramento                                                           
             , getDesdobramentoSalario(evento_calculado.desdobramento,'') as desdobramento_texto           
          FROM folhapagamento.ultimo_registro_evento                                                    
           INNER JOIN folhapagamento.registro_evento                                                    
                 ON ultimo_registro_evento.cod_evento = registro_evento.cod_evento                      
                AND ultimo_registro_evento.cod_registro = registro_evento.cod_registro                  
                AND ultimo_registro_evento.timestamp = registro_evento.timestamp                        
         INNER JOIN folhapagamento.registro_evento_periodo                                              
                 ON registro_evento.cod_registro = registro_evento_periodo.cod_registro                 
         INNER JOIN folhapagamento.evento_calculado                                                     
                 ON ultimo_registro_evento.cod_evento = evento_calculado.cod_evento                     
                AND ultimo_registro_evento.cod_registro = evento_calculado.cod_registro                 
                AND ultimo_registro_evento.timestamp = evento_calculado.timestamp_registro              
          LEFT JOIN folhapagamento.registro_evento_parcela                                              
                 ON ultimo_registro_evento.cod_evento = registro_evento_parcela.cod_evento              
                AND ultimo_registro_evento.cod_registro = registro_evento_parcela.cod_registro          
                AND ultimo_registro_evento.timestamp = registro_evento_parcela.timestamp                
         INNER JOIN folhapagamento.evento                                                               
                 ON evento_calculado.cod_evento = evento.cod_evento                                     
         WHERE 1=1";

        if ($filtro) {
            $sql .= $filtro;
        }

        $sql .= $ordem ? " ORDER BY ".$ordem : " ORDER BY descricao ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $codConfiguracao
     * @param $codPeriodoMovimentacao
     * @param $codContrato
     * @param $codComplementar
     * @param $entidade
     * @param $ordem
     *
     * @return array
     */
    public function recuperarEventosCalculadosFichaFinanceira($codConfiguracao, $codPeriodoMovimentacao, $codContrato, $codComplementar, $entidade, $ordem)
    {
        $sql = "
          SELECT evento_calculado.*                                                                       
	         , CASE WHEN evento_calculado.apresenta_parcela = TRUE 
	         THEN (evento_calculado.quantidade::INTEGER)::VARCHAR 	               
	         ELSE REPLACE((evento_calculado.quantidade::NUMERIC)::VARCHAR, '.', ',') END AS quantidade_parcelas        
	         FROM recuperarEventosCalculados($codConfiguracao,$codPeriodoMovimentacao,$codContrato,$codComplementar,'{$entidade}','{$ordem}') as evento_calculado; 
        ";

        $query = $this->_em->getConnection()->prepare($sql);
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
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculo(
    " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    ) order by codigo";

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
        $stSql = "select recuperaRotuloValoresAcumuladosCalculo(
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
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select * from recuperaValoresAcumuladosCalculoSalarioFamilia(
    " . $codContrato . ",
    " . $codPeriodoMovimentacao . ",
    " . $numCgm . ",
    '" . $natureza . "',
    '" . $entidade . "'
    ) order by codigo";

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
    public function montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        $stSql = "select recuperaRotuloValoresAcumuladosCalculoSalarioFamilia(
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
     * @param $params
     * @param $exercicio
     *
     * @return array
     */
    public function recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtro)
    {
        $stSqlDesdobramento = "";
        if ($params["stDesdobramento"] != "") {
            $stSqlDesdobramento = "\n AND desdobramento = '" . $params["stDesdobramento"] . "'";
        }

        $stSql = "\n SELECT *";
        $stSql .= "\n   FROM (";
        $stSql .= "\n SELECT servidor_pensionista.* ";
        $stSql .= "\n      , eventos_calculados.proventos ";
        $stSql .= "\n      , eventos_calculados.descontos ";

        if ($params['nuPercentualPagar'] != "") {
            $stSql .= "\n      , CASE WHEN eventos_calculados.proventos - eventos_calculados.descontos > 0 THEN ";
            $stSql .= "\n                  ((eventos_calculados.proventos - eventos_calculados.descontos) * " . $params['nuPercentualPagar'] . ") / 100 ";
            $stSql .= "\n             ELSE ";
            $stSql .= "\n                  0 ";
            $stSql .= "\n        END as liquido";
        } else {
            $stSql .= "\n      , (eventos_calculados.proventos - eventos_calculados.descontos) as liquido ";
        }

        $stSql .= "\n   FROM ( ";

        if ($params["stSituacao"] != "'pensionistas") {
            $stSql .= "\n          SELECT 'S' as tipo_cadastro ";
            $stSql .= "\n               , servidor.cod_contrato ";
            $stSql .= "\n               , servidor.nom_cgm ";
            $stSql .= "\n               , servidor.cpf ";
            $stSql .= "\n               , servidor.registro ";
            $stSql .= "\n               , servidor.nr_conta_salario as nr_conta ";
            $stSql .= "\n               , servidor.num_banco_salario as num_banco ";
            $stSql .= "\n               , servidor.cod_banco_salario as cod_banco";
            $stSql .= "\n               , servidor.num_agencia_salario as num_agencia";
            $stSql .= "\n               , servidor.cod_orgao ";
            $stSql .= "\n               , servidor.cod_local ";
            $stSql .= "\n               , servidor.desc_cargo as descricao_cargo ";
            $stSql .= "\n               , servidor.desc_funcao as descricao_funcao ";
            $stSql .= "\n            FROM recuperarContratoServidor('cgm,cs,o,l,f,ca',''," . $params["inCodPeriodoMovimentacao"] . ",'" . $params["stTipoFiltro"] . "','" . $params["stValoresFiltro"] . "','" . $exercicio . "') as servidor ";
            $stSql .= "\n           WHERE servidor.nr_conta_salario IS NOT NULL";//adicionado esse parametro para filtrar os servidores que recebam por crédito em conta
            $stSql .= "\n             AND servidor.num_banco_salario IS NOT NULL ";
            $stSql .= "\n             AND servidor.cod_banco_salario IS NOT NULL";
            $stSql .= "\n             AND servidor.num_agencia_salario IS NOT NULL";
        }

        if ($params["stSituacao"] == "pensionistas" || $params["stSituacao"] == "todos") {
            if ($params["stSituacao"] == "todos") {
                $stSql .= "\n  UNION ";
            }
            $stSql .= "\n          SELECT 'P' as tipo_cadastro ";
            $stSql .= "\n               , pensionista.cod_contrato ";
            $stSql .= "\n               , pensionista.nom_cgm ";
            $stSql .= "\n               , pensionista.cpf ";
            $stSql .= "\n               , pensionista.registro ";
            $stSql .= "\n               , pensionista.nr_conta_salario as nr_conta";
            $stSql .= "\n               , pensionista.num_banco_salario as num_banco";
            $stSql .= "\n               , pensionista.cod_banco_salario as cod_banco";
            $stSql .= "\n               , pensionista.num_agencia_salario as num_agencia";
            $stSql .= "\n               , pensionista.cod_orgao";
            $stSql .= "\n               , pensionista.cod_local ";
            $stSql .= "\n               , null as descricao_cargo ";
            $stSql .= "\n               , null as descricao_funcao ";
            $stSql .= "\n            FROM recuperarContratoPensionista('cgm,cs,o,l',''," . $params["inCodPeriodoMovimentacao"] . ",'" . $params["stTipoFiltro"] . "','" . $params["stValoresFiltro"] . "','" . $exercicio . "') as pensionista ";
        }

        $stSql .= "\n     ) as servidor_pensionista ";

        $stSql .= "\nINNER JOIN (   SELECT cod_contrato ";
        $stSql .= "\n                    , coalesce(sum(proventos),0) as proventos";
        $stSql .= "\n                    , coalesce(sum(descontos),0) as descontos";
        $stSql .= "\n                 FROM (";
        $stSql .= "\n                           SELECT cod_contrato";
        $stSql .= "\n                                , sum(valor) as proventos";
        $stSql .= "\n                                , 0 as descontos";
        $stSql .= "\n                             FROM recuperarEventosCalculados(" . $params["inCodConfiguracao"] . "," . $params["inCodPeriodoMovimentacao"] . ",0," . $params["inCodComplementar"] . ",'', 'evento.descricao') as eventos_proventos";
        $stSql .= "\n                            WHERE ";

        if (isset($params['arEventosProventos']) && (is_array($params['arEventosProventos']))) {
            $stSql .= " eventos_proventos.cod_evento IN (" . implode(",", $params['arEventosProventos']) . ") ";
        } else {
            $stSql .= " eventos_proventos.natureza = 'P' ";
        }

        $stSql .= "\n                              " . $stSqlDesdobramento;
        $stSql .= "\n                         GROUP BY eventos_proventos.cod_contrato";
        $stSql .= "\n                            UNION ";
        $stSql .= "\n                           SELECT cod_contrato";
        $stSql .= "\n                                , 0 as proventos";
        $stSql .= "\n                                , sum(valor) as descontos";
        $stSql .= "\n                             FROM recuperarEventosCalculados(" . $params["inCodConfiguracao"] . "," . $params["inCodPeriodoMovimentacao"] . ",0," . $params["inCodComplementar"] . ",'', 'evento.descricao') as eventos_descontos";
        $stSql .= "\n                            WHERE ";

        if (isset($params['arEventosProventos']) && (is_array($params['arEventosDescontos']))) {
            $stSql .= " eventos_descontos.cod_evento IN (" . implode(",", $params['arEventosDescontos']) . ") ";
        } else {
            $stSql .= " eventos_descontos.natureza = 'D' ";
        }

        $stSql .= "\n                              " . $stSqlDesdobramento;
        $stSql .= "\n                         GROUP BY eventos_descontos.cod_contrato";
        $stSql .= "\n                        ) as eventos_calculados_proventos_descontos_contrato";
        $stSql .= "\n               GROUP BY cod_contrato";
        $stSql .= "\n             ) as eventos_calculados";
        $stSql .= "\n          ON servidor_pensionista.cod_contrato = eventos_calculados.cod_contrato";
        $stSql .= "\n ) as remessa ";

        $stSqlFiltro = "";

        switch ($params["stSituacao"]) {
            case "ativos":
                $stSqlFiltro .= "AND recuperarSituacaoDoContrato(remessa.cod_contrato, " . $params["inCodPeriodoMovimentacao"] . ", '') = 'A'";
                break;
            case "aposentados":
                $stSqlFiltro .= "AND recuperarSituacaoDoContrato(remessa.cod_contrato, " . $params["inCodPeriodoMovimentacao"] . ", '') = 'P'";
                break;
            case "rescindidos":
                $stSqlFiltro .= "AND recuperarSituacaoDoContrato(remessa.cod_contrato, " . $params["inCodPeriodoMovimentacao"] . ", '') = 'R'";
                break;
            case "pensionistas":
                $stSqlFiltro .= "AND recuperarSituacaoDoContrato(remessa.cod_contrato, " . $params["inCodPeriodoMovimentacao"] . ", '') = 'E'";
                break;
            case "todos":
                $stSqlFiltro .= "AND recuperarSituacaoDoContrato(remessa.cod_contrato, " . $params["inCodPeriodoMovimentacao"] . ", '') IN('A','P','R','E')";
                break;
        }

        if ($params['inCodBanco'] != "'") {
            //Se for passado apenas um ID executa id, senão executa else onde os id's são inseridos dentro do IN
            if (is_numeric($params['inCodBanco'])) {
                $stSqlFiltro .= " AND remessa.cod_banco = " . $params['inCodBanco'];
            } else {
                $stSqlFiltro .= " AND remessa.cod_banco IN (" . $params['inCodBanco'] . ")'";
            }
        }

        if ($params['nuLiquidoMinimo'] != "" && $params['nuLiquidoMaximo'] != "") {
            $stSqlFiltro .= " AND (remessa.proventos - remessa.descontos) BETWEEN " . $params['nuLiquidoMinimo'] . " AND " . $params['nuLiquidoMaximo'];
        }

        $stSqlFiltro .= " AND remessa.liquido > 0 ";

        $stSql .= " WHERE " . substr($stSqlFiltro, 4);

        if ($filtro) {
            $stSql .= $filtro;
        }
        $stSql .= " ORDER BY nom_cgm;";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
