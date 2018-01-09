<?php

namespace Urbem\CoreBundle\Repository\Organograma;

use Doctrine\ORM\EntityRepository;

/**
 * Class VwOrgaoNivelViewRepository
 *
 * @package Urbem\CoreBundle\Repository\Organograma
 */
class VwOrgaoNivelViewRepository extends EntityRepository
{
    /**
     * Retorna todos os orgão abaixo de um orgão.
     *
     * @param $codOrgao
     *
     * @return array
     */
    public function getArrayOrgaosInsideOrgao($codOrgao)
    {
        $sql = <<<SQL
SELECT cod_orgao
FROM organograma.vw_orgao_nivel
WHERE orgao_reduzido LIKE
    (SELECT DISTINCT (vw_orgao_nivel.orgao_reduzido)
     FROM organograma.vw_orgao_nivel
     WHERE vw_orgao_nivel.cod_orgao = :cod_orgao ) || '%'
GROUP BY cod_orgao
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute(['cod_orgao' => $codOrgao]);

        return $stmt->fetchAll();
    }
}
