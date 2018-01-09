<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoInscricao
 */
class SwProcessoInscricao
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
    private $numInscricao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcessoInscricao
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
     * @return SwProcessoInscricao
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
     * Set numInscricao
     *
     * @param string $numInscricao
     * @return SwProcessoInscricao
     */
    public function setNumInscricao($numInscricao)
    {
        $this->numInscricao = $numInscricao;
        return $this;
    }

    /**
     * Get numInscricao
     *
     * @return string
     */
    public function getNumInscricao()
    {
        return $this->numInscricao;
    }

    /**
     * OneToOne (owning side)
     * Set SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoInscricao
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
