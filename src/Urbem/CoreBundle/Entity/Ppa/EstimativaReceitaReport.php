<?php

namespace Urbem\CoreBundle\Entity\Ppa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EstimativaReceitaReport
 */
class EstimativaReceitaReport
{
    /**
     * PK
     * @var integer
     */
    private $codFake;

    /**
     * @var integer
     */
    private $ppa;

    /**
     * @return int
     */
    public function getCodFake()
    {
        return $this->codFake;
    }

    /**
     * @param int $codFake
     */
    public function setCodFake($codFake)
    {
        $this->codFake = $codFake;
    }

    /**
     * @return mixed
     */
    public function getPpa()
    {
        return $this->ppa;
    }

    /**
     * @param mixed $ppa
     */
    public function setPpa($ppa)
    {
        $this->ppa = $ppa;
    }
}
