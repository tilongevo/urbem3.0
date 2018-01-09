<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 12/7/16
 * Time: 10:59 AM
 */

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class SubDivisaoRepository extends ORM\EntityRepository
{

    public function getSubDivisoesDisponiveisJson($params)
    {
        $sql = sprintf(
            "SELECT * FROM pessoal.sub_divisao WHERE %s",
            implode(" AND ", $params)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);

    }

}