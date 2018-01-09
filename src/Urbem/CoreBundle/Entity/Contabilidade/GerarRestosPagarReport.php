<?php

namespace Urbem\CoreBundle\Entity\Contabilidade;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GerarRestosPagarReport
 */
class GerarRestosPagarReport
{
    /**
     * PK
     * @var integer
     */
    private $codFake;

    private $entidade;

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
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param mixed $entidade
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
    }
}
