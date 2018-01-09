<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoMatricula
 */
class SwProcessoMatricula
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var string
     */
    private $numMatricula;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcessoMatricula
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwProcessoMatricula
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set numMatricula
     *
     * @param string $numMatricula
     * @return SwProcessoMatricula
     */
    public function setNumMatricula($numMatricula)
    {
        $this->numMatricula = $numMatricula;
        return $this;
    }

    /**
     * Get numMatricula
     *
     * @return string
     */
    public function getNumMatricula()
    {
        return $this->numMatricula;
    }

    /**
     * OneToOne (owning side)
     * Set SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoMatricula
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
