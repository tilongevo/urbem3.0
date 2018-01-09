<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class DesdobramentoReceitaRepository extends ORM\EntityRepository
{
    public function getAllDesdobramentosReceitas($exercicio)
    {
        $sql = sprintf(
            "
            SELECT dr.percentual, dr.exercicio, cr.mascara_classificacao as receitaPrincipal, crs.mascara_classificacao as receitaSecundaria
            FROM contabilidade.desdobramento_receita dr 
            JOIN orcamento.vw_classificacao_receita cr on cr.cod_conta = dr.cod_receita_principal
            JOIN orcamento.vw_classificacao_receita crs on crs.cod_conta = dr.cod_receita_secundaria
            WHERE dr.exercicio = '%s' and cr.exercicio = '%s' and crs.exercicio = '%s'",
            $exercicio,
            $exercicio,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
