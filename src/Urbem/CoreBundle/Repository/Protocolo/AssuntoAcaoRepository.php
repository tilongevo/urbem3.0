<?php

namespace Urbem\CoreBundle\Repository\Protocolo;

use Doctrine\ORM;

class AssuntoAcaoRepository extends ORM\EntityRepository
{
    public function getAcoesByCodAssuntoAndCodClassificacao($codAssunto, $codClassificacao)
    {
        $sql = sprintf(
            "SELECT concat(r2.traducao_rota, ' > ' , r1.traducao_rota) AS descricao, r1.cod_rota, r1.descricao_rota
            FROM protocolo.assunto_acao aa JOIN administracao.rota r1 ON (aa.cod_acao = r1.cod_rota)
            JOIN administracao.rota r2 ON (r1.rota_superior = r2.descricao_rota)
            WHERE aa.cod_assunto = %d AND aa.cod_classificacao = %d",
            $codAssunto,
            $codClassificacao
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
