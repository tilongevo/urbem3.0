<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class PlanoBancoRepository extends ORM\EntityRepository
{
    /**
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return array
     */
    public function findPlanoBanco(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "SELECT
                 pa.cod_plano,pc.cod_estrutural,pc.nom_conta,pc.cod_conta,
                 publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido,
                 pc.cod_classificacao,pc.cod_sistema,
                 pb.exercicio, pb.cod_banco, pb.cod_agencia,
                 pb.cod_entidade,pa.natureza_saldo,
                 CASE WHEN publico.fn_nivel(cod_estrutural) > 4 THEN
                         5
                      ELSE
                         publico.fn_nivel(cod_estrutural)
                 END as nivel
             FROM
                 contabilidade.plano_conta as pc
             LEFT JOIN contabilidade.plano_analitica as pa on (
             pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )
             LEFT JOIN contabilidade.plano_banco as pb on (
             pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio
             )
             WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
