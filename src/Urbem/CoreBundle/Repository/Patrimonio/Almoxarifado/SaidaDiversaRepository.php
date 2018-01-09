<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM\EntityRepository;

/**
 * Class SaidaDiversaRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado
 */
class SaidaDiversaRepository extends EntityRepository
{
    /**
     * @param array $params
     * @return array
     */
    public function performContabilidadeAlmoxarifadoLancamento(array $params)
    {
        $sql = <<<SQL
SELECT
  contabilidade.almoxarifadoLancamento(
    :cod_conta_despesa,
    :exercicio,
    :valor,
    :complemento,
    :cod_lote,
    :tipo_lote,
    :cod_entidade,
    :estorno
) AS sequencia;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
