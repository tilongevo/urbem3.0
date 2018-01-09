<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AssinaturaModuloRepository
 *
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class AssinaturaModuloRepository extends AbstractRepository
{
    /**
     * @param $codModulo
     * @param $exercicio
     * @param $codEntidade
     *
     * @return array
     */
    public function getAssinaturasPorModulo($codModulo, $exercicio, $codEntidade)
    {
        $sql = <<<SQL
SELECT DISTINCT assinatura_modulo.*
FROM administracao.assinatura_modulo
WHERE assinatura_modulo.exercicio = :exercicio AND assinatura_modulo.cod_modulo = :cod_modulo AND
      assinatura_modulo.timestamp = (SELECT max(timestamp)
                                     FROM administracao.assinatura_modulo
                                     WHERE exercicio = :exercicio) AND assinatura_modulo.cod_entidade = :cod_entidade;
SQL;
        $stmt = $this->_em->getConnection()->prepare($sql);

        $stmt->execute([
            'exercicio'    => $exercicio,
            'cod_entidade' => $codEntidade,
            'cod_modulo'   => $codModulo
        ]);

        return $stmt->fetchAll();
    }
}
