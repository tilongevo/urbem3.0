<?php

namespace Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias;

class StopChain implements IValidarFerias
{
    private $proximo;

    /**
     * @param $tipoFolha
     * @param $codPeriodoMovimentacao
     * @param $em
     * @return bool
     */
    public function validar($tipoFolha, $codPeriodoMovimentacao, $em)
    {
        return false;
    }

    /**
     * @param IValidarFerias $proximo
     */
    public function setProximo(IValidarFerias $proximo)
    {
        // stop chain.
    }
}
