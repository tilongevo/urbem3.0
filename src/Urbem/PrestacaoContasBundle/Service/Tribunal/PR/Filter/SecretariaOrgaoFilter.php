<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter;

final class SecretariaOrgaoFilter
{
    /**
     * @var integer
     */
    protected $idSecretariaTce;

    /**
     * @return int
     */
    public function getIdSecretariaTce()
    {
        return $this->idSecretariaTce;
    }

    /**
     * @param int $numCadastro
     */
    public function setIdSecretariaTce($idSecretariaTce)
    {
        $this->idSecretariaTce = $idSecretariaTce;
    }
}