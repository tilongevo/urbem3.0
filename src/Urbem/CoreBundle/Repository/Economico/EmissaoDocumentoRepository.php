<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class EmissaoDocumentoRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class EmissaoDocumentoRepository extends AbstractRepository
{

    /**
     * @param $codLicenca
     * @return mixed
     */
    public function getNumEmissao($codLicenca)
    {
        $sql = "SELECT
                    coalesce (max(num_emissao), 0 ) as valor
                FROM
                    economico.emissao_documento
                WHERE cod_licenca = :codLicenca ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("codLicenca", $codLicenca);
        $query->execute();
        $result = $query->fetch();

        return $result;
    }
}
