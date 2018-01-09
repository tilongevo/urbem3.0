<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter;

final class CadastroSecretarioFilter
{
    /**
     * @var integer
     */
    protected $numCadastro;

    /**
     * @return int
     */
    public function getNumCadastro()
    {
        return $this->numCadastro;
    }

    /**
     * @param int $numCadastro
     */
    public function setNumCadastro($numCadastro)
    {
        $this->numCadastro = $numCadastro;
    }
}