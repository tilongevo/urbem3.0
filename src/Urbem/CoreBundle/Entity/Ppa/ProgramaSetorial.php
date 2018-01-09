<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * ProgramaSetorial
 */
class ProgramaSetorial
{
    /**
     * PK
     * @var integer
     */
    private $codSetorial;

    /**
     * @var integer
     */
    private $codMacro;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\Programa
     */
    private $fkPpaProgramas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\MacroObjetivo
     */
    private $fkPpaMacroObjetivo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codSetorial
     *
     * @param integer $codSetorial
     * @return ProgramaSetorial
     */
    public function setCodSetorial($codSetorial)
    {
        $this->codSetorial = $codSetorial;
        return $this;
    }

    /**
     * Get codSetorial
     *
     * @return integer
     */
    public function getCodSetorial()
    {
        return $this->codSetorial;
    }

    /**
     * Set codMacro
     *
     * @param integer $codMacro
     * @return ProgramaSetorial
     */
    public function setCodMacro($codMacro)
    {
        $this->codMacro = $codMacro;
        return $this;
    }

    /**
     * Get codMacro
     *
     * @return integer
     */
    public function getCodMacro()
    {
        return $this->codMacro;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ProgramaSetorial
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ProgramaSetorial
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     * @return ProgramaSetorial
     */
    public function addFkPpaProgramas(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        if (false === $this->fkPpaProgramas->contains($fkPpaPrograma)) {
            $fkPpaPrograma->setFkPpaProgramaSetorial($this);
            $this->fkPpaProgramas->add($fkPpaPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     */
    public function removeFkPpaProgramas(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        $this->fkPpaProgramas->removeElement($fkPpaPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\Programa
     */
    public function getFkPpaProgramas()
    {
        return $this->fkPpaProgramas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaMacroObjetivo
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo
     * @return ProgramaSetorial
     */
    public function setFkPpaMacroObjetivo(\Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo)
    {
        $this->codMacro = $fkPpaMacroObjetivo->getCodMacro();
        $this->fkPpaMacroObjetivo = $fkPpaMacroObjetivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaMacroObjetivo
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\MacroObjetivo
     */
    public function getFkPpaMacroObjetivo()
    {
        return $this->fkPpaMacroObjetivo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodSetorial(), $this->descricao);
    }
}
