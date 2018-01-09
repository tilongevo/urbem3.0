<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;

class EspecialidadeSubDivisaoRepository extends ORM\EntityRepository
{
    public function getEspecialidadeSubDivisaoPorTimestamp($info, $codEspecialidade)
    {
        $sql = "
        SELECT
            especialidade_sub_divisao.cod_especialidade, 
            especialidade_sub_divisao.cod_sub_divisao, 
            especialidade_sub_divisao.nro_vaga_criada,
            sub_divisao.cod_regime
        FROM
            pessoal.especialidade_sub_divisao
        INNER JOIN 
            pessoal.sub_divisao on sub_divisao.cod_sub_divisao = especialidade_sub_divisao.cod_sub_divisao
        WHERE 
            cod_especialidade = ". $codEspecialidade ."
        AND
            date_trunc('second', \"timestamp\") = '". $info->format('Y-m-d H:i:s') ."'
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getVagasOcupadasEspecialidade($codRegime, $codSubDivisao, $codEspecialidade)
    {
        $sql = "
            SELECT getVagasOcupadasEspecialidade($codRegime, $codSubDivisao, $codEspecialidade, 0, true, '') as vagas
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return array_shift($result)['vagas'];
    }
}
