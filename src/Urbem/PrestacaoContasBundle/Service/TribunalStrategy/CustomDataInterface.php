<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy;

interface CustomDataInterface
{
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getData();
}
