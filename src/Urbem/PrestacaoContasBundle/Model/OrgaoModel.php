<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class OrgaoModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class OrgaoModel extends AbstractTransparenciaModel
{
    /**
     * @return mixed
     */
    public function getDadosExportacao()
    {
        $sql = <<<SQL
SELECT exercicio ,
       LPAD(num_orgao::VARCHAR, 5, '0') AS num_orgao,
       RPAD(nom_orgao, 80, ' ') AS nom_orgao
FROM orcamento.orgao ;
SQL;

        return $this->getQueryResults($sql);
    }
}
