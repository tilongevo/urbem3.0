<?php

namespace Urbem\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SonataReport
 */
class SonataReport
{
    /**
     * PK
     * @var integer
     */
    private $codFake;

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
}
