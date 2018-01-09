<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

interface StnInterface
{
    function includeJs();

    function processParameters();

    function dynamicBlockJs();
}
