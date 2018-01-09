<?php

namespace Urbem\PrestacaoContasBundle\Model;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Interface InterfaceTransparenciaModel
 */
class AbstractTransparenciaModel
{
    /** @var  EntityManager */
    protected $entityManager;

    /**
     * OrcamentoEntidadeModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $sql
     * @param array  $params
     * @param bool   $singleResult
     *
     * @return mixed
     */
    public function getQueryResults($sql, $params = [], $singleResult = false)
    {
        $conn = $this->entityManager->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        if ($singleResult) {
            return $stmt->fetch();
        }

        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getSamLinkHost()
    {
        $samLinkHost = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('samlink_host', Modulo::MODULO_ADMINISTRATIVO, true);

        return $samLinkHost;
    }


    /**
     * @param string         $schema
     * @param string|integer $codEntidade
     *
     * @return bool
     */
    public function hasEsquemaForEntidade($schema, $codEntidade)
    {
        $sql = <<<SQL
SELECT nspname
FROM pg_namespace
WHERE nspname = :esquema
SQL;

        return $this->getQueryResults($sql, [
            'esquema' => sprintf('%s_%d', $schema, $codEntidade)
        ], true);
    }
}
