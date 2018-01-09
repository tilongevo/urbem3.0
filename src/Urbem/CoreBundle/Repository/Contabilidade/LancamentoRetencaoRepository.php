<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class LancamentoRetencaoRepository extends ORM\EntityRepository
{
    public function validaRemoveEntidadeContaCaixa($info)
    {
        $sql = sprintf(
            "
            SELECT  cc.cod_plano, lr.cod_lote
            FROM contabilidade.lancamento_retencao as lr JOIN contabilidade.conta_credito as cc 
            ON (
              lr.cod_lote = cc.cod_lote
              AND lr.cod_entidade = cc.cod_entidade
              AND lr.sequencia    = cc.sequencia
              AND lr.tipo         = cc.tipo
              AND lr.exercicio    = cc.exercicio
            )
            WHERE lr.exercicio = '%s'
            AND lr.cod_entidade = %d
            AND cc.cod_plano = %d
            LIMIT 1",
            $info['exercicio'],
            $info['cod_entidade'],
            $info['cod_plano']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
