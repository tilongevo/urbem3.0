<?php

namespace Urbem\CoreBundle\Entity\Ppa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AcoesNaoOrcamentariasReport
 */
class AcoesNaoOrcamentariasReport
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
     * @var integer
     */
    private $programa;

    /**
     * @var integer
     */
    private $tipoAcao;

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

    /**
     * @return mixed
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * @param mixed $programa
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;
    }


    /**
     * @return mixed
     */
    public function getTipoAcao()
    {
        return $this->tipoAcao;
    }

    /**
     * @param mixed $tipoAcao
     */
    public function setTipoAcao($tipoAcao)
    {
        $this->tipoAcao = $tipoAcao;
    }
}
