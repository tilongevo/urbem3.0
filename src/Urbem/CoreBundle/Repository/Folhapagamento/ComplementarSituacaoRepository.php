<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ComplementarSituacaoRepository extends AbstractRepository
{
    /**
     * @return object
     */
    public function recuperaUltimaFolhaComplementarSituacao()
    {
        $sql = "
            select
                complementar_situacao.*
            from
                folhapagamento.complementar_situacao,
                (
                    select
                        cod_complementar,
                        max( timestamp ) as timestamp
                    from
                        folhapagamento.complementar_situacao
                    group by
                        cod_complementar
                ) as max_complementar_situacao,
                (
                    select
                        max( cod_periodo_movimentacao ) as cod_periodo_movimentacao
                    from
                        folhapagamento.periodo_movimentacao
                ) as periodo_movimentacao
            where
                complementar_situacao.cod_complementar = max_complementar_situacao.cod_complementar
                and complementar_situacao.timestamp = max_complementar_situacao.timestamp
                and complementar_situacao.cod_periodo_movimentacao = periodo_movimentacao.cod_periodo_movimentacao
            order by
                complementar_situacao.cod_complementar desc limit 1
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
