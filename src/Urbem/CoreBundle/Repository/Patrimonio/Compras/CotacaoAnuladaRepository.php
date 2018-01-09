<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class CotacaoAnuladaRepository extends ORM\EntityRepository
{
    public function insertCotacaoAnulada($codCotacao, $exercicio)
    {
        $motivo = sprintf('Exclusão do Julgamento da Licitação do Mapa %s/%s', $codCotacao, $exercicio);
        $stSql = "INSERT INTO compras.cotacao_anulada (
                exercicio,
                cod_cotacao,
                motivo
            )VALUES(
                '{$exercicio}',
                $codCotacao,
                '{$motivo}'
            )";
        $query = $this->_em->getConnection()->prepare($stSql);
        return $query->execute();
    }
}
