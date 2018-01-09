<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class PgNamespaceModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class PgNamespaceModel extends AbstractTransparenciaModel
{
    /**
     * @param $nspname
     * @return mixed
     */
    public function getSchemasCreated($nspname)
    {
        $sql = <<<SQL
 SELECT nspname       
  FROM pg_namespace  
 WHERE nspname = '{$nspname}'
SQL;

        return $this->getQueryResults($sql);
    }
}
