<?php

namespace Urbem\CoreBundle\Helper;

class ReportHelper
{
    /**
     * @param $params
     * @param $gettMethod
     * @return bool|string
     */
    public static function getValoresComVirgula($params, $gettMethod)
    {
        $valores = '';
        if (sizeof($params) <= 0 || $params == '') {
            return 'null';
        }

        foreach ($params as $param) {
            if ($param && is_object($param)) {
                $getterMethod = sprintf('get%s', ucfirst($gettMethod));
                $valores .= $param->$getterMethod().', ';
            } elseif ($param) {
                $valores .= $param.', ';
            }
        }
        $valores = substr($valores, 0, -2);

        return $valores;
    }

    /**
     * @param $entities
     * @return array
     */
    public static function getPoderAndNomeEntidade($entities)
    {
        $nome= (String) $entities[0];
        $poder = '';

        if (sizeof($entities) == 1) {
            if (preg_match("/prefeitura.*/i", $nome)) {
                $poder = 'Executivo';
            } else {
                $poder = 'Legislativo';
            }
        } else {
            foreach ($entities as $e) {
                if (preg_match("/prefeitura.*/i", (String) $e)) {
                    $nome = (String) $e;
                    $poder = 'Executivo';
                }
            }
        }

        $params = array();
        $params['nom_entidade'] = substr($nome, 4);
        $params['poder'] = $poder;

        return $params;
    }

    /**
     * @param $valores
     * @return array
     */
    public static function getAssinaturaParams($valores)
    {
        $params = array();
        $params['numero_assinatura'] = sizeof($valores);
        $params['codEntidade'] = '';
        $params['numcgm'] = '';
        $params['timestamp'] = '';

        foreach ($valores as $v) {
            $itens = explode("|", $v);
            $params['codEntidade'] .= $itens[0].',';
            $params['numcgm'] .= $itens[1].',';
            $params['timestamp'] .= "'".$itens[2]."',";
        }

        $params['codEntidade'] = substr($params['codEntidade'], 0, -1);
        $params['numcgm'] = substr($params['numcgm'], 0, -1);
        $params['timestamp'] = substr($params['timestamp'], 0, -1);

        return $params;
    }

    /**
     * @param $entities
     * @return string
     */
    public static function getCodEntidades($entities)
    {
        $cod_Entidades = '';
        foreach ($entities as $entity) {
            $cod_Entidades .= $entity->getCodEntidade().',';
        }

        $cod_Entidades = substr($cod_Entidades, 0, -1);

        return $cod_Entidades;
    }

    /**
     * @param $entities
     * @return string
     */
    public static function getEntidadesDescricao($entities)
    {
        $descricao = '';
        foreach ($entities as $entity) {
            $entity = substr($entity, 4);
            $descricao .= $entity.' ';
        }
        $descricao = substr($descricao, 0, -1);

        return $descricao;
    }

