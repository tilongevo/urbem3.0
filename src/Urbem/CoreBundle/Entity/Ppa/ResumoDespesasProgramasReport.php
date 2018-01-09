<?php

namespace Urbem\CoreBundle\Entity\Ppa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ResumoDespesasProgramasReport
 */
class ResumoDespesasProgramasReport
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
    private $programaDe;

    /**
     * @var integer
     */
    private $programaAte;

    /**
     * @var integer
     */
    private $tipoPrograma;

    /**
     * @var integer
     */
    private $naturezaTemporal;

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
    public function getProgramaDe()
    {
        return $this->programaDe;
    }

    /**
     * @param mixed $programaDe
     */
    public function setProgramaDe($programaDe)
    {
        $this->programaDe = $programaDe;
    }

    /**
     * @return mixed
     */
    public function getProgramaAte()
    {
        return $this->programaAte;
    }

    /**
     * @param mixed $programaAte
     */
    public function setProgramaAte($programaAte)
    {
        $this->programaAte = $programaAte;
    }

    /**
     * @return mixed
     */
    public function getTipoPrograma()
    {
        return $this->tipoPrograma;
    }

    /**
     * @param mixed $tipoPrograma
     */
    public function setTipoPrograma($tipoPrograma)
    {
        $this->tipoPrograma = $tipoPrograma;
    }

    /**
     * @return mixed
     */
    public function getNaturezaTemporal()
    {
        return $this->naturezaTemporal;
    }

    /**
     * @param mixed $naturezaTemporal
     */
    public function setNaturezaTemporal($naturezaTemporal)
    {
        $this->naturezaTemporal = $naturezaTemporal;
    }
}
