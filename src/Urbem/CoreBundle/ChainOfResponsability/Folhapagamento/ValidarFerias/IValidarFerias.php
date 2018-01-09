<?php

namespace Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias;

interface IValidarFerias
{
    public function validar($tipoFolha, $codPeriodoMovimentacao, $em);
    public function setProximo(IValidarFerias $proximo);
}
