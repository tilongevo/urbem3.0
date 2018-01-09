<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

/**
 * Class AutenticacaoRepository
 * @package Urbem\CoreBundle\Repository\Financeiro\Tesouraria
 */
class AutenticacaoRepository extends ORM\EntityRepository
{
    /**
     * @param array $params
     * @return mixed
     */
    public function recuperaUltimoCodigoAutenticacao(array $params)
    {
        $sql = <<<SQL
SELECT COALESCE(MAX(cod_autenticacao),0) as codigo                                              
FROM tesouraria.autenticacao                                                                                  
WHERE to_char(dt_autenticacao,'dd/mm/yyyy') = :dt_autenticacao 
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}
