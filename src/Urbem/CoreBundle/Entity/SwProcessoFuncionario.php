<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoFuncionario
 */
class SwProcessoFuncionario
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
    private $codRegistro;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcessoFuncionario
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
     * @return SwProcessoFuncionario
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
     * Set codRegistro
     *
     * @param string $codRegistro
     * @return SwProcessoFuncionario
     */
    public function setCodRegistro($codRegistro)
    {
        $this->codRegistro = $codRegistro;
        return $this;
    }

    /**
     * Get codRegistro
     *
     * @return string
     */
    public function getCodRegistro()
    {
        return $this->codRegistro;
    }

    /**
     * OneToOne (owning side)
     * Set SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoFuncionario
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
