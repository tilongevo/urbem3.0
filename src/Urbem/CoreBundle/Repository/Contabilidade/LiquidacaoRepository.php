<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class LiquidacaoRepository extends ORM\EntityRepository
{
    public function empenhoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho)
    {
        $sql = sprintf(
            "SELECT EmpenhoLiquidacaoRestosAPagarTCEMS(
                '%s',
                '%s',
                '%s',
                %d,
                '%s',
                %d,
                %d,
                '%s'
            ) as sequencia",
            $exercicio,
            $valor,
            $complemento,
            $codLote,
            $tipoLote,
            $codEntidade,
            $codNota,
            $exercicioEmpenho
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function empenhoAnulacaoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho)
    {
        $sql = sprintf(
            "SELECT EmpenhoAnulacaoLiquidacaoRestosAPagarTCEMS(
                '%s',
                '%s',
                '%s',
                %d,
                '%s',
                %d,
                %d,
                '%s',
                '%s'
            ) as sequencia",
            $exercicio,
            $valor,
            $complemento,
            $codLote,
            $tipoLote,
            $codEntidade,
            $codNota,
            $exercicioEmpenho,
            date('Y')
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }
}
