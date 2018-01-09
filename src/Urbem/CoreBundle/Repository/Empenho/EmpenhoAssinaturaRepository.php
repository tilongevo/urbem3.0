<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class EmpenhoAssinaturaRepository extends AbstractRepository
{
    public function getProximoNumAssinatura($exercicio)
    {
        return $this->nextVal(
            'num_assinatura',
            array(
                'exercicio' => $exercicio
            )
        );
    }
    
    public function getCgmAssinatura($exercicio, $codEntidade)
    {
        $sql = "
        SELECT
            assinatura.exercicio,
            assinatura.cod_entidade,
            assinatura.numcgm,
            sw_cgm.nom_cgm,
            assinatura.timestamp,
            assinatura.cargo,
            assinatura_crc.insc_crc
        FROM
            administracao.assinatura
            JOIN sw_cgm
            USING (
                numcgm )
            LEFT JOIN administracao.assinatura_crc
            USING (
                exercicio,
                cod_entidade,
                numcgm,
                timestamp )
        WHERE
            assinatura.exercicio = :exercicio
            AND assinatura.timestamp = (
                SELECT
                    max (
                        timestamp )
                FROM
                    administracao.assinatura
                WHERE
                    exercicio = :exercicio )
            AND assinatura.cod_entidade = :cod_entidade
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function getCgmAssinaturaPorCgm($exercicio, $codEntidade, $numcgm)
    {
        $sql = "
        SELECT
            assinatura.exercicio,
            assinatura.cod_entidade,
            assinatura.numcgm,
            sw_cgm.nom_cgm,
            assinatura.timestamp,
            assinatura.cargo,
            assinatura_crc.insc_crc
        FROM
            administracao.assinatura
            JOIN sw_cgm
            USING (
                numcgm )
            LEFT JOIN administracao.assinatura_crc
            USING (
                exercicio,
                cod_entidade,
                numcgm,
                timestamp )
        WHERE
            assinatura.exercicio = :exercicio
            AND assinatura.timestamp = (
                SELECT
                    max (
                        timestamp )
                FROM
                    administracao.assinatura
                WHERE
                    exercicio = :exercicio )
            AND assinatura.cod_entidade = :cod_entidade
            AND sw_cgm.numcgm = :numcgm
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->bindValue('numcgm', $numcgm, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getAssinaturasPorEmpenho(
        $exercicio,
        $codEntidade,
        $codEmpenho
    ) {
        $sql = "
        SELECT
            eea.exercicio,
            eea.cod_entidade,
            eea.cod_empenho,
            eea.num_assinatura,
            scgm.numcgm,
            scgm.nom_cgm,
            eea.cargo
        FROM
            empenho.empenho_assinatura AS eea
            JOIN sw_cgm AS scgm
            USING (
                numcgm )
        WHERE
            eea.exercicio = :exercicio
            AND eea.cod_entidade = :cod_entidade
            AND eea.cod_empenho = :cod_empenho
        ORDER BY
            num_assinatura
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue('cod_empenho', $codEmpenho, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
