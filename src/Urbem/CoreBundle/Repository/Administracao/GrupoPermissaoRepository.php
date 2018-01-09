<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class GrupoUsuarioRepository
 *
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class GrupoPermissaoRepository extends AbstractRepository
{
    /**
     * @param int    $codUsuario
     * @param string $descricaoRota
     *
     * @return bool|string
     */
    public function hasAccessToRoute($codUsuario, $descricaoRota)
    {
        $sql = <<<SQL
SELECT (count(*) > 0) AS has_access
FROM
  administracao.grupo g_
  JOIN administracao.grupo_usuario gu_ ON gu_.cod_grupo = g_.cod_grupo
  JOIN administracao.grupo_permissao gp_ ON gp_.cod_grupo = gp_.cod_grupo
  JOIN administracao.rota r_ ON gp_.cod_rota = r_.cod_rota
WHERE gu_.cod_usuario = :cod_usuario
      AND r_.descricao_rota = :descricao_rota;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_usuario' => $codUsuario,
            'descricao_rota' => $descricaoRota
        ]);

        return $stmt->fetchColumn();
    }
}
