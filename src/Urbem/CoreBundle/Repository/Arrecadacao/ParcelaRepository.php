<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ParcelaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getCodParcela()
    {
        return $this->nextVal('cod_parcela');
    }

    /**
     * @param $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getFnPeriodicoArrecadacaoSintetico($params)
    {
        $sql = "SELECT * FROM ARRECADACAO.FN_RL_PERIODICO_ARRECADACAO(";

        $sql .= sprintf("'%s', ", strtoupper($params['tipoRelatorio']));
        $sql .= sprintf("'%s', ", $params['dtInicio']);
        $sql .= sprintf("'%s', ", $params['dtFinal']);
        $sql .= sprintf("'%s', ", $params['creditoInicial']);
        $sql .= sprintf("'%s', ", $params['creditoFinal']);
        $sql .= sprintf("'%s', ", $params['grupoCreditoInicial']);
        $sql .= sprintf("'%s', ", $params['grupoCreditoFinal']);

        if ($params['inscricaoImobiliariaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoImobiliariaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoImobiliariaFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoImobiliariaFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoEconomicaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoEconomicaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoEconomicaFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoEconomicaFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['contribuinteInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['contribuinteInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['contribuinteFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['contribuinteFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['atividadeEconomicaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['atividadeEconomicaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['atividadeEconomicaFinal'] != '') {
            $sql .= sprintf("'%s'", $params['atividadeEconomicaFinal']);
        } else {
            $sql .= 'null';
        }

        $sql .= ") AS (
                    cod_grupo integer,
                    descricao varchar,
                    lancado numeric,
                    pago numeric,
                    aberto_vencido numeric,
                    aberto_a_vencer numeric
                )";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $params
     * @return array
     */
    public function getFnPeriodicoArrecadacaoAnalitico($params)
    {
        $sql = "SELECT * FROM ARRECADACAO.FN_RL_PERIODICO_ARRECADACAO(";

        $sql .= sprintf("'%s', ", strtoupper($params['tipoRelatorio']));
        $sql .= sprintf("'%s', ", $params['dtInicio']);
        $sql .= sprintf("'%s', ", $params['dtFinal']);
        $sql .= sprintf("'%s', ", $params['creditoInicial']);
        $sql .= sprintf("'%s', ", $params['creditoFinal']);
        $sql .= sprintf("'%s', ", $params['grupoCreditoInicial']);
        $sql .= sprintf("'%s', ", $params['grupoCreditoFinal']);

        if ($params['inscricaoImobiliariaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoImobiliariaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoImobiliariaFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoImobiliariaFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoEconomicaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoEconomicaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['inscricaoEconomicaFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['inscricaoEconomicaFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['contribuinteInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['contribuinteInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['contribuinteFinal'] != '') {
            $sql .= sprintf("'%s', ", $params['contribuinteFinal']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['atividadeEconomicaInicial'] != '') {
            $sql .= sprintf("'%s', ", $params['atividadeEconomicaInicial']);
        } else {
            $sql .= 'null, ';
        }

        if ($params['atividadeEconomicaFinal'] != '') {
            $sql .= sprintf("'%s'", $params['atividadeEconomicaFinal']);
        } else {
            $sql .= 'null';
        }

        $sql .= ") AS (
                cod                     integer
                ,descricao              character varying
                ,cgm                    text
                ,lancado                numeric
                ,pago                   numeric
                ,aberto_vencido         numeric
                ,aberto_a_vencer        numeric
            );";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