    /**
     * @return array
     * Método responsável por selecionar o formato de data para os parametros
     * de acordo com a seleção do campo periodicidade
     */
    public static function getValoresPeriodicidade($periodicidade, $periodos, $exercicio, $periodoSoNoMes)
    {
        // Periodicidade = dia
        if ($periodicidade == 0) {
            $data = $periodos[0];
            $periodoSoNoMes ?
                $periodo = null :
                $periodo = ReportHelper::getMesEmPortugues($data->format('m'));
            // Se o mês for Janeiro, não mostrar mês anterior.
            if ($data->format('m') == 1) {
                // Se a data for 01/01/exercicio, não imprime o dia anterior
                if ($data->format('d/m') == '01/01') {
                    $dataFinalAnterior = '01/01/'.$exercicio;
                } else {
                    $dataFinalAnterior = date('d/m/Y', strtotime('-1 day', strtotime($data->format('Y-m-d'))));
                }
            } else {
                $dataFinalAnterior = date('d/m/Y', strtotime('-1 day', strtotime($data->format('Y-m-d'))));
            }

                $valores = array(
                    "periodo" => $periodo,

                    "data_inicial" => $data->format('d/m/Y'),
                    "data_final" => $data->format('d/m/Y'),

                    "data_inicial_nota" => $data->format('Y-m-d'),
                    "data_final_nota" => $data->format('Y-m-d'),

                    "data_inicial_anterior" => '01/01/'.$exercicio,
                    "data_final_anterior" => $dataFinalAnterior
                );

            return $valores;
        }

        // Periodicidade = mês
        if ($periodicidade == 1) {
            $numeroMes = $periodos[1] ;

            $dataInicio = new \DateTime("first day of this month");
            $dataInicio = $dataInicio->setDate($exercicio, $numeroMes, 1);

            $dataFinal = new \DateTime("last day of this month");
            $dataFinal = $dataFinal->setDate($exercicio, $numeroMes, 30);

            $valores = array(
                "periodo" => ReportHelper::getMesEmPortugues($numeroMes),

                "data_inicial" => $dataInicio->format('d/m/Y'),
                "data_final" => $dataFinal->format('d/m/Y'),

                "data_inicial_nota" => $dataInicio->format('Y-m-d'),
                "data_final_nota" => $dataFinal->format('Y-m-d'),
            );

            // Se o mês for Janeiro, não mostrar mês anterior.
            if ($numeroMes == 1) {
                $dataInicioAnterior = $dataInicio->setDate($exercicio, 1, 1);
                $dataFinalAnterior = $dataInicio->setDate($exercicio, 1, 1);
            } else {
                $dataInicioAnterior = $dataInicio->setDate($exercicio, 1, 1);
                $dataFinalAnterior = $dataFinal->setDate($exercicio, $numeroMes -1, 30);
            }

            $valores['data_inicial_anterior'] = $dataInicioAnterior->format('d/m/Y');
            $valores['data_final_anterior'] = $dataFinalAnterior->format('d/m/Y');

            return $valores;
        }

        // Periodicidade = ano
        if ($periodicidade == 2) {
            $valores = array(

                "periodo" => 'JANEIRO A DEZEMBRO',
                "data_inicial" => '01/01/'.$exercicio,
                "data_final" => '31/12/'.$exercicio,

                "data_inicial_nota" => $exercicio.'-01-01',
                "data_final_nota" => $exercicio.'-12-31',

                "data_inicial_anterior" => '01/01/'.$exercicio,
                "data_final_anterior" => '01/01/'.$exercicio
            );

            return $valores;
        }

        // Periodicidade = intervalo
        if ($periodicidade == 3) {
            $data_ini = $periodos[3];
            $data_fim = $periodos[4];

            $periodoSoNoMes ?
                $periodo = null :
                $periodo = ReportHelper::getMesEmPortugues($data_fim->format('m'));
            // Se o mês for Janeiro, não mostrar mês anterior.
            if ($data_ini->format('m') == 1) {
                // Se a data for 01/01/exercicio, não imprime o dia anterior
                if ($data_ini->format('d/m') == '01/01') {
                    $dataFinalAnterior = '01/01/'.$exercicio;
                } else {
                    $dataFinalAnterior = date('d/m/Y', strtotime('-1 day', strtotime($data_ini->format('Y-m-d'))));
                }
            } else {
                $dataFinalAnterior = date('d/m/Y', strtotime('-1 day', strtotime($data_ini->format('Y-m-d'))));
            }

            $valores = array(
                "periodo" => $periodo,

                "data_inicial" => $data_ini->format('d/m/Y'),
                "data_final" => $data_fim->format('d/m/Y'),

                "data_inicial_nota" => $data_ini->format('Y-m-d'),
                "data_final_nota" => $data_fim->format('Y-m-d'),

                "data_inicial_anterior" => '01/01/'.$exercicio,
                "data_final_anterior" => $dataFinalAnterior
            );

            return $valores;
        }
    }

    /**
     * @param $numeroMes
     * @return string
     */
    public static function getMesEmPortugues($numeroMes)
    {
        switch ($numeroMes) {
            case "1":
                $mes = "JANEIRO";
                break;
            case "2":
                $mes = "FEVEREIRO";
                break;
            case "3":
                $mes = "MARÇO";
                break;
            case "4":
                $mes = "ABRIL";
                break;
            case "5":
                $mes = "MAIO";
                break;
            case "6":
                $mes = "JUNHO";
                break;
            case "7":
                $mes = "JULHO";
                break;
            case "8":
                $mes = "AGOSTO";
                break;
            case "9":
                $mes = "SETEMBRO";
                break;
            case "10":
                $mes = "OUTUBRO";
                break;
            case "11":
                $mes = "NOVEMBRO";
                break;
            case "12":
                $mes = "DEZEMBRO";
                break;
            default:
                $mes =  null;
                break;
        }

        return $mes;
    }

    /**
     * @param $cod_reduzido_inicial
     * @param $cod_reduzido_final
     * @return null|string
     */
    public static function getFiltroValidado($cod_reduzido_inicial, $cod_reduzido_final)
    {
        $filtro_ini = $cod_reduzido_inicial ? 'AND pa.cod_plano >= '.$cod_reduzido_inicial : '';
        $filtro_fim = $cod_reduzido_final ? 'AND pa.cod_plano <= '.$cod_reduzido_final : '';
        $filtro = $filtro_ini .' '. $filtro_fim;

        if ($filtro != ' ') {
            return $filtro;
        } else {
            return null;
        }
    }
}
