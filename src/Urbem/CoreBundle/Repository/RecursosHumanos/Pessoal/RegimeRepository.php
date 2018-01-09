<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class RegimeRepository extends ORM\EntityRepository
{
    public function getListaRegimeSubdivisaoFuncaoEspecialidade()
    {
        $sql = "
            SELECT
                 pr.descricao as nom_regime,
                 pr.cod_regime,
                 psd.descricao as nom_sub_divisao,
                 psd.cod_sub_divisao,
                 psd.cod_regime,
                 c.descricao as descricao_cargo,
                 e.descricao as descricao_especialidade,
                 c.cod_cargo
             FROM
                pessoal.regime as pr,
                pessoal.sub_divisao as psd,
                pessoal.cargo_sub_divisao as csd,
                pessoal.especialidade_sub_divisao as esd,
                pessoal.cargo as c
             left join
                pessoal.especialidade as e on  e.cod_cargo = c.cod_cargo
             WHERE
                 pr.cod_regime = psd.cod_regime
             and csd.cod_sub_divisao = psd.cod_sub_divisao
             and esd.cod_sub_divisao = psd.cod_sub_divisao
             and c.cod_cargo = csd.cod_cargo
             AND psd.cod_regime IN (1,2) group by c.cod_cargo, pr.descricao,  pr.cod_regime,
                 psd.descricao,
                 psd.cod_sub_divisao,
                 psd.cod_regime,
                 c.descricao,
                 e.descricao order by nom_regime, nom_sub_divisao, descricao_cargo, descricao_especialidade;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $res = $query->fetchAll(\PDO::FETCH_OBJ);

        $regimes = array();
        foreach($res as $res_key => $regime) {
            $regimes[$regime->nom_regime. " - " . $regime->nom_sub_divisao. " - ". $regime->descricao_cargo] = $regime->cod_cargo;
        }

        return $regimes;
    }

    /**
     * @return array
     */
    public function getRegimeSubdivisao()
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r.descricao as nomRegime', 'r.codRegime', 's.descricao as nomSubDivisao', 's.codSubDivisao', 's.codRegime')
            ->join('Urbem\CoreBundle\Entity\Pessoal\SubDivisao', 's', 'WITH', 'r.codRegime = s.codRegime')
            ->orderBy('s.descricao');

        return $qb->getQuery()->getResult();
    }
}