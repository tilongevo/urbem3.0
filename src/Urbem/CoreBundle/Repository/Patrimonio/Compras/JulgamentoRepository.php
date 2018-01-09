<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class JulgamentoRepository extends ORM\EntityRepository
{
    public function removeJulgamento($codCotacao, $exercicio)
    {
        $sql = "DELETE FROM compras.julgamento WHERE exercicio = '{$exercicio}' AND cod_cotacao = $codCotacao ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
