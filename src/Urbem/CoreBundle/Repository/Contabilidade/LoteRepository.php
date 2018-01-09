<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class LoteRepository extends ORM\EntityRepository
{
    /**
     * @param $exercicio
     * @return array|mixed
     */
    public function verificaImplantacaoSaldo($exercicio)
    {
        $sql = sprintf(
            "
            SELECT
                CASE
                    WHEN count( lo.exercicio ) > 0 THEN true
                    ELSE FALSE
                END AS retorno
            FROM
                contabilidade.lote AS lo
            WHERE
                lo.tipo = 'I'
                AND lo.exercicio = '%s'",
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        if ($result) {
            return array_shift($result);
        }
        return $result;
    }

    /**
     * @param $params
     * @return array
     */
    public function getLotes($params)
    {
        $sql = sprintf(
            "
            SELECT
                cod_lote,
                exercicio,
                tipo,
                cod_entidade,
                nom_lote,
                TO_CHAR(dt_lote, 'dd/mm/yyyy') as dt_lote
            FROM
                contabilidade.lote
            WHERE
                lote.cod_entidade = %d
                AND lote.exercicio = '%s'
                AND lote.dt_lote = '%s'
                AND lote.tipo = '%s'
                AND lote.nom_lote = '%s'",
            $params['codEntidade'],
            $params['exercicio'],
            $params['dtLote'],
            $params['tipo'],
            $params['nomLote']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codLote
     * @param $tipo
     */
    public function removeLancamento($exercicio, $codEntidade, $codLote, $tipo)
    {
        $sql = sprintf(
            "
            DELETE from contabilidade.conta_debito
            where exercicio  = '%s'
            and cod_entidade = %d
            and tipo = '%s'
            and cod_lote IN ( %d )
            ",
            $exercicio,
            $codEntidade,
            $tipo,
            $codLote
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $sql = sprintf(
            "
            DELETE from contabilidade.conta_credito
            where exercicio  = '%s'
            and cod_entidade = %d
            and tipo = '%s'
            and cod_lote IN ( %d )
            ",
            $exercicio,
            $codEntidade,
            $tipo,
            $codLote
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $sql = sprintf(
            "
            DELETE from contabilidade.valor_lancamento
            where exercicio  = '%s'
            and cod_entidade = %d
            and tipo = '%s'
            and cod_lote IN ( %d )
            ",
            $exercicio,
            $codEntidade,
            $tipo,
            $codLote
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $sql = sprintf(
            "
            DELETE  from contabilidade.lancamento
            where exercicio  = '%s'
            and cod_entidade = %d
            and tipo = '%s'
            and cod_lote IN ( %d )
            ",
            $exercicio,
            $codEntidade,
            $tipo,
            $codLote
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getLoteByExercicio($exercicio)
    {
        $sql =  " SELECT cod_lote, exercicio
                  FROM contabilidade.lote
                  WHERE lote.exercicio = :exercicio";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
