<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;

class ReciboExtraRepository extends ORM\EntityRepository
{
    public function getProximoTimestamp($exercicio, $codEntidade, $tipoRecibo)
    {
        /**
         * $tipoRecurso
         * R = Recibo de Receita Extra
         * D = Recibo de Despesa Extra
         */
        $sql = "
        SELECT max(re.TIMESTAMP) AS data
        FROM tesouraria.recibo_extra AS re
        LEFT JOIN tesouraria.recibo_extra_anulacao AS ra ON (
                re.cod_recibo_extra = ra.cod_recibo_extra
                AND re.exercicio = ra.exercicio
                AND re.cod_entidade = ra.cod_entidade
                AND re.tipo_recibo = ra.tipo_recibo
                )
        WHERE ra.cod_recibo_extra IS NULL
            AND re.exercicio = :exercicio
            AND re.tipo_recibo = :tipoRecibo
            AND re.cod_entidade = :codEntidade
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('tipoRecibo', $tipoRecibo);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        $retorno = $query->fetch();

        return $retorno['data'];
    }

    public function getCodContaBanco($exercicio, $codEntidade)
    {
        $sql = "
        SELECT pa.cod_plano
            ,pc.cod_estrutural
            ,pc.nom_conta
            ,pc.cod_conta
            ,publico.fn_mascarareduzida(pc.cod_estrutural) AS cod_reduzido
            ,pc.cod_classificacao
            ,pc.cod_sistema
            ,pb.exercicio
            ,pb.cod_banco
            ,pb.cod_agencia
            ,pb.cod_entidade
            ,pa.natureza_saldo
            ,CASE 
                WHEN publico.fn_nivel(cod_estrutural) > 4
                    THEN 5
                ELSE publico.fn_nivel(cod_estrutural)
                END AS nivel
        FROM contabilidade.plano_conta AS pc
        LEFT JOIN contabilidade.plano_analitica AS pa ON (
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                )
        LEFT JOIN contabilidade.plano_banco AS pb ON (
                pb.cod_plano = pa.cod_plano
                AND pb.exercicio = pa.exercicio
                )
        WHERE pa.cod_plano IS NOT NULL
            AND pc.exercicio = :exercicio
            AND (
                pb.cod_banco IS NOT NULL
                AND pb.cod_entidade IN (:codEntidade)
                AND (
                    pc.cod_estrutural LIKE '1.1.1.%'
                    OR pc.cod_estrutural LIKE '1.1.4.%'
                    )
                )
        ORDER BY cod_estrutural
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();

        return $query->fetchAll();
    }

    public function getCodContaReceira($exercicio)
    {
        $sql = "
        SELECT pa.cod_plano
            ,pc.cod_estrutural
            ,pc.nom_conta
            ,pc.cod_conta
            ,publico.fn_mascarareduzida(pc.cod_estrutural) AS cod_reduzido
            ,pc.cod_classificacao
            ,pc.cod_sistema
            ,pb.exercicio
            ,pb.cod_banco
            ,pb.cod_agencia
            ,pb.cod_entidade
            ,pa.natureza_saldo
            ,CASE 
                WHEN publico.fn_nivel(cod_estrutural) > 4
                    THEN 5
                ELSE publico.fn_nivel(cod_estrutural)
                END AS nivel
        FROM contabilidade.plano_conta AS pc
        LEFT JOIN contabilidade.plano_analitica AS pa ON (
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                )
        LEFT JOIN contabilidade.plano_banco AS pb ON (
                pb.cod_plano = pa.cod_plano
                AND pb.exercicio = pa.exercicio
                )
        WHERE pa.cod_plano IS NOT NULL
            AND pc.exercicio = :exercicio
            AND (
                pc.cod_estrutural LIKE '1.1.2.%'
                OR pc.cod_estrutural LIKE '1.1.3.%'
                OR pc.cod_estrutural LIKE '1.1.4.9%'
                OR pc.cod_estrutural LIKE '1.2.1.%'
                OR pc.cod_estrutural LIKE '2.1.1.%'
                OR pc.cod_estrutural LIKE '2.1.2.%'
                OR pc.cod_estrutural LIKE '2.1.8.%'
                OR pc.cod_estrutural LIKE '2.1.9.%'
                OR pc.cod_estrutural LIKE '2.2.1.%'
                OR pc.cod_estrutural LIKE '2.2.2.%'
                OR pc.cod_estrutural LIKE '3.5.%'
                )
        ORDER BY cod_estrutural
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();

        return $query->fetchAll();
    }

    public function getAssinaturas($exercicio, $codEntidade)
    {
        $sql = "
        select assinatura.exercicio
            ,assinatura.cod_entidade
            ,assinatura.numcgm
            ,sw_cgm.nom_cgm
            ,assinatura.timestamp
            ,assinatura.cargo
            ,assinatura_crc.insc_crc
        from administracao.assinatura
        join sw_cgm
            using (numcgm)
        left join administracao.assinatura_crc
            using (exercicio,cod_entidade,numcgm,timestamp)
        where assinatura.exercicio = :exercicio
            and assinatura.timestamp = (select max(timestamp) from administracao.assinatura where exercicio = :exercicio)
            and assinatura.cod_entidade in ( :codEntidade )
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();

        return $query->fetchAll();
    }

    public function findReciboExtra(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "select * from tesouraria.recibo_extra WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
